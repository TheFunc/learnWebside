@extends('layouts.admin')

@section('title', '外部课程')

@section('content')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .card h2 {
            font-size: 20px;
            color: #1e293b;
            margin-bottom: 16px;
        }

        .card p {
            color: #64748b;
            font-size: 14px;
        }
    </style>

    <div class="container">
        <div class="card">
            <h2>外部课程</h2>
            <p>外部课程列表将在此显示。</p>
        </div>
    </div>
@endsection
