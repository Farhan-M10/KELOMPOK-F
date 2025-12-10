<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cherry Pet Clinic - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #0066B3 0%, #003D7A 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(ellipse at center, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
            padding: 0;
            overflow: hidden;
            position: relative;
        }

        .header-section {
            background: linear-gradient(135deg, #0066B3 0%, #003D7A 100%);
            padding: 35px 30px 30px;
            text-align: center;
            position: relative;
        }

        .logo {
            width: 75px;
            height: 75px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.15));
        }

        .header-section h1 {
            font-size: 24px;
            color: white;
            font-weight: 600;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-section p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 400;
        }

        .form-section {
            padding: 35px 30px;
            background: white;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 25px;
        }

        .welcome-text h2 {
            font-size: 17px;
            color: #1A1A1A;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .welcome-text p {
            font-size: 12px;
            color: #757575;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            color: #424242;
            margin-bottom: 7px;
            font-weight: 500;
        }

        label span {
            color: #E31E24;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 45px 12px 14px;
            border: 1px solid #D0D0D0;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.3s;
            background: white;
            color: #424242;
        }

        /* Hapus icon bawaan browser untuk password */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        input[type="password"]::-webkit-credentials-auto-fill-button,
        input[type="password"]::-webkit-contacts-auto-fill-button {
            visibility: hidden;
            pointer-events: none;
            position: absolute;
            right: 0;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #0066B3;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 102, 179, 0.08);
        }

        input::placeholder {
            color: #BDBDBD;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #BDBDBD;
            width: 20px;
            height: 20px;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #757575;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            stroke-width: 2;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 12px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #0066B3;
        }

        .remember-me label {
            margin: 0;
            cursor: pointer;
            font-weight: 400;
            color: #616161;
            font-size: 12px;
        }

        .forgot-password {
            color: #0066B3;
            text-decoration: none;
            font-weight: 500;
            font-size: 12px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background: #E31E24;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 14px rgba(227, 30, 36, 0.3);
        }

        .login-button:hover {
            background: #FF4444;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(227, 30, 36, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .header-section {
                padding: 30px 25px 25px;
            }
            
            .form-section {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="header-section">
            <div class="logo">
                <img src="{{ asset('asset/logo.png') }}" alt="Cherry Pet Clinic Logo">
            </div>
            <h1>Cherry Pet Clinic</h1>
            <p>UGD 24 jam - Arcawinangun Purwokerto</p>
        </div>

        <div class="form-section">
            <div class="welcome-text">
                <h2>Selamat Datang Kembali!</h2>
                <p>Masuk ke sistem untuk mengelola dashboard</p>
            </div>

            <form action="{{ route('login.submit') }}" method="POST">
                <div class="form-group">
                    <label for="email">Email<span>*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Admin@cherrypetclinic.com" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi<span>*</span></label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••" 
                            required
                        >
                        <span class="toggle-password" onclick="togglePassword()">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <a href="#" class="forgot-password">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="login-button">Masuk ke Dashboard</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Eye slash icon (mata dicoret)
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                // Eye icon (mata normal)
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</body>
</html>