<?php

use App\User;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Model\Record\Record;

class RecordsTableSeeder extends Seeder
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

        for ($i=1; $i <= 10; $i++) {
            foreach ($users as $user) {
                $date = $startDate->copy()->addDay($i)->format('Y-m-d');
                $ip = $faker->numberBetween(188888888, 9999999999);

                $checkIn = Carbon::createFromTimeStamp($faker->dateTimeBetween("{$date} 08:20:00", "{$date} 09:10:00")->getTimestamp());
                $checkOut = $checkIn->copy()->addMinutes($faker->numberBetween(180, 360));
                $this->createEntry($user->id, $checkIn, $checkOut, $ip);

                $checkIn = $checkOut->addMinutes($faker->numberBetween(30, 70));
                $checkOut = $checkIn->copy()->addMinutes($faker->numberBetween(120, 240));
                $this->createEntry($user->id, $checkIn, $checkOut, $ip);
            }
        }
    }

    private function createEntry($id, $checkIn, $checkOut, $ip) {
        Record::create([
            'user_id' => $id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'night_shift' => 0,
            'ip' => $ip
        ]);
    }
}
