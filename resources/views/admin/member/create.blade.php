@extends('layouts.admin')

@section('title', '增加成员')

@section('content')
    <form action="{{ route('admin.member.store') }}" method="POST" style="max-width: 500px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">名称</label>
            <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">密码</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">确认密码</label>
            <input type="password" name="password_confirmation" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">权限授权</label>
            <select name="permission" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
                <option value="0">成员</option>
                <option value="1">管理</option>
            </select>
        </div>
        <div>
            <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">提交</button>
            <button type="reset" style="margin-left: 10px; padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">重置</button>
        </div>
    </form>
@endsection