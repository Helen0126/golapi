<?php

namespace Database\Seeders;

use App\Actions\SaveUserFromPerson;
use App\Models\Cycle;
use App\Models\Person;
use App\Models\Role;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Str;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tutoresSistemas = [
            [
                'names' => 'Nancy',
                'last_names' => 'Casildo',
                'cycle_id' => 2,
                'gender' => 'Femenino'
            ],
            [
                'names' => 'Hitler',
                'last_names' => 'Collantes',
                'cycle_id' => 4,
                'gender' => 'Masculino'
            ],
            [
                'names' => 'Joseph',
                'last_names' => 'Cruz Rodriguez',
                'cycle_id' => 6,
                'gender' => 'Masculino'
            ],
            [
                'names' => 'Sergio',
                'last_names' => 'Valladares',
                'cycle_id' => 8,
                'gender' => 'Masculino'
            ],
            [
                'names' => 'Danny',
                'last_names' => 'Levano Rodriguez',
                'cycle_id' => 10,
                'gender' => 'Masculino'
            ],
            [
                'names' => 'Baldwin',
                'last_names' => 'Huaman Laban',
                'cycle_id' => 10,
                'gender' => 'Masculino'
            ],
        ];

        foreach ($tutoresSistemas as $tutor) {
            $person = Person::create([
                'names' => $tutor['names'],
                'last_names' => $tutor['last_names'],
                'code' => fake()->unique()->randomNumber(9),
                'email' => $this->getFirstNameAndLastNameBy($tutor['names'], $tutor['last_names'], '') . '@upeu.edu.pe',
                'phone' => fake()->unique()->randomNumber(9),
                'type_id' => Type::TUTOR,
                'gender' => $tutor['gender'],
                'cycle_id' => Cycle::whereSchoolId(1)->whereName($tutor['cycle_id'])->first()->id,
            ]);

            $user = SaveUserFromPerson::make()->handle($person, true);
            $user->syncRoles([Role::TUTOR]);
        }

        $tutoresAmbiental = [
            [
                'names' => 'Reyna',
                'last_names' => 'Idelfonso',
                'cycle_id' => 2,
                'gender' => 'Femenino'
            ],
            [
                'names' => 'Balbina',
                'last_names' => 'Cordova',
                'cycle_id' => 2,
                'gender' => 'Femenino'
            ],
            [
                'names' => 'Ana',
                'last_names' => 'Casildo',
                'cycle_id' => 4,
                'gender' => 'Femenino'
            ],
            [
                'names' => 'Jessica',
                'last_names' => 'Perez Rivera',
                'cycle_id' => 6,
                'gender' => 'Femenino'
            ],
            [
                'names' => 'David',
                'last_names' => 'German Chacon',
                'cycle_id' => 8,
                'gender' => 'Masculino'
            ],
        ];

        foreach ($tutoresAmbiental as $tutor) {
            $person = Person::create([
                'names' => $tutor['names'],
                'last_names' => $tutor['last_names'],
                'code' => fake()->unique()->randomNumber(9),
                'email' => $this->getFirstNameAndLastNameBy($tutor['names'], $tutor['last_names'], '') . '@upeu.edu.pe',
                'phone' => fake()->unique()->randomNumber(9),
                'type_id' => Type::TUTOR,
                'gender' => $tutor['gender'],
                'cycle_id' => Cycle::whereSchoolId(2)->whereName($tutor['cycle_id'])->first()->id,
            ]);

            $user = SaveUserFromPerson::make()->handle($person, true);
            $user->syncRoles([Role::TUTOR]);
        }

        $tutoresArqui = [
            [
                'names' => 'Astrid',
                'last_names' => 'Zapata',
                'cycle_id' => 2,
                'gender' => 'Femenino',
            ],
            [
                'names' => 'Adesmiro',
                'last_names' => 'Zelada Escobedo',
                'cycle_id' => 2,
                'gender' => 'Masculino',
            ],
            [
                'names' => 'Carolina',
                'last_names' => 'Pariacuri',
                'cycle_id' => 4,
                'gender' => 'Femenino',
            ],
            [
                'names' => 'Jhon Harol',
                'last_names' => 'Gonzales Garay',
                'cycle_id' => 6,
                'gender' => 'Masculino',
            ],
            [
                'names' => 'Daniela',
                'last_names' => 'Concha',
                'cycle_id' => 8,
                'gender' => 'Femenino',
            ],
        ];

        foreach ($tutoresArqui as $tutor) {
            $person = Person::create([
                'names' => $tutor['names'],
                'last_names' => $tutor['last_names'],
                'code' => fake()->unique()->randomNumber(9),
                'email' => $this->getFirstNameAndLastNameBy($tutor['names'], $tutor['last_names'], '') . '@upeu.edu.pe',
                'phone' => fake()->unique()->randomNumber(9),
                'type_id' => Type::TUTOR,
                'gender' => $tutor['gender'],
                'cycle_id' => Cycle::whereSchoolId(3)->whereName($tutor['cycle_id'])->first()->id,
            ]);

            $user = SaveUserFromPerson::make()->handle($person, true);
            $user->syncRoles([Role::TUTOR]);
        }
    }

    public function getFirstNameAndLastNameBy(string $names, string $last_names, string $dotOrPlus)
    {
        $first_name = Str::of(Str::lower(trim($names)))->explode(' ')[0];
        $last_name  = Str::of(Str::lower(trim($last_names)))->explode(' ')[0];

        return $first_name . $dotOrPlus . $last_name;
    }
}
