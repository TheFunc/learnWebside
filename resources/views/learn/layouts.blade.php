<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>家校情怀 技能报国 - 学习平台</title>
    
    <!-- Vite Assets (Tailwind CSS & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- 引入 Font Awesome 图标库 -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    
    <!-- 引入 Google Fonts: Noto Sans SC（正文）+ Orbitron（科技感标题） -->
    <link rel="stylesheet" href="{{ asset('css/google-fonts.css') }}">
    
    <!-- 引入 Alpine.js 轻量级交互框架 -->
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>
    
    <style>
        /* ========== 全局变量 ========== */
        :root {
            --bg-primary: #f0f7ff;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --accent-cyan: #38bdf8;
            --accent-blue: #3b82f6;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -2px rgba(59, 130, 246, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(59, 130, 246, 0.1), 0 4px 6px -4px rgba(59, 130, 246, 0.1);
        }

        /* ========== 全局样式 ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans SC', sans-serif;
            background: linear-gradient(180deg, var(--bg-primary) 0%, #e8f4fd 50%, var(--bg-primary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ========== 柔和装饰圆 ========== */
        .particles-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.3;
            animation: particleFloat 12s ease-in-out infinite;
        }

        .particle:nth-child(1) { left: 5%; top: 10%; width: 120px; height: 120px; background: radial-gradient(circle, rgba(59,130,246,0.08), transparent); animation-delay: 0s; }
        .particle:nth-child(2) { left: 70%; top: 20%; width: 180px; height: 180px; background: radial-gradient(circle, rgba(56,189,248,0.06), transparent); animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; top: 60%; width: 150px; height: 150px; background: radial-gradient(circle, rgba(59,130,246,0.07), transparent); animation-delay: 4s; }
        .particle:nth-child(4) { left: 80%; top: 70%; width: 100px; height: 100px; background: radial-gradient(circle, rgba(96,165,250,0.08), transparent); animation-delay: 1s; }
        .particle:nth-child(5) { left: 50%; top: 40%; width: 200px; height: 200px; background: radial-gradient(circle, rgba(56,189,248,0.05), transparent); animation-delay: 3s; }

        @keyframes particleFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        /* ========== 渐变背景网格 ========== */
        .grid-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* ========== 顶部Header区域 ========== */
        .learn-header {
            position: relative;
            z-index: 50;
            background: linear-gradient(135deg, #ffffff 0%, var(--blue-50) 50%, #dbeafe 100%);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
        }

        /* 顶部装饰线 */
        .header-glow {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                var(--accent-blue) 30%, 
                var(--accent-cyan) 70%, 
                transparent 100%
            );
        }

        /* 汉堡菜单按钮 */
        .hamburger-btn {
            display: none;
            width: 40px;
            height: 40px;
            border: none;
            background: var(--bg-card);
            border-radius: 10px;
            cursor: pointer;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .hamburger-btn span {
            display: block;
            width: 20px;
            height: 2px;
            background: var(--text-primary);
            border-radius: 1px;
            transition: all 0.3s ease;
        }

        .hamburger-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger-btn.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        /* 移动端导航抽屉 */
        .mobile-nav-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-nav-overlay.active {
            display: block;
            opacity: 1;
        }

        .mobile-nav-drawer {
            position: fixed;
            top: 0;
            right: -280px;
            width: 280px;
            height: 100%;
            background: var(--bg-card);
            z-index: 1000;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .mobile-nav-drawer.active {
            right: 0;
        }

        .mobile-nav-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-nav-close {
            width: 32px;
            height: 32px;
            border: none;
            background: var(--blue-50);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            transition: all 0.2s;
        }

        .mobile-nav-close:hover {
            background: var(--blue-100);
            color: var(--blue-600);
        }

        .mobile-nav-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .mobile-nav-user .user-avatar {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .mobile-nav-list {
            padding: 12px;
        }

        .mobile-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .mobile-nav-item:hover {
            background: var(--blue-50);
            color: var(--blue-600);
        }

        .mobile-nav-item.active {
            background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
            color: var(--blue-600);
        }

        .mobile-nav-item i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .mobile-nav-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            margin-top: 8px;
        }

        .mobile-nav-footer form button,
        .mobile-nav-footer button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            border: none;
            background: none;
            color: var(--text-secondary);
            font-size: 0.95rem;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .mobile-nav-footer form button:hover,
        .mobile-nav-footer button:hover {
            background: var(--blue-50);
            color: var(--blue-600);
        }

        /* ========== Logo区域 ========== */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo-img {
            height: 72px;
            width: auto;
            filter: drop-shadow(0 2px 8px rgba(59, 130, 246, 0.15));
            transition: all 0.3s ease;
        }

        .logo-img:hover {
            filter: drop-shadow(0 4px 12px rgba(59, 130, 246, 0.25));
            transform: scale(1.05);
        }

        /* ========== 标语文字 - 蓝紫渐变 ========== */
        .slogan-text {
            font-family: 'Noto Sans SC', sans-serif;
            font-weight: 900;
            font-size: 2.25rem;
            letter-spacing: 0.15em;
            white-space: nowrap;
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
            text-shadow: none;
            position: relative;
        }

        /* 文字柔和发光效果 */
        .slogan-text::after {
            content: '家校情怀 技能报国';
            position: absolute;
            left: 0;
            top: 0;
            z-index: -1;
            background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: blur(12px);
            opacity: 0.3;
        }

        @keyframes gradientShift {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* ========== 导航栏 ========== */
        .nav-container {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .nav-item {
            position: relative;
            padding: 14px 28px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            letter-spacing: 0.05em;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-blue), var(--accent-cyan));
            transition: width 0.3s ease;
            border-radius: 1px;
        }

        .nav-item:hover {
            color: var(--blue-600);
            background: var(--blue-50);
        }

        .nav-item:hover::before {
            width: 60%;
        }

        .nav-item.active {
            color: var(--blue-600);
            background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
            box-shadow: var(--shadow-sm);
        }

        .nav-item.active::before {
            width: 60%;
        }

        .nav-item i {
            margin-right: 8px;
            font-size: 0.9rem;
        }

        /* ========== 用户区域 ========== */
        .user-dropdown {
            position: relative;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-trigger:hover {
            background: var(--blue-50);
            border-color: var(--blue-400);
            box-shadow: var(--shadow-md);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
        }

        .user-name {
            font-weight: 500;
            font-size: 1.05rem;
            color: var(--text-primary);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 160px;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            box-shadow: var(--shadow-lg);
            z-index: 100;
            pointer-events: auto;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: var(--blue-50);
            color: var(--blue-600);
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 4px 0;
        }

        /* ========== 修改密码模态框 ========== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .modal-card {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            width: 90%;
            max-width: 420px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            animation: modalIn 0.3s ease;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
        }
        .modal-close-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: #f1f5f9;
            border-radius: 50%;
            font-size: 16px;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .modal-close-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .modal-msg {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .modal-msg-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }
        .modal-msg-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        .modal-field {
            margin-bottom: 16px;
        }
        .modal-field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
        .modal-field label i {
            width: 14px;
            margin-right: 4px;
            color: #3b82f6;
        }
        .modal-field input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .modal-field input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }
        .modal-btn-cancel, .modal-btn-confirm {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .modal-btn-cancel {
            background: #f1f5f9;
            color: #475569;
        }
        .modal-btn-cancel:hover {
            background: #e2e8f0;
        }
        .modal-btn-confirm {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .modal-btn-confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        /* ========== 主内容区域 ========== */
        .main-content {
            position: relative;
            z-index: 10;
            min-height: calc(100vh - 100px);
            padding: 40px;
        }

        /* ========== 响应式适配 ========== */
        .header-inner {
            flex-wrap: nowrap !important;
        }

        .header-slogan-nav {
            white-space: nowrap;
            flex-shrink: 1;
            min-width: 0;
        }

        .header-inner > div:first-child {
            flex-shrink: 0;
        }

        @media (max-width: 1024px) {
            .header-inner {
                gap: 12px;
                padding: 16px 24px;
            }

            .slogan-text {
                font-size: 1.5rem;
            }

            .nav-item {
                padding: 10px 18px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 768px) {
            .header-inner {
                padding: 12px 16px;
                gap: 8px;
            }

            /* 隐藏桌面端导航 */
            .nav-container {
                display: none;
            }

            /* 隐藏桌面端用户下拉 */
            .user-dropdown {
                display: none;
            }

            /* 显示汉堡菜单 */
            .hamburger-btn {
                display: flex;
            }

            .logo-img {
                height: 44px;
            }

            .slogan-text {
                font-size: 1rem;
                white-space: nowrap;
                letter-spacing: 0.08em;
            }

            .main-content {
                padding: 16px;
            }

            /* 模态框移动端适配 */
            .modal-card {
                width: 95%;
                padding: 24px;
                max-width: 95%;
            }

            .modal-title {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .header-inner {
                padding: 10px 12px;
            }

            .logo-img {
                height: 36px;
            }

            .slogan-text {
                font-size: 1rem;
                white-space: nowrap;
            }

            .main-content {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- 柔和装饰背景 -->
    <div class="particles-bg">
        @for($i = 1; $i <= 5; $i++)
        <div class="particle"></div>
        @endfor
    </div>
    
    <!-- 网格背景 -->
    <div class="grid-bg"></div>

    <!-- 顶部Header -->
    <header class="learn-header">
        <div class="header-glow"></div>
        <div class="header-inner w-full px-12 py-5 flex items-center justify-between flex-nowrap">
            <!-- 最左侧：Logo -->
            <div>
                <img src="{{ asset('images/jmjx-logo.png') }}" alt="Logo" class="logo-img">
            </div>

            <!-- 中间：标语 + 导航栏 -->
            <div class="flex items-center gap-8 header-slogan-nav">
                <span class="slogan-text">家校情怀 技能报国</span>
                <nav class="nav-container">
                    <a href="{{ route('learn.index') }}" 
                       class="nav-item {{ request()->routeIs('learn.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>首页
                    </a>
                    <a href="{{ route('learn.courses') }}" 
                       class="nav-item {{ request()->routeIs('learn.courses') ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap"></i>课程学习
                    </a>
                    <a href="{{ route('learn.external') }}" 
                       class="nav-item {{ request()->routeIs('learn.external') ? 'active' : '' }}">
                        <i class="fa-solid fa-link"></i>外部学习
                    </a>
                    <a href="{{ route('learn.homework') }}" 
                       class="nav-item {{ request()->routeIs('learn.homework') ? 'active' : '' }}">
                        <i class="fa-solid fa-book-open"></i>作业
                    </a>
                    <a href="{{ route('learn.navigation') }}" 
                       class="nav-item {{ request()->routeIs('learn.navigation') ? 'active' : '' }}">
                        <i class="fa-solid fa-compass"></i>网站导航
                    </a>
                </nav>
            </div>

            <!-- 最右侧：用户下拉菜单 + 汉堡菜单 -->
            <div class="user-dropdown" id="userDropdown">
                <div class="user-trigger" id="userTrigger">
                    <div class="user-avatar">{{ mb_substr(session('learn_user_name', 'U'), 0, 1) }}</div>
                    <span class="user-name">{{ session('learn_user_name', '用户') }}</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-300" id="dropdownArrow"></i>
                </div>

                <!-- 下拉菜单 -->
                <div class="dropdown-menu" id="dropdownMenu" style="display: none;">
                    <button type="button" onclick="openChangePasswordModal()" class="dropdown-item">
                        <i class="fa-solid fa-key"></i>
                        <span>修改密码</span>
                    </button>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('learn.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item w-full text-left">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>退出登录</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- 汉堡菜单按钮（移动端） -->
            <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleMobileNav()">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- 移动端导航抽屉 -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="closeMobileNav()"></div>
    <div class="mobile-nav-drawer" id="mobileNavDrawer">
        <div class="mobile-nav-header">
            <span style="font-weight: 700; font-size: 1.1rem; color: var(--text-primary);">菜单</span>
            <button class="mobile-nav-close" onclick="closeMobileNav()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- 用户信息 -->
        <div class="mobile-nav-user">
            <div class="user-avatar">{{ mb_substr(session('learn_user_name', 'U'), 0, 1) }}</div>
            <span style="font-weight: 500; font-size: 0.95rem;">{{ session('learn_user_name', '用户') }}</span>
        </div>

        <!-- 导航列表 -->
        <div class="mobile-nav-list">
            <a href="{{ route('learn.index') }}" 
               class="mobile-nav-item {{ request()->routeIs('learn.index') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>首页</span>
            </a>
            <a href="{{ route('learn.courses') }}" 
               class="mobile-nav-item {{ request()->routeIs('learn.courses') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>课程学习</span>
            </a>
            <a href="{{ route('learn.external') }}" 
               class="mobile-nav-item {{ request()->routeIs('learn.external') ? 'active' : '' }}">
                <i class="fa-solid fa-link"></i>
                <span>外部学习</span>
            </a>
            <a href="{{ route('learn.homework') }}" 
               class="mobile-nav-item {{ request()->routeIs('learn.homework') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open"></i>
                <span>作业</span>
            </a>
            <a href="{{ route('learn.navigation') }}" 
               class="mobile-nav-item {{ request()->routeIs('learn.navigation') ? 'active' : '' }}">
                <i class="fa-solid fa-compass"></i>
                <span>网站导航</span>
            </a>
        </div>

        <!-- 底部操作 -->
        <div class="mobile-nav-footer">
            <button type="button" onclick="closeMobileNav(); openChangePasswordModal();">
                <i class="fa-solid fa-key"></i>
                <span>修改密码</span>
            </button>
            <form action="{{ route('learn.logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>退出登录</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 主内容区域 -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- 全局弹窗容器（body 直接子元素，避免 transform 影响 fixed 定位） -->
    @yield('modal')

    <!-- 修改密码模态框 -->
    <div id="changePasswordModal" class="modal-overlay" style="display: none;">
        <div class="modal-card">
            <div class="modal-header-row">
                <h3 class="modal-title"><i class="fa-solid fa-key"></i> 修改密码</h3>
                <button onclick="closeChangePasswordModal()" class="modal-close-btn"><i class="fa-solid fa-xmark"></i></button>
            </div>

            @if(session('pwd_success'))
            <div class="modal-msg modal-msg-success"><i class="fa-solid fa-check-circle"></i> {{ session('pwd_success') }}</div>
            @endif
            @if(session('pwd_error'))
            <div class="modal-msg modal-msg-error"><i class="fa-solid fa-exclamation-circle"></i> {{ session('pwd_error') }}</div>
            @endif
            @if($errors->any())
            <div class="modal-msg modal-msg-error"><i class="fa-solid fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <form action="{{ route('learn.change-password.post') }}" method="POST" id="changePwdForm">
                @csrf
                <div class="modal-field">
                    <label><i class="fa-solid fa-lock"></i> 旧密码</label>
                    <input type="password" name="old_password" required placeholder="请输入旧密码">
                </div>
                <div class="modal-field">
                    <label><i class="fa-solid fa-key"></i> 新密码</label>
                    <input type="password" name="new_password" required minlength="6" placeholder="至少6位">
                </div>
                <div class="modal-field">
                    <label><i class="fa-solid fa-shield-halved"></i> 确认新密码</label>
                    <input type="password" name="new_password_confirmation" required minlength="6" placeholder="再次输入新密码">
                </div>
                <div class="modal-actions">
                    <button type="button" onclick="closeChangePasswordModal()" class="modal-btn-cancel">取消</button>
                    <button type="submit" class="modal-btn-confirm">确认修改</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 页面加载动画 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 主内容淡入效果
            const mainContent = document.querySelector('.main-content');
            if (mainContent) {
                mainContent.style.opacity = '0';
                mainContent.style.transform = 'translateY(20px)';
                mainContent.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                
                setTimeout(() => {
                    mainContent.style.opacity = '1';
                    mainContent.style.transform = 'translateY(0)';
                }, 100);
            }

            // 用户下拉菜单
            const userTrigger = document.getElementById('userTrigger');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownArrow = document.getElementById('dropdownArrow');
            const userDropdown = document.getElementById('userDropdown');

            if (userTrigger && dropdownMenu && dropdownArrow) {
                userTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = dropdownMenu.style.display === 'block';
                    dropdownMenu.style.display = isOpen ? 'none' : 'block';
                    dropdownArrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
                });

                // 点击外部关闭
                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target)) {
                        dropdownMenu.style.display = 'none';
                        dropdownArrow.style.transform = 'rotate(0deg)';
                    }
                });
            }

            // 如果有 session 提示或验证错误，自动打开修改密码弹窗
            @if(session('pwd_success') || session('pwd_error') || $errors->any())
            openChangePasswordModal();
            @endif
        });

        function openChangePasswordModal() {
            document.getElementById('changePasswordModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeChangePasswordModal() {
            document.getElementById('changePasswordModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        // 点击遮罩关闭
        document.getElementById('changePasswordModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeChangePasswordModal();
        });

        // 移动端导航
        function toggleMobileNav() {
            const overlay = document.getElementById('mobileNavOverlay');
            const drawer = document.getElementById('mobileNavDrawer');
            const btn = document.getElementById('hamburgerBtn');
            overlay.classList.add('active');
            drawer.classList.add('active');
            btn.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileNav() {
            const overlay = document.getElementById('mobileNavOverlay');
            const drawer = document.getElementById('mobileNavDrawer');
            const btn = document.getElementById('hamburgerBtn');
            overlay.classList.remove('active');
            drawer.classList.remove('active');
            btn.classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>
</body>
</html>
