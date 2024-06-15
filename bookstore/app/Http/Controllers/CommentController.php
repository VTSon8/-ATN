<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function index()
    {
    }

    public function store(CommentRequest $request)
    {
        if (is_null($request->user())) {
            return back()->with('warning', 'Bạn cần đăng nhập để bình luận');
        }

        try {
            DB::beginTransaction();
            $comment = $request->validated();
            $comment['customer_id'] = Auth::user()->id;
            Comment::create($comment);
            DB::commit();
        } catch (\Exception $e) {
            record_error_log($e);
            DB::rollBack();
        }

        return back();
    }
}
