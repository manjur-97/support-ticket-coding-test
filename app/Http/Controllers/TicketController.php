<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{

    public function create()
    {

        return view('ticket.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation Start
        $request->validate([
            'issue_title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        // validation End



        $user = User::find(auth()->id());

        if ($user->role !== 'customer') {
            return redirect()->route('tickets.create')->with('error', 'Admin can not open ticket, Only Customer can create ticket');
        }


        $ticket = Ticket::create([
            'customer_id' => auth()->id(),
            'issue_title' => $request->issue_title,
            'description' => $request->description,
            'status' => 'open',
        ]);

        $mailDetails =
            [
                'issue_title' => $ticket->issue_title,
                'description' => $ticket->description,
                'customer_id' => $user->id,
                'customer_name' => $user->name,
                'status' => $ticket->status,
            ];


        $admins = User::where('role', 'admin')->get();
        try {
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new NotificationMail($mailDetails));
            }

            return redirect()->route('customer.dashboard')->with('success', 'Ticket created successfully And Send Email Successfully to Admin');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Error sending email: ' . $e->getMessage());

            return redirect()->route('customer.dashboard')->with('error', "Ticket created successfully But Send Email Fail , Set SMTP Credential Correctly");
        }
    }



    public function close(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);

        $closeTicket = $ticket->update(
            [
                'feedback' => $request->feedback,
                'status' => 'closed',
                'admin_id' => auth()->id()
            ]
        );

        $mailDetails =
            [
                'feedback' =>  $request->feedback,
                'status' => 'closed',

            ];
        try {

            Mail::to($ticket->customer->email)->send(new NotificationMail($mailDetails));


            return redirect()->route('admin.dashboard')->with('success', 'Ticket is close and  email send to customer');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Error sending email: ' . $e->getMessage());

            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'issue_title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'issue_title' => $request->issue_title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Ticket updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->delete();

        return redirect()->route('customer.dashboard')->with('success', 'Ticket deleted successfully.');
    }
}
