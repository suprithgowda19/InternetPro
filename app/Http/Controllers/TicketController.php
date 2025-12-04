<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
  
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin: see all tickets with user + ward
            $tickets = Ticket::with(['user.ward'])
                ->latest()
                ->get();
        } else {
            // Normal user: see only own tickets
            $tickets = Ticket::with(['user.ward'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        $wards = Ward::select('id', 'name')->get();

        return view('tickets.index', compact('tickets', 'wards', 'user'));
    }

    /**
     * Create a new ticket (authorized user only).
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            abort(403, 'Admins cannot raise tickets.');
        }

        return view('tickets.create', compact('user'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            abort(403, 'Admins cannot create tickets.');
        }
        $validated = $request->validate([
            'description' => 'required|string',
        ]);
        Ticket::create([
            'user_id'          => $user->id,
            'description'      => $validated['description'],
            'status'           => 'Pending',
            'admin_resolution' => null,
            'admin_remarks'    => null,
            'admin_image'      => null,
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket raised successfully!');
    }

    /**
     * Show a single ticket (authorized user only).
     */
    public function show($id)
    {
        $ticket = Ticket::with(['user.ward'])->findOrFail($id);
        // - admin can view any
        // - normal user can view only own ticket
        $this->authorize('view', $ticket);

        return view('tickets.show', compact('ticket'));
    }


    public function edit($id)
    {
        $user = Auth::user();

        if ($user->hasRole('user')) {
            abort(403, 'Only admins can resolve tickets.');
        }

        $ticket = Ticket::with(['user.ward'])->findOrFail($id);

        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->hasRole('user')) {
            abort(403, 'Only admins can update tickets.');
        }

        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'admin_remarks' => 'nullable|string',
            'status'        => 'required|in:Pending,Irrelevant,Resolved',
            'admin_image'   => 'nullable|image|max:2048',
        ]);

        $data = [
            'admin_remarks' => $validated['admin_remarks'] ?? null,
            'status'        => $validated['status'],
        ];

        if ($request->hasFile('admin_image')) {
         
            if ($ticket->admin_image) {
                Storage::disk('public')->delete($ticket->admin_image);
            }

            $data['admin_image'] = $request->file('admin_image')
                ->store('ticket_resolutions', 'public');
        }

        $ticket->update($data);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket updated successfully!');
    }
    public function destroy($id)
    {
        $user = Auth::user();

        if (! $user->hasRole('admin')) {
            abort(403, 'Only admins can delete tickets.');
        }

        $ticket = Ticket::findOrFail($id);

        if ($ticket->admin_image) {
            Storage::disk('public')->delete($ticket->admin_image);
        }

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }
}
