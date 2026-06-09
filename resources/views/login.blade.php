<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录</title>
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
            --success: #10B981;
            --danger: #EF4444;
            --text-primary: #F9FAFB;
            --text-secondary: #D1D5DB;
            --text-dark: #1F2937;
            --card-bg: #FFFFFF;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
            background: linear-gradient(135deg, #1F2937 0%, #111827 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 40px 30px;
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
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.3; }
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.2);
        }

        .login-icon i {
            font-size: 36px;
            color: var(--text-primary);
        }

        .login-header h1 {
            color: var(--text-primary);
            font-size: 24px;
            font-weight: 600;
            position: relative;
            z-index: 1;
            letter-spacing: 2px;
        }

        .login-header p {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
            margin-top: 8px;
            position: relative;
            z-index: 1;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            padding: 14px 14px 14px 48px;
            border: 2px solid #E5E7EB;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #F9FAFB;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(55, 65, 81, 0.1);
        }

        .form-input:focus + i,
        .input-wrapper:hover i {
            color: var(--primary);
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--text-primary);
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(55, 65, 81, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-message {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #DC2626;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-message i {
            font-size: 18px;
        }

        .login-footer {
            text-align: center;
            padding: 20px 30px;
            background: #F9FAFB;
            border-top: 1px solid #E5E7EB;
        }

        .login-footer p {
            color: #6B7280;
            font-size: 13px;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .decorative-circle {
            position: fixed;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(55, 65, 81, 0.1) 0%, rgba(55, 65, 81, 0.05) 100%);
            pointer-events: none;
        }

        .circle-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
        }

        .circle-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            left: -50px;
        }

        .remember-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .checkbox-wrapper input[type="checkbox"] {
            display: none;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #D1D5DB;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            background: #F9FAFB;
        }

        .custom-checkbox i {
            color: white;
            font-size: 12px;
            opacity: 0;
            transform: scale(0);
            transition: all 0.2s ease;
        }

        .checkbox-wrapper:hover .custom-checkbox {
            border-color: var(--primary);
        }

        .checkbox-wrapper input[type="checkbox"]:checked + .custom-checkbox {
            background: var(--primary);
            border-color: var(--primary);
        }

        .checkbox-wrapper input[type="checkbox"]:checked + .custom-checkbox i {
            opacity: 1;
            transform: scale(1);
        }

        .remember-text {
            font-size: 14px;
            color: #6B7280;
            user-select: none;
        }

        .hint-text {
            font-size: 12px;
            color: #9CA3AF;
        }
    </style>
</head>
<body>
    <div class="decorative-circle circle-1"></div>
    <div class="decorative-circle circle-2"></div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h1>管理员登录</h1>
                <p>后台管理系统</p>
            </div>
            
            <div class="login-body">
                @if ($errors->any())
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first('error') }}</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
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
                            <span class="remember-text">长期登录</span>
                        </label>
                        <span class="hint-text">7天内无需重复登录</span>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        登 录
                    </button>
                </form>
            </div>
            
            <div class="login-footer">
                <p>请使用管理员账号登录</p>
            </div>
        </div>
    </div>
</body>
</html>
