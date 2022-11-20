<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GolResource extends JsonResource
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
            'name' => $this->name,
            'motto' => $this->motto,
            'chant' => $this->chant,
            'verse' => $this->verse,
            'photo' => $this->getPhoto(),
            $this->mergeWhen($this->relationLoaded('cycle'), [
                'cycle' => $this->cycle->name,
                'school' => $this->cycle->school->name,
            ]),
        ];
    }
}
