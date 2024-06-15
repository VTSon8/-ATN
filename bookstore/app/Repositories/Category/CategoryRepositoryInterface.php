<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function getAllCategory();

    public function getAll();

    public function getCategoryBySlug(string $slug);

    public function createCategory(array $params);

    public function getCategoryById($id);

    public function updateCategory($id, array $params);

    public function getSubCategory();

    public function getParentCategory();
    public function getBooksByCategory();


}
