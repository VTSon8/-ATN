<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SkuObserver
{
    public function creating(Model $model)
    {
        $sku = Str::uuid();
        if (!empty($sku)) {
            $model->sku = $sku;
        }
    }
}
