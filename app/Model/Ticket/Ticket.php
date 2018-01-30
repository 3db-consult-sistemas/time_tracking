<?php

namespace App\Model\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'tickets';

    /**
	 * Indicates if the model should be timestamped.
	 */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status', 'comments',
    ];

    /**
     * Get the record that owns the ticket.
     */
    public function record()
    {
        return $this->belongsTo(\App\Model\Record\Record::class);
    }
}
