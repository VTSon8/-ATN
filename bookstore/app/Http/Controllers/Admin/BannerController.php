<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Services\UploadImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

//use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    private $bannerRepository;
    private $uploadImage;

    public function __construct(BannerRepositoryInterface $bannerRepository, UploadImage $uploadImage)
    {
        $this->uploadImage = $uploadImage;
        $this->bannerRepository = $bannerRepository;
    }

    public function index()
    {
        $banners = Banner::query()->paginate(config('constants.PER_PAGE'));

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Display view create update
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.banners.create_update');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(BannerRequest $request)
    {
        try {
            $banner = $request->validated();
            $fileName = $this->uploadImage->handleUploadedImage($banner['thumb']);
            if ($fileName) {
                $banner['thumb'] = $fileName;
            }
            $banner['created_by'] = Auth::guard('admin')->user()->id;
            $this->bannerRepository->create($banner);
        } catch (\Exception $e) {
            $this->uploadImage->handleUnlinkImage($fileName);
            record_error_log($e);
            return back()->with('msg', __('Tạo mới không thành công xin thử lại'));
        }

        toastr()->success(__('Thêm mới thành công'), 'Thông báo');
        return redirect()->route('admin.banners.index');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $banner = Banner::where('id', $id)->first();
        return view('admin.banners.create_update', compact('banner', 'id'));
    }

    /**
     * @param  Request  $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(BannerRequest $request, $id)
    {
        try {
            $inputBanner = $request->validated();
            $banner = $this->bannerRepository->getBannerById($id);
            $fileName = $this->uploadImage->handleUploadedImage($request->file('thumb'));
            if ($fileName) {
                $this->uploadImage->handleUnlinkImage($banner->thumb);
                $inputBanner['thumb'] = $fileName;
            }
            $banner->update($inputBanner);
        } catch (\Exception $e) {
            record_error_log($e);
        }

        toastr()->success(__('Cập nhật thành công'), 'Thông báo');
        return redirect()->route('admin.banners.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        try {
            $this->bannerRepository->delete($id);
            toastr()->success(__('Xóa thành công'), 'Thông báo');
            return back();
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
    }

}
