<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menber;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $menber = Menber::where('Name', $request->name)
                        ->where('Password', $request->password)
                        ->first();

        if (!$menber) {
            return back()->withErrors(['error' => '用户名或密码错误'])->withInput();
        }

        if ($menber->Permission != 1) {
            return back()->withErrors(['error' => '您没有权限访问后台'])->withInput();
        }

        if ($menber->Status != 1) {
            return back()->withErrors(['error' => '账号已被禁用'])->withInput();
        }

        $menber->LoginTime = now();
        $menber->Status = 1;
        $menber->save();

        Session::put('admin_id', $menber->id);
        Session::put('admin_name', $menber->Name);
        Session::put('is_admin', true);

        if ($request->has('remember') && $request->remember == 1) {
            Session::put('remember', true);
            Config::set('session.lifetime', 10080);
        }

        return redirect()->route('admin.member.index');
    }

    public function logout()
    {
        $adminId = Session::get('admin_id');
        if ($adminId) {
            $menber = Menber::find($adminId);
            if ($menber) {
                $menber->Status = 0;
                $menber->save();
            }
        }

        Session::forget('admin_id');
        Session::forget('admin_name');
        Session::forget('is_admin');
        Session::forget('remember');

        return redirect()->route('login');
    }
}
