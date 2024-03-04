<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
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
}
