<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index(Request $request)
    {
        return $this->itemService->list($request);
    }

    public function store(CreateItemRequest $request)
    {
        return $this->itemService->add($request);
    }

    public function show($id)
    {
        return $this->itemService->get($id);
    }

    public function update(UpdateItemRequest $request, $id)
    {
        return $this->itemService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->itemService->delete($id);
    }
}