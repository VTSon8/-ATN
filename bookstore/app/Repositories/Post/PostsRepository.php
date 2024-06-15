<?php

namespace App\Repositories\Post;


use App\Models\Post;
use App\Repositories\BaseRepository;

class PostsRepository extends BaseRepository implements PostsRepositoryInterface
{
    public function getAllPosts()
    {
        return Post::paginate(config('constants.pagination'));
    }

    public function getPostsById($id)
    {
        return Post::findOrFail($id);
    }

    public function deletePosts($id)
    {
        return Post::whereId($id)->delete();
    }

    public function updatePostsStatus($id, int $status)
    {
        $post_status['status'] = ($status == Post::PUBLISHED) ? Post::NOT_PUBLISHED : Post::PUBLISHED;

        return Post::whereId($id)->update($post_status);
    }

    public function getModel()
    {
       return Post::class;
    }
}
