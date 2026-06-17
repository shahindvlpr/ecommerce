<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Support\Str;

class CustomerSupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.support.index', compact('tickets'));
    }

    public function create()
    {
        return view('customer.support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'nullable|string|max:100',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $ticketNumber = 'TKT-' . strtoupper(Str::random(8)) . '-' . time();

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'ticket_number' => $ticketNumber,
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => 'open',
            'category' => $request->category,
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('support', 'public');
            $ticket->attachment = $path;
            $ticket->save();
        }

        return redirect()->route('customer.support.show', $ticket->id)
            ->with('success', 'Ticket created successfully! We\'ll get back to you soon.');
    }

    public function show($id)
    {
        $ticket = SupportTicket::where('user_id', Auth::id())
            ->with('replies.user')
            ->findOrFail($id);

        return view('customer.support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|min:3',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $ticket = SupportTicket::where('user_id', Auth::id())->findOrFail($id);

        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false,
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('support', 'public');
            $reply->attachment = $path;
            $reply->save();
        }

        // Update ticket status if it was closed
        if ($ticket->status === 'closed') {
            $ticket->status = 'open';
            $ticket->save();
        }

        return redirect()->back()->with('success', 'Reply added successfully.');
    }

    public function close($id)
    {
        $ticket = SupportTicket::where('user_id', Auth::id())->findOrFail($id);
        
        $ticket->status = 'closed';
        $ticket->closed_at = now();
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket closed successfully.');
    }
}