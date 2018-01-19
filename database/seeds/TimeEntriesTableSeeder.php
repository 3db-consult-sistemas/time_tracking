<?php

use App\User;
use App\TimeEntry;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TimeEntriesTableSeeder extends Seeder
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
        $startDate = Carbon::now()->subDay(7);

        for ($i=1; $i <= 7; $i++) {
            foreach ($users as $user) {
                $date = $startDate->copy()->addDay($i)->format('Y-m-d');

                $checkIn = Carbon::createFromTimeStamp($faker->dateTimeBetween("{$date} 08:20:00", "{$date} 09:10:00")->getTimestamp());
                $checkOut = $checkIn->copy()->addMinutes($faker->numberBetween(180, 360));
                $this->createEntry($user->id, $checkIn, $checkOut);

                $checkIn = $checkOut->addMinutes($faker->numberBetween(30, 70));
                $checkOut = $checkIn->copy()->addMinutes($faker->numberBetween(120, 240));
                $this->createEntry($user->id, $checkIn, $checkOut);
            }
        }
    }

    private function createEntry($id, $checkIn, $checkOut) {
        TimeEntry::create([
            'user_id' => $id,
            'check_in' => $checkIn,
            'check_out' => $checkOut
        ]);
    }
}
