<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Añado los proyectos
        $projects = [
            [ 'name' => 'RANEVO - Diseño', 'enabled' => false ],
            [ 'name' => 'RANEVO - IT' ],
            [ 'name' => 'RANEVO - OPT' ],
            [ 'name' => 'ANE - Diseño' ],
            [ 'name' => 'ANE - IT', 'enabled' => false ],
            [ 'name' => 'Formación - En puesto' ],
            [ 'name' => 'Formación - Curso' ],
            [ 'name' => 'Formación - Desarrollos' ]
        ];

        for ($i=0; $i < count($projects); $i++) {
            $projects[$i]['id'] = DB::table('projects')->insertGetId($projects[$i]);
        }

        // Creo las relaciones entre usuarios y proyectos as los que puede reportar
        $users = User::all();

        foreach ($users as $user) {
            $arrayIndex = array_rand($projects, $faker->numberBetween(2, 4));

            foreach ($arrayIndex as $index) {
                DB::table('project_user')->insertGetId(['project_id' => $projects[$index]['id'], 'user_id' => $user->id]);
            }
        }
    }
}
