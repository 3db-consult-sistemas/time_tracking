<?php

namespace App\Http\Controllers;

use App\UserRepository;
use App\Model\Ticket\Ticket;
use Illuminate\Http\Request;
use App\Model\Record\RecordRepository;
use App\Model\Ticket\TicketRepository;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    protected $ticketRepository, $userRepository;

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

        $this->middleware(['auth', 'ismobile']);
        $this->middleware('checkrole:super_admin,admin')->except(['create', 'store']);
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
		$projects = $ticket->user->availableProjects();

        return view('tickets.edit', compact('ticket', 'projects'));
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
			'check_in' => 'date_format_multi:"Y-m-d H:i:s","Y-m-d H:i"',
            'check_out' => 'date_format_multi:"Y-m-d H:i","Y-m-d H:i:s"|after_or_equal:check_in',
		]);

		if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if (! (new RecordRepository)->timeRangeIsOk(
                $ticket->user_id,
                $request->get('check_in'),
                $request->get('check_out'))) {

            return redirect()->back()
                ->withInput()
                ->withErrors(['ticket' => 'Ya existe un registro con el periodo de rango indicado.']);
        }

        $this->ticketRepository->closeTicket($ticket, $request);

        return redirect('tickets');
	}

	/**
	 * Muestro el formulario para crear tickets.
	 */
	public function create(int $entryId)
	{
		$record = (new RecordRepository)->fetchById($entryId);

		return view('tickets.create', compact('record'));
	}

	/**
	 * Guardo el ticket.
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'comments' => 'required|string|max:191',
			'user_id' => 'required|exists:users,id',
			'record_id' => 'required|exists:records,id',
		]);

		if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
		}

        // Pendiente
        // Verificar que no exista otro ticket abierto del mismo registro.

		$response = $this->ticketRepository->create($request->only('record_id', 'user_id', 'comments'));

        if (! $response) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['ticket' => '¡Error creando la solicitud de cambio!']);
		}

		return redirect()->route('summary', ['userName' => 'ivan.iglesias', 'aggregate' => 'record']);
	}
}
