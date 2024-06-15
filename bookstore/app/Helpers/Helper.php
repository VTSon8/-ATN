<?php

if (!function_exists('record_error_log')) {
    function record_error_log($e) {
        \Illuminate\Support\Facades\Log::error($e);
    }
}
