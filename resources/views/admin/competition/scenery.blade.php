@extends('layouts.admin')

@section('title', '比赛风光')

@section('content')
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 70vh;
            padding: 30px 20px;
        }
        .form-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
        }
        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 32px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .form-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 2px;
        }
        .form-group {
            margin-bottom: 24px;
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
        .form-label .required {
            color: #ef4444;
            margin-left: 4px;
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
        .form-textarea::placeholder {
            color: #94a3b8;
        }
        .upload-area {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 30px 20px;
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
            font-size: 40px;
            color: #94a3b8;
            margin-bottom: 12px;
            display: block;
        }
        .upload-area span {
            display: block;
            font-size: 14px;
            color: #475569;
            font-weight: 500;
        }
        .upload-area small {
            display: block;
            font-size: 12px;
            color: #94a3b8;
            margin-top: 6px;
        }
        .cover-preview {
            margin-top: 16px;
            display: none;
        }
        .cover-preview.active {
            display: block;
        }
        .cover-preview-img {
            position: relative;
            display: inline-block;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .cover-preview-img img {
            max-width: 100%;
            max-height: 200px;
            display: block;
            border-radius: 12px;
        }
        .cover-preview-remove {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .cover-preview-remove:hover {
            background: #dc2626;
            transform: scale(1.1);
        }
        .form-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 32px;
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
        .error-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            color: #dc2626;
            font-size: 14px;
            line-height: 1.6;
        }
        .error-alert i {
            font-size: 18px;
            margin-top: 2px;
            flex-shrink: 0;
        }
        .success-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            color: #166534;
            font-size: 14px;
            line-height: 1.6;
        }
        .success-alert i {
            font-size: 18px;
            margin-top: 2px;
            flex-shrink: 0;
        }
    </style>

    <div class="form-container">
        <form action="{{ route('admin.competition.scenery.store') }}" method="POST" enctype="multipart/form-data" class="form-card" id="competitionForm">
            @csrf
            <h2 class="form-title">添加比赛</h2>
            
            @if($errors->any())
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="success-alert">
                <i class="fa-solid fa-check-circle"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif
            
            <div class="form-group">
                <label class="form-label">比赛标题 <span class="required">*</span></label>
                <input type="text" name="Title" required class="form-input" placeholder="请输入比赛标题" value="{{ old('Title') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">比赛图片 <span class="required">*</span></label>
                <div class="upload-area" id="uploadArea" onclick="document.getElementById('imgFile').click()">
                    <i class="fa-solid fa-image"></i>
                    <span>点击或拖拽上传图片</span>
                    <small>支持 JPG、PNG、WebP、GIF 格式，最大 5MB</small>
                </div>
                <input type="file" id="imgFile" name="ImgUrl" accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;">
                <div class="cover-preview" id="coverPreview">
                    <div class="cover-preview-img">
                        <img id="previewImg" src="" alt="预览">
                        <button type="button" class="cover-preview-remove" onclick="removePreview()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">比赛描述</label>
                <textarea name="Description" class="form-textarea" placeholder="请输入比赛描述">{{ old('Description') }}</textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-check"></i> 提交
                </button>
                <button type="reset" class="btn btn-secondary" id="resetBtn">
                    <i class="fa-solid fa-rotate-left"></i> 重置
                </button>
            </div>
        </form>
    </div>

    <script>
        const imgFile = document.getElementById('imgFile');
        const uploadArea = document.getElementById('uploadArea');
        const coverPreview = document.getElementById('coverPreview');
        const previewImg = document.getElementById('previewImg');

        // 文件选择预览
        imgFile.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    coverPreview.classList.add('active');
                    uploadArea.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });

        // 拖拽上传
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                imgFile.files = e.dataTransfer.files;
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    coverPreview.classList.add('active');
                    uploadArea.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });

        // 移除预览
        function removePreview() {
            imgFile.value = '';
            previewImg.src = '';
            coverPreview.classList.remove('active');
            uploadArea.style.display = 'block';
        }

        // 重置按钮
        document.getElementById('resetBtn').addEventListener('click', function() {
            setTimeout(function() {
                removePreview();
            }, 0);
        });
    </script>
@endsection
