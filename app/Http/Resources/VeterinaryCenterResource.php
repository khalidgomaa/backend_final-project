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
            'name' => $this->name,
            'street_address' => $this->street_address,
            'governorate' => $this->governorate,
            'about' => $this->about,
            'logo' => $this->logo,
            'license' => $this->license,
            'tax_record' => $this->tax_record,
            'commercial_record' => $this->commercial_record,
        ];
    }
}
