<?php

namespace App\Services;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryIndexResource;
use App\Http\Resources\CategoryResource;
use App\Http\Responses\ApiCode;
use App\Interfaces\CategoryRepositoryInterface;
use App\Traits\WrapsApiResponse as WrapsApiResponse;

class CategoryService
{
    use WrapsApiResponse;

    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
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
        if (!$category) return notFound();
        return $this->respondSuccess(new CategoryResource($category));
    }

    public function update($request, $id)
    {
        $category = $this->categoryRepository->update($id, $request->validated());
        if (!$category) return notFound();
        return $this->respondSuccess(new CategoryResource($category->fresh()));
    }

    public function delete($id)
    {
        $category = $this->categoryRepository->delete($id);
        if (!$category) return notFound();
        return $this->respondSuccess();
    }

    public function potintialParents($id)
    {
        $categories = $this->categoryRepository->potintialParents($id);
        return $this->respondSuccess(CategoryIndexResource::collection($categories));
    }
}
