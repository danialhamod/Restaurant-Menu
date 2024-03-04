<?php

namespace App\Services;

use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Http\Responses\ApiCode;
use App\Interfaces\ItemRepositoryInterface;
use App\Traits\WrapsApiResponse as WrapsApiResponse;

class ItemService
{
    use WrapsApiResponse;

    protected $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function list($request)
    {
        $search = $request->get('query');
        $pageSize = $request->get('page_size') ?? 10;
        $all = $request->boolean('all');

        $categories = $this->itemRepository->search($search, $pageSize, $all);
        return $this->respondSuccess(new ItemCollection($categories));
    }

    public function add($request)
    {
        $item = $this->itemRepository->create($request->validated());
        return $this->respondSuccess(new ItemResource($item->fresh()));
    }

    public function get($id)
    {
        $item = $this->itemRepository->findById($id);
        if (!$item) return $this->notFound();
        return $this->respondSuccess(new ItemResource($item));
    }

    public function update($request, $id)
    {
        $item = $this->itemRepository->update($id, $request->validated());
        if (!$item) return $this->notFound();
        return $this->respondSuccess(new ItemResource($item->fresh()));
    }

    public function delete($id)
    {
        $item = $this->itemRepository->delete($id);
        if (!$item) return $this->notFound();
        return $this->respondSuccess();
    }

    private function notFound() {
        return $this->respondError('Item doesn\'t exist anymore', ApiCode::NotFound);
    }
}
