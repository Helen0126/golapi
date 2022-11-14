<?php

namespace App\Actions;

use App\Models\Person;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class SaveUserFromPerson
{
    use AsAction;

    public function handle(Person $person, bool $is_active = false): User
    {
        return $person->user()->create([
            'name' => $person->getFirstNameAndLastNameBy('.'),
            'password' => 'password',
            'is_active' => $is_active,

        ]);
    }
}
