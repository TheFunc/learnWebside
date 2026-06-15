@extends('learn.layouts')

@section('content')
<div class="homepage-content">
    <div class="competitions-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fa-solid fa-trophy"></i>
                荣誉墙
            </h2>
            <p class="section-desc">记录每一次精彩瞬间，展现团队风采</p>
        </div>

        @if($competitions->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-trophy empty-icon"></i>
                <h3>暂无比赛内容</h3>
                <p>精彩内容即将呈现，敬请期待</p>
            </div>
        @else
            <div class="competitions-grid">
                @foreach($competitions as $item)
                <div class="competition-card">
                    <div class="card-image">
                        @if($item->ImgUrl)
                            <img src="{{ $item->ImgUrl }}" alt="{{ $item->Title }}" loading="lazy">
                        @else
                            <div class="card-image-placeholder">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $item->Title }}</h3>
                        @if($item->Description)
                            <p class="card-description">{{ $item->Description }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $competitions->links('learn.pagination') }}
            </div>
        @endif
    </div>
</div>

<style>
    .homepage-content {
        width: 100%;
        padding: 32px 40px;
    }

    .competitions-section {
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-header {
        margin-bottom: 32px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
    }

    .section-title i {
        color: var(--blue-500);
        font-size: 22px;
    }

    .section-desc {
        font-size: 14px;
        color: var(--text-muted);
        margin-left: 32px;
    }

    .competitions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    .competition-card {
        background: var(--bg-card);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .competition-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(59, 130, 246, 0.15);
        border-color: var(--blue-200);
    }

    .card-image {
        width: 100%;
        height: 180px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--blue-50), #f1f5f9);
        position: relative;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .competition-card:hover .card-image img {
        transform: scale(1.05);
    }

    .card-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 40px;
        opacity: 0.4;
    }

    .card-body {
        padding: 16px;
    }

    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-description {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }

    .empty-icon {
        font-size: 56px;
        margin-bottom: 16px;
        opacity: 0.35;
    }

    .empty-state h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: 14px;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 16px;
    }

    /* 移动端适配 */
    @media (max-width: 1200px) {
        .competitions-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .competitions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .homepage-content {
            padding: 24px 20px;
        }
    }

    @media (max-width: 768px) {
        .competitions-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .card-image {
            height: 140px;
        }
        .homepage-content {
            padding: 16px;
        }
        .section-title {
            font-size: 20px;
        }
    }
</style>
@endsection
