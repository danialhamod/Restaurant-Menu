<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class MaxLevelSubCategory implements Rule
{
    protected $maxLevel;
    protected $categoryRepository;

    public function __construct($maxLevel)
    {
        $this->maxLevel = $maxLevel;
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

        return $existsRuleResult && Category::find($parentId)->isUnderMaxLavel($this->maxLevel);
    }

    /**
     * Get the validation error message.
     *
     * @param string $attribute
     * @return string
     */
    public function message()
    {
        return "Subcategory cannot be created more than " . $this->maxLevel . " levels deep.";
    }
}
