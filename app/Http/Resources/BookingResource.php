<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'booking_id'   => $this->booking_id,
            'booking_date' => $this->booking_date->format('Y-m-d'),
            'start_time'   => $this->start_time->format('H:i'),
            'end_time'     => $this->end_time->format('H:i'),
            'status'       => $this->status,
            'total_fee_php'=> $this->total_fee_php,
            'purpose'      => $this->purpose,

            // Showing only what's necessary
            'user' => $this->whenLoaded('user', function () {
                return [
                    'user_id' => $this->user->user_id,
                    'name'    => $this->user->name,
                ];
            }),

            // Showing only what's necessary
            'amenity' => $this->whenLoaded('amenity', function () {
                return [
                    'amenity_id'   => $this->amenity->amenity_id,
                    'name'         => $this->amenity->name,
                    'building_name'=> $this->amenity->building_name,
                ];
            }),
        ];
    }
}
