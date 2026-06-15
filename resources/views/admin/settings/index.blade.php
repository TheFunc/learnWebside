@extends('layouts.admin')

@section('title', '系统设置')

@section('content')
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

</div>


<script>
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
    });
</script>
@endsection