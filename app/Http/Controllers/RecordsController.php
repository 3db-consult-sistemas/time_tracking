<?php

namespace App\Http\Controllers;

use App\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RecordRequest;
use App\Http\Requests\AbsenceRequests;
use App\Model\Record\RecordRepository;

class RecordsController extends Controller
{
    protected $recordRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        RecordRepository $recordRepository,
        UserRepository $userRepository)
    {
        $this->recordRepository = $recordRepository;
        $this->userRepository = $userRepository;

        $this->middleware('auth');
    }

    /**
     * Filtro los registros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RecordRequest $request)
    {
        $data = $request->formatData()->all();
        $users = $this->userRepository->fetch();

        if ($data['aggregate'] == 'record') {
            $entries = $this->recordRepository->fetchPaginate($data);
        }
        else {
            $entries = $this->recordRepository->fetch($data);
        }

        return view('summary.index', compact('data', 'users', 'entries'));

    }

    /**
     * Realizo el 'check in' para el usuario autenticado.
     *
     * @return redirect
     */
    public function checkIn()
    {
        if(! $this->recordRepository->create(['user_id' => auth()->id()])) {
            return redirect()->back()
                ->withErrors(['No se ha podido realizar el Check-In.']);
		}

        return redirect()->back();
    }

    /**
     * Realizo el 'check out' para el usuario autenticado.
     *
     * @param  $entryId
     * @return redirect
     */
    public function checkOut($entryId)
    {
        if(! $this->recordRepository->close($entryId)) {
            return redirect()->back()
                ->withErrors(['No se ha podido realizar el Check-Out.']);
		}

        return redirect()->back();
    }

    /**
     * Create or finish absence time entry.
     *
     * @param  $entryId
     * @return redirect
     */
    public function absence(AbsenceRequests $request, $entryId)
    {
        $data = $request->formatData();

        $this->recordRepository->absence($data);

        return redirect()->back();
    }
}
