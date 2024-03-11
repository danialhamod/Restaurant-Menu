<?php
namespace App\Repositories;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface
{
    private $searchFields = ['name'];

    public function search($search, $pageSize, $all)
    {
        $query = Item::with('category');
        
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
        return Item::create($attributes);
    }

    public function findById($id)
    {
        return Item::with('category')->find($id);
    }

    public function update($id, array $attributes)
    {
        $item = $this->findById($id);
        if ($item)
            $item->update($attributes);
        return $item;
    }

    public function delete($id)
    {
        $item = $this->findById($id);
        if ($item)
            $item->delete();
        return $item;
    }
}
