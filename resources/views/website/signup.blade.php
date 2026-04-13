<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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
}
        .login-modal { width:420px; background:#fff; border-radius:20px; border:3px solid #004271; padding:35px; position:relative; }
        .close-btn { position:absolute; top:15px; right:20px; font-size:28px; cursor:pointer; }
        h2 { text-align:center; color:#004271; font-family:'Libre Baskerville', serif; }
        .login-input { width:100%; height:45px; border-radius:10px; border:1.5px solid #ccc; padding:0 14px; margin-bottom:15px; }
        .continue-btn { width:100%; height:48px; background:#004271; color:#fff; border:none; border-radius:12px; font-size:16px; cursor:pointer; }
        .signup-text { text-align:center; margin-top:10px; }
        .signup-text a { color:#004271; font-weight:700; text-decoration:none; }
        .row { display:flex; gap:10px; }
    </style>
</head>
<body>

<div class="login-modal">
    <div class="close-btn" onclick="goHome()">&times;</div>
    <h2>Sign Up</h2>

    <form action="#" method="POST">
        @csrf

        <div class="row">
            <input type="text" name="first_name" class="login-input" placeholder="First Name" required>
            <input type="text" name="last_name" class="login-input" placeholder="Last Name" required>
        </div>

        <input type="email" name="email" class="login-input" placeholder="Email" required>
        <input type="text" name="phone" class="login-input" placeholder="Phone Number" required>

        <button class="continue-btn">Sign Up</button>
    </form>

    <div class="signup-text">
        Already have an account?
        <a href="{{ url('/login') }}">Login here</a>
    </div>
</div>

<script>
    function goHome() {
        window.location.href = "{{ url('/') }}";
    }
</script>

</body>
</html>