<?php
namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    private $searchFields = ['name'];

    public function search($search, $pageSize, $all)
    {
        $query = Category::query();
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                foreach ($this->searchFields as $field) {
                    $q->orWhere($field, 'like', '%' . $search . '%');
                }
            });
        }

        return $all ? $query->get() : $query->paginate($pageSize);
    }

    public function create(array $attributes)
    {
        return Category::create($attributes);
    }

    public function findById($id)
    {
        return Category::find($id);
    }

    public function update($id, array $attributes)
    {
        $category = $this->findById($id);
        if ($category)
            $category->update($attributes);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->findById($id);
        if ($category)
            $category->delete();
        return $category;
    }

    public function potintialParents($id)
    {
        $categories = Category::where('id', '<>', $id)->get();

        $potentialParents = [];
        foreach ($categories as $category) {
            if (!$category->isDescendantOf($id, $categories)) {
                $potentialParents[] = $category;
            }
        }
        return $potentialParents;
    }
}
