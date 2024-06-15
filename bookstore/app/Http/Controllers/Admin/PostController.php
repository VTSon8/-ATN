<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostsRequest;
use App\Repositories\Post\PostsRepositoryInterface;
use App\Models\Post;
use App\Services\UploadImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    private $postsRepository;
    private $uploadImage;

    public function __construct(PostsRepositoryInterface $postsRepository, UploadImage $uploadImage)
    {
        $this->postsRepository = $postsRepository;
        $this->uploadImage = $uploadImage;
    }


    public function index()
    {
        $posts = $this->postsRepository->getAllPosts();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create_update');
    }

    public function store(PostsRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['title']);
            $fileName = $this->uploadImage->handleUploadedImage($request->file('img'));
            if (empty($fileName)) {
                toastr()->error(__('Lỗi upload ảnh'), 'Thông báo');
                return back();
            }
            $data['img'] = $fileName;
            $data['created_by'] = Auth::guard('admin')->user()->id;
            $this->postsRepository->create($data);
            DB::commit();

            toastr()->success(__('Thêm mới thành công'), 'Thông báo');
            return redirect()->route('admin.posts.index');
        } catch (\Exception $e) {
            DB::rollBack();
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
    }

    public function show($id)
    {
        $post = $this->postsRepository->getPostsById($id);
        return view('admin.posts.create_update', compact('id', 'post'));
    }

    public function update(PostsRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $posts = $this->postsRepository->getPostsById($id);
            $data['slug'] = Str::slug($data['title']);
            if (isset($data['img'])) {
                $data['img'] = $this->uploadImage->handleUploadedImage($data['img']);
                $this->uploadImage->handleUnlinkImage($posts->img);
            }
            $posts->update($data);
            DB::commit();

            toastr()->success(__('Cập nhật thành công'), 'Thông báo');
            return redirect()->route('admin.posts.index');
        } catch (\Exception $e) {
            DB::rollBack();
            record_error_log($e);
            toastr()->error(__('Cập nhật thất baị'), 'Thông báo');
            return redirect()->route('admin.posts.index');
        }
    }

    /**
     * @param  PostsRequest  $request
     * @param $id
     * @return RedirectResponse
     */
    public function updateStatus(PostsRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $post = $request->validated();
            $this->postsRepository->updatePostsStatus($id, $post['status']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            record_error_log($e);
            toastr()->error(__('Cập nhật thất baị'), 'Thông báo');
            return back();
        }

        toastr()->success(__('Cập nhật thành công'), 'Thông báo');
        return back();
    }

    public function destroy($id)
    {
        try {
            $post = $this->postsRepository->getPostsById($id);
            if ($post) {
                $this->uploadImage->handleUnlinkImage($post->img);
                $this->postsRepository->deletePosts($id);
            }

            toastr()->success(__('Xóa thành công'), 'Thông báo');
            return back();
        } catch (\Throwable $e) {
            toastr()->error(__('Xóa thất baị'), 'Thông báo');
            record_error_log($e);
        }
    }
}
