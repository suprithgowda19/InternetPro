<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use PDF;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();

        $users = User::with('ward')->latest()->get();
        $wards = Ward::select('id', 'name')->get();

        return view('users.index', compact('users', 'wards'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $wards = Ward::orderByRaw('number + 0 ASC')->get();

        return view('users.create', compact('wards'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'ward_id'         => 'required|exists:wards,id',
            'clinic_name'     => 'required|string',
            'password'        => 'required|string|min:4',
            'email'           => 'required|email|unique:users,email',
            'internet_status' => 'required|in:active,inactive',
            'name'            => 'required|string',
            'phone'           => 'required|digits:10|unique:users,phone',
            'internet_speed'  => 'required|string',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
        ]);

        // Bandwidth always pre-set to Unlimited
        $validated['bandwidth'] = 'Unlimited';
        $validated['password'] = Hash::make($validated['password']);

        DB::transaction(function () use ($validated) {
            $user = User::create($validated);
            $user->assignRole('user');
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function show($id)
    {
        $user = User::with(['ward', 'installation'])->findOrFail($id);
        $this->authorize('view', $user);

        $installationData = $this->prepareInstallationData($user);

        return view('users.show', compact('user', 'installationData'));
    }

    public function edit($id)
    {
        $user = User::with('ward')->findOrFail($id);
        $this->authorize('update', $user);

        $wards = Ward::orderBy('name')->get();

        return view('users.edit', compact('user', 'wards'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $validated = $request->validate([
            'ward_id'         => 'required|exists:wards,id',
            'clinic_name'     => 'required|string',
            'internet_status' => 'required|in:active,inactive',
            'name'            => 'required|string',
            'phone'           => "required|digits:10|unique:users,phone,{$user->id}",
            'internet_speed'  => 'required|string',
            'email'           => "required|email|unique:users,email,{$user->id}",
            'password'        => 'nullable|min:4',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Always enforce Unlimited bandwidth
        $validated['bandwidth'] = 'Unlimited';

        $user->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', "You can't delete your own account.");
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    public function updateStatus(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'id' => 'required|exists:users,id',
            'internet_status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($request->id);

        if (auth()->id() == $user->id) {
            return response()->json([
                'error' => true,
                'message' => 'You cannot change your own status.'
            ], 403);
        }

        $user->update(['internet_status' => $request->internet_status]);

        return response()->json(['success' => true]);
    }

    /**
     * Prepare installation-related UI data
     */
    private function prepareInstallationData(User $user): ?array
    {
        if (!$user->installation) {
            return null;
        }

        $inst = $user->installation;

        return [
            'installed_on' => $inst->installed_on
                ? Carbon::parse($inst->installed_on)->format('d M Y')
                : null,

            'expiry_date' => $inst->installed_on
                ? Carbon::parse($inst->installed_on)->addMonths(6)->format('d M Y')
                : null,

            'routes' => $inst->routes ?: null,
            'cables' => $inst->cables ?: null,
            'has_items' => filled($inst->routes) || filled($inst->cables),

            'image' => $inst->image ? asset('storage/' . $inst->image) : null,
        ];
    }

    private function authorizeAdmin()
    {
        abort_unless(auth()->user()->hasRole('admin'), 403, 'Unauthorized');
    }


    public function downloadPdf($id)
    {
        $user = User::with(['ward', 'installation'])->findOrFail($id);

        $pdf = PDF::loadView('users.pdf', compact('user'))->setPaper('a4');

        return $pdf->download('user-profile-' . $user->id . '.pdf');
    }
}
