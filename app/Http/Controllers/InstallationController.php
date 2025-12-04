<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstallationController extends Controller
{
   
    public function index()
    {
        $authUser = Auth::user();

        if (! $authUser->hasRole('admin')) {
            abort(403, 'Access denied.');
        }

        // Installation + user + user's ward (for view)
        $installations = Installation::with(['user.ward'])
            ->latest()
            ->get();

        return view('installations.index', compact('installations'));
    }

    /**
     * Admin-only: Show create form
     */
    public function create()
    {
        $authUser = Auth::user();

        if (! $authUser->hasRole('admin')) {
            abort(403, 'Access denied.');
        }

        // Users for dropdown
        $users = User::select('id', 'name', 'clinic_name')
            ->orderBy('name')
            ->get();

        return view('installations.create', compact('users'));
    }

    /**
     * Admin-only: Store new installation
     */
    public function store(Request $request)
    {
        $authUser = Auth::user();

        if (! $authUser->hasRole('admin')) {
            abort(403, 'Access denied.');
        }

        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'installed_on' => 'required|date',
            'comments'     => 'nullable|string',
            'image'        => 'nullable|image|max:2048',
        ]);

        // Get selected user to copy ward_id
        $selectedUser = User::select('id', 'ward_id')->findOrFail($validated['user_id']);

        $data = [
            'user_id'      => $selectedUser->id,
            'ward_id'      => $selectedUser->ward_id,   
            'installed_on' => $validated['installed_on'],
            'comments'     => $validated['comments'] ?? null,
        ];

        // Image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('installations', 'public');
        }

        Installation::create($data);

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation created successfully!');
    }

    /**
     * Admin-only: Show installation details
     */
    public function show($id)
    {
        $authUser = Auth::user();

        if (! $authUser->hasRole('admin')) {
            abort(403, 'Access denied.');
        }

        $installation = Installation::with(['user.ward'])
            ->findOrFail($id);

        return view('installations.show', compact('installation'));
    }

    /**
     * Admin-only: Delete installation
     */
    public function destroy($id)
    {
        $authUser = Auth::user();

        if (! $authUser->hasRole('admin')) {
            abort(403, 'Access denied.');
        }

        $installation = Installation::findOrFail($id);

        if ($installation->image) {
            Storage::disk('public')->delete($installation->image);
        }

        $installation->delete();

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation deleted successfully!');
    }
}
