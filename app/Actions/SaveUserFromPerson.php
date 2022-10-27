<?php

namespace App\Actions;

use App\Models\Person;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class SaveUserFromPerson
{
    use AsAction;

    public function handle(Person $person): User
    {
        return $person->user()->create([
            'name' => $person->code,
            'password' => 'password',
        ]);
    }
}
