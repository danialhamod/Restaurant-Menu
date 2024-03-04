<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CategoryCollection extends BaseResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->isPaginated()) {
            return [
                'data' => $this->collection,
                'total' => $this->resource->total(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
            ];
        } 
        return [
            'data' => $this->collection,
        ];
    }
}
