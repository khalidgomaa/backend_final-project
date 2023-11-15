<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VeterinaryCenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'street_address' => $this->street_address,
            'governorate' => $this->governorate,
            'about' => $this->about,
            'open_at' => $this->open_at,
            'close_at' => $this->close_at,
            'logo' => $this->logo,
            'license' => $this->license,
            'tax_record' => $this->tax_record,
            'commercial_record' => $this->commercial_record,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'doctors' => $this->doctors,
        ];
    }
}
