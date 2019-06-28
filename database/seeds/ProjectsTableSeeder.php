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
        $data = [
			[ 'name' => 'Vacaciones', 'status' => 2 ],
			[ 'name' => 'Baja', 'status' => 2 ],
			[ 'name' => 'Formación - En puesto', 'status' => 1 ],
            [ 'name' => 'Formación - Curso', 'status' => 1 ],
			[ 'name' => 'Formación - Desarrollos', 'status' => 1 ],
			[ 'name' => 'Comité', 'status' => 4 ],
			[ 'name' => 'Igualdad', 'status' => 4 ],
			[ 'name' => 'Gerencia', 'status' => 4 ],
			[ 'name' => 'Sistemas', 'status' => 4 ],

            [ 'name' => 'RANEVO - Diseño', 'status' => 3 ],
            [ 'name' => 'RANEVO - IT', 'status' => 4 ],
            [ 'name' => 'RANEVO - OPT', 'status' => 4 ],
            [ 'name' => 'ANE - Diseño', 'status' => 4 ],
            [ 'name' => 'ANE - IT', 'status' => 3 ]
        ];

		$projects = [];
        for ($i=0; $i < count($data); $i++) {
			$data[$i]['id'] = DB::table('projects')->insertGetId($data[$i]);

			if ($data[$i]['status'] > 2) { $projects[] = $data[$i]; }
        }

        // Creo las relaciones entre usuarios y proyectos a los que puede reportar
        $users = User::all();

        foreach ($users as $user) {
            $arrayIndex = array_rand($projects, $faker->numberBetween(2, 4));

            foreach ($arrayIndex as $index) {
                DB::table('project_user')->insertGetId(['project_id' => $projects[$index]['id'], 'user_id' => $user->id]);
            }
        }
    }
}
