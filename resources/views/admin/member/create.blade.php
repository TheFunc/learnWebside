@extends('layouts.admin')

@section('title', '增加成员')

@section('content')
    <form action="{{ route('admin.member.store') }}" method="POST" style="max-width: 500px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">姓名</label>
            <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">邮箱</label>
            <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">密码</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">学习时间</label>
            <input type="number" name="LearnTime" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
        </div>
        <div>
            <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">提交</button>
            <a href="{{ route('admin.member.index') }}" style="margin-left: 10px; padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; text-decoration: none;">返回</a>
        </div>
    </form>
@endsection