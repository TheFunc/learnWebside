<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ExternalController extends Controller
{
    public function course()
    {
        return view('admin.external.course');
    }

    public function manage()
    {
        return view('admin.external.manage');
    }

    public function create()
    {
        return view('admin.external.create');
    }
}
