<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClinicSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClinicSubmissionController extends Controller
{
    /**
     * API: Store clinic submission (FILE upload only)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phc'          => 'required|string|max:255',
            'clinic_name'  => 'required|string|max:255',
            'doctor_name'  => 'nullable|string|max:255',
            'phone'        => 'required|digits:10',
            'lat'          => 'required|numeric|between:-90,90',
            'lng'          => 'required|numeric|between:-180,180',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $submission = ClinicSubmission::create([
                'phc'          => $validated['phc'],
                'clinic_name'  => $validated['clinic_name'],
                'doctor_name'  => $validated['doctor_name'] ?? null,
                'phone'        => $validated['phone'],
                'lat'          => $validated['lat'],
                'lng'          => $validated['lng'],
                'image_status' => 'pending',
                'source'       => 'whatsapp',
                'raw_payload'  => $request->except('image'),
            ]);

            /** ---------------------------
             *  Image Upload (Same as Installation)
             * --------------------------- */
            if ($request->hasFile('image')) {

                $filename = Str::uuid() . '.' . $request->file('image')->extension();

                $imagePath = $request->file('image')
                    ->storeAs('clinic_submissions', $filename, 'public');

                $submission->update([
                    'image_path'   => $imagePath, // clinic_submissions/uuid.jpg
                    'image_status' => 'completed',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'id'      => $submission->id,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Clinic submission failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Submission failed',
            ], 422);
        }
    }

    /**
     * Admin UI: complaints list
     */
    public function index()
    {
        $complaints = ClinicSubmission::latest()->paginate(20);

        return view('complaints.index', compact('complaints'));
    }

    /**
     * Admin UI: complaint detail
     */
    public function show($id)
    {
        $complaint = ClinicSubmission::findOrFail($id);

        return view('complaints.show', compact('complaint'));
    }
}
