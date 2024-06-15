<?php

namespace App\Repositories\Post;

use App\Repositories\RepositoryInterface;

interface PostsRepositoryInterface extends RepositoryInterface {
    public function getAllPosts();
    public function getPostsById($id);
    public function updatePostsStatus($id, int $status);
    public function deletePosts($id);
}
