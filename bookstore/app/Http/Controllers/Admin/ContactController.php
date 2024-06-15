<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        $contact = $this->contactRepository->getAllContact();
        return view('admin.contact.index', compact('contact'));
    }

    public function show($id)
    {
        $contact = $this->contactRepository->getContactById($id);
        return view('admin.contact.detail', compact('contact'));
    }

    public function delete($id)
    {
        try {
            $this->contactRepository->delete($id);
            toastr()->success(__('Xóa thành công'), 'Thông báo');
            return back();
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
    }
}
