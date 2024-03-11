<?php

namespace App\Rules;

use App\Enums\ChildTypes;
use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class DontHaveMixedChilds implements Rule
{
    protected $relation;

    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $parentId)
    {
        // Retrieve the already validated 'exists' rule result
        $existsRuleResult = app('validator')->make(
            [$attribute => $parentId],
            [$attribute => 'exists:categories,id']
        )->passes();

        if (!$existsRuleResult) {
            return false;
        }
        $category = Category::with(['items', 'subcategories'])->find($parentId);
        $childsCount = $this->relation === ChildTypes::Item ? $category->items()->count() : $category->subcategories()->count();
        return $childsCount === 0;
    }

    /**
     * Get the validation error message.
     *
     * @param string $attribute
     * @return string
     */
    public function message()
    {
        return "Category or subcategory must not have mixed children.";
    }
}

