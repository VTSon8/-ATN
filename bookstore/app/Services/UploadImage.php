<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadImage {

	public function handleUploadedImage($file)
	{
		if (!is_null($file)) {
            $fileName = time(). '_' . $file->getClientOriginalName();
            $folderImg = 'assets/upload';
//            Storage::disk('public')->putFileAs($folderImg, $file, $fileName);
            $file->move(public_path($folderImg), $fileName);
            return $fileName;
        }

        return '';
	}

    public function handleUnlinkImage($fileName) {
        $pathFile = public_path('assets/upload/' . $fileName);
        if (!is_dir($pathFile) && File::exists($pathFile)) {
            unlink($pathFile);
        }
    }
}
