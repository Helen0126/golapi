<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;
use App\Actions\SaveUserFromPerson;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $person = Person::create([
            'names' => 'Neisser David',
            'last_names' => 'Rey Gutierrez',
            'code' => 201410859,
            'email' => 'neisserrey@upeu.edu.pe',
            'phone' => 123456789,
        ]);

        $user = SaveUserFromPerson::make()->handle($person);

        $user->assignRole('Administrador');
    }
}
