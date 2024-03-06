<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class NotDescendantCategory implements Rule
{
    private $categoryId;

    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function passes($attribute, $parentId)
    {
        // Retrieve the already validated 'exists' rule result
        $existsRuleResult = app('validator')->make(
            [$attribute => $parentId],
            [$attribute => 'exists:categories,id']
        )->passes();

        // Check if the selected parent category is not a child of the category being edited
        return ! Category::find($parentId)->isDescendantOf($this->categoryId);
    }

    public function message()
    {
        return 'The selected parent category cannot be a descendant of the current category.';
    }
}
