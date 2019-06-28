<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'projects';

    /**
	 * Indicates if the model should be timestamped.
	 */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status'];

    /**
     * The users that belong to the project.
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }
}
