<?php

namespace App;

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
     * Get the timetable records associated with the user.
     */
    public function timetables()
    {
        return $this->hasMany(\App\Model\HoursDay\HoursDay::class);
    }
}
