<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Role;
use Illuminate\Database\Seeder;

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
            'names' => 'Pastor Name',
            'last_names' => 'Apellido Pastor',
            'code' => 123456789,
            'email' => 'neisserrey@upeu.edu.pe',
            'phone' => 123456789,
            'type_id' => 1
        ]);

        $user = $person->user()->create([
            'name' => $person->getFirstNameAndLastNameBy('.'),
            'password' => 'password',
            'is_active' => true,
        ]);

        $user->assignRole(Role::ADMINISTRADOR);
    }
}
