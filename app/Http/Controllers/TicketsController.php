<?php

namespace App\Http\Controllers;

use App\UserRepository;
use App\Model\Ticket\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        //$this->middleware('checkrole:super_admin,admin')->except(['create', 'store']);
    }

    /**
     * Visualizo la vista de tickets. Si el usuario no es administrador solo podra ver sus tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $userAuth = auth()->user();
        $userName = null;
        $users = null;

        if ($userAuth->role == 'user') {
            $data['userName'] = $userAuth->username;
        }
        else {
            $userName = $request->get('userName');
            $users = $this->userRepository->fetch();
        }

        $tickets = $this->ticketRepository->ticketsByUserName($data);

        return view('tickets.index', compact('users', 'userName', 'tickets'));
    }

	/**
	 * Muestro el formulario para crear tickets.
	 */
	public function create(int $entryId)
	{
		$record = (new RecordRepository)->fetchById($entryId);

		return view('tickets.forms.create', compact('record'));
	}

	/**
	 * Guardo el ticket.
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'record_id' => 'required|exists:records,id',
            'user_id' => 'required|exists:users,id',
            'comments' => 'required|string|max:191',
            'type' => 'required|in:' . implode(array_keys(config('options.ticket_options')), ',')
        ]);

		if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
		}

        // Pendiente
        // Verificar que no exista otro ticket abierto del mismo registro.
        // Por ahora no se hace porque no doy la opción en la vista.

		$response = $this->ticketRepository->create($request->only('record_id', 'user_id', 'comments', 'type'));

        if (! $response) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['ticket' => '¡Error creando la solicitud de cambio!']);
		}

        return redirect()->route('summary', ['userName' => auth()->user()->username, 'aggregate' => 'record']);
    }

    /**
     * Visualizo los detalles de ticket cerrado.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        if (Gate::denies('checkrole', 'super_admin') &&
            Gate::denies('checkrole', 'admin')) {

            if ($ticket->user_id != auth()->id()) {
                abort(403, 'No tienes permisos para realizar esta acción.');
            }
        }

        return view('tickets.forms.show', compact('ticket'));
    }

    /**
     * Visualizo la edicion de tickets. Solo se podra visualizar los detalles de un
     * ticket el dueño o un administrador.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        if ($ticket->status == 'close') {
            abort(403, 'No se puede editar un ticket cerrado.');
        }

        if (Gate::denies('checkrole', 'super_admin') &&
            Gate::denies('checkrole', 'admin')) {

            if ($ticket->user_id != auth()->id()) {
                abort(403, 'No tienes permisos para realizar esta acción.');
            }
        }

        if (auth()->user()->role == 'user') {
            return view('tickets.forms.create', compact('ticket'));
        }

        $projects = $ticket->user->availableProjects(true);

        return view('tickets.forms.close', compact('ticket', 'projects'));
    }

    /**
     * Cierro el ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket, string $action)
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

        if ($action == 'update') {
            $this->ticketRepository->update($ticket, $request);
            return redirect('tickets');
        }

        $this->ticketRepository->close($ticket, $request);
        return redirect('tickets');
	}

    /**
     * Elimino un ticket abierto.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $response = $this->ticketRepository->delete($id);

        if (! $response) {
            return redirect()->back()
                ->withErrors(['ticket' => '¡Error eliminando el ticket!']);
		}

        return redirect('tickets');
    }
}
