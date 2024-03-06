<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'discount' => $this->discount,
            'parent_id' => $this->parent_id,
            'parent_name' => $this->parent ? $this->parent->name : '',
            'created_at' => Carbon::parse($this->created_at)->format('M d Y'),
        ];
    }
}
