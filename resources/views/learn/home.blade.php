@extends('learn.layouts')

@section('content')
<div class="homepage-video-container">
    @if($homepageVideo)
        {{-- 全屏循环播放视频 --}}
        <video 
            id="homepageVideo"
            class="homepage-video" 
            preload="auto"
            loop
            playsinline
            controlsList="nodownload nofullscreen noremoteplayback"
            disablePictureInPicture
        >
            <source src="{{ $homepageVideo }}" type="video/mp4">
            您的浏览器不支持视频播放
        </video>

        {{-- 视频遮罩层（防止右键和交互） --}}
        <div class="video-overlay"></div>
    @else
        {{-- 无视频时的占位提示 --}}
        <div class="no-video-placeholder">
            <div class="w-24 h-24 mb-6 rounded-full bg-blue-50 flex items-center justify-center">
                <i class="fa-solid fa-house text-4xl text-blue-500"></i>
            </div>
            <h2 class="text-2xl font-semibold text-slate-600 mb-2">首页</h2>
            <p class="text-slate-400">管理员尚未设置首页视频</p>
        </div>
    @endif
</div>

<style>
    /* 首页主内容区占满剩余空间 */
    .main-content {
        padding: 0 !important;
        min-height: calc(100vh - 100px) !important;
        height: calc(100vh - 100px) !important;
        opacity: 1 !important;
        transform: none !important;
    }

    /* 首页视频容器 - 占满主内容区 */
    .homepage-video-container {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background: #000;
    }

    /* 视频占满容器，完整显示不裁剪 */
    .homepage-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* 遮罩层 - 防止用户与视频交互 */
    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 3;
    }

    /* 无视频占位 */
    .no-video-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        background: transparent;
        position: relative;
        z-index: 2;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('homepageVideo');
    if (!video) return;

    // 尝试直接带声音播放
    video.muted = false;
    video.volume = 1;
    video.play().catch(function(error) {
        console.log('浏览器阻止了有声自动播放:', error);
        // 如果浏览器阻止，降级为静音播放
        video.muted = true;
        video.play().catch(function() {});
    });

    // 禁止右键菜单
    video.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // 禁止键盘快捷键
    video.addEventListener('keydown', function(e) {
        e.preventDefault();
    });

    // 点击导航链接时立即暂停视频，确保页面切换不被阻塞
    document.querySelectorAll('.nav-item').forEach(function(link) {
        link.addEventListener('click', function() {
            video.pause();
            video.src = '';
            video.load();
        });
    });
});
</script>
@endsection
