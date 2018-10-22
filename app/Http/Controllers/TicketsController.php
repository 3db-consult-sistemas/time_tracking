<?php

namespace App\Http\Controllers;

use App\UserRepository;
use App\Model\Ticket\Ticket;
use Illuminate\Http\Request;
use App\Model\Ticket\TicketRepository;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    protected $ticketRepository, $recordRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        TicketRepository $ticketRepository,
        UserRepository $userRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->userRepository = $userRepository;

        $this->middleware(['auth', 'ismobile', 'checkrole:super_admin,admin']);
    }

    /**
     * Visualizo la vista de tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = $request->get('userName');

        $users = $this->userRepository->fetch();

        $tickets = $this->ticketRepository->ticketsByUserName($request->all());

        return view('tickets.index', compact('users', 'userName', 'tickets'));
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
            'comments' => 'required|string|max:191',
            'check_out' => 'date_format:"Y-m-d H:i"|after:' . $ticket->record->check_in->format('Y-m-d H:i'),
		]);

		if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $this->ticketRepository->closeTicket($ticket, $request);

        return redirect('tickets');
    }
}
