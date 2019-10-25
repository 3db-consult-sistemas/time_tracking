<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimetableRequest;
use App\Model\Timetable\Timetable;
use App\Model\Timetable\TimetableRepository;

class TimetablesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TimetableRepository $timetableRepository)
    {
        $this->middleware(['auth', 'ismobile', 'checkrole:super_admin,admin']);

        $this->timetableRepository = $timetableRepository;
    }

    /**
     * Creo un nuevo horario.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TimetableRequest $request)
    {
        $data = $request->formatData();

        $lastTimetable = $this->timetableRepository->lastDate($data['user_id']);

        if ($lastTimetable != null &&
            $lastTimetable->format('Y-m-d') > $data['from_date']->format('Y-m-d')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['La fecha del nuevo horario no puede ser anterior a la del último existente.']);
        }

        $this->timetableRepository->create($data);

        return redirect()->back();
    }

    /**
     * Elimino un horario.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->timetableRepository->delete($id);

        return redirect()->back();
    }
}
