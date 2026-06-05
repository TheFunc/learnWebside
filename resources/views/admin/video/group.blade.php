@extends('layouts.admin')

@section('title', '视频组详情')

@section('content')
    <div class="video-group-container">
        <div class="page-header">
            <a href="{{ route('admin.video.manage') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>返回</span>
            </a>
        </div>

        <div class="videos-section">
            <h3>视频列表 (共 {{ $videos->count() }} 个视频)</h3>
            <table class="video-table">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>文件名</th>
                        <th>描述</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($videos as $index => $video)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ basename($video->Path) }}</td>
                            <td>{{ $video->Description ?: '无描述' }}</td>
                            <td>
                                <button class="btn-play" onclick="playVideo('{{ $video->Path }}', '{{ basename($video->Path) }}')">
                                    <i class="fas fa-play"></i> 播放
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 视频播放模态框 -->
    <div id="videoModal" class="modal">
        <div class="modal-overlay" onclick="closeModal()"></div>
        <div class="modal-wrapper">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-film"></i>
                    <span id="videoTitle">视频播放</span>
                </div>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="dplayer"></div>
                <div id="speedToast" class="speed-toast">播放速度: 1x</div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/DPlayer.min.js') }}"></script>

    <style>
        .video-group-container {
            padding: 0;
        }

        .page-header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            padding: 0 0 16px 0;
            border-bottom: 1px solid var(--card-border);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: transparent;
            color: var(--primary-light);
            text-decoration: none;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .back-btn:hover {
            background: var(--accent-hover);
            color: var(--primary);
            border-color: var(--primary-hover);
            transform: translateX(-2px);
        }

        .back-btn i {
            font-size: 12px;
            transition: transform 0.2s ease;
        }

        .back-btn:hover i {
            transform: translateX(-3px);
        }

        .videos-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .videos-section h3 {
            margin-bottom: 15px;
            color: #495057;
        }

        .video-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }

        .video-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }

        .video-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
            color: #495057;
        }

        .video-table tbody tr:last-child td {
            border-bottom: none;
        }

        .video-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-play {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            background: #28a745;
            color: white;
            transition: all 0.3s;
        }

        .btn-play:hover {
            background: #218838;
        }

        /* ===== 现代模态框设计 ===== */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        /* 背景遮罩 - 毛玻璃效果 */
        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* 模态框主体 */
        .modal-wrapper {
            position: relative;
            z-index: 1001;
            width: 85%;
            max-width: 900px;
            background: #0f172a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.08);
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* 头部 */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e2e8f0;
            font-size: 15px;
            font-weight: 500;
        }

        .modal-title i {
            color: #38bdf8;
            font-size: 14px;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.06);
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .modal-close:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            transform: rotate(90deg);
        }

        /* 播放器区域 */
        .modal-body {
            padding: 0;
            background: #000;
        }

        #dplayer {
            width: 100%;
            height: 480px;
        }

        /* DPlayer 自定义主题 */
        .dplayer {
            border-radius: 0 0 16px 16px;
            overflow: hidden;
        }

        .dplayer-controller .dplayer-bar-wrap .dplayer-bar .dplayer-loaded {
            background: rgba(255, 255, 255, 0.2) !important;
        }

        .dplayer-controller .dplayer-bar-wrap .dplayer-bar .dplayer-played {
            background: #38bdf8 !important;
        }

        .dplayer-controller .dplayer-bar-wrap .dplayer-bar .dplayer-thumb {
            background: #38bdf8 !important;
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.5) !important;
        }

        .dplayer-controller .dplayer-icons .dplayer-icon:hover {
            color: #38bdf8 !important;
        }

        .dplayer-controller .dplayer-setting .dplayer-setting-item:hover {
            color: #38bdf8 !important;
        }

        .dplayer-menu .dplayer-menu-item:hover {
            color: #38bdf8 !important;
        }

        /* 倍速提示 Toast */
        .speed-toast {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 100;
        }

        .speed-toast.show {
            opacity: 1;
        }

        /* 响应式 */
        @media (max-width: 768px) {
            .modal-wrapper {
                width: 95%;
                border-radius: 12px;
            }

            #dplayer {
                height: 280px;
            }
        }
    </style>

    <script>
        let dp = null;

        function playVideo(videoPath, videoTitle) {
            const modal = document.getElementById('videoModal');
            const titleElement = document.getElementById('videoTitle');

            titleElement.textContent = videoTitle;
            modal.classList.add('active');

            // 销毁之前的播放器实例
            if (dp) {
                dp.destroy();
                dp = null;
            }

            // 初始化 DPlayer
            dp = new DPlayer({
                container: document.getElementById('dplayer'),
                video: {
                    url: `/video/stream/${encodeURIComponent(videoPath)}`,
                    type: 'auto'
                },
                theme: '#38bdf8',
                lang: 'zh-cn',
                screenshot: true,
                hotkey: true,
                preload: 'metadata',
                volume: 0.7,
                playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2, 5],
                contextmenu: [
                    {
                        text: '视频管理系统',
                        link: window.location.href
                    }
                ]
            });

            // 自动播放
            dp.on('loadedmetadata', function () {
                dp.play().catch(function(error) {
                    console.log('自动播放被阻止:', error);
                });
            });

            // 倍速切换事件监听
            dp.on('playbackSpeedChange', function(speed) {
                showSpeedToast(speed);
            });
        }

        function showSpeedToast(speed) {
            const toast = document.getElementById('speedToast');
            toast.textContent = '播放速度: ' + speed + 'x';
            toast.classList.add('show');
            
            // 2秒后隐藏
            setTimeout(function() {
                toast.classList.remove('show');
            }, 2000);
        }

        function closeModal() {
            const modal = document.getElementById('videoModal');

            if (dp) {
                dp.pause();
                dp.destroy();
                dp = null;
            }

            modal.classList.remove('active');
        }

        // ESC 键关闭
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endsection
