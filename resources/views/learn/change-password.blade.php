@extends('learn.layouts')

@section('content')
<div class="max-w-md mx-auto">
    <!-- 修改密码卡片 -->
    <div class="relative overflow-hidden rounded-2xl bg-white border border-blue-100 shadow-md p-8">
        <!-- 装饰背景 -->
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-100 rounded-full blur-2xl opacity-50"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-6 text-center">
                <span class="bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text text-transparent">
                    修改密码
                </span>
            </h2>

            <!-- 成功提示 -->
            @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
                <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            <!-- 错误提示 -->
            @if($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('learn.change-password.post') }}" method="POST">
                @csrf
                
                <!-- 旧密码 -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        <i class="fa-solid fa-lock mr-1 text-blue-500"></i>旧密码
                    </label>
                    <input type="password" name="old_password" required
                           class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-colors"
                           placeholder="请输入旧密码">
                </div>

                <!-- 新密码 -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        <i class="fa-solid fa-key mr-1 text-blue-500"></i>新密码
                    </label>
                    <input type="password" name="new_password" required minlength="6"
                           class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-colors"
                           placeholder="请输入新密码（至少6位）">
                </div>

                <!-- 确认新密码 -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        <i class="fa-solid fa-shield-halved mr-1 text-blue-500"></i>确认新密码
                    </label>
                    <input type="password" name="new_password_confirmation" required minlength="6"
                           class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-colors"
                           placeholder="请再次输入新密码">
                </div>

                <!-- 提交按钮 -->
                <button type="submit"
                        class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 to-sky-500 text-white font-medium hover:from-blue-600 hover:to-sky-600 transition-all duration-300 hover:shadow-lg hover:shadow-blue-200 active:scale-95">
                    <i class="fa-solid fa-check mr-2"></i>确认修改
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
