<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>后台管理系统</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #374151;
            --primary-light: #4B5563;
            --primary-hover: #6B7280;
            --accent: #E5E7EB;
            --accent-hover: #F3F4F6;
            --accent-light: rgba(229, 231, 235, 0.1);
            --success: #10B981;
            --danger: #EF4444;
            
            --text-primary: #F9FAFB;
            --text-secondary: #D1D5DB;
            --text-muted: #9CA3AF;
            
            --content-bg: #F1F5F9;
            --card-bg: #FFFFFF;
            --card-border: #E2E8F0;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
            background-color: var(--content-bg);
            font-size: 14px;
            line-height: 1.6;
        }

        .admin-container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--text-primary);
            position: fixed;
            height: 100%;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .menu-item {
            position: relative;
        }

        .menu-item > .menu-header {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.25s ease;
            background: transparent;
            position: relative;
            overflow: hidden;
        }

        .menu-item > .menu-header::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--accent);
            transform: scaleY(0);
            transition: transform 0.25s ease;
            transform-origin: top;
        }

        .menu-item > .menu-header:hover::before {
            transform: scaleY(1);
        }

        .menu-item > .menu-header:hover {
            background: var(--primary-hover);
            padding-left: 28px;
        }

        .menu-item > .menu-header:active {
            background: rgba(59, 130, 246, 0.2);
        }

        .menu-item > .menu-header .arrow {
            font-size: 18px;
            font-weight: 300;
            color: var(--text-muted);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), color 0.25s ease;
        }

        .menu-item > .menu-header .arrow {
            transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .menu-item > .menu-header:hover .arrow {
            color: var(--accent);
        }

        .menu-item > .menu-header .arrow.expanded {
            transform: rotate(90deg);
        }

        .menu-item > .menu-header .menu-content {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-item > .menu-header .icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.95);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .menu-item > .menu-header:hover .icon {
            background: rgba(255, 255, 255, 0.25);
            color: #FFFFFF;
            transform: scale(1.08);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        }

        .menu-item > .menu-header .title {
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .sub-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.8s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.6s ease-in, transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            background: rgba(0, 0, 0, 0.15);
            transform: translateY(-8px);
        }

        .sub-menu.active {
            max-height: 200px;
            opacity: 1;
            transform: translateY(0);
            transition: max-height 1s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.8s ease-out, transform 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .sub-menu a {
            display: flex;
            align-items: center;
            padding: 14px 24px 14px 76px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: padding 0.3s cubic-bezier(0.4, 0, 0.2, 1), background 0.25s ease, color 0.25s ease, border-left-color 0.25s ease;
            position: relative;
            border-left: 3px solid transparent;
            opacity: 0.9;
        }

        .sub-menu a::before {
            content: '';
            position: absolute;
            left: 50px;
            top: 50%;
            transform: translateY(-50%) scale(0.8);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--text-muted);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0.6;
        }

        .sub-menu a:hover {
            background: rgba(59, 130, 246, 0.12);
            color: var(--text-primary);
            padding-left: 82px;
            border-left-color: var(--accent);
            opacity: 1;
        }

        .sub-menu a:hover::before {
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
            transform: translateY(-50%) scale(1.2);
            opacity: 1;
        }

        .sub-menu a.active {
            background: rgba(59, 130, 246, 0.15);
            color: var(--text-primary);
            border-left-color: var(--accent);
            font-weight: 600;
        }

        .sub-menu a.active::before {
            background: var(--accent);
            box-shadow: 0 0 12px var(--accent);
        }

        .sub-menu a .sub-icon {
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 14px;
            opacity: 0.75;
            color: rgba(255, 255, 255, 0.85);
            transition: opacity 0.25s ease;
        }

        .sub-menu a:hover .sub-icon,
        .sub-menu a.active .sub-icon {
            opacity: 1;
            color: #FFFFFF;
        }

        .content {
            margin-left: 230px;
            flex: 1;
            padding: 0;
            overflow-y: auto;
        }

        .content-header {
            padding: 20px 30px;
            margin-bottom: 0;
            border-bottom: 2px solid #e2e8f0;
            background: var(--card-bg);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-header h1 {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .content-header h1::before {
            content: '';
            width: 3px;
            height: 20px;
            background: #3b82f6;
            border-radius: 2px;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.2;
        }

        .user-role {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            border-radius: 10px;
            color: #dc2626;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.1);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        .btn-logout:active {
            transform: translateY(0);
        }

        .btn-logout i {
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .btn-logout:hover i {
            transform: translateX(-3px);
        }

        .content-body {
            background: var(--card-bg);
            padding: 0;
            border-radius: 0;
            box-shadow: none;
            border: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                z-index: 100;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="menu-item">
                <div class="menu-header" onclick="toggleMenu(this)">
                    <div class="menu-content">
                        <i class="icon fa-solid fa-users"></i>
                        <span class="title">成员管理</span>
                    </div>
                    <span class="arrow">›</span>
                </div>
                <div class="sub-menu">
                    <a href="{{ route('admin.member.index') }}" {{ request()->routeIs('admin.member.index') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-list"></i>
                        <span>成员列表</span>
                    </a>
                    <a href="{{ route('admin.member.create') }}" {{ request()->routeIs('admin.member.create') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-user-plus"></i>
                        <span>添加成员</span>
                    </a>
                </div>
            </div>

            <div class="menu-item">
                <div class="menu-header" onclick="toggleMenu(this)">
                    <div class="menu-content">
                        <i class="icon fa-solid fa-video"></i>
                        <span class="title">视频</span>
                    </div>
                    <span class="arrow">›</span>
                </div>
                <div class="sub-menu">
                    <a href="{{ route('admin.video.course') }}" {{ request()->routeIs('admin.video.course') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-book-open"></i>
                        <span>课程管理</span>
                    </a>
                    <a href="{{ route('admin.video.create') }}" {{ request()->routeIs('admin.video.create') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-plus-circle"></i>
                        <span>增加视频</span>
                    </a>
                    <a href="{{ route('admin.video.manage') }}" {{ request()->routeIs('admin.video.manage') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-film"></i>
                        <span>视频管理</span>
                    </a>
                </div>
            </div>

            <div class="menu-item">
                <div class="menu-header" onclick="toggleMenu(this)">
                    <div class="menu-content">
                        <i class="icon fa-solid fa-file-text"></i>
                        <span class="title">作业</span>
                    </div>
                    <span class="arrow">›</span>
                </div>
                <div class="sub-menu">
                    <a href="{{ route('admin.homework.preview') }}" {{ request()->routeIs('admin.homework.preview') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-eye"></i>
                        <span>作业预览</span>
                    </a>
                    <a href="{{ route('admin.homework.assign') }}" {{ request()->routeIs('admin.homework.assign') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-edit"></i>
                        <span>布置作业</span>
                    </a>
                    <a href="{{ route('admin.homework.member') }}" {{ request()->routeIs('admin.homework.member') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-users"></i>
                        <span>成员作业</span>
                    </a>
                </div>
            </div>

            <div class="menu-item">
                <div class="menu-header" onclick="toggleMenu(this)">
                    <div class="menu-content">
                        <i class="icon fa-solid fa-trophy"></i>
                        <span class="title">比赛</span>
                    </div>
                    <span class="arrow">›</span>
                </div>
                <div class="sub-menu">
                    <a href="{{ route('admin.competition.scenery') }}" {{ request()->routeIs('admin.competition.scenery') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-image"></i>
                        <span>添加荣誉墙</span>
                    </a>
                    <a href="{{ route('admin.competition.manage') }}" {{ request()->routeIs('admin.competition.manage') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-cogs"></i>
                        <span>管理荣誉墙</span>
                    </a>
                </div>
            </div>

            <div class="menu-item">
                <div class="menu-header" onclick="toggleMenu(this)">
                    <div class="menu-content">
                        <i class="icon fa-solid fa-sliders-h"></i>
                        <span class="title">系统设置</span>
                    </div>
                    <span class="arrow">›</span>
                </div>
                <div class="sub-menu">
                    <a href="{{ route('admin.settings.index') }}" {{ request()->routeIs('admin.settings.index') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-cog"></i>
                        <span>系统配置</span>
                    </a>
                </div>
            </div>

            <div class="menu-item">
                <div class="menu-header" onclick="toggleMenu(this)">
                    <div class="menu-content">
                        <i class="icon fa-solid fa-globe"></i>
                        <span class="title">外部</span>
                    </div>
                    <span class="arrow">›</span>
                </div>
                <div class="sub-menu">
                    <a href="{{ route('admin.external.course') }}" {{ request()->routeIs('admin.external.course') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-book-open"></i>
                        <span>外部课程</span>
                    </a>
                    <a href="{{ route('admin.external.manage') }}" {{ request()->routeIs('admin.external.manage') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-cogs"></i>
                        <span>外部管理</span>
                    </a>
                    <a href="{{ route('admin.external.create') }}" {{ request()->routeIs('admin.external.create') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-plus-circle"></i>
                        <span>添加外部</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-header">
                <h1>@yield('title')</h1>
                <div class="header-user">
                    <div class="user-info">
                        <div class="user-avatar">{{ mb_substr(session('admin_name', 'A'), 0, 1) }}</div>
                        <div class="user-details">
                            <span class="user-name">{{ session('admin_name', 'Admin') }}</span>
                            <span class="user-role">管理员</span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            退出登录
                        </button>
                    </form>
                </div>
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        function toggleMenu(el) {
            const arrow = el.querySelector('.arrow');
            const subMenu = el.parentElement.querySelector('.sub-menu');
            arrow.classList.toggle('expanded');
            subMenu.classList.toggle('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const activeLink = document.querySelector('.sub-menu a.active');
            if (activeLink) {
                const menuItem = activeLink.closest('.menu-item');
                const arrow = menuItem.querySelector('.arrow');
                const subMenu = menuItem.querySelector('.sub-menu');
                arrow.classList.add('expanded');
                subMenu.classList.add('active');
            }

            const themes = {
                original: { primary: '#374151', secondary: '#4B5563', accent: '#E5E7EB' },
                aurora: { primary: '#667eea', secondary: '#764ba2', accent: '#f093fb' },
                midnight: { primary: '#0f0c29', secondary: '#302b63', accent: '#24243e' },
                dawn: { primary: '#fa709a', secondary: '#fee140', accent: '#f09819' },
                galaxy: { primary: '#0c0c0c', secondary: '#1a1a2e', accent: '#16213e' },
                forest: { primary: '#134e5e', secondary: '#71b280', accent: '#a8e063' },
                ocean: { primary: '#11998e', secondary: '#38ef7d', accent: '#013220' }
            };

            const savedTheme = localStorage.getItem('selectedTheme') || 'original';
            const theme = themes[savedTheme];
            
            if (theme) {
                document.documentElement.style.setProperty('--primary', theme.primary);
                document.documentElement.style.setProperty('--primary-light', theme.secondary);
                document.documentElement.style.setProperty('--accent', theme.accent);
            }
        });
    </script>
</body>
</html>