<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getAllProduct(string $key_word);
    public function getfeaturedBooks();
    public function getsellingBooks();

    public function getProductByCondition($key_word, array $sortBy);

    public function createProduct(array $params);

    public function getProductById($id);

//    public function update(array $params);
    public function updateProduct($id, array $params);

    public function deleteProduct($id);

    public function restoreProductById($id);

    public function foreverDeleteProductById($id);

    public function totalTrash();

    public function searchProduct(string $key_word);

    public function findProduct($id);

    public function getAllSimilarProducts($id, $category_id);

    public function getProductBySlug($slug);

    public function getPromotionalProducts();

    public function getProductByCategory($slug);
    public function getAuthorAll();

    public function getProductByIdOnlyTrashed($slug);

    public function getOnlyTrashed();

    public function updateProductStatus($id, int $status);

}
