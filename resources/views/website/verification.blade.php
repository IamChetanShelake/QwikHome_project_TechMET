<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

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


        .verification-box {
            width: 380px;
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            border: 3px solid #004271;
        }

        .verification-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #004271;
            font-size: 32px;
            font-weight: 700;
        }

        .close-btn {
            position: absolute;
            right: 18px;
            top: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #003b6f;
        }

        .info {
            text-align: center;
            color: #555;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .info strong {
            display: block;
            font-size: 16px;
            color: #000;
            margin-bottom: 4px;
        }

        /* icon container */
        .msg-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #004271;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .msg-icon img {
            width: 20px;
            height: 20px;
            filter: invert(100%);
            filter: brightness(0) invert(1);
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .otp-inputs input {
            width: 52px;
            height: 60px;
            text-align: center;
            font-size: 20px;
            border-radius: 14px;
            border: 2px solid #004271;
            outline: none;
            transition: 0.3s;
        }

        .otp-inputs input:focus {
            border-color: #003b6f;
        }

        .timer {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: #004271;
            margin-bottom: 20px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #004271;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #002c54;
        }
    </style>
</head>
<body>

<div class="verification-box">
    <div class="close-btn" onclick="goHome()">&times;</div>
    <!-- <div class="close-btn">&times;</div> -->
        <h2>Login</h2>

    <div class="info">
        <div style="display:flex; align-items:center; justify-content:center; gap:8px;">
            <div class="msg-icon">
                <img src="img/msg.png" alt="msg">
            </div>
            <strong>Enter Verification Code</strong>
        </div>
        <div style="margin-top:6px;">We’ve sent a 6-digit code to your number</div>
    </div>

    <form action="{{ route('verification') }}" method="POST">
        @csrf

        <div class="otp-inputs">
            <input type="text" maxlength="1" name="code[]" required>
            <input type="text" maxlength="1" name="code[]" required>
            <input type="text" maxlength="1" name="code[]" required>
            <input type="text" maxlength="1" name="code[]" required>
            <input type="text" maxlength="1" name="code[]" required>
            <input type="text" maxlength="1" name="code[]" required>
        </div>

        <div class="timer">
            ⏱ <span id="countdown">00:30</span>
        </div>

        <button type="submit" class="btn-submit">Continue</button>
    </form>
</div>
</div>

<script>
    // Auto move to next input
    const inputs = document.querySelectorAll('.otp-inputs input');
    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });
    });

    // Countdown timer
    let time = 30;
    const countdown = document.getElementById('countdown');

    setInterval(() => {
        if (time > 0) {
            time--;
            countdown.textContent = `00:${time < 10 ? '0' + time : time}`;
        }
    }, 1000);
     function goHome() {
        window.location.href = "{{ url('/') }}";
    }
</script>

</body>
</html>