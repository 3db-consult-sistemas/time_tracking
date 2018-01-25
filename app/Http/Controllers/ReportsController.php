<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Model\Helpers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ReportRequest;
use App\Model\Record\RecordRepository;

class ReportsController extends Controller
{
	use Helpers;

    protected $recordRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RecordRepository $recordRepository)
    {
        $this->recordRepository = $recordRepository;

        $this->middleware(['auth', 'checkrole:super_admin,admin']);
    }

    /**
     * Visualizo la vista de reportes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.index');
	}

    /**
     * Aplico el filtro seleccionado y descargo la informacion en formato excel.
     *
     */
    public function download(ReportRequest $request)
    {
		$entries = $this->recordRepository->fetch($request->all());

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
			$entry['mes'] = $item->_month;
			if (property_exists($item, '_week')) $entry['semana'] = $item->_week;
			if (property_exists($item, 'type')) {
				$entry['tipo'] = $item->type;
				$entry['check_In'] = $item->check_in;
				$entry['check_Out'] = $item->check_out;
			}
			$entry['trabajado'] = $this->formatSeconds($item->secs);
			$entry['estimado'] = $this->formatSeconds($item->hoursToWork);
			if (property_exists($item, 'average')) $entry['tiempo_medio'] = $this->formatSeconds($item->average);
			if (property_exists($item, 'comments')) $entry['comentarios'] = $item->comments;
			return $entry;

			/*
			unset($item->user_id);
			if (property_exists($item, 'average')) {
				$item->average = $this->formatSeconds($item->average);
			}
			$item->secs = $this->formatSeconds($item->secs);
			$item->hoursToWork = $this->formatSeconds($item->hoursToWork);
			return get_object_vars($item);
			*/
		}, $array);
	}
}
