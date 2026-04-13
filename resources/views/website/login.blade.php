<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    margin: 0;
    height: 100vh;
    background: url('img/bg.png') center / cover no-repeat fixed;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', sans-serif;
    position: relative;
    overflow: hidden;
}

/* Light color overlay (Figma color) */
body::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(213, 213, 213, 0.54); /* #D5D5D58A */
    backdrop-filter: blur(3px); /* VERY light blur */
    z-index: 0;
}

/* Your login box or content */
.login-modal {
    position: relative;
    z-index: 1;
}        .login-modal { width:420px; background:#fff; border-radius:20px; border:3px solid #004271; padding:40px; position:relative; }
        .close-btn { position:absolute; top:15px; right:20px; font-size:28px; cursor:pointer; }
        h2 { text-align:center; color:#004271; font-family:'Libre Baskerville', serif; }
        .login-input { width:100%; height:50px; border-radius:12px; border:1.5px solid #ccc; padding:0 16px; margin-bottom:20px; }
        .continue-btn { width:100%; height:50px; background:#004271; color:#fff; border:none; border-radius:12px; font-size:18px; cursor:pointer; }
        .signup-text { text-align:center; margin-top:15px; }
        .signup-text a { color:#004271; font-weight:700; text-decoration:none; }
        /* icon label styling */
        .input-label { display:flex; align-items:center; gap:12px; margin-bottom:12px; }
        .phone-icon { width:40px; height:40px; background:#004271; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .phone-icon svg { width:20px; height:20px; fill:white; }
        .label-text { font-size:16px; font-weight:600; color:#333; }
    </style>
</head>
<body>

<div class="login-modal">
    <div class="close-btn" onclick="goHome()">&times;</div>
    <h2>Login</h2>

    <form action="{{ route('verification') }}" method="GET">
        <div class="input-label">
            <div class="phone-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                </svg>
            </div>
            <span class="label-text">Enter your Phone Number</span>
        </div>
        <input type="text" name="phone" class="login-input" placeholder="Enter Phone Number" required>
        <button class="continue-btn">Continue</button>
    </form>

    <div class="signup-text">
        Don’t have an account?
        <a href="{{ route('signup.page') }}">Sign up here</a>
    </div>
</div>

<script>
    function goHome() {
        window.location.href = "{{ url('/') }}";
    }
</script>

</body>
</html>