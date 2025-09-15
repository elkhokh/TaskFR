<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Log in') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .form-card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .form-card h2 {
            margin-bottom: 28px;
            color: #2c3e50;
            font-weight: 600;
        }

        .input-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #7f8c8d;
            font-weight: 600;
        }

        .input-group input {
            width: 100%;
            padding: 14px;
            border: 1px solid #dfe6e9;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        .login-button {
            width: 100%;
            padding: 16px;
            background-color: #3498db;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #2980b9;
        }

        .social-login {
            margin-top: 24px;
        }
        
        .social-login p {
            color: #7f8c8d;
            margin-bottom: 16px;
            font-weight: 500;
            position: relative;
        }

        .social-login p::before,
        .social-login p::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 35%;
            height: 1px;
            background-color: #dfe6e9;
        }

        .social-login p::before {
            left: 0;
        }

        .social-login p::after {
            right: 0;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 15px; /* المسافة بين الأزرار */
        }

        .social-button {
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background-color 0.3s, color 0.3s;
            width: 100%;
        }

        .social-button.google {
            background-color: #e74c3c;
            color: #ffffff;
            border: none;
        }

        .social-button.google:hover {
            background-color: #c0392b;
        }
        
        .social-button.facebook {
            background-color: #3b5998;
            color: #ffffff;
            border: none;
        }

        .social-button.facebook:hover {
            background-color: #2d4373;
        }
        
        .social-button i {
            font-size: 20px;
        }

        .remember-me {
            text-align: left;
            margin-bottom: 20px;
            color: #7f8c8d;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border: 1px solid #dfe6e9;
            border-radius: 4px;
            background-color: #ffffff;
            cursor: pointer;
            position: relative;
        }

        .remember-me input[type="checkbox"]:checked {
            background-color: #3498db;
            border-color: #3498db;
        }

        .remember-me input[type="checkbox"]:checked::after {
            content: '\2713';
            font-size: 14px;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        .remember-me label {
            font-weight: 500;
        }

        .forgot-password {
            margin-top: 15px;
            text-align: center;
        }
        
        .forgot-password a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h2>{{ __('Log in') }}</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="input-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">{{ __('Remember me') }}</label>
                </div>
                <button type="submit" class="login-button">{{ __('Log in') }}</button>
            </form>
            <div class="social-login">
    <p><span>{{ __('Or') }}</span></p>
    <div class="social-buttons">
        <a href="{{ route('auth.provider.redirect','google') }}" class="social-button google">
            <i class="fab fa-google"></i> Google
        </a>
        <a href="{{ route('auth.provider.redirect','facebook') }}" class="social-button facebook">
            <i class="fab fa-facebook-f"></i> Facebook
        </a>
    </div>
</div>

            @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>