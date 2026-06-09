@extends('learn.layouts')

@section('content')
<div class="watch-page">
    {{-- 返回按钮 --}}
    <div class="watch-header">
        <a href="{{ route('learn.courses', ['type_id' => $typeId]) }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            <span>返回课程</span>
        </a>
        <h1 class="watch-title">{{ $videos->first()->title ?? '视频观看' }}</h1>
    </div>

    {{-- 播放器 + 视频列表 --}}
    <div class="watch-layout">
        {{-- 左侧播放器 --}}
        <div class="player-section">
            <div class="player-wrapper">
                <div id="dplayer" class="dplayer-container"></div>
            </div>
            <div class="video-info">
                <h2 class="video-title" id="currentTitle">{{ $videos->first()->title }}</h2>
                <p class="video-desc" id="currentDesc">{{ $videos->first()->Description }}</p>
            </div>
        </div>

        {{-- 右侧视频列表 --}}
        <div class="playlist-section">
            <div class="playlist-header">
                <i class="fa-solid fa-list"></i>
                <span>视频列表</span>
                <span class="playlist-count">({{ $videos->count() }})</span>
            </div>
            <div class="playlist-list" id="playlist">
                @foreach($videos as $index => $video)
                <div class="playlist-item {{ $index === 0 ? 'active' : '' }}" 
                     data-index="{{ $index }}"
                     data-url="{{ route('learn.video.stream', ['path' => $video->Path]) }}"
                     data-title="{{ $video->display_name }}"
                     data-desc="{{ $video->Description }}"
                     data-cover="{{ $video->cover ? asset('storage/' . $video->cover->path) : '' }}"
                     onclick="switchVideo(this)">
                    <div class="item-index">{{ $index + 1 }}</div>
                    <div class="item-info">
                        <div class="item-title">{{ $video->display_name }}</div>
                        <div class="item-desc">{{ Str::limit($video->Description, 30) }}</div>
                    </div>
                    <div class="item-playing">
                        <i class="fa-solid fa-volume-high"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- DPlayer CSS --}}
<link rel="stylesheet" href="{{ asset('css/DPlayer.min.css') }}">

<style>
    .watch-page {
        max-width: 1400px;
        margin: 0 auto;
    }

    .watch-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .back-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .back-btn:hover {
        background: var(--blue-50);
        color: var(--blue-600);
        border-color: var(--blue-400);
    }

    .watch-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .watch-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .watch-layout {
            grid-template-columns: 1fr;
        }
    }

    /* 播放器区域 */
    .player-section {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .player-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        background: #000;
    }

    .dplayer-container {
        width: 100%;
        height: 100%;
    }

    .dplayer-container .dplayer-video {
        object-fit: contain;
    }

    .video-info {
        padding: 20px 24px;
        border-top: 1px solid var(--border-color);
    }

    .video-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 8px;
    }

    .video-desc {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.6;
    }

    /* 播放列表区域 */
    .playlist-section {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        max-height: calc(100vh - 180px);
        display: flex;
        flex-direction: column;
    }

    .playlist-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 20px;
        background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
        border-bottom: 1px solid var(--border-color);
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-primary);
        flex-shrink: 0;
    }

    .playlist-header i {
        color: var(--blue-500);
    }

    .playlist-count {
        margin-left: auto;
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 400;
    }

    .playlist-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px;
    }

    .playlist-list::-webkit-scrollbar {
        width: 6px;
    }

    .playlist-list::-webkit-scrollbar-track {
        background: transparent;
    }

    .playlist-list::-webkit-scrollbar-thumb {
        background: var(--blue-200);
        border-radius: 3px;
    }

    .playlist-list::-webkit-scrollbar-thumb:hover {
        background: var(--blue-400);
    }

    .playlist-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .playlist-item:hover {
        background: var(--blue-50);
    }

    .playlist-item.active {
        background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
        color: white;
    }

    .playlist-item.active .item-index {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .playlist-item.active .item-desc {
        color: rgba(255, 255, 255, 0.8);
    }

    .item-index {
        width: 32px;
        height: 32px;
        background: var(--blue-50);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--blue-600);
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .item-info {
        flex: 1;
        min-width: 0;
    }

    .item-title {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-primary);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        margin-bottom: 2px;
    }

    .playlist-item.active .item-title {
        color: white;
    }

    .item-desc {
        font-size: 0.75rem;
        color: var(--text-muted);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .item-playing {
        display: none;
        color: var(--blue-400);
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .playlist-item.active .item-playing {
        display: block;
        color: white;
    }

    /* DPlayer 自定义样式覆盖 */
    .dplayer-container .dplayer-mask {
        background: rgba(0, 0, 0, 0.5);
    }

    .dplayer-container .dplayer-controller {
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    }

    .dplayer-container .dplayer-bar-wrap {
        padding: 8px 0;
    }

    .dplayer-container .dplayer-bar {
        height: 4px;
        border-radius: 2px;
    }

    .dplayer-container .dplayer-played {
        background: var(--blue-500);
    }

    .dplayer-container .dplayer-thumb {
        width: 14px;
        height: 14px;
        background: var(--blue-500);
        border: 2px solid white;
    }

    .dplayer-container .dplayer-icons .dplayer-icon {
        color: white;
    }

    .dplayer-container .dplayer-time {
        color: white;
    }

    .dplayer-container .dplayer-fullscreen-in .dplayer-fullscreen-icon {
        color: white;
    }
</style>

{{-- DPlayer JS --}}
<script src="{{ asset('js/DPlayer.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoList = document.querySelectorAll('.playlist-item');
    let currentPlayer = null;

    function initPlayer(videoUrl, coverUrl) {
        const container = document.getElementById('dplayer');
        
        // 销毁旧实例
        if (currentPlayer) {
            currentPlayer.destroy();
        }

        const options = {
            container: container,
            video: {
                url: videoUrl,
                pic: coverUrl || '',
                type: 'auto'
            },
            autoplay: true,
            theme: '#3b82f6',
            loop: false,
            screenshot: false,
            hotkey: true,
            preload: 'metadata',
            volume: 1,
            playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2]
        };

        currentPlayer = new DPlayer(options);
    }

    // 初始化第一个视频
    const firstItem = videoList[0];
    if (firstItem) {
        const firstUrl = firstItem.dataset.url;
        const firstCover = firstItem.dataset.cover;
        initPlayer(firstUrl, firstCover);
    }

    window.switchVideo = function(element) {
        const url = element.dataset.url;
        const title = element.dataset.title;
        const desc = element.dataset.desc;
        const cover = element.dataset.cover;

        // 更新激活状态
        videoList.forEach(item => item.classList.remove('active'));
        element.classList.add('active');

        // 更新视频信息
        document.getElementById('currentTitle').textContent = title;
        document.getElementById('currentDesc').textContent = desc;

        // 切换视频
        initPlayer(url, cover);

        // 滚动到可视区域
        element.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    };
});
</script>
@endsection
