@extends('learn.layouts')

@section('content')
<div class="courses-page">
    {{-- 课程标语横幅 --}}
    <div class="course-hero">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            <h1 class="hero-title">学无止境，技以立身</h1>
            <p class="hero-subtitle">每一次学习都是成长的阶梯，每一段视频都承载着知识的重量</p>
            <div class="hero-divider"></div>
        </div>
        <div class="hero-glow"></div>
    </div>

    {{-- 类型菜单栏 --}}
    <div class="type-menu">
        <div class="type-menu-inner">
            <a href="{{ route('learn.courses') }}" 
               class="type-item {{ !$typeId ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i>
                <span>全部</span>
            </a>
            @foreach($videoTypes as $type)
            <a href="{{ route('learn.courses', ['type_id' => $type->TypeID]) }}" 
               class="type-item {{ $typeId == $type->TypeID ? 'active' : '' }}">
                <i class="fa-solid fa-folder-open"></i>
                <span>{{ $type->Type }}</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- 视频组卡片网格 --}}
    <div class="video-grid">
        @forelse($videoGroups as $group)
        <a href="{{ route('learn.watch', ['groupId' => $group['group_id']]) }}" 
           class="video-card">
            <div class="card-cover">
                @if($group['cover'])
                <img src="{{ asset('storage/' . $group['cover']) }}" 
                     alt="封面" 
                     class="cover-img"
                     onerror="this.parentElement.classList.add('no-cover')">
                @else
                <div class="no-cover-placeholder">
                    <i class="fa-solid fa-film"></i>
                </div>
                @endif
                <div class="card-overlay">
                    <div class="play-btn">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>
                <div class="card-badge">
                    <i class="fa-solid fa-list-ol"></i>
                    <span>{{ $group['video_count'] }} 集</span>
                </div>
            </div>
            <div class="card-info">
                <h3 class="card-title">{{ $group['videos']->first()->title ?? '视频组 ' . $group['group_id'] }}</h3>
                <p class="card-meta">
                    <i class="fa-solid fa-play-circle"></i>
                    共 {{ $group['video_count'] }} 个视频
                </p>
            </div>
        </a>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h3 class="empty-title">暂无视频</h3>
            <p class="empty-desc">
                @if($typeId)
                该类型下还没有视频内容
                @else
                请选择一个视频类型查看内容
                @endif
            </p>
        </div>
        @endforelse
    </div>
</div>

<style>
    .courses-page {
        max-width: 1280px;
        margin: 0 auto;
    }

    /* ========== 课程标语横幅 ========== */
    .course-hero {
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

    /* 背景几何图案 */
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

    /* 内容区域 */
    .hero-content {
        position: relative;
        z-index: 2;
    }

    /* 图标 */
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

    /* 标题 */
    .hero-title {
        font-family: 'Noto Sans SC', sans-serif;
        font-weight: 900;
        font-size: 1.75rem;
        letter-spacing: 0.12em;
        margin: 0 0 12px;
        background: linear-gradient(
            135deg,
            var(--blue-600) 0%,
            var(--accent-cyan) 50%,
            var(--blue-500) 100%
        );
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientShift 4s linear infinite;
    }

    /* 副标题 */
    .hero-subtitle {
        font-size: 0.95rem;
        color: var(--text-secondary);
        margin: 0 0 16px;
        letter-spacing: 0.05em;
        line-height: 1.6;
    }

    /* 装饰分隔线 */
    .hero-divider {
        width: 80px;
        height: 3px;
        margin: 0 auto;
        background: linear-gradient(90deg, transparent, var(--blue-400), var(--accent-cyan), var(--blue-400), transparent);
        border-radius: 2px;
    }

    /* 底部发光效果 */
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

    /* 类型菜单栏 */
    .type-menu {
        margin-bottom: 32px;
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .type-menu-inner {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 16px 24px;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .type-menu-inner::-webkit-scrollbar {
        display: none;
    }

    .type-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--blue-50);
        border: 1px solid transparent;
        border-radius: 10px;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        white-space: nowrap;
        transition: all 0.25s ease;
    }

    .type-item:hover {
        background: var(--blue-100);
        color: var(--blue-600);
        border-color: var(--blue-200);
    }

    .type-item.active {
        background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .type-item i {
        font-size: 0.9rem;
    }

    /* 视频组卡片网格 */
    .video-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    @media (max-width: 1200px) {
        .video-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 900px) {
        .video-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .video-grid { grid-template-columns: 1fr; }
    }

    .video-card {
        display: block;
        background: var(--bg-card);
        border-radius: 14px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
    }

    .video-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: var(--blue-400);
    }

    .card-cover {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
    }

    .cover-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .video-card:hover .cover-img {
        transform: scale(1.05);
    }

    .no-cover {
        background: linear-gradient(135deg, var(--blue-100), var(--blue-200));
    }

    .no-cover-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--blue-400);
        font-size: 2.5rem;
    }

    .card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .video-card:hover .card-overlay {
        opacity: 1;
    }

    .play-btn {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--blue-600);
        font-size: 1.3rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        transform: scale(0.8);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .video-card:hover .play-btn {
        transform: scale(1);
    }

    .card-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        border-radius: 6px;
        color: white;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .card-info {
        padding: 14px 16px;
    }

    .card-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 6px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .card-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    .card-meta i {
        font-size: 0.75rem;
        color: var(--blue-400);
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
</style>
@endsection
