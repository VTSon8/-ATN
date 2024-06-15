<?php
namespace App\Traits;

use App\Observers\SkuObserver;
use Illuminate\Database\Eloquent\Model;

trait SkuObservable
{
    public static function bootSkuObservable()
    {
        self::observe(SkuObserver::class);
    }
}
