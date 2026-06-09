<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Menber;

class LearnController extends Controller
{
    /**
     * 学习平台首页
     */
    public function index()
    {
        // 获取后台设置的首页视频
        $homepageVideo = $this->getHomepageVideo();

        return view('learn.home', compact('homepageVideo'));
    }

    /**
     * 获取后台设置的首页视频
     */
    private function getHomepageVideo()
    {
        $files = Storage::disk('public')->files('homepage');

        if (empty($files)) {
            return null;
        }

        // 取第一个视频文件
        $fileName = basename($files[0]);
        return route('admin.settings.stream.video', ['fileName' => $fileName]);
    }

    /**
     * 课程学习页面
     */
    public function courses()
    {
        return view('learn.courses');
    }

    /**
     * 作业页面
     */
    public function homework()
    {
        return view('learn.homework');
    }

    /**
     * 网站导航页面
     */
    public function navigation()
    {
        return view('learn.navigation');
    }

    /**
     * 修改密码页面
     */
    public function showChangePassword()
    {
        return view('learn.change-password');
    }

    /**
     * 执行修改密码
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $adminId = Session::get('learn_user_id');
        $menber = Menber::find($adminId);

        if (!$menber) {
            return back()->withErrors(['error' => '用户不存在']);
        }

        // 验证旧密码
        if ($menber->Password !== $request->old_password) {
            return back()->withErrors(['error' => '旧密码不正确']);
        }

        // 更新密码
        $menber->Password = $request->new_password;
        $menber->save();

        return back()->with('success', '密码修改成功');
    }
}
