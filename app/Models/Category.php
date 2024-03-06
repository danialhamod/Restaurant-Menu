<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $append = ['parent'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'parent_id',
        'discount'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->HasMany(Category::class, 'parent_id');
    }

    public function items()
    {
        return $this->HasMany(Item::class);
    }

    public function isUnderMaxLavel($maxLevel)
    {
        $count = 0;
        $currentCategory = $this;

        while ($currentCategory->parent) {
            $currentCategory = $currentCategory->parent;
            $count++;
            if ($count >= $maxLevel) {
                return false;
            }
        }

        return true;
    }

    public function getClosestDiscount()
    {
        $count = 0;
        $currentCategory = $this;

        while ($currentCategory) {
            if ($currentCategory->discount) {
                return $currentCategory->discount;
            }
            $currentCategory = $currentCategory->parent;
        }

        return 0;
    }
    
}
