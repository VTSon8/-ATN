<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use App\Services\UploadImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $supplierRepository;
    private $uploadImage;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        SupplierRepositoryInterface $supplierRepository,
        UploadImage $uploadImage
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->supplierRepository = $supplierRepository;
        $this->uploadImage = $uploadImage;
    }

    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $total_trash = $this->productRepository->totalTrash();
        $listProduct = $this->productRepository->getAllProduct($request->q);

        return view('admin.product.index', compact('listProduct', 'total_trash'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $listCategory = $this->categoryRepository->getSubCategory();
        $listSupplier = $this->supplierRepository->getAllSupplier();
        return view('admin.product.create_update', compact('listCategory', 'listSupplier'));
    }

    /**
     * @param  ProductStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::guard('admin')->user()->id;
            $data['slug'] = Str::slug($data['name']);
            $data['sku'] = random_int(100000, 999999);
            $data['thumb'] = $this->uploadImage->handleUploadedImage($request->file('thumb'));
            $newProduct = $this->productRepository->createProduct($data);
            if (isset($data['images'])) {
                $this->uploadMultipleFiles($newProduct->id, $data['images']);
            }
        } catch (\Exception $e) {
            $this->uploadImage->handleUnlinkImage($data['thumb']);
            record_error_log($e);
            toastr()->error(__('Lỗi hệ thống'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Thêm mới thành công'), 'Thông báo');
        return redirect()->route('admin.products.index');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $data = $this->productRepository->getProductById($id);
        $listCategory = $this->categoryRepository->getAllCategory();
        $listSupplier = $this->supplierRepository->getAllSupplier();
        return view('admin.product.create_update', compact('id', 'data', 'listCategory', 'listSupplier'));
    }

    /**
     * @param  ProductUpdateRequest  $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $updateProduct = $this->productRepository->getProductById($id);
            if (isset($data['thumb'])) {
                $data['thumb'] = $this->uploadImage->handleUploadedImage($data['thumb']);
                $this->uploadImage->handleUnlinkImage($updateProduct->thumb);
            }

            if (isset($data['images'])) {
                $this->destroyMultipleFiles($updateProduct->id);
                $this->uploadMultipleFiles($updateProduct->id, $data['images']);
            }
            $updateProduct->update($data);
        } catch (\Exception $e) {
            record_error_log($e);
            return back();
        }
        toastr()->success(__('Cập nhật thành công'), 'Thông báo');
        return redirect()->route('admin.products.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        try {
            $this->productRepository->deleteProduct($id);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }

        toastr()->success(__('Xóa thành công'), 'Thông báo');
        return back();
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function import($id)
    {
        $product = $this->productRepository->getProductById($id);
        return view('admin.product.import', compact('id', 'product'));
    }

    /**
     * @param  ProductUpdateRequest  $request
     * @param $id
     * @return RedirectResponse
     */
    public function updateProductQuantity(ProductUpdateRequest $request, $id): RedirectResponse
    {
        try {
            $quantityInput = $request->validated();
            $product = $this->productRepository->getProductById($id);
            $number['number'] = $product->number + (int)$quantityInput['number'];
            $product->update($number);
        } catch (\Exception $e) {
            record_error_log($e);
            return back();
        }
        toastr()->success(__('Cập nhật thành công'), 'Thông báo');
        return redirect()->route('admin.products.index');
    }

    /**
     * @param  ProductUpdateRequest  $request
     * @param $id
     * @return RedirectResponse
     */
    public function updateStatus(ProductUpdateRequest $request, $id): RedirectResponse
    {
        try {
            $product = $request->validated();
            $this->productRepository->updateProductStatus($id, $product['status']);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Cập nhật thất baị'), 'Thông báo');
            return back();
        }

        toastr()->success(__('Cập nhật thành công'), 'Thông báo');
        return back();
    }

    /**
     * @return Application|Factory|View
     */
    public function recyclebin()
    {
        $recyclebin = $this->productRepository->getOnlyTrashed();
        return view('admin.product.recyclebin', compact('recyclebin'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        try {
            $this->productRepository->restoreProductById($id);
        } catch (\Exception $e) {
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Khôi phục thành công'), 'Thông báo');
        return back();
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function foreverDelete($id): RedirectResponse
    {
        try {
            $product = $this->productRepository->getProductByIdOnlyTrashed($id);
            $this->uploadImage->handleUnlinkImage($product->thumb);
            $this->destroyMultipleFiles($product->id);
            $this->productRepository->foreverDeleteProductById($id);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }

        toastr()->success(__('Xóa thành công'), 'Thông báo');
        return back();
    }

//    private function uploadMultipleFiles($files)
//    {
//        $file_name = '';
//        foreach ($files as $file) {
//            $name = $file->getClientOriginalName();
//            $file->move(public_path().'/product/', $name);
//            $file_name .= '#'.$name;
//        }
//        return $file_name;
//
//    }

    /**
     * @param $product_id
     * @param $files
     * @return void
     */
    private function uploadMultipleFiles($product_id, $files)
    {
        if (!is_null($files)) {
            foreach ($files as $key => $file) {
                $image['name'] = $this->uploadImage->handleUploadedImage($file);
                $image['product_id'] = $product_id;
                Image::create($image);
            }
        }
    }

    private function destroyMultipleFiles($productId)
    {
        try {
            $images = Image::where('product_id', $productId)->get();

            foreach ($images as $image) {
                $this->uploadImage->handleUnlinkImage($image->name);
                $image->delete();
            }

        } catch (\Exception $e) {
            record_error_log($e);
        }
    }


}
