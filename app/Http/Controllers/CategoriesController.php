<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        return $this->categoryService->list($request);
    }

    public function store(CreateCategoryRequest $request)
    {
        return $this->categoryService->add($request);
    }

    public function show($id)
    {
        return $this->categoryService->get($id);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        return $this->categoryService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->categoryService->delete($id);
    }
}