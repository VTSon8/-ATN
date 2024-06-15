<?php

namespace App\Repositories\Banner;

interface BannerRepositoryInterface
{
    public function getAllBanner();
    public function getBannerById($id);
    public function updateBanner($id, array $data);
    public function delete($id);
}
