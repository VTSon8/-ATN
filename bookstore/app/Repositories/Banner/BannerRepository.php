<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
//use Str;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{

    public function getAllBanner()
    {
        return Banner::paginate(config('constants.pagination'));
    }

    public function getBannerById($id)
    {
        return Banner::whereId($id)->first();
    }

    public function updateBanner($id, array $data)
    {
        return Banner::find($id)->update($data);
    }

    public function delete($id)
    {
        return Banner::destroy($id);
    }

    public function getModel()
    {
        return Banner::class;
    }

}
