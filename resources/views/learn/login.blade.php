<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录 - 家校情怀 技能报国</title>
    
    <!-- 引入 Font Awesome 图标库 -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    
    <!-- 引入 Google Fonts -->
    <link rel="stylesheet" href="{{ asset('css/google-fonts.css') }}">
    
    <style>
        /* ========== 全局变量 ========== */
        :root {
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-300: #93c5fd;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-800: #1e40af;
            --blue-900: #1e3a8a;
            --cyan-400: #38bdf8;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(59, 130, 246, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -2px rgba(59, 130, 246, 0.1);
            --shadow-lg: 0 10px 25px -3px rgba(59, 130, 246, 0.15), 0 4px 6px -4px rgba(59, 130, 246, 0.1);
            --shadow-xl: 0 20px 40px -5px rgba(59, 130, 246, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans SC', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, var(--blue-50) 0%, #e8f4fd 50%, var(--blue-100) 100%);
            overflow: hidden;
            position: relative;
        }

        /* ========== 背景装饰 ========== */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            animation: float 12s ease-in-out infinite;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            top: -80px;
            right: -60px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08), transparent 70%);
            animation-delay: 0s;
        }

        .circle-2 {
            width: 250px;
            height: 250px;
            bottom: -50px;
            left: -40px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.06), transparent 70%);
            animation-delay: 2s;
        }

        .circle-3 {
            width: 180px;
            height: 180px;
            top: 40%;
            left: 10%;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.07), transparent 70%);
            animation-delay: 4s;
        }

        .circle-4 {
            width: 220px;
            height: 220px;
            top: 20%;
            right: 15%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.05), transparent 70%);
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.03); }
        }

        /* 网格背景 */
        .grid-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
        }

        /* ========== 登录容器 ========== */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 20px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            border: 1px solid rgba(59, 130, 246, 0.1);
        }

        /* ========== 登录头部 ========== */
        .login-header {
            background: linear-gradient(135deg, var(--blue-600) 0%, var(--blue-500) 50%, var(--cyan-400) 100%);
            padding: 48px 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
            animation: headerPulse 15s ease-in-out infinite;
        }

        @keyframes headerPulse {
            0%, 100% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.1); opacity: 0.2; }
        }

        .login-logo {
            width: 72px;
            height: 72px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        .login-logo i {
            font-size: 32px;
            color: var(--white);
        }

        .login-header h1 {
            color: var(--white);
            font-size: 26px;
            font-weight: 700;
            position: relative;
            z-index: 1;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
        }

        .login-header .subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            position: relative;
            z-index: 1;
            font-weight: 300;
        }

        /* ========== 登录表单 ========== */
        .login-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
            letter-spacing: 0.05em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
            transition: color 0.3s ease;
            z-index: 1;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid var(--blue-200);
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Noto Sans SC', sans-serif;
            transition: all 0.3s ease;
            background: var(--blue-50);
            color: var(--text-primary);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--blue-500);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-input:focus + i,
        .input-wrapper:hover i {
            color: var(--blue-500);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        /* ========== 记住登录 ========== */
        .remember-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-wrapper input[type="checkbox"] {
            display: none;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid var(--blue-300);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            background: var(--white);
        }

        .custom-checkbox i {
            color: var(--white);
            font-size: 11px;
            opacity: 0;
            transform: scale(0);
            transition: all 0.2s ease;
        }

        .checkbox-wrapper:hover .custom-checkbox {
            border-color: var(--blue-500);
        }

        .checkbox-wrapper input[type="checkbox"]:checked + .custom-checkbox {
            background: var(--blue-500);
            border-color: var(--blue-500);
        }

        .checkbox-wrapper input[type="checkbox"]:checked + .custom-checkbox i {
            opacity: 1;
            transform: scale(1);
        }

        .remember-text {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .hint-text {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ========== 登录按钮 ========== */
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--blue-600) 0%, var(--blue-500) 100%);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Noto Sans SC', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.1em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: var(--shadow-md);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: linear-gradient(135deg, var(--blue-700) 0%, var(--blue-600) 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ========== 错误提示 ========== */
        .error-message {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        .error-message i {
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ========== 登录底部 ========== */
        .login-footer {
            text-align: center;
            padding: 20px 40px 28px;
            background: linear-gradient(180deg, var(--white), var(--blue-50));
            border-top: 1px solid var(--blue-100);
        }

        .login-footer p {
            color: var(--text-secondary);
            font-size: 13px;
        }

        /* ========== 响应式 ========== */
        @media (max-width: 480px) {
            .login-wrapper {
                padding: 16px;
            }

            .login-header {
                padding: 36px 24px 32px;
            }

            .login-body {
                padding: 32px 24px;
            }

            .login-footer {
                padding: 16px 24px 24px;
            }

            .login-header h1 {
                font-size: 22px;
            }
        }

        @media (max-width: 360px) {
            .login-header {
                padding: 28px 20px 24px;
            }

            .login-body {
                padding: 24px 20px;
            }

            .login-footer {
                padding: 12px 20px 20px;
            }

            .login-logo {
                width: 56px;
                height: 56px;
                margin-bottom: 16px;
            }

            .login-logo i {
                font-size: 24px;
            }

            .login-header h1 {
                font-size: 20px;
            }

            .form-input {
                padding: 12px 14px 12px 42px;
                font-size: 14px;
            }

            .btn-login {
                padding: 14px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- 背景装饰 -->
    <div class="bg-decoration">
        <div class="floating-circle circle-1"></div>
        <div class="floating-circle circle-2"></div>
        <div class="floating-circle circle-3"></div>
        <div class="floating-circle circle-4"></div>
    </div>
    
    <!-- 网格背景 -->
    <div class="grid-bg"></div>
    
    <div class="login-wrapper">
        <div class="login-card">
            <!-- 登录头部 -->
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>网站技术学习平台</h1>
                <p class="subtitle">家校情怀 技能报国</p>
            </div>
            
            <!-- 登录表单 -->
            <div class="login-body">
                @if ($errors->any())
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first('error') }}</span>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('learn.login.post') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">用户名</label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                name="name" 
                                class="form-input" 
                                placeholder="请输入用户名"
                                value="{{ old('name') }}"
                                required
                                autofocus
                            >
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">密码</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                class="form-input" 
                                placeholder="请输入密码"
                                required
                            >
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>

                    <div class="remember-group">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="remember" value="1">
                            <span class="custom-checkbox">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="remember-text">记住登录状态</span>
                        </label>
                        <span class="hint-text">7天内免登录</span>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        登 录
                    </button>
                </form>
            </div>
            
            <!-- 登录底部 -->
            <div class="login-footer">
                <p>欢迎使用学习平台</p>
            </div>
        </div>
    </div>
</body>
</html>
