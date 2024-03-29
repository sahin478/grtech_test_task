<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray(
        //         'id' => $this->id,
        //         'name' => $this->name,
        //         'email' => $this->email,
        //         'logo' => $this->logo ? asset($this->logo) : null,
        //         'website' => $this->website,
        //         'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        //         'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        //     );
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $this->logo ? asset($this->logo) : null,
            'website' => $this->website,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
