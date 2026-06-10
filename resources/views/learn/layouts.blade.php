<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>家校情怀 技能报国 - 学习平台</title>
    
    <!-- 引入 Tailwind CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-BHPn_HJv.css') }}">
    
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

        /* ========== 主内容区域 ========== */
        .main-content {
            position: relative;
            z-index: 10;
            min-height: calc(100vh - 100px);
            padding: 40px;
        }

        /* ========== 响应式适配 ========== */
        @media (max-width: 1024px) {
            .header-inner {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }
            
            .nav-container {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .slogan-text {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 640px) {
            .main-content {
                padding: 20px;
            }
            
            .nav-item {
                padding: 10px 16px;
                font-size: 0.85rem;
            }
            
            .slogan-text {
                font-size: 1rem;
            }
            
            .logo-img {
                height: 40px;
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
        <div class="header-inner w-full px-12 py-5 flex items-center justify-between">
            <!-- 最左侧：Logo -->
            <div>
                <img src="{{ asset('images/jmjx-logo.png') }}" alt="Logo" class="logo-img">
            </div>

            <!-- 中间：标语 + 导航栏 -->
            <div class="flex items-center gap-8">
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

            <!-- 最右侧：用户下拉菜单 -->
            <div class="user-dropdown" id="userDropdown">
                <div class="user-trigger" id="userTrigger">
                    <div class="user-avatar">{{ mb_substr(session('learn_user_name', 'U'), 0, 1) }}</div>
                    <span class="user-name">{{ session('learn_user_name', '用户') }}</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-300" id="dropdownArrow"></i>
                </div>

                <!-- 下拉菜单 -->
                <div class="dropdown-menu" id="dropdownMenu" style="display: none;">
                    <a href="{{ route('learn.change-password') }}" class="dropdown-item">
                        <i class="fa-solid fa-key"></i>
                        <span>修改密码</span>
                    </a>
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
        </div>
    </header>

    <!-- 主内容区域 -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- 全局弹窗容器（body 直接子元素，避免 transform 影响 fixed 定位） -->
    @yield('modal')

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
        });
    </script>
</body>
</html>
