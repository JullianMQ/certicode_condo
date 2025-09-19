<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmenityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amenity_id' => $this->amenity_id,
            'name' => $this->name,
            'building_name' => $this->building_name,
            'capacity' => $this->capacity,
            'is_bookable' => $this->is_bookable,
            'fee_per_hour_php' => $this->fee_per_hour_php,
            'start_hours' => $this->start_hours->format('H:i'),
            'end_hours' => $this->end_hours->format('H:i'),
            'advance_booking_days' => $this->advance_booking_days,
        ];
    }
}
