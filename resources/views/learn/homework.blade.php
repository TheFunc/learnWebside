@extends('learn.layouts')

@section('content')
<div class="homework-page">
    {{-- 标语横幅 --}}
    <div class="homework-hero">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-solid fa-pen-ruler"></i>
            </div>
            <h1 class="hero-title">课后练习，巩固所学</h1>
            <p class="hero-subtitle">每一次练习都是对知识的深化，每一道题目都助你更进一步</p>
            <div class="hero-divider"></div>
        </div>
        <div class="hero-glow"></div>
    </div>

    {{-- 成功提示 --}}
    @if(session('success'))
    <div class="success-toast" id="successToast">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- 作业列表 --}}
    <div class="homework-grid">
        @forelse($homeworks as $hw)
        <div class="homework-card">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="difficulty">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $hw->Difficulty)
                            <i class="fa-solid fa-star filled"></i>
                        @else
                            <i class="fa-regular fa-star"></i>
                        @endif
                    @endfor
                    <span class="difficulty-num">{{ $hw->Difficulty }}</span>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">{{ $hw->Title }}</h3>
            </div>
            <div class="card-footer">
                <a href="{{ route('learn.homework.download', ['id' => $hw->id]) }}" class="btn btn-download">
                    <i class="fa-solid fa-download"></i>
                    <span>下载</span>
                </a>
                <button class="btn btn-upload" onclick="openUploadModal({{ $hw->id }}, '{{ $hw->Title }}')">
                    <i class="fa-solid fa-upload"></i>
                    <span>上传</span>
                </button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <h3 class="empty-title">暂无作业</h3>
            <p class="empty-desc">老师还没有布置作业，请耐心等待</p>
        </div>
        @endforelse
    </div>

    {{-- 分页 --}}
    @if($homeworks->hasPages())
    <div class="pagination-wrapper">
        {{ $homeworks->links('learn.pagination') }}
    </div>
    @endif
</div>

{{-- 上传弹窗 - 使用 @section('modal') 渲染在 layout 的 body 层级，避免受 .main-content 的 transform 影响 --}}
@section('modal')
<div class="upload-modal" id="uploadModal">
    <div class="modal-overlay" onclick="closeUploadModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">上传作业</h3>
            <button class="modal-close" onclick="closeUploadModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="uploadForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <p class="upload-hw-title" id="uploadHwTitle"></p>
                <div class="file-drop" id="fileDrop">
                    <input type="file" name="file" id="fileInput" class="file-input" required>
                    <div class="drop-content">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p class="drop-text">点击或拖拽文件到此处</p>
                        <p class="drop-hint">支持 ZIP、7Z、RAR、TAR、GZ 等压缩包，最大 50MB</p>
                    </div>
                    <div class="file-preview" id="filePreview" style="display: none;">
                        <i class="fa-solid fa-file"></i>
                        <span class="file-name" id="fileName"></span>
                        <button type="button" class="file-remove" onclick="removeFile(event)">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeUploadModal()">取消</button>
                <button type="submit" class="btn btn-submit">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>提交作业</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .homework-page {
        max-width: 1280px;
        margin: 0 auto;
    }

    /* ========== 标语横幅 ========== */
    .homework-hero {
        position: relative;
        margin-bottom: 32px;
        padding: 48px 40px;
        background: linear-gradient(135deg, #ffffff 0%, var(--blue-50) 40%, var(--blue-100) 100%);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        text-align: center;
    }

    .hero-pattern {
        position: absolute;
        inset: 0;
        opacity: 0.04;
        background-image:
            radial-gradient(circle at 20% 50%, var(--blue-500) 1px, transparent 1px),
            radial-gradient(circle at 80% 20%, var(--accent-cyan) 1px, transparent 1px),
            radial-gradient(circle at 60% 80%, var(--blue-400) 1px, transparent 1px);
        background-size: 40px 40px, 60px 60px, 50px 50px;
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25);
        animation: heroIconPulse 3s ease-in-out infinite;
    }

    .hero-icon i {
        font-size: 1.6rem;
        color: white;
    }

    @keyframes heroIconPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25); }
        50% { transform: scale(1.05); box-shadow: 0 12px 32px rgba(59, 130, 246, 0.35); }
    }

    .hero-title {
        font-family: 'Noto Sans SC', sans-serif;
        font-weight: 900;
        font-size: 1.75rem;
        letter-spacing: 0.12em;
        margin: 0 0 12px;
        background: linear-gradient(135deg, var(--blue-600) 0%, var(--accent-cyan) 50%, var(--blue-500) 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientShift 4s linear infinite;
    }

    .hero-subtitle {
        font-size: 0.95rem;
        color: var(--text-secondary);
        margin: 0 0 16px;
        letter-spacing: 0.05em;
        line-height: 1.6;
    }

    .hero-divider {
        width: 80px;
        height: 3px;
        margin: 0 auto;
        background: linear-gradient(90deg, transparent, var(--blue-400), var(--accent-cyan), var(--blue-400), transparent);
        border-radius: 2px;
    }

    .hero-glow {
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 40px;
        background: radial-gradient(ellipse, rgba(59, 130, 246, 0.15), transparent 70%);
        pointer-events: none;
    }

    /* ========== 作业网格 ========== */
    .homework-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    @media (max-width: 768px) {
        .homework-grid { grid-template-columns: 1fr; }
    }

    .homework-card {
        display: block;
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
    }

    .homework-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--blue-500), var(--accent-cyan));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .homework-card:hover {
        box-shadow: var(--shadow-lg);
        border-color: var(--blue-400);
    }

    .homework-card:hover::before {
        opacity: 1;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .card-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--blue-500);
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .homework-card:hover .card-icon {
        background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .difficulty {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .difficulty i {
        font-size: 0.85rem;
        color: var(--blue-200);
        transition: color 0.2s ease;
    }

    .difficulty i.filled {
        color: #f59e0b;
    }

    .difficulty-num {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-left: 4px;
    }

    .card-body {
        margin-bottom: 16px;
    }

    .card-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        line-height: 1.5;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    /* 按钮 */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn i {
        font-size: 0.8rem;
    }

    .btn-download {
        background: var(--blue-50);
        color: var(--blue-600);
        border: 1px solid var(--blue-200);
    }

    .btn-download:hover {
        background: var(--blue-100);
        border-color: var(--blue-400);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
    }

    .btn-upload {
        background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
        color: white;
        border: 1px solid transparent;
    }

    .btn-upload:hover {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: var(--bg-primary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }

    .btn-cancel:hover {
        background: var(--blue-50);
        color: var(--blue-600);
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
        color: white;
        border: 1px solid transparent;
    }

    .btn-submit:hover {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    /* 成功提示 */
    .success-toast {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 24px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 12px;
        font-weight: 500;
        font-size: 0.9rem;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        animation: toastSlideIn 0.4s ease, toastSlideOut 0.4s ease 2.6s forwards;
    }

    .success-toast i {
        font-size: 1.1rem;
    }

    @keyframes toastSlideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes toastSlideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    /* 上传弹窗 */
    .upload-modal {
        position: fixed;
        inset: 0;
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .upload-modal.active {
        display: flex;
    }

    .modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        position: relative;
        z-index: 1;
        width: 90%;
        max-width: 480px;
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.15);
        animation: modalSlideIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes modalSlideIn {
        from { transform: translateY(20px) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
    }

    .modal-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .modal-close {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--blue-50);
        border: none;
        border-radius: 8px;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .modal-close:hover {
        background: var(--blue-100);
        color: var(--blue-600);
    }

    .modal-body {
        padding: 24px;
    }

    .upload-hw-title {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin: 0 0 16px;
        padding: 10px 14px;
        background: var(--blue-50);
        border-radius: 8px;
        border-left: 3px solid var(--blue-500);
    }

    /* 文件拖拽区域 */
    .file-drop {
        position: relative;
        border: 2px dashed var(--blue-300);
        border-radius: 14px;
        padding: 32px 20px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: var(--blue-50);
    }

    .file-drop:hover,
    .file-drop.dragover {
        border-color: var(--blue-500);
        background: var(--blue-100);
    }

    .file-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .drop-content i {
        font-size: 2.5rem;
        color: var(--blue-400);
        margin-bottom: 12px;
        display: block;
    }

    .drop-text {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-primary);
        margin: 0 0 4px;
    }

    .drop-hint {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* 文件预览 */
    .file-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: white;
        border-radius: 10px;
        box-shadow: var(--shadow-sm);
    }

    .file-preview i {
        font-size: 1.5rem;
        color: var(--blue-500);
    }

    .file-name {
        flex: 1;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-primary);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .file-remove {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--blue-50);
        border: none;
        border-radius: 6px;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .file-remove:hover {
        background: #fee2e2;
        color: #ef4444;
    }

    .modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 24px;
        border-top: 1px solid var(--border-color);
    }

    /* 空状态 */
    .empty-state {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--blue-50);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .empty-icon i {
        font-size: 2rem;
        color: var(--blue-400);
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin: 0 0 8px;
    }

    .empty-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ========== 分页 ========== */
    .pagination-wrapper {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper nav {
        display: flex;
        gap: 6px;
    }

    .pagination-wrapper .relative {
        display: inline-flex;
    }

    .pagination-wrapper span,
    .pagination-wrapper a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 14px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination-wrapper span[aria-current="page"] {
        background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .pagination-wrapper a:hover {
        background: var(--blue-50);
        border-color: var(--blue-300);
        color: var(--blue-600);
    }

    .pagination-wrapper span[disabled] {
        opacity: 0.4;
        cursor: not-allowed;
    }
</style>

<script>
function openUploadModal(hwId, hwTitle) {
    const modal = document.getElementById('uploadModal');
    const form = document.getElementById('uploadForm');
    const titleEl = document.getElementById('uploadHwTitle');

    form.action = "{{ route('learn.homework.upload', ['id' => '__ID__']) }}".replace('__ID__', hwId);
    titleEl.textContent = '作业：' + hwTitle;

    // 重置文件选择
    document.getElementById('fileInput').value = '';
    document.getElementById('filePreview').style.display = 'none';
    document.querySelector('.drop-content').style.display = '';

    // 补偿滚动条宽度，防止弹窗偏移
    const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
    document.body.style.paddingRight = scrollBarWidth + 'px';
    document.body.style.overflow = 'hidden';

    modal.classList.add('active');
}

function closeUploadModal() {
    const modal = document.getElementById('uploadModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

function removeFile(e) {
    e.preventDefault();
    e.stopPropagation();
    document.getElementById('fileInput').value = '';
    document.getElementById('filePreview').style.display = 'none';
    document.querySelector('.drop-content').style.display = '';
}

// 文件选择预览
document.getElementById('fileInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('filePreview').style.display = 'flex';
        document.querySelector('.drop-content').style.display = 'none';
    }
});

// 拖拽效果
const fileDrop = document.getElementById('fileDrop');

fileDrop.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

fileDrop.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

fileDrop.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    const fileInput = document.getElementById('fileInput');
    fileInput.files = e.dataTransfer.files;
    fileInput.dispatchEvent(new Event('change'));
});

// ESC 关闭弹窗
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeUploadModal();
    }
});
</script>
@endsection
