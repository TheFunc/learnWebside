<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function course()
    {
        return view('admin.video.course');
    }

    public function manage()
    {
        return view('admin.video.manage');
    }

    public function create()
    {
        return view('admin.video.create');
    }
}
