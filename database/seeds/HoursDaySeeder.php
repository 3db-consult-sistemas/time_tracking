<?php

use App\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HoursDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();
        $startDate = Carbon::now()->subDay(10);

        foreach ($users as $user) {
            $this->createEntry($user->id, $startDate, 25200);   // 07:00

            if ($faker->boolean(60) || $user->id == 1) {
                $date = $faker->dateTimeBetween($startDate->copy()->addDay(7), Carbon::now());
                $this->createEntry($user->id, $date, 29700); // 8:15
            }
        }
    }

    private function createEntry($id, $date, $seconds) {
        DB::table('hours_day')->insert([
            'user_id' => $id,
            'from_date' => $date,
            'monday' => $seconds,
            'tuesday' => $seconds,
            'wednesday' => $seconds,
            'thursday' => $seconds,
            'friday' => $seconds
        ]);
    }
}
