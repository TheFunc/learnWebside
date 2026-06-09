@extends('learn.layouts')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- 欢迎卡片 -->
    <div class="relative overflow-hidden rounded-2xl bg-white border border-blue-100 shadow-md p-12 mb-8">
        <!-- 装饰背景 -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-sky-100 rounded-full blur-3xl opacity-60"></div>
        
        <div class="relative z-10">
            <h1 class="text-4xl font-bold mb-4">
                <span class="bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text text-transparent">
                    欢迎使用学习平台
                </span>
            </h1>
            <p class="text-slate-500 text-lg">
                在这里，家校情怀 技能报国。开始你的学习之旅吧！
            </p>
        </div>
    </div>

    <!-- 占位提示 -->
    <div class="flex flex-col items-center justify-center py-20">
        <div class="w-24 h-24 mb-6 rounded-full bg-blue-50 flex items-center justify-center">
            <i class="fa-solid fa-house text-4xl text-blue-500"></i>
        </div>
        <h2 class="text-2xl font-semibold text-slate-600 mb-2">首页</h2>
        <p class="text-slate-400">页面内容开发中，敬请期待...</p>
    </div>
</div>
@endsection
