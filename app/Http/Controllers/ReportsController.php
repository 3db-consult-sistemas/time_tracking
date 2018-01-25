<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ReportRequest;
use App\Model\Record\RecordRepository;

class ReportsController extends Controller
{
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


    public function index()
    {
        return view('reports.index');
    }

    public function download(ReportRequest $request)
    {
        dd('hola');
        //$entries = $this->recordRepository->fetch($data);




        $data = [
            ['name' => 'ivan'],
            ['name' => 'madoka']
        ];

    	$fileName = Carbon::now()->format('Ymd_Hi') . '_reporte';

		Excel::create($fileName, function($excel) use ($data) {
            $this->addSheet('reporte', $excel, $data);
            //$this->addSheet($data['type'], $excel, $this->getFrom($data));
		})->export('xlsx');
    }

	/**
	 * Filtro las alarmas de un tipo determinado.
	 *
	 * @param  $data
	 * @return array
	 */
	private function getFrom($data)
	{
		$array = $this->alarmRepository->fetch($data);

		return array_map( function($item) {
			return get_object_vars($item);
		}, $array);
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




}
