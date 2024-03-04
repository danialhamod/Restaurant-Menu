<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    /**
     * Check if the current collection is paginated.
     *
     * @return bool
     */
    protected function isPaginated(): bool
    {
        return method_exists($this->resource, 'total') && $this->resource->total() !== null;
    }
}
