<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>后台管理系统</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: var(--accent-light);
            border-radius: 10px;
            font-size: 16px;
            color: var(--accent);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
        }

        .menu-item > .menu-header:hover .icon {
            background: rgba(255, 255, 255, 0.2);
            color: #FFFFFF;
            transform: scale(1.08);
            box-shadow: 0 0 12px rgba(255, 255, 255, 0.2);
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
            opacity: 0.7;
            transition: opacity 0.25s ease;
        }

        .sub-menu a:hover .sub-icon,
        .sub-menu a.active .sub-icon {
            opacity: 1;
            color: var(--accent);
        }

        .content {
            margin-left: 230px;
            flex: 1;
            padding: 30px 0;
            overflow-y: auto;
        }

        .content-header {
            padding: 0 0 20px 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
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

        .content-body {
            background: var(--card-bg);
            padding: 30px 0;
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
                    <a href="{{ route('admin.video.manage') }}" {{ request()->routeIs('admin.video.manage') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-film"></i>
                        <span>视频管理</span>
                    </a>
                    <a href="{{ route('admin.video.create') }}" {{ request()->routeIs('admin.video.create') ? 'class=active' : '' }}>
                        <i class="sub-icon fa-solid fa-plus-circle"></i>
                        <span>增加视频</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-header">
                <h1>@yield('title')</h1>
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
        });
    </script>
</body>
</html>