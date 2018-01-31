<?php

namespace App\Model\Timetable;

use Carbon\Carbon;
use App\Model\Timetable\Timetable;

class TimetableRepository
{
	/**
	 * Instantiate a repository's model.
	 *
	 * @return Timetable
	 */
	public function getModel()
	{
		return new Timetable;
    }

    /**
     * Obtengo la fecha del ultimo horario existente.
     *
     * @param $id
     * @return void
     */
    public function lastDate($userId)
    {
        return $this->getModel()
            ->where('user_id', $userId)
            ->orderBy('from_date', 'desc')
            ->value('from_date');
    }

    /**
     * Creo el nuevo horario.
     *
     * @param $data
     * @return boolean
     */
    public function create(array $data)
    {
        $this->delete([
            'userId' => $data['user_id'],
            'fromDate' => $data['from_date']->format('Y-m-d'),
        ]);

        return $this->getModel()->create($data);
    }

    /**
     * Elimino un horario.
     *
     * @param $data
     * @return boolean
     */
    public function delete($data)
    {
        if (is_array($data)) {
            return $this->getModel()
                ->where('user_id', $data['userId'])
                ->where('from_date', $data['fromDate'])
                ->delete();
        }

        return $this->getModel()->find($data)->delete();
    }
}
