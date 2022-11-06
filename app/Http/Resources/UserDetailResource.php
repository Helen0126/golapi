<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            // 'id' => $this->id,
            'name' => $this->name,
            $this->mergeWhen($this->relationLoaded('person'), [
                'person' => new PersonResource($this->whenLoaded('person')),
                'avatar' => $this->fetchFirstMedia()->file_url ?? 'https://ui-avatars.com/api/?name=' . $this->person->getFirstNameAndLastName(),
            ]),
            // $this->mergeWhen($this->relationLoaded('person.grade'), [
            //     'grade' => $this->person->grade,
            //     'school' => $this->fetchFirstMedia()->file_url ?? 'https://ui-avatars.com/api/?name=' . $this->person->getFirstNameAndLastName(),
            // ]),
            'roles' => $this->getRoleNames(),
            // $this->mergeWhen($this->hasAnyRole(['Tutor', 'Estudiante']), [
            //     'school' => $this->school->name,
            //     'grade' => $this->school->name,
            //     'person' => new PersonResource($this->whenLoaded('person')),
            //     'avatar' => $this->fetchFirstMedia()->file_url ?? 'https://ui-avatars.com/api/?name=' . $this->person->getFirstNameAndLastName(),
            // ]),
        ];
    }
}
