<?php

namespace App\Http\Controllers;

use App\Model\Helpers;
use App\Model\Ticket\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    use Helpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'checkrole:super_admin,admin']);
    }

    /**
     * Visualizo la vista de tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::with(['record', 'user'])
            ->orderBy('status')
            ->latest()
            ->paginate(15);

        return view('tickets.index', compact('tickets'));
	}

    /**
     * Visualizo la edicion de tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Cierro el ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'comments' => 'string|nullable|max:191',
            'check_out' => 'date_format:"Y-m-d H:i"|before_or_equal:now',
		]);

		if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if (($checkOut = $this->toCarbon($request['check_out'])) <= $ticket->record->check_in) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['The check out must be a date greater than check in.']);
        }

        $record = $ticket->record;
        $record->check_out = $checkOut;
        $record->save();

        $ticket->comments = $request->get('comments');
        $ticket->status = 'close';
        $ticket->save();

        return redirect('tickets');
    }
}
