<?php

use App\User;
use App\Model\Record\Record;
use App\Model\Ticket\Ticket;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $admin = User::where('username', 'ivan.iglesias')->first();

        $records = Record::where('user_id', '!=', $admin->id)
            ->whereDate ('check_in', Carbon::yesterday()->format('Y-m-d'))
            ->orderBy('check_in', 'desc')
            ->limit(5)
            ->get();

        foreach ($records as $record)
        {
            $status = 'open';
            $closedBy = null;
            $comments = null;

            if ($faker->boolean(0))
            {
                $status = 'close';
                $closedBy = $admin->id;
                $comments = $faker->sentence($nbWords = 6, $variableNbWords = true);
            }

            Ticket::create([
                'user_id' => $record->user_id,
                'record_id' => $record->id,
                'closed_by_id' => $closedBy,
                'status' => $status,
                'comments' => $comments
            ]);
        }
    }
}
