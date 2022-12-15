<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'banner' => $this->getBanner(),
            'programmed_at' => $this->programmed_at,
            'status' => $this->status,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'topic' => new TopicResource($this->whenLoaded('topic'))
        ];
    }
}
