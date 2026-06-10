@extends('layouts.admin')

@section('title', '添加外部')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #334155;
            background: #f8fafc;
            transition: all 0.25s ease;
            box-sizing: border-box;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background: #ffffff;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .btn:hover::before {
            opacity: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-primary::before {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-secondary::before {
            background: linear-gradient(135deg, rgba(0,0,0,0.05) 0%, transparent 50%);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .empty-types {
            text-align: center;
            padding: 20px;
            color: #94a3b8;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .empty-types a {
            color: #3b82f6;
            text-decoration: none;
        }

        .empty-types a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fa-solid fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <div class="card">
            <h3 class="card-title">添加外部视频链接</h3>
            
            @if($types->isEmpty())
                <div class="empty-types">
                    <p>暂无外部类型，请先前往 <a href="{{ route('admin.external.course') }}">外部课程</a> 添加类型</p>
                </div>
            @else
                <form action="{{ route('admin.external.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">外部类型</label>
                        <select name="type" required class="form-select">
                            <option value="">请选择外部类型</option>
                            @foreach($types as $type)
                                <option value="{{ $type->type }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">外部名称</label>
                        <input type="text" name="name" required class="form-input" placeholder="请输入外部名称">
                    </div>
                    <div class="form-group">
                        <label class="form-label">外部链接</label>
                        <input type="url" name="url" required class="form-input" placeholder="请输入外部视频链接，例如：https://www.bilibili.com/video/xxx">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check"></i> 确认添加
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fa-solid fa-rotate-left"></i> 重置
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
