@extends('layouts.admin')

@section('title', '系统设置')

@section('content')
<script src="{{ asset('js/DPlayer.min.js') }}"></script>
<style>
    .settings-container {
        padding: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        padding-left: 20px;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 24px;
        background: linear-gradient(180deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 2px;
    }

    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .theme-selector {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .theme-card {
        position: relative;
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 3px solid transparent;
        overflow: hidden;
        filter: brightness(0.92) saturate(0.9);
    }

    .theme-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.15);
        z-index: 1;
        pointer-events: none;
    }

    .theme-card:hover {
        transform: translateY(-6px) scale(1.01);
        border-color: rgba(255, 255, 255, 0.25);
        filter: brightness(0.98) saturate(1);
    }

    .theme-card.selected {
        border-color: rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        transform: scale(1.02);
        filter: brightness(1) saturate(1.05);
    }

    .theme-card.selected::after {
        content: '✓';
        position: absolute;
        top: 10px;
        right: 10px;
        width: 28px;
        height: 28px;
        background: rgba(255, 255, 255, 0.18);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: white;
        backdrop-filter: blur(6px);
        z-index: 2;
    }

    .theme-name {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 8px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        letter-spacing: 0.5px;
        font-family: 'PingFang SC', 'Microsoft YaHei', sans-serif;
        position: relative;
        z-index: 2;
    }

    .theme-desc {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.78);
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.35);
        position: relative;
        z-index: 2;
    }

    .theme-aurora {
        background: linear-gradient(135deg, #5a6bc2 0%, #6b418a 50%, #d885d8 100%);
    }

    .theme-midnight {
        background: linear-gradient(135deg, #1a163a 0%, #2d265a 50%, #1e1e38 100%);
    }

    .theme-dawn {
        background: linear-gradient(135deg, #e894b2 0%, #f8d67e 50%, #e5b55a 100%);
    }

    .theme-galaxy {
        background: linear-gradient(135deg, #121212 0%, #1f1f3a 30%, #1e2d4a 60%, #163a58 100%);
    }

    .theme-forest {
        background: linear-gradient(135deg, #1a5a66 0%, #68a87a 50%, #9dcb7b 100%);
    }

    .theme-ocean {
        background: linear-gradient(135deg, #1a8e82 0%, #32c974 30%, #0a4a38 100%);
    }

    .theme-original {
        background: linear-gradient(135deg, #374151 0%, #4B5563 50%, #6B7280 100%);
    }

    .upload-section {
        margin-top: 30px;
    }

    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .upload-area:hover {
        border-color: #6366f1;
        background: linear-gradient(135deg, #f0f0ff 0%, #eef2ff 100%);
    }

    .upload-area.dragover {
        border-color: #8b5cf6;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        transform: scale(1.02);
    }

    .upload-icon {
        font-size: 48px;
        color: #94a3b8;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }

    .upload-area:hover .upload-icon {
        color: #6366f1;
        transform: scale(1.1);
    }

    .upload-text {
        font-size: 16px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .upload-hint {
        font-size: 13px;
        color: #94a3b8;
    }

    #videoInput {
        display: none;
    }

    .video-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 24px;
    }

    .video-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .video-card.active {
        border-color: #6366f1;
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
    }



    .video-info {
        padding: 12px;
    }

    .video-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .video-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        flex: 1;
        padding: 8px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .action-btn.view {
        background: #eff6ff;
        color: #3b82f6;
    }

    .action-btn.view:hover {
        background: #dbeafe;
    }

    .action-btn.delete {
        background: #fef2f2;
        color: #ef4444;
    }

    .action-btn.delete:hover {
        background: #fee2e2;
    }

    .preview-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        pointer-events: none;
    }

    .preview-modal.active {
        display: flex;
        animation: fadeIn 0.3s ease;
        pointer-events: auto;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .preview-content {
        background: #1e293b;
        border-radius: 20px;
        overflow: hidden;
        max-width: 70vw;
        max-height: 70vh;
        width: 720px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: scaleIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
    }

    #dplayer {
        width: 100%;
        height: 420px;
        flex-shrink: 0;
    }

    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .preview-video {
        display: block;
        max-width: 100%;
        max-height: 50vh;
    }

    .preview-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
    }

    .preview-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    .current-theme-badge {
        display: inline-block;
        padding: 6px 16px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 16px;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }

    .upload-progress {
        display: none;
        margin-top: 16px;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 4px;
        transition: width 0.3s ease;
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 16px 24px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        z-index: 2000;
        animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.5s forwards;
    }

    .toast.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .toast.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    @keyframes slideIn {
        from { transform: translateX(100px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
</style>

<div class="settings-container">
    <div class="card">
        <div class="section-title">
            <i class="fa-solid fa-palette"></i>
            <span>界面风格</span>
        </div>
        
        <div class="theme-selector">
            @foreach($themes as $theme)
                <div 
                    class="theme-card theme-{{ $theme['id'] }}"
                    onclick="selectTheme('{{ $theme['id'] }}')"
                >
                    <div class="theme-name">{{ $theme['name'] }}</div>
                    <div class="theme-desc">{{ $theme['description'] }}</div>
                </div>
            @endforeach
        </div>
        
        <div class="current-theme-badge" id="currentThemeBadge">
            当前风格: <span id="currentThemeName">极光幻境</span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">
            <i class="fa-solid fa-video"></i>
            <span>首页视频设置</span>
        </div>

        <div class="upload-area" id="uploadArea" onclick="document.getElementById('videoInput').click()">
            <i class="upload-icon fa-solid fa-cloud-upload"></i>
            <div class="upload-text">点击或拖拽上传视频</div>
            <div class="upload-hint">支持 MP4, MOV, AVI, WMV 格式，最大 50MB</div>
        </div>

        <input type="file" id="videoInput" accept="video/*" onchange="handleVideoUpload(event)">

        <div class="upload-progress" id="uploadProgress">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        @if(count($homepageVideos) > 0)
            <div class="video-grid">
                @foreach($homepageVideos as $video)
                    <div class="video-card">
                        <div class="video-info">
                            <div class="video-name">{{ $video['name'] }}</div>
                            <div class="video-actions">
                                <button class="action-btn view" onclick="previewVideo('{{ $video['url'] }}')">
                                    <i class="fa-solid fa-eye"></i>预览
                                </button>
                                <button class="action-btn delete" onclick="event.stopPropagation(); deleteVideo('{{ $video['name'] }}')">
                                    <i class="fa-solid fa-trash"></i>删除
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 20px; color: #94a3b8;">
                <i class="fa-solid fa-film" style="font-size: 48px; margin-bottom: 12px; opacity: 0.5;"></i>
                <p>暂无视频，请上传首页视频</p>
            </div>
        @endif
    </div>
</div>

<div class="preview-modal" id="previewModal">
    <button class="preview-close" onclick="closePreview()">×</button>
    <div class="preview-content">
        <div id="dplayer"></div>
    </div>
</div>

<script>
    let dp = null;

    const themes = {
        original: {
            primary: '#374151',
            secondary: '#4B5563',
            accent: '#E5E7EB',
            name: '经典雅致'
        },
        aurora: {
            primary: '#667eea',
            secondary: '#764ba2',
            accent: '#f093fb',
            name: '极光幻境'
        },
        midnight: {
            primary: '#0f0c29',
            secondary: '#302b63',
            accent: '#24243e',
            name: '暗夜鎏金'
        },
        dawn: {
            primary: '#fa709a',
            secondary: '#fee140',
            accent: '#f09819',
            name: '晨曦迷雾'
        },
        galaxy: {
            primary: '#0c0c0c',
            secondary: '#1a1a2e',
            accent: '#16213e',
            name: '星河漫步'
        },
        forest: {
            primary: '#134e5e',
            secondary: '#71b280',
            accent: '#a8e063',
            name: '绿野仙踪'
        },
        ocean: {
            primary: '#11998e',
            secondary: '#38ef7d',
            accent: '#013220',
            name: '深海秘境'
        }
    };

    function selectTheme(themeId) {
        const theme = themes[themeId];
        
        document.querySelectorAll('.theme-card').forEach(card => {
            card.classList.remove('selected');
        });
        document.querySelector('.theme-card.theme-' + themeId).classList.add('selected');

        document.getElementById('currentThemeName').textContent = theme.name;

        document.documentElement.style.setProperty('--primary', theme.primary);
        document.documentElement.style.setProperty('--primary-light', theme.secondary);
        document.documentElement.style.setProperty('--accent', theme.accent);

        localStorage.setItem('selectedTheme', themeId);

        showToast('风格切换成功: ' + theme.name, 'success');
    }

    function handleVideoUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('video', file);

        const uploadProgress = document.getElementById('uploadProgress');
        const progressFill = document.getElementById('progressFill');
        
        uploadProgress.style.display = 'block';

        fetch('{{ route('admin.settings.upload.video') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                uploadProgress.style.display = 'none';
                showToast('视频上传成功', 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showToast('上传失败', 'error');
            }
        })
        .catch(error => {
            uploadProgress.style.display = 'none';
            showToast('上传失败', 'error');
        });
    }

    function previewVideo(url) {
        const modal = document.getElementById('previewModal');
        
        if (dp) {
            dp.destroy();
            dp = null;
        }

        dp = new DPlayer({
            container: document.getElementById('dplayer'),
            video: {
                url: url,
                type: 'auto'
            },
            theme: '#6366f1',
            lang: 'zh-cn',
            screenshot: true,
            hotkey: true,
            preload: 'auto',
            volume: 0.7,
            playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2],
            contextmenu: [
                {
                    text: '视频管理系统',
                    link: window.location.href
                }
            ],
            mutex: false,
            danmaku: false
        });

        dp.on('loadedmetadata', function () {
            dp.play().catch(function(error) {
                console.log('自动播放被阻止:', error);
            });
        });

        modal.classList.add('active');
    }

    function closePreview() {
        const modal = document.getElementById('previewModal');
        
        if (dp) {
            dp.destroy();
            dp = null;
        }
        
        modal.classList.remove('active');
    }

    function deleteVideo(fileName) {
        if (!confirm('确定要删除这个视频吗？')) return;

        fetch('{{ route('admin.settings.delete.video') }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ fileName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('视频删除成功', 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showToast('删除失败', 'error');
            }
        });
    }

    function selectVideo(fileName) {
        document.querySelectorAll('.video-card').forEach(card => {
            card.classList.remove('active');
        });
        event.currentTarget.classList.add('active');
        showToast('已选择: ' + fileName, 'success');
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = 'toast ' + type;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('selectedTheme') || 'original';
        selectTheme(savedTheme);

        const uploadArea = document.getElementById('uploadArea');
        
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('video/')) {
                const input = document.getElementById('videoInput');
                input.files = e.dataTransfer.files;
                handleVideoUpload({ target: input });
            }
        });
    });
</script>
@endsection