@extends('layouts.admin')

@section('title', '增加视频')

@section('content')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
        }

        /* 顶部固定按钮栏 */
        .sticky-actions {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-radius: 16px;
            padding: 20px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .sticky-actions .form-actions {
            margin-top: 0;
            margin-left: auto;
            flex-shrink: 0;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        /* 整体进度条 */
        .overall-progress {
            flex: 1;
            max-width: 400px;
        }

        .overall-progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
        }

        .overall-progress-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .overall-progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .overall-progress-fill.complete {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }

        /* 保存按钮禁用状态 */
        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-primary:disabled:hover {
            transform: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        /* 上传结果弹窗 */
        .upload-result-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .upload-result-overlay.active {
            display: flex;
        }

        .upload-result-modal {
            background: #fff;
            border-radius: 20px;
            width: 92%;
            max-width: 720px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #e2e8f0;
            animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .upload-result-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .upload-result-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .upload-result-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #94a3b8;
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .upload-result-close:hover {
            background: #f1f5f9;
            color: #475569;
        }

        .upload-result-body {
            padding: 20px 24px;
            overflow-y: auto;
            flex: 1;
            min-height: 100px;
        }

        .upload-result-body::-webkit-scrollbar {
            width: 6px;
        }

        .upload-result-body::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .upload-result-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .upload-result-body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .upload-result-footer {
            display: flex;
            justify-content: flex-end;
            padding: 16px 24px;
            border-top: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .upload-result-empty {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }

        .upload-result-empty i {
            font-size: 48px;
            margin-bottom: 16px;
            display: block;
        }

        .upload-result-empty p {
            font-size: 15px;
            margin: 0;
        }

        .upload-result-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .upload-result-item:last-child {
            margin-bottom: 0;
        }

        .upload-result-item-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .upload-result-item-icon.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .upload-result-item-icon.error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .upload-result-item-icon.pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .upload-result-item-progress {
            flex: 1;
            overflow: hidden;
        }

        .upload-result-item-name {
            font-size: 14px;
            font-weight: 500;
            color: #334155;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .upload-result-item-status {
            font-size: 12px;
            margin-top: 2px;
        }

        .upload-result-item-pbar {
            margin-top: 6px;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .upload-result-item-pbar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .upload-result-item-pbar-fill.done {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }

        .upload-result-item-status.success {
            color: #10b981;
        }

        .upload-result-item-status.error {
            color: #ef4444;
        }

        .upload-result-item-status.pending {
            color: #f59e0b;
        }

        .upload-result-summary {
            display: flex;
            gap: 20px;
            padding: 16px 20px;
            background: #f0f9ff;
            border-radius: 12px;
            margin-bottom: 16px;
            border: 1px solid #bae6fd;
        }

        .upload-result-summary-item {
            flex: 1;
            text-align: center;
        }

        .upload-result-summary-value {
            font-size: 22px;
            font-weight: 700;
            color: #0284c7;
        }

        .upload-result-summary-label {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* 提示弹窗 */
        .toast-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .toast-overlay.active {
            display: flex;
        }

        .toast-box {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            width: 90%;
            max-width: 380px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .toast-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .toast-icon i {
            font-size: 28px;
            color: white;
        }

        .toast-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .toast-message {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .toast-btn {
            padding: 12px 32px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            transition: all 0.2s ease;
        }

        .toast-btn:hover {
            transform: translateY(-1px);
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
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

        .form-input {
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

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background: #ffffff;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #334155;
            background: #f8fafc;
            transition: all 0.25s ease;
            box-sizing: border-box;
            min-height: 120px;
            resize: vertical;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background: #ffffff;
        }

        .form-select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #334155;
            background: #f8fafc;
            transition: all 0.25s ease;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
        }

        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background: #ffffff;
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

        .btn-success {
            padding: 8px 16px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            font-size: 13px;
        }

        .btn-danger {
            padding: 8px 16px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 13px;
        }

        .upload-area {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            background: #fafafa;
        }

        .upload-area:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }

        .upload-area.dragover {
            border-color: #3b82f6;
            background: #eff6ff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .upload-area i {
            font-size: 48px;
            color: #94a3b8;
            margin-bottom: 16px;
            display: block;
        }

        .upload-area span {
            display: block;
            font-size: 15px;
            color: #475569;
            font-weight: 500;
        }

        .upload-area small {
            display: block;
            font-size: 13px;
            color: #94a3b8;
            margin-top: 8px;
        }

        .file-list {
            margin-top: 20px;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.25s ease;
        }

        .file-item:hover {
            background: #f1f5f9;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            font-size: 20px;
        }

        .file-icon.image {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
        }

        .file-icon.video {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .file-info {
            flex: 1;
            overflow: hidden;
        }

        .file-name {
            font-size: 14px;
            font-weight: 500;
            color: #334155;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-size {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .file-progress {
            margin-top: 8px;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }

        .file-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .file-status {
            font-size: 12px;
            margin-top: 4px;
        }

        .file-status.success {
            color: #10b981;
        }

        .file-status.error {
            color: #ef4444;
        }

        .file-status.uploading {
            color: #3b82f6;
        }

        .file-actions {
            display: flex;
            gap: 8px;
        }

        .cover-preview {
            margin-top: 16px;
            max-width: 200px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .cover-preview img {
            width: 100%;
            height: auto;
            display: block;
        }

        .group-id-display {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
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

        .hidden {
            display: none;
        }

        .success-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.2s ease;
        }

        .success-modal-overlay.active {
            display: flex;
        }

        .success-modal {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #e2e8f0;
            animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }

        .success-icon i {
            font-size: 40px;
            color: white;
        }

        .success-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
        }

        .success-message {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 24px;
        }

        .success-stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 24px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #3b82f6;
        }

        .stat-label {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .success-actions {
            display: flex;
            gap: 12px;
        }

        .success-actions .btn {
            flex: 1;
        }
    </style>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- 顶部固定按钮栏 --}}
        <div class="sticky-actions">
            <div class="overall-progress">
                <div class="overall-progress-label">
                    <span>上传进度</span>
                    <span id="progressText">0 / 0</span>
                </div>
                <div class="overall-progress-bar">
                    <div class="overall-progress-fill" id="overallProgressFill"></div>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="openUploadResult()">
                    <i class="fa-solid fa-list-check"></i> 上传信息
                </button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                    <i class="fa-solid fa-rotate-left"></i> 重置
                </button>
                <button type="button" class="btn btn-primary" id="saveBtn" onclick="handleSaveClick()">
                    <i class="fa-solid fa-save"></i> 保存全部
                </button>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">增加视频</h3>
            
            <input type="hidden" id="groupID" value="{{ $groupID }}">

            <div class="form-group">
                <label class="form-label">课程标题</label>
                <input type="text" id="title" class="form-input" placeholder="请输入课程标题" required>
            </div>

            <div class="form-group">
                <label class="form-label">项目名称</label>
                <select id="typeID" class="form-select" required>
                    <option value="">请选择项目名称</option>
                    @foreach($types as $type)
                        <option value="{{ $type->TypeID }}">{{ $type->Type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">视频描述</label>
                <textarea id="description" class="form-textarea" placeholder="请输入视频描述"></textarea>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">封面上传</h3>
            
            <div class="upload-area" id="coverUploadArea" onclick="document.getElementById('coverFile').click()">
                <i class="fa-solid fa-image"></i>
                <span>点击或拖拽上传封面图片</span>
                <small>支持 JPG、PNG、GIF 格式，最大 2MB</small>
            </div>
            
            <input type="file" id="coverFile" class="hidden" accept="image/jpeg,image/png,image/gif">
            
            <div id="coverPreview"></div>
        </div>

        <div class="card">
            <h3 class="card-title">视频上传</h3>
            
            <div class="upload-area" id="videoUploadArea" onclick="document.getElementById('videoFiles').click()">
                <i class="fa-solid fa-video"></i>
                <span>点击或拖拽上传视频文件</span>
                <small>支持 MP4、AVI、MOV、WMV、FLV 格式，最大 500MB</small>
            </div>
            
            <input type="file" id="videoFiles" class="hidden" accept="video/*" multiple>
        </div>
    </div>

    <div class="success-modal-overlay" id="successModal">
        <div class="success-modal">
            <div class="success-icon">
                <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="success-title">保存成功</h3>
            <p class="success-message">视频信息已成功保存到系统</p>
            <div class="success-stats">
                <div class="stat-item">
                    <div class="stat-value" id="statVideos">0</div>
                    <div class="stat-label">视频数量</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="statCover">否</div>
                    <div class="stat-label">封面上传</div>
                </div>
            </div>
            <div class="success-actions">
                <button class="btn btn-secondary" onclick="closeSuccessModal()">
                    <i class="fa-solid fa-rotate-left"></i> 继续添加
                </button>
                <button class="btn btn-primary" onclick="goToVideoManage()">
                    <i class="fa-solid fa-list"></i> 查看列表
                </button>
            </div>
        </div>
    </div>

    {{-- 上传结果弹窗 --}}
    <div class="upload-result-overlay" id="uploadResultOverlay">
        <div class="upload-result-modal">
            <div class="upload-result-header">
                <h3><i class="fa-solid fa-list-check"></i> 上传信息</h3>
                <button class="upload-result-close" onclick="closeUploadResult()">&times;</button>
            </div>
            <div class="upload-result-body" id="uploadResultBody">
                <div class="upload-result-empty">
                    <i class="fa-regular fa-file-video"></i>
                    <p>暂无上传记录</p>
                </div>
            </div>
            <div class="upload-result-footer">
                <button class="btn btn-secondary" onclick="closeUploadResult()">
                    <i class="fa-solid fa-xmark"></i> 关闭
                </button>
            </div>
        </div>
    </div>

    {{-- 未完成上传提示弹窗 --}}
    <div class="toast-overlay" id="toastOverlay">
        <div class="toast-box">
            <div class="toast-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="toast-title">视频尚未上传完成</h3>
            <p class="toast-message" id="toastMessage">请等待所有视频文件上传完成后再点击保存。</p>
            <button class="toast-btn" onclick="closeToast()">我知道了</button>
        </div>
    </div>

    <script>
        const uploadedVideos = [];
        let coverPath = null;
        let coverFilename = null;
        let totalVideos = 0;
        let completedVideos = 0;
        let uploadingVideos = {}; // 跟踪正在上传的文件

        document.getElementById('coverUploadArea').addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        document.getElementById('coverUploadArea').addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        document.getElementById('coverUploadArea').addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                uploadCover(files[0]);
            }
        });

        document.getElementById('coverFile').addEventListener('change', function(e) {
            if (this.files.length > 0) {
                uploadCover(this.files[0]);
            }
        });

        document.getElementById('videoUploadArea').addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        document.getElementById('videoUploadArea').addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        document.getElementById('videoUploadArea').addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            for (let i = 0; i < files.length; i++) {
                if (files[i].type.startsWith('video/')) {
                    uploadVideo(files[i]);
                }
            }
        });

        document.getElementById('videoFiles').addEventListener('change', function(e) {
            for (let i = 0; i < this.files.length; i++) {
                uploadVideo(this.files[i]);
            }
            this.value = '';
        });

        function uploadCover(file) {
            const previewDiv = document.getElementById('coverPreview');
            previewDiv.innerHTML = `
                <div class="file-item">
                    <div class="file-icon image">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                        <div class="file-progress">
                            <div class="file-progress-bar" style="width: 0%"></div>
                        </div>
                        <div class="file-status uploading">上传中...</div>
                    </div>
                </div>
            `;

            const formData = new FormData();
            formData.append('cover', file);
            formData.append('groupID', document.getElementById('groupID').value);
            formData.append('title', document.getElementById('title').value);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('admin.video.upload.cover') }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = (e.loaded / e.total) * 100;
                    previewDiv.querySelector('.file-progress-bar').style.width = percent + '%';
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    coverPath = response.path;
                    coverFilename = response.filename;
                    
                    previewDiv.innerHTML = `
                        <div class="cover-preview">
                            <img src="${window.location.origin}/storage/${response.path}" alt="封面预览">
                        </div>
                        <div class="file-item" style="margin-top: 10px;">
                            <div class="file-icon image">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div class="file-info">
                                <div class="file-name">${response.filename}</div>
                                <div class="file-size">${formatFileSize(file.size)}</div>
                                <div class="file-status success">上传成功</div>
                            </div>
                            <div class="file-actions">
                                <button class="btn btn-danger" onclick="removeCover()">
                                    <i class="fa-solid fa-trash"></i> 删除
                                </button>
                            </div>
                        </div>
                    `;
                } else {
                    previewDiv.querySelector('.file-status').textContent = '上传失败';
                    previewDiv.querySelector('.file-status').className = 'file-status error';
                }
            });

            xhr.addEventListener('error', function() {
                previewDiv.querySelector('.file-status').textContent = '上传失败';
                previewDiv.querySelector('.file-status').className = 'file-status error';
            });

            xhr.send(formData);
        }

        function removeCover() {
            coverPath = null;
            coverFilename = null;
            document.getElementById('coverPreview').innerHTML = '';
        }

        function uploadVideo(file) {
            const fileId = 'video-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
            
            totalVideos++;
            uploadingVideos[fileId] = true;
            updateOverallProgress();
            
            // 先确保模态框已打开
            const overlay = document.getElementById('uploadResultOverlay');
            if (!overlay.classList.contains('active')) {
                overlay.classList.add('active');
            }

            // 如果模态框内容当前是空状态，先清空
            const body = document.getElementById('uploadResultBody');
            const emptyEl = body.querySelector('.upload-result-empty');
            if (emptyEl) {
                body.innerHTML = '';
            }

            body.innerHTML += `
                <div class="upload-result-item" id="${fileId}">
                    <div class="upload-result-item-icon pending" id="${fileId}-icon">
                        <i class="fa-solid fa-spinner fa-spin"></i>
                    </div>
                    <div class="upload-result-item-progress">
                        <div class="upload-result-item-name">${file.name}</div>
                        <div class="upload-result-item-status pending">上传中... <span id="${fileId}-percent">0%</span></div>
                        <div class="upload-result-item-pbar">
                            <div class="upload-result-item-pbar-fill" id="${fileId}-barfill" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            `;

            const formData = new FormData();
            formData.append('video', file);
            formData.append('groupID', document.getElementById('groupID').value);
            formData.append('title', document.getElementById('title').value);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('admin.video.upload.video') }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    const percentEl = document.getElementById(fileId + '-percent');
                    if (percentEl) percentEl.textContent = percent + '%';
                    const barEl = document.getElementById(fileId + '-barfill');
                    if (barEl) barEl.style.width = percent + '%';
                }
            });

            xhr.addEventListener('load', function() {
                delete uploadingVideos[fileId];
                
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    
                    uploadedVideos.push({
                        path: response.path,
                        filename: response.filename,
                        originalName: file.name
                    });

                    completedVideos++;
                    updateOverallProgress();

                    const iconEl = document.getElementById(fileId + '-icon');
                    if (iconEl) {
                        iconEl.className = 'upload-result-item-icon success';
                        iconEl.innerHTML = '<i class="fa-solid fa-check"></i>';
                    }
                    const statusEl = document.querySelector('#' + fileId + ' .upload-result-item-status');
                    if (statusEl) {
                        statusEl.textContent = '上传成功';
                        statusEl.className = 'upload-result-item-status success';
                    }
                } else {
                    totalVideos--;
                    updateOverallProgress();
                    let errMsg = '上传失败';
                    try {
                        const errResp = JSON.parse(xhr.responseText);
                        if (errResp.message) errMsg = errResp.message;
                    } catch(e) {}
                    const iconEl = document.getElementById(fileId + '-icon');
                    if (iconEl) {
                        iconEl.className = 'upload-result-item-icon error';
                        iconEl.innerHTML = '<i class="fa-solid fa-x"></i>';
                    }
                    const statusEl = document.querySelector('#' + fileId + ' .upload-result-item-status');
                    if (statusEl) {
                        statusEl.textContent = errMsg;
                        statusEl.className = 'upload-result-item-status error';
                    }
                }
            });

            xhr.addEventListener('error', function() {
                delete uploadingVideos[fileId];
                totalVideos--;
                updateOverallProgress();
                let errMsg = '网络错误，上传失败';
                try {
                    const errResp = JSON.parse(xhr.responseText);
                    if (errResp.message) errMsg = errResp.message;
                } catch(e) {}
                const iconEl = document.getElementById(fileId + '-icon');
                if (iconEl) {
                    iconEl.className = 'upload-result-item-icon error';
                    iconEl.innerHTML = '<i class="fa-solid fa-x"></i>';
                }
                const statusEl = document.querySelector('#' + fileId + ' .upload-result-item-status');
                if (statusEl) {
                    statusEl.textContent = errMsg;
                    statusEl.className = 'upload-result-item-status error';
                }
            });

            xhr.send(formData);
        }

        function cancelUpload(fileId) {
            if (uploadingVideos[fileId]) {
                delete uploadingVideos[fileId];
                totalVideos--;
                updateOverallProgress();
            }
            document.getElementById(fileId).remove();
        }

        function removeVideo(fileId, path) {
            const index = uploadedVideos.findIndex(v => v.path === path);
            if (index > -1) {
                uploadedVideos.splice(index, 1);
                completedVideos--;
                updateOverallProgress();
            }
            document.getElementById(fileId).remove();
        }

        function updateOverallProgress() {
            const fill = document.getElementById('overallProgressFill');
            const text = document.getElementById('progressText');
            const saveBtn = document.getElementById('saveBtn');
            
            if (totalVideos === 0) {
                fill.style.width = '0%';
                fill.classList.remove('complete');
                text.textContent = '0 / 0';
                saveBtn.disabled = true;
                return;
            }
            
            const percent = (completedVideos / totalVideos) * 100;
            fill.style.width = percent + '%';
            text.textContent = completedVideos + ' / ' + totalVideos;
            
            const allComplete = completedVideos > 0 && completedVideos === totalVideos && Object.keys(uploadingVideos).length === 0;
            
            if (allComplete) {
                fill.classList.add('complete');
                saveBtn.disabled = false;
            } else {
                fill.classList.remove('complete');
                saveBtn.disabled = true;
            }
        }

        function handleSaveClick() {
            const allComplete = completedVideos > 0 && completedVideos === totalVideos && Object.keys(uploadingVideos).length === 0;
            
            if (!allComplete) {
                const uploading = Object.keys(uploadingVideos).length;
                const remaining = totalVideos - completedVideos;
                let msg = '还有 ' + remaining + ' 个视频未完成上传。';
                if (uploading > 0) {
                    msg += '（其中 ' + uploading + ' 个正在上传中）';
                }
                msg += '\n\n请等待所有视频上传完成后再点击保存。';
                document.getElementById('toastMessage').textContent = msg;
                document.getElementById('toastOverlay').classList.add('active');
                return;
            }

            // 立即禁用按钮，防止重复点击
            const btn = document.getElementById('saveBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> 保存中...';
            
            saveAll();
        }

        function closeToast() {
            document.getElementById('toastOverlay').classList.remove('active');
        }

        function restoreSaveBtn() {
            const btn = document.getElementById('saveBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-save"></i> 保存全部';
        }

        function saveAll() {
            const title = document.getElementById('title').value.trim();
            const typeID = document.getElementById('typeID').value;
            const description = document.getElementById('description').value.trim();
            const groupID = document.getElementById('groupID').value;

            if (!title) {
                alert('请输入视频标题');
                restoreSaveBtn();
                return;
            }

            if (!typeID) {
                alert('请选择视频类型');
                restoreSaveBtn();
                return;
            }

            if (uploadedVideos.length === 0) {
                alert('请至少上传一个视频');
                restoreSaveBtn();
                return;
            }

            fetch('{{ route('admin.video.save.info') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    title: title,
                    typeID: typeID,
                    description: description,
                    groupID: groupID,
                    videos: uploadedVideos,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessModal();
                } else {
                    alert('保存失败，请重试');
                    restoreSaveBtn();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('保存失败，请重试');
                restoreSaveBtn();
            });
        }

        function renderUploadResult() {
            const body = document.getElementById('uploadResultBody');
            const hasCover = coverPath !== null && coverFilename !== null;
            const hasVideos = uploadedVideos.length > 0;

            if (!hasCover && !hasVideos) {
                body.innerHTML = `
                    <div class="upload-result-empty">
                        <i class="fa-regular fa-file-video"></i>
                        <p>暂无上传记录</p>
                    </div>
                `;
                return;
            }

            let html = '';
            html += '<div class="upload-result-summary">';
            html += '<div class="upload-result-summary-item"><div class="upload-result-summary-value">' + (hasCover ? '1' : '0') + '</div><div class="upload-result-summary-label">封面上传</div></div>';
            html += '<div class="upload-result-summary-item"><div class="upload-result-summary-value">' + uploadedVideos.length + '</div><div class="upload-result-summary-label">视频数量</div></div>';
            html += '</div>';

            if (hasCover) {
                html += '<div class="upload-result-item">';
                html += '<div class="upload-result-item-icon success"><i class="fa-solid fa-check"></i></div>';
                html += '<div class="upload-result-item-progress"><div class="upload-result-item-name">' + coverFilename + '</div><div class="upload-result-item-status success">封面 — 上传成功</div></div>';
                html += '</div>';
            }

            for (let i = 0; i < uploadedVideos.length; i++) {
                const v = uploadedVideos[i];
                const displayName = v.originalName || v.filename;
                html += '<div class="upload-result-item">';
                html += '<div class="upload-result-item-icon success"><i class="fa-solid fa-check"></i></div>';
                html += '<div class="upload-result-item-progress"><div class="upload-result-item-name">' + displayName + '</div><div class="upload-result-item-status success">视频 — 上传成功</div></div>';
                html += '</div>';
            }

            body.innerHTML = html;
        }

        function openUploadResult() {
            document.getElementById('uploadResultOverlay').classList.add('active');
        }

        function closeUploadResult() {
            document.getElementById('uploadResultOverlay').classList.remove('active');
        }

        function resetForm() {
            document.getElementById('title').value = '';
            document.getElementById('typeID').value = '';
            document.getElementById('description').value = '';
            coverPath = null;
            coverFilename = null;
            uploadedVideos.length = 0;
            totalVideos = 0;
            completedVideos = 0;
            uploadingVideos = {};
            document.getElementById('coverPreview').innerHTML = '';
            // 同时清空模态框中的上传记录
            document.getElementById('uploadResultBody').innerHTML = `
                <div class="upload-result-empty">
                    <i class="fa-regular fa-file-video"></i>
                    <p>暂无上传记录</p>
                </div>
            `;
            updateOverallProgress();
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showSuccessModal() {
            document.getElementById('statVideos').textContent = uploadedVideos.length;
            document.getElementById('statCover').textContent = coverPath ? '是' : '否';
            document.getElementById('successModal').classList.add('active');
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.remove('active');
            resetForm();
        }

        function goToVideoManage() {
            window.location.href = '{{ route('admin.video.manage') }}';
        }
    </script>
@endsection