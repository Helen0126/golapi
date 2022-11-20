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
            $this->mergeWhen($this->relationLoaded('cycle'), [
                'cycle' => $this->cycle->name ?? '',
                'school' => $this->cycle->school->name ?? '',
                'gol' => $this->cycle->gol->name,
            ]),
            // $this->mergeWhen($this->relationLoaded('gol'), [
            //     'gol' => $this->gol->name ?? '',
            // ]),
        ];
    }
}
