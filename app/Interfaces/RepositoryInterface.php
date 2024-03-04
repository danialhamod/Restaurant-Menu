<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function search($search, $pageSize, $all);
    public function create(array $attributes);
    public function findById($id);
    public function update($id, array $attributes);
    public function delete($id);
}
