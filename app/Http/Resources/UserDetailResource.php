<?php

namespace App\Http\Resources;

use App\Models\Event;
use Carbon\Carbon;
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
                'avatar' => $this->fetchFirstMedia()->file_url ?? 'https://ui-avatars.com/api/?name=' . $this->person->getFirstNameAndLastNameBy('+'),
            ]),
            'event' => Event::whereProgrammedAt(Carbon::parse(now())->next(Carbon::FRIDAY))
                ->whereGolId($this->person->cycle->gol->id)->first(),
            'roles' => $this->getRoleNames(),
        ];
    }
}
