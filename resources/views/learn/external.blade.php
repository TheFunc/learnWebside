@extends('learn.layouts')

@section('content')
<div class="external-page">
    {{-- 页面标语横幅 --}}
    <div class="external-hero">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-solid fa-globe"></i>
            </div>
            <h1 class="hero-title">外部学习资源</h1>
            <p class="hero-subtitle">汇聚优质外部学习链接，拓展知识边界，探索无限可能</p>
            <div class="hero-divider"></div>
        </div>
        <div class="hero-glow"></div>
    </div>

    {{-- 类型菜单栏 --}}
    <div class="type-menu">
        <div class="type-menu-inner">
            <a href="{{ route('learn.external') }}" 
               class="type-item {{ !$typeId ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i>
                <span>全部</span>
            </a>
            @foreach($externalTypes as $type)
            <a href="{{ route('learn.external', ['type_id' => $type->id]) }}" 
               class="type-item {{ $typeId == $type->id ? 'active' : '' }}">
                <i class="fa-solid fa-folder-open"></i>
                <span>{{ $type->type }}</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- 外部链接卡片网格 --}}
    @forelse($externalLinks as $group)
    <div class="link-section">
        <div class="section-header">
            <div class="section-title">
                <i class="fa-solid fa-folder"></i>
                <span>{{ $group['type'] ?: '未分类' }}</span>
                <span class="section-count">{{ $group['count'] }}</span>
            </div>
        </div>
        <div class="link-grid">
            @foreach($group['links'] as $link)
            <a href="{{ $link->url }}" target="_blank" class="link-card">
                <div class="link-icon">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </div>
                <div class="link-info">
                    <h3 class="link-name">{{ $link->name }}</h3>
                    <p class="link-url">{{ $link->url }}</p>
                </div>
                <div class="link-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fa-solid fa-link-slash"></i>
        </div>
        <h3 class="empty-title">暂无外部学习资源</h3>
        <p class="empty-desc">
            @if($typeId)
            该分类下还没有外部链接
            @else
            当前没有外部学习资源
            @endif
        </p>
    </div>
    @endforelse
</div>

<style>
    .external-page {
        max-width: 1280px;
        margin: 0 auto;
    }

    /* ========== 页面标语横幅 ========== */
    .external-hero {
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
        background: linear-gradient(135deg, var(--blue-500) 0%, var(--accent-cyan) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
    }

    .hero-icon i {
        font-size: 28px;
        color: white;
    }

    .hero-title {
        font-family: 'Orbitron', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--blue-600) 0%, var(--accent-cyan) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 12px;
        letter-spacing: 1px;
    }

    .hero-subtitle {
        font-size: 1rem;
        color: var(--text-secondary);
        margin: 0;
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

    /* ========== 类型菜单栏 ========== */
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
        transform: translateY(-1px);
    }

    .type-item.active {
        background: linear-gradient(135deg, var(--blue-500) 0%, var(--blue-600) 100%);
        color: white;
        border-color: var(--blue-600);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .type-item i {
        font-size: 1rem;
    }

    /* ========== 分类区块 ========== */
    .link-section {
        margin-bottom: 32px;
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .section-header {
        padding: 20px 24px;
        background: linear-gradient(135deg, var(--blue-50) 0%, var(--bg-card) 100%);
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .section-title i {
        color: var(--blue-500);
    }

    .section-count {
        background: var(--blue-100);
        color: var(--blue-600);
        font-size: 0.8rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 10px;
        margin-left: 4px;
    }

    /* ========== 链接卡片网格 ========== */
    .link-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 16px;
        padding: 24px;
    }

    .link-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .link-card:hover {
        border-color: var(--blue-400);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        transform: translateY(-2px);
    }

    .link-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, var(--blue-50) 0%, var(--blue-100) 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .link-icon i {
        font-size: 18px;
        color: var(--blue-500);
    }

    .link-info {
        flex: 1;
        min-width: 0;
    }

    .link-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .link-url {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .link-arrow {
        color: var(--text-muted);
        transition: all 0.25s ease;
        flex-shrink: 0;
    }

    .link-card:hover .link-arrow {
        color: var(--blue-500);
        transform: translateX(4px);
    }

    /* ========== 空状态 ========== */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        background: var(--blue-50);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon i {
        font-size: 36px;
        color: var(--blue-400);
        opacity: 0.6;
    }

    .empty-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin: 0 0 8px;
    }

    .empty-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ========== 响应式 ========== */
    @media (max-width: 768px) {
        .external-hero {
            padding: 32px 20px;
        }

        .hero-title {
            font-size: 1.5rem;
        }

        .link-grid {
            grid-template-columns: 1fr;
            padding: 16px;
        }

        .type-menu-inner {
            padding: 12px 16px;
        }
    }
</style>
@endsection
