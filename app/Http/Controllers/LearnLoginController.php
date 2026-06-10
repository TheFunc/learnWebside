<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menber;
use Illuminate\Support\Facades\Session;

class LearnLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('learn.login');
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

        $menber->LoginTime = now();
        $menber->Status = 1;
        $menber->save();

        Session::put('learn_user_id', $menber->id);
        Session::put('learn_user_name', $menber->Name);

        if ($request->has('remember') && $request->remember == 1) {
            Session::put('learn_remember', true);
            config(['session.lifetime' => 10080]);
        }

        return redirect()->route('learn.index');
    }

    public function logout()
    {
        $userId = Session::get('learn_user_id');
        if ($userId) {
            $menber = Menber::find($userId);
            if ($menber) {
                $menber->Status = 0;
                $menber->save();
            }
        }

        Session::forget('learn_user_id');
        Session::forget('learn_user_name');
        Session::forget('learn_remember');

        return redirect()->route('learn.login');
    }
}
