<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        // 检查登录状态
        if (!Session::get('admin_name')) {
            return redirect()->route('login')->with('error', '请先登录');
        }

        return view('learn.home');
    }

    /**
     * 课程学习页面
     */
    public function courses()
    {
        if (!Session::get('admin_name')) {
            return redirect()->route('login')->with('error', '请先登录');
        }

        return view('learn.courses');
    }

    /**
     * 作业页面
     */
    public function homework()
    {
        if (!Session::get('admin_name')) {
            return redirect()->route('login')->with('error', '请先登录');
        }

        return view('learn.homework');
    }

    /**
     * 网站导航页面
     */
    public function navigation()
    {
        if (!Session::get('admin_name')) {
            return redirect()->route('login')->with('error', '请先登录');
        }

        return view('learn.navigation');
    }

    /**
     * 修改密码页面
     */
    public function showChangePassword()
    {
        if (!Session::get('admin_name')) {
            return redirect()->route('login')->with('error', '请先登录');
        }

        return view('learn.change-password');
    }

    /**
     * 执行修改密码
     */
    public function changePassword(Request $request)
    {
        if (!Session::get('admin_name')) {
            return redirect()->route('login')->with('error', '请先登录');
        }

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $adminId = Session::get('admin_id');
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
