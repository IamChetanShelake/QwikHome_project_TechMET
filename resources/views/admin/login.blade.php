<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QwikHome - Admin Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-image {
            height: 60px;
            width: auto;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .logo-image:hover {
            filter: sepia(1) saturate(5) hue-rotate(180deg) brightness(1.2); /* Adds cyan tint on hover */
        }

        .logo p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #ffffff;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
        }

        .form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 15px 15px 15px 45px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.7);
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #00d4ff;
        }

        .forgot-password {
            color: #00d4ff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #0099cc;
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border: none;
            color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .role-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .role-option {
            flex: 1;
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }

        .role-option.active {
            background: rgba(0, 212, 255, 0.2);
            border-color: #00d4ff;
            color: #ffffff;
        }

        .role-option:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .footer-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            margin-top: 20px;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                padding: 30px 25px;
            }
            
            .logo h1 {
                font-size: 24px;
            }
            
            .role-selector {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="{{ asset('images/qwikhome-logo-white.svg') }}" alt="QwikHome" class="logo-image">
            <p>Admin Panel Access</p>
        </div>

        <form id="loginForm">
            <div class="role-selector">
                <div class="role-option active" data-role="admin">
                    <i class="fas fa-user-shield"></i>
                    <div>Super Admin</div>
                </div>
                <div class="role-option" data-role="sub-admin">
                    <i class="fas fa-user-cog"></i>
                    <div>Sub Admin</div>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" class="form-input" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" class="form-input" placeholder="Enter your password" required>
                </div>
            </div>

            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" id="remember">
                    Remember me
                </label>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i>
                Sign In to Dashboard
            </button>
        </form>

        <div class="footer-text">
            © 2024 QwikHome. All rights reserved.
        </div>
    </div>

    <script>
        // Role selector functionality
        document.querySelectorAll('.role-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.role-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple demo login - in real app, this would be server-side validation
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (email && password) {
                // Show loading state
                const btn = document.querySelector('.login-btn');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
                btn.disabled = true;
                
                // Simulate login delay
                setTimeout(() => {
                    window.location.href = '/admin';
                }, 1500);
            }
        });

        // Demo credentials hint
        setTimeout(() => {
            if (!document.getElementById('email').value) {
                document.getElementById('email').placeholder = 'Demo: admin@qwikhome.com';
                document.getElementById('password').placeholder = 'Demo: admin123';
            }
        }, 3000);
    </script>
</body>
</html>
