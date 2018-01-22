<?php

namespace App\Model\TimeEntry;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'time_entries';

    /**
	 * Indicates if the model should be timestamped.
	 */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'check_in', 'check_out', 'type', 'comments'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['check_in', 'check_out'];

}
