<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository
{
	/**
	 * Instantiate a repository's model.
	 *
	 * @return Record
	 */
	public function getModel()
	{
		return new User;
    }

    /**
     * Filtro los usuarios existentes con el estado correspondiente.
     *
     * @return array
     */
    public function fetch($enabled = null)
    {
        $now = Carbon::now();

        $enabled = $enabled === null ? '' : "WHERE users.enabled = {$enabled}";

        $users = DB::select(DB::raw(
            "SELECT users.id, users.name, users.role, users.email, users.username, records.type, records.check_in, records.check_out, 'N/A' as status, 'default' as class
            FROM users LEFT JOIN records ON records.id = (
                SELECT id FROM records
                WHERE records.user_id = users.id AND
                    (records.check_out IS NULL OR (records.check_out > '{$now}' AND records.type = 'ausencia')
                )
            LIMIT 1)
            {$enabled}
            ORDER BY users.name"));

        return $this->status($users);
    }

    /**
     * Obtengo el estado del usuario.
     *
     * @return string
     */
    protected function status($users)
    {
        foreach ($users as $user) {
            if ($user->type == null) {
                $user->status = 'close';
                $user->class = 'danger';
                continue;
            }

            if ($user->check_out != null) {
                $user->status = 'absence-planned';
                $user->class = 'warning';
                continue;
            }

            if ($user->type == 'ausencia') {
                $user->status = 'absence';
                $user->class = 'warning';
                continue;
            }

            $user->status = 'open';
            $user->class = 'success';
        }
        return $users;
    }
}
