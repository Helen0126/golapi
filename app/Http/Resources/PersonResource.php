<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'id' => $this->id,
            'names' => $this->names,
            'last_names' => $this->last_names,
            'code' => $this->code,
            'email' => $this->email,
            'phone' => $this->phone,
            $this->mergeWhen($this->relationLoaded('grade'), [
                'grade' => $this->grade ? $this->grade->name : '',
                'school' => $this->grade->name ? $this->grade->school->name : '',
            ]),
        ];
    }
}
