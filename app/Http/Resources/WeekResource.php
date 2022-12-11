<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;

class WeekResource extends JsonResource
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
            'event_date' => Str::title(Carbon::parse($this->event_date)->translatedFormat('l jS \\de F')),
            $this->mergeWhen($this->relationLoaded('topics'), [
                'topics' => new TopicResource($this->topics)
            ]),
        ];
    }
}
