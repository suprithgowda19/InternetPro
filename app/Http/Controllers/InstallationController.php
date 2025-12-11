<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class InstallationController extends Controller
{
    /**
     * Admin: List all installations
     */
    public function index()
    {
        $this->authorizeAdmin();

        $installations = Installation::with(['user.ward'])
            ->latest()
            ->get();

        return view('installations.index', compact('installations'));
    }

    /**
     * Admin: Show create form
     */
    public function create()
    {
        $this->authorizeAdmin();

        $users = User::select('id', 'name', 'clinic_name')
            ->orderBy('name')
            ->get();

        return view('installations.create', compact('users'));
    }

    /**
     * Admin: Store installation
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'installed_on' => 'required|date',
            'comments'     => 'nullable|string|max:5000',
            'routes'       => 'nullable|string|max:1000',   // NEW
            'cables'       => 'nullable|string|max:1000',   // NEW
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Get user to inherit ward_id automatically
        $selectedUser = User::select('id', 'ward_id')->findOrFail($validated['user_id']);

        $data = [
            'user_id'      => $selectedUser->id,
            'ward_id'      => $selectedUser->ward_id,
            'installed_on' => $validated['installed_on'],
            'comments'     => $validated['comments'] ?? null,
            'routes'       => $validated['routes'] ?? null,  // NEW
            'cables'       => $validated['cables'] ?? null,  // NEW
        ];

        /** ---------------------------
         *  Image Upload (Best Practice)
         * --------------------------- */
        if ($request->hasFile('image')) {

            $filename = Str::uuid() . '.' . $request->file('image')->extension();

            $data['image'] = $request->file('image')
                ->storeAs('installation_images', $filename, 'public');
        }

        Installation::create($data);

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation created successfully!');
    }

    /**
     * Admin: View installation details
     */
    public function show($id)
    {
        $this->authorizeAdmin();

        $installation = Installation::with(['user.ward'])
            ->findOrFail($id);

        return view('installations.show', compact('installation'));
    }

    /**
     * Admin: Delete installation
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();

        $installation = Installation::findOrFail($id);

        // Delete image from storage
        if ($installation->image) {
            Storage::disk('public')->delete($installation->image);
        }

        $installation->delete();

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation deleted successfully!');
    }
    private function authorizeAdmin()
    {
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Access denied.');
        }
    }

}
