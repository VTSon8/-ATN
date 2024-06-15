<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $listCategory = $this->categoryRepository->getAllCategory();
        return view('admin.category.index', compact('listCategory'));
    }

    public function create()
    {
        $listCategory = $this->categoryRepository->getParentCategory();
        return view('admin.category.create_update', compact('listCategory'));
    }

    /**
     * @param  CategoryStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            $data['created_by'] = Auth::guard('admin')->user()->id;
            $this->categoryRepository->createCategory($data);
            DB::commit();
            toastr()->success(__('Thêm mới thành công'), 'Thông báo');
            return redirect()->route('admin.category.index');
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Xảy ra lỗi'), 'Thông báo');
            DB::rollBack();
            return back();
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $listCategory = $this->categoryRepository->getParentCategory();
        $data = $this->categoryRepository->getCategoryById($id);
        return view('admin.category.create_update', compact('id', 'data', 'listCategory'));
    }

    /**
     * @param $id
     * @param  CategoryStoreRequest  $request
     * @return RedirectResponse
     */
    public function update($id, CategoryStoreRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $updateCategory = $request->validated();
            $updateCategory['slug'] = Str::slug($updateCategory['name']);
            $updateCategory['updated_by'] = Auth::guard('admin')->user()->id;
            $this->categoryRepository->updateCategory($id, $updateCategory);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            record_error_log($e);
            toastr()->error(__('Xảy ra lỗi'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Cập nhật thành công'), 'Thông báo');
        return redirect()->route('admin.category.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $category = Category::query()->findOrFail($id);
            $category->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Xóa thành công'), 'Thông báo');
        return back();
    }

}
