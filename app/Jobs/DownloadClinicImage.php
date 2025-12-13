<?php

namespace App\Jobs;

use App\Models\ClinicSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class DownloadClinicImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Retry strategy
     */
    public int $tries = 3;
    public array $backoff = [10, 30, 60];
    public int $timeout = 20;

    public function __construct(
        public int $submissionId,
        public string $imageUrl
    ) {}

    public function handle(): void
    {
        $submission = ClinicSubmission::find($this->submissionId);

        if (! $submission) {
            return;
        }

        $submission->refresh();

        if (in_array($submission->image_status, ['processing', 'completed'])) {
            return;
        }

        $submission->update([
            'image_status' => 'processing',
            'image_error'  => null,
        ]);

        try {
            if (! Str::startsWith($this->imageUrl, 'https://')) {
                throw new \RuntimeException('Only HTTPS image URLs allowed');
            }

            $ext = strtolower(
                pathinfo(parse_url($this->imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION)
            );

            if (! in_array($ext, ['jpg', 'jpeg', 'png'])) {
                throw new \RuntimeException('Invalid image extension');
            }

            $response = Http::connectTimeout(5)
                ->timeout(10)
                ->accept('image/*')
                ->get($this->imageUrl);

            if (! $response->successful()) {
                throw new \RuntimeException('Image download failed');
            }

            $contentType = $response->header('Content-Type');

            if (! str_starts_with($contentType, 'image/')) {
                throw new \RuntimeException('Invalid image content type');
            }

            if (strlen($response->body()) > 2 * 1024 * 1024) {
                throw new \RuntimeException('Image exceeds size limit');
            }

            $filename = sprintf(
                'clinic_%d_%s.%s',
                $submission->id,
                Str::random(12),
                $ext
            );

            Storage::disk('public')->put(
                "clinic_submissions/{$filename}",
                $response->body()
            );

            $submission->update([
                'image_path'   => "clinic_submissions/{$filename}",
                'image_status' => 'completed',
            ]);
        } catch (Throwable $e) {
            Log::warning('Clinic image download failed', [
                'submission_id' => $submission->id,
                'url'           => $this->imageUrl,
                'error'         => $e->getMessage(),
            ]);

            $submission->update([
                'image_status' => 'failed',
                'image_error'  => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
