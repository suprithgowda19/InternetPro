<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
 
    public function index()
    {
        $this->authorizeAdmin();
        $users = User::with('ward')->latest()->get();
         $wards = Ward::select('id', 'name')->get();
        return view('users.index', compact(['users', 'wards'])); 
    }

   
    public function create()
    {
        $this->authorizeAdmin();
        $wards = Ward::orderBy('name')->get();
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
            'bandwidth'       => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'ward_id'         => $validated['ward_id'],
                'clinic_name'     => $validated['clinic_name'],
                'password'        => Hash::make($validated['password']),
                'email'           => $validated['email'],
                'internet_status' => $validated['internet_status'],
                'name'            => $validated['name'],
                'phone'           => $validated['phone'],
                'internet_speed'  => $validated['internet_speed'],
                'bandwidth'       => $validated['bandwidth'],
            ]);

            $user->assignRole('user');
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function show($id)
    {
        $user = User::with(['tickets', 'ward'])->findOrFail($id);
        $this->authorize('view', $user);
        return view('users.show', compact('user'));
    }

   
    public function edit($id)
    {
        $user = User::with('ward')->findOrFail($id);
        $this->authorize('update', $user);
        $wards = Ward::orderBy('name')->get();
        return view('users.edit', compact('user', 'wards'));
    }

    /**
     * USER: Update own profile
     */
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
            'bandwidth'       => 'required|string',
            'email'           => "required|email|unique:users,email,{$user->id}",
            'password'        => 'nullable|min:4',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

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

    /**
     * AJAX: Toggle Internet Status
     */
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
     * Helper: Allow only Admin
     */
    private function authorizeAdmin()
    {
        abort_unless(auth()->user()->hasRole('admin'), 403, 'Unauthorized');
    }
}
