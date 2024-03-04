<?php

namespace App\Http\Resources;

use App\Enums\AppSettingsKeys;
use App\Models\AppSettings;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'price' => $this->price,
            'discount' => $this->discount,
            'discounted_price' => $this->calculateDiscountedPrice($this->price),
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function calculateDiscountedPrice($originalPrice)
    {
        // Begin with item discount:
        $discount = $this->discount ?? 0;

        // If item has no discount search for closest parent (category) discount:
        if (!$discount) {
            $discount = $this->category->getClosestDiscount();
        }

        // If all parents (categories) have no discount we should see global menu discount:
        if (!$discount) {
            $discount = AppSettings::where('key', AppSettingsKeys::GlobalDiscount)->first()->value;
        }
        
        return $originalPrice - ($originalPrice * $discount / 100);
    }
}
