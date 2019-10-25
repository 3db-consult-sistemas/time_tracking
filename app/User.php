<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the tickets records associated with the user.
     */
    public function tickets()
    {
        return $this->hasMany(\App\Model\Ticket\Ticket::class);
    }

    /**
     * Get the tickets records associated with the user.
     */
    public function closedTickets()
    {
        return $this->hasMany(\App\Model\Ticket\Ticket::class, 'closed_by_id');
    }

    /**
     * Get the records associated with the user.
     */
    public function records()
    {
        return $this->hasMany(\App\Model\Record\Record::class);
    }

    /**
     * The projects that belong to the user.
     */
    public function projects(bool $withDisabled = false)
    {
		return $this->belongsToMany(\App\Model\Project\Project::class);
	}

	/**
	 * Proyectos a los que el usuario puede reportar.
	 */
    public function availableProjects($allProjects = False)
    {
        $userId = $this->id;

        $where = $allProjects ? " or status='1'" : '';

		$query = "SELECT id, status, name FROM project_user AS pu
				JOIN projects AS p ON p.id = pu.project_id WHERE pu.user_id = {$userId}
				UNION (SELECT id, status, name FROM projects WHERE status='2' {$where})
                ORDER BY status, name";

		return DB::select(DB::raw($query));
    }

    /**
     * Get the timetable records associated with the user.
     */
    public function timetables()
    {
        return $this->hasMany(\App\Model\Timetable\Timetable::class)
            ->orderBy('from_date', 'desc')
            ->select([
                'id',
                 DB::raw("DATE(from_date) as date"),
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            ]);
    }
}
