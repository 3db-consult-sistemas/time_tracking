<?php

namespace App\Http\Controllers;

use App\Model\Helpers;
use App\UserRepository;
use App\Http\Requests\ReportRequest;
use App\Model\Record\RecordRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
	use Helpers;

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

        $this->middleware(['auth', 'ismobile', 'checkrole:super_admin,admin']);
    }

    /**
     * Visualizo la vista de reportes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = $this->userRepository->fetch();

        return view('reports.index', compact('users'));
	}

    /**
     * Aplico el filtro seleccionado y descargo la informacion en formato excel.
     *
     */
    public function download(ReportRequest $request)
    {
		$entries = $this->recordRepository->fetch($request->formatData()->all());

		if (count($entries) == 0) {
			return redirect()->back()
				->withInput()
				->withErrors(['No se han encontrado registros con el filtro actual.']);
		}

		$fileName = Carbon::now()->format('Ymd_Hi') . '_' . $request['aggregate'] . '_' . studly_case($request['userName'] ?? 'reporte');

		Excel::create($fileName, function($excel) use ($entries) {
            $this->addSheet('Hoja1', $excel, $this->format($entries));
		})->export('xlsx');
    }

    /**
	 * Creo una pestaña nueva en el excel.
	 *
	 * @param $name     Nombre de la pestaña
	 * @param $excel    Excel sobre el que crear la pestaña
	 * @param $data     Datos a insertar en la pestaña
	 */
	private function addSheet($name, $excel, $data)
	{
		if(count($data) > 0) {
			$excel->sheet($name, function($sheet) use ($data) {
				$sheet->fromArray($data);
				$sheet->freezeFirstRow();
				$sheet->setHeight(1, 20);
				$sheet->row(1, function($row) {
					$row->setBackground('#C6EFD8');
					$row->setFontColor('#006100');
					$row->setAlignment('center');
					$row->setValignment('center');
				});
			});
		}
		else {
			$excel->sheet($name, function($sheet) {
				$sheet->row(1, array('No data available'));
			});
		}
    }

	/**
	 * Doy formato de array de arrays necesario para exportar a excel.
	 *
	 * @param  $array
	 * @return array
	 */
	private function format($array)
	{
		return array_map( function($item) {
			$entry = [];
			$entry['nombre'] = $item->user_name;
			if (property_exists($item, '_date')) $entry['fecha'] = $item->_date;
			if (property_exists($item, '_month')) $entry['mes'] = $item->_month;
			if (property_exists($item, '_week')) $entry['semana'] = $item->_week;
			if (property_exists($item, 'type')) $entry['tipo'] = $item->type;
			if (property_exists($item, 'comments')) $entry['comentarios'] = $item->comments;

			if (property_exists($item, 'type')) {
				$entry['check_In'] = $item->check_in;
				$entry['check_Out'] = $item->check_out;
			}

			$entry['estimado'] = (float) $this->formatSecondsToDecimal($item->hoursToWork);
			$entry['trabajado'] = (float) $this->formatSecondsToDecimal($item->secs);

			if (property_exists($item, 'average')) {
				$entry['tiempo_medio'] = (float) $this->formatSecondsToDecimal($item->average);
			}

			$entry['horas_nocturnas'] = (float) $this->formatSecondsToDecimal($item->night_shift);
			$entry['horas_diurnas'] = $entry['trabajado'] - $entry['horas_nocturnas'];
			return $entry;
		}, $array);
	}
}
