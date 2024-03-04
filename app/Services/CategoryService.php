<?php

namespace App\Services;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Responses\ApiCode;
use App\Interfaces\RepositoryInterface;
use App\Traits\WrapsApiResponse as WrapsApiResponse;

class CategoryService
{
    use WrapsApiResponse;

    protected $categoryRepository;

    public function __construct(RepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function list($request)
    {
        $search = $request->get('query');
        $pageSize = $request->get('page_size') ?? 10;
        $all = $request->boolean('all');

        $categories = $this->categoryRepository->search($search, $pageSize, $all);
        return $this->respondSuccess(new CategoryCollection($categories));
    }

    public function add($request)
    {
        $category = $this->categoryRepository->create($request->validated());
        return $this->respondSuccess(new CategoryResource($category->fresh()));
    }

    public function get($id)
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            return $this->respondError('Category doesn\'t exist anymore', ApiCode::NotFound);
        }
        return $this->respondSuccess(new CategoryResource($category));
    }

    public function update($request, $id)
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            return $this->respondError('Category doesn\'t exist anymore', ApiCode::NotFound);
        }
        $category = $this->categoryRepository->update($id, $request->validated());
        return $this->respondSuccess(new CategoryResource($category->fresh()));
    }

    public function delete($id)
    {
        $this->categoryRepository->delete($id);
        return ['message' => 'done'];
    }
}
