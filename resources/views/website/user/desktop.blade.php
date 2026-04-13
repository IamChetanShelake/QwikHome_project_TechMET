<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Cart</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Roboto:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Roboto', sans-serif; background: #fff; min-height: 100vh; }

    /* HEADER */
    .header {
      width: 100%;
      height: 160px;
      background: #E4F9FF;
      box-shadow: 0px 4px 4px 0px #00000040;
      display: flex;
      align-items: center;
      padding: 0 40px;
      gap: 18px;
    }
    .back-btn {
      background: none; border: none; cursor: pointer;
      padding: 4px; display: flex; align-items: center;
    }
    .back-btn svg { width: 26px; height: 52px; }
    .header-title {
      font-family: 'Libre Baskerville', serif;
      font-weight: 700; font-size: 24px;
      letter-spacing: 0.03em; color: #004271; line-height: 100%;
    }

    /* STEPPER */
    .stepper-wrap {
      display: flex; justify-content: center;
      align-items: center; margin-top: 46px;
    }
    .step-label {
      font-family: 'Roboto', sans-serif; font-size: 20px;
      letter-spacing: 0.05em; line-height: 100%; white-space: nowrap;
    }
    .step-label.active  { font-weight: 600; color: #004271; }
    .step-label.inactive { font-weight: 400; color: #4E4F4F; }
    .step-line {
      width: 114px; border: none;
      border-top: 1.5px dashed #004271; margin: 0 10px; flex-shrink: 0;
    }

    /* CARDS SECTION - clip right so 3rd card is half-visible */
    .cards-section {
      margin: 30px 0 0 40px;
      overflow: hidden;
    }
    .cards-row {
      display: flex; gap: 24px; flex-wrap: nowrap;
      overflow-x: auto; padding-right: 40px;
      scrollbar-width: none; -ms-overflow-style: none;
    }
    .cards-row::-webkit-scrollbar { display: none; }

    /* CARD */
    .cart-card {
      position: relative;
      width: 519px; min-width: 519px; height: 201px;
      border: 1px solid #B5B5B5; border-radius: 15px;
      display: flex; align-items: center;
      padding: 20px 20px 20px 56px; gap: 16px;
      background: #fff; transition: box-shadow 0.2s; flex-shrink: 0;
    }
    .cart-card:hover { box-shadow: 0 4px 18px rgba(0,66,113,0.10); }

    .card-radio {
      position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
      width: 25px; height: 25px; border-radius: 50%;
      border: 1px solid #004271;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; background: #fff; flex-shrink: 0;
    }
    .card-radio.selected::after {
      content: ''; width: 15px; height: 15px;
      border-radius: 50%; background: #004271;
    }

    .card-img {
      width: 133px; min-width: 133px; height: 161px;
      border-radius: 15px; border: 1px solid #B5B5B5;
      object-fit: cover; flex-shrink: 0; background: #e8f5fb;
    }

    .card-content {
      flex: 1; display: flex; flex-direction: column; min-width: 0;
    }
    .card-title {
      font-weight: 600; font-size: 20px; color: #353535;
      margin-bottom: 10px; line-height: 100%;
    }
    .card-desc {
      font-weight: 400; font-size: 16px; color: #353535;
      line-height: 120%; margin-bottom: 18px;
    }
    .card-divider {
      width: 100%; border: none;
      border-top: 0.5px solid #A1A1A1; margin-bottom: 12px;
    }
    .card-bottom {
      display: flex; align-items: center; gap: 16px;
    }
    .card-price {
      font-weight: 400; font-size: 20px; color: #353535; flex: 1;
    }

    /* QTY CONTROL — light blue background pill */
    .qty-control {
      display: flex; align-items: center; gap: 6px;
      background: #C6E8F5;
      border-radius: 8px; padding: 3px 10px; height: 30px;
    }
    .qty-btn {
      background: none; border: none; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      padding: 0; line-height: 1;
    }
    .qty-num {
      font-weight: 400; font-size: 20px; color: #004271;
      min-width: 14px; text-align: center; line-height: 1;
    }

    .delete-btn {
      background: none; border: none; cursor: pointer;
      display: flex; align-items: center; padding: 2px;
    }

    /* BOTTOM BUTTONS */
    .bottom-actions {
      display: flex; justify-content: flex-end; align-items: center;
      gap: 20px; margin: 36px 40px 40px 40px;
    }
    .btn-outline {
      width: 198px; height: 54px; border-radius: 15px;
      border: 1px solid #004271; background: #fff;
      font-family: 'Roboto', sans-serif; font-weight: 600;
      font-size: 18px; color: #505050; cursor: pointer;
      transition: background 0.2s;
    }
    .btn-outline:hover { background: #E4F9FF; }
    .btn-filled {
      width: 198px; height: 54px; border-radius: 15px;
      border: none; background: #004271;
      font-family: 'Roboto', sans-serif; font-weight: 600;
      font-size: 18px; color: #fff; cursor: pointer;
      transition: background 0.2s;
    }
    .btn-filled:hover { background: #005a9e; }

    /* RESPONSIVE */
    @media (max-width: 900px) {
      .cart-card { width: 420px; min-width: 420px; }
    }
    @media (max-width: 640px) {
      .header { height: auto; padding: 24px 16px; }
      .step-line { width: 48px; }
      .step-label { font-size: 12px; }
      .cards-section { margin: 20px 0 0 16px; }
      .cart-card { width: 300px; min-width: 300px; height: auto; padding: 14px 12px 14px 42px; }
      .card-img { width: 88px; min-width: 88px; height: 108px; }
      .card-title { font-size: 15px; }
      .card-desc { font-size: 12px; }
      .card-price { font-size: 15px; }
      .bottom-actions { margin: 24px 16px; gap: 12px; }
      .btn-outline, .btn-filled { width: 148px; height: 46px; font-size: 14px; }
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <button class="back-btn" aria-label="Go back">
      <svg viewBox="0 0 26 52" fill="none">
        <path d="M20 6L6 26L20 46" stroke="#004271" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>
    <span class="header-title">Your Cart</span>
  </header>

  <!-- STEPPER -->
  <div class="stepper-wrap">
    <span class="step-label active">CART</span>
    <hr class="step-line"/>
    <span class="step-label inactive">ADDRESS</span>
    <hr class="step-line"/>
    <span class="step-label inactive">PAYMENT</span>
  </div>

  <!-- CARDS -->
  <div class="cards-section">
    <div class="cards-row">

      <!-- Card 1 -->
      <div class="cart-card">
        <div class="card-radio selected"></div>
        <img class="card-img"
          src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&q=80"
          alt="Home Deep Cleaning"/>
        <div class="card-content">
          <div class="card-title">Home Deep Cleaning</div>
          <div class="card-desc">Comprehensive cleaning for a spotless home.</div>
          <hr class="card-divider"/>
          <div class="card-bottom">
            <span class="card-price">AED 2499</span>
            <div class="qty-control">
              <button class="qty-btn" onclick="changeQty(this,-1)">
                <svg width="19" height="2" viewBox="0 0 19 2"><rect width="19" height="2" rx="1" fill="#004271"/></svg>
              </button>
              <span class="qty-num">1</span>
              <button class="qty-btn" onclick="changeQty(this,1)">
                <svg width="14" height="14" viewBox="0 0 14 14"><rect x="6" width="2" height="14" rx="1" fill="#BABABA"/><rect y="6" width="14" height="2" rx="1" fill="#BABABA"/></svg>
              </button>
            </div>
            <button class="delete-btn">
              <svg width="18" height="23" viewBox="0 0 18 23" fill="none">
                <path d="M1 5.5H17M6.5 5.5V2.5H11.5V5.5M3 5.5L4 20.5H14L15 5.5H3Z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="cart-card">
        <div class="card-radio"></div>
        <img class="card-img"
          src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=400&q=80"
          alt="AC Repair & Servicing"/>
        <div class="card-content">
          <div class="card-title">AC Repair &amp; Servicing</div>
          <div class="card-desc">Quick and professional AC maintenance at your doorstep.</div>
          <hr class="card-divider"/>
          <div class="card-bottom">
            <span class="card-price">AED 1499</span>
            <div class="qty-control">
              <button class="qty-btn" onclick="changeQty(this,-1)">
                <svg width="19" height="2" viewBox="0 0 19 2"><rect width="19" height="2" rx="1" fill="#004271"/></svg>
              </button>
              <span class="qty-num">1</span>
              <button class="qty-btn" onclick="changeQty(this,1)">
                <svg width="14" height="14" viewBox="0 0 14 14"><rect x="6" width="2" height="14" rx="1" fill="#BABABA"/><rect y="6" width="14" height="2" rx="1" fill="#BABABA"/></svg>
              </button>
            </div>
            <button class="delete-btn">
              <svg width="18" height="23" viewBox="0 0 18 23" fill="none">
                <path d="M1 5.5H17M6.5 5.5V2.5H11.5V5.5M3 5.5L4 20.5H14L15 5.5H3Z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Card 3: Salon for Women (half-visible) -->
      <div class="cart-card">
        <div class="card-radio"></div>
        <img class="card-img"
          src="https://images.unsplash.com/photo-1560066984-138dadb4c035?w=400&q=80"
          alt="Salon for Women"/>
        <div class="card-content">
          <div class="card-title">Salon for Women</div>
          <div class="card-desc">At-home beauty and self-care services, customized for you.</div>
          <hr class="card-divider"/>
          <div class="card-bottom">
            <span class="card-price">AED 2499</span>
            <div class="qty-control">
              <button class="qty-btn" onclick="changeQty(this,-1)">
                <svg width="19" height="2" viewBox="0 0 19 2"><rect width="19" height="2" rx="1" fill="#004271"/></svg>
              </button>
              <span class="qty-num">1</span>
              <button class="qty-btn" onclick="changeQty(this,1)">
                <svg width="14" height="14" viewBox="0 0 14 14"><rect x="6" width="2" height="14" rx="1" fill="#BABABA"/><rect y="6" width="14" height="2" rx="1" fill="#BABABA"/></svg>
              </button>
            </div>
            <button class="delete-btn">
              <svg width="18" height="23" viewBox="0 0 18 23" fill="none">
                <path d="M1 5.5H17M6.5 5.5V2.5H11.5V5.5M3 5.5L4 20.5H14L15 5.5H3Z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- BOTTOM ACTIONS -->
  <div class="bottom-actions">
    <button class="btn-outline">Add Services</button>
    <button class="btn-filled">Add address &amp; slot</button>
  </div>

  <script>
    function changeQty(btn, delta) {
      const numEl = btn.closest('.qty-control').querySelector('.qty-num');
      let v = parseInt(numEl.textContent) + delta;
      numEl.textContent = v < 1 ? 1 : v;
    }
    document.querySelectorAll('.card-radio').forEach(r => {
      r.addEventListener('click', () => {
        document.querySelectorAll('.card-radio').forEach(x => x.classList.remove('selected'));
        r.classList.add('selected');
      });
    });
  </script>
</body>
</html>






































{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Cart</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Roboto:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Roboto', sans-serif;
      background: #fff;
      min-height: 100vh;
    }

    /* HEADER */
    .header {
      width: 100%;
      height: 160px;
      background: #E4F9FF;
      box-shadow: 0px 4px 4px 0px #00000040;
      display: flex;
      align-items: center;
      padding: 0 40px;
      gap: 18px;
    }

    .back-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      background: none;
      border: none;
      cursor: pointer;
      padding: 4px;
    }

    .back-btn svg {
      width: 26px;
      height: 52px;
    }

    .header-title {
      font-family: 'Libre Baskerville', serif;
      font-weight: 700;
      font-size: 24px;
      letter-spacing: 0.03em;
      color: #004271;
      line-height: 100%;
    }

    /* STEPPER */
    .stepper-wrap {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 46px;
      gap: 0;
    }

    .step-label {
      font-family: 'Roboto', sans-serif;
      font-size: 20px;
      letter-spacing: 0.05em;
      line-height: 100%;
      white-space: nowrap;
    }

    .step-label.active {
      font-weight: 600;
      color: #004271;
    }

    .step-label.inactive {
      font-weight: 400;
      color: #4E4F4F;
    }

    .step-line {
      width: 114px;
      height: 0;
      border: none;
      border-top: 1.5px dashed #004271;
      margin: 0 10px;
      flex-shrink: 0;
    }

    /* CARDS AREA */
    .cards-section {
      margin: 30px 40px 0 40px;
      overflow: hidden;
    }

    .cards-row {
      display: flex;
      gap: 24px;
      flex-wrap: nowrap;
      overflow-x: auto;
      padding-bottom: 12px;
      scroll-snap-type: x mandatory;
      -webkit-overflow-scrolling: touch;
      /* hide scrollbar visually */
      scrollbar-width: none;
    }
    .cards-row::-webkit-scrollbar { display: none; }

    /* SINGLE CARD */
    .cart-card {
      position: relative;
      width: 519px;
      min-width: 519px;
      min-height: 201px;
      border: 1px solid #B5B5B5;
      border-radius: 15px;
      display: flex;
      align-items: center;
      padding: 20px 20px 20px 56px;
      gap: 16px;
      background: #fff;
      transition: box-shadow 0.2s;
      flex-shrink: 0;
      scroll-snap-align: start;
    }

    .cart-card:hover {
      box-shadow: 0 4px 18px rgba(0,66,113,0.10);
    }

    /* 3rd card — half visible peek */
    .cart-card.peek {
      min-width: 260px;
      width: 260px;
      overflow: hidden;
    }

    /* Radio circle */
    .card-radio {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      width: 25px;
      height: 25px;
      border-radius: 50%;
      border: 1px solid #004271;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      flex-shrink: 0;
      background: #fff;
    }

    .card-radio.selected::after {
      content: '';
      width: 15px;
      height: 15px;
      border-radius: 50%;
      background: #004271;
    }

    /* Image */
    .card-img {
      width: 133px;
      height: 161px;
      border-radius: 15px;
      border: 1px solid #B5B5B5;
      object-fit: cover;
      flex-shrink: 0;
      background: #e8f5fb;
    }

    /* Card content */
    .card-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 0;
      min-width: 0;
    }

    .card-title {
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 20px;
      color: #353535;
      letter-spacing: 0;
      margin-bottom: 10px;
      line-height: 100%;
    }

    .card-desc {
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 16px;
      color: #353535;
      letter-spacing: 0;
      line-height: 120%;
      margin-bottom: 18px;
    }

    .card-divider {
      width: 282px;
      border: none;
      border-top: 0.5px solid #A1A1A1;
      margin-bottom: 12px;
    }

    .card-bottom {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    .card-price {
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 20px;
      color: #353535;
      letter-spacing: 0;
    }

    /* Quantity control */
    .qty-control {
      display: flex;
      align-items: center;
      gap: 6px;
      background: #E4F9FF;
      border-radius: 50px;
      padding: 5px 12px;
    }

    .qty-btn {
      background: none;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2px;
    }

    .qty-num {
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 20px;
      color: #004271;
      min-width: 18px;
      text-align: center;
    }

    .delete-btn {
      background: none;
      border: none;
      cursor: pointer;
      margin-left: 8px;
      display: flex;
      align-items: center;
    }

    /* BOTTOM BUTTONS */
    .bottom-actions {
      display: flex;
      justify-content: flex-end;
      gap: 20px;
      margin: 40px 40px 40px 40px;
      flex-wrap: wrap;
    }

    .btn-outline {
      padding: 16px 36px;
      border-radius: 50px;
      border: 1.5px solid #004271;
      background: #fff;
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 18px;
      color: #004271;
      cursor: pointer;
      letter-spacing: 0.01em;
      transition: background 0.2s, color 0.2s;
    }

    .btn-outline:hover {
      background: #E4F9FF;
    }

    .btn-filled {
      padding: 16px 36px;
      border-radius: 50px;
      border: none;
      background: #004271;
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 18px;
      color: #fff;
      cursor: pointer;
      letter-spacing: 0.01em;
      transition: background 0.2s;
    }

    .btn-filled:hover {
      background: #005a9e;
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
      .cart-card { min-width: 420px; width: 420px; }
      .cart-card.peek { min-width: 210px; width: 210px; }
    }

    @media (max-width: 640px) {
      .header { height: auto; padding: 24px 16px; }
      .stepper-wrap { gap: 0; }
      .step-line { width: 44px; }
      .step-label { font-size: 13px; }
      .cards-section { margin: 24px 16px 0 16px; }
      .cart-card { min-width: 300px; width: 300px; padding: 14px 14px 14px 42px; }
      .cart-card.peek { min-width: 150px; width: 150px; }
      .card-img { width: 90px; height: 110px; }
      .card-title { font-size: 16px; }
      .card-price { font-size: 16px; }
      .card-divider { width: 100%; }
      .bottom-actions { margin: 24px 16px; }
      .btn-outline, .btn-filled { padding: 12px 20px; font-size: 15px; }
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <button class="back-btn" aria-label="Go back">
      <svg viewBox="0 0 26 52" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 6L6 26L20 46" stroke="#004271" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>
    <span class="header-title">Your Cart</span>
  </header>

  <!-- STEPPER -->
  <div class="stepper-wrap">
    <span class="step-label active">CART</span>
    <hr class="step-line"/>
    <span class="step-label inactive">ADDRESS</span>
    <hr class="step-line"/>
    <span class="step-label inactive">PAYMENT</span>
  </div>

  <!-- CARDS -->
  <div class="cards-section">
    <div class="cards-row">

      <!-- Card 1: Home Deep Cleaning -->
      <div class="cart-card">
        <div class="card-radio selected"></div>
        <img class="card-img"
          src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&q=80"
          alt="Home Deep Cleaning"/>
        <div class="card-content">
          <div class="card-title">Home Deep Cleaning</div>
          <div class="card-desc">Comprehensive cleaning for a spotless home.</div>
          <hr class="card-divider"/>
          <div class="card-bottom">
            <span class="card-price">AED 2499</span>
            <div class="qty-control">
              <button class="qty-btn qty-minus" onclick="changeQty(this, -1)" aria-label="Decrease">
                <svg width="19" height="2" viewBox="0 0 19 2" fill="none">
                  <rect width="19" height="2" rx="1" fill="#004271"/>
                </svg>
              </button>
              <span class="qty-num">1</span>
              <button class="qty-btn qty-plus" onclick="changeQty(this, 1)" aria-label="Increase">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                  <rect x="6" width="2" height="14" rx="1" fill="#BABABA"/>
                  <rect y="6" width="14" height="2" rx="1" fill="#BABABA"/>
                </svg>
              </button>
            </div>
            <button class="delete-btn" aria-label="Delete item">
              <svg width="18" height="23" viewBox="0 0 18 23" fill="none">
                <path d="M1 5.5H17M6.5 5.5V2.5H11.5V5.5M3 5.5L4 20.5H14L15 5.5H3Z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Card 2: AC Repair & Servicing -->
      <div class="cart-card">
        <div class="card-radio"></div>
        <img class="card-img"
          src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=400&q=80"
          alt="AC Repair & Servicing"/>
        <div class="card-content">
          <div class="card-title">AC Repair &amp; Servicing</div>
          <div class="card-desc">Quick and professional AC maintenance at your doorstep.</div>
          <hr class="card-divider"/>
          <div class="card-bottom">
            <span class="card-price">AED 1499</span>
            <div class="qty-control">
              <button class="qty-btn qty-minus" onclick="changeQty(this, -1)" aria-label="Decrease">
                <svg width="19" height="2" viewBox="0 0 19 2" fill="none">
                  <rect width="19" height="2" rx="1" fill="#004271"/>
                </svg>
              </button>
              <span class="qty-num">1</span>
              <button class="qty-btn qty-plus" onclick="changeQty(this, 1)" aria-label="Increase">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                  <rect x="6" width="2" height="14" rx="1" fill="#BABABA"/>
                  <rect y="6" width="14" height="2" rx="1" fill="#BABABA"/>
                </svg>
              </button>
            </div>
            <button class="delete-btn" aria-label="Delete item">
              <svg width="18" height="23" viewBox="0 0 18 23" fill="none">
                <path d="M1 5.5H17M6.5 5.5V2.5H11.5V5.5M3 5.5L4 20.5H14L15 5.5H3Z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Card 3: Salon — half visible peek -->
      <div class="cart-card peek">
        <div class="card-radio"></div>
        <img class="card-img"
          src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=400&q=80"
          alt="Salon at Home"/>
        <div class="card-content">
          <div class="card-title">Salon at Home</div>
          <div class="card-desc">At-home beauty services for our customers.</div>
          <hr class="card-divider"/>
          <div class="card-bottom">
            <span class="card-price">AED 899</span>
            <div class="qty-control">
              <button class="qty-btn" onclick="changeQty(this, -1)" aria-label="Decrease">
                <svg width="19" height="2" viewBox="0 0 19 2" fill="none">
                  <rect width="19" height="2" rx="1" fill="#004271"/>
                </svg>
              </button>
              <span class="qty-num">1</span>
              <button class="qty-btn" onclick="changeQty(this, 1)" aria-label="Increase">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                  <rect x="6" width="2" height="14" rx="1" fill="#BABABA"/>
                  <rect y="6" width="14" height="2" rx="1" fill="#BABABA"/>
                </svg>
              </button>
            </div>
            <button class="delete-btn" aria-label="Delete item">
              <svg width="18" height="23" viewBox="0 0 18 23" fill="none">
                <path d="M1 5.5H17M6.5 5.5V2.5H11.5V5.5M3 5.5L4 20.5H14L15 5.5H3Z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- BOTTOM ACTIONS -->
  <div class="bottom-actions">
    <button class="btn-outline">Add Services</button>
    <button class="btn-filled">Add address &amp; slot</button>
  </div>

  <script>
    function changeQty(btn, delta) {
      const control = btn.closest('.qty-control');
      const numEl = control.querySelector('.qty-num');
      let val = parseInt(numEl.textContent) + delta;
      if (val < 1) val = 1;
      numEl.textContent = val;
    }

    // Radio selection
    document.querySelectorAll('.card-radio').forEach(radio => {
      radio.addEventListener('click', () => {
        document.querySelectorAll('.card-radio').forEach(r => r.classList.remove('selected'));
        radio.classList.add('selected');
      });
    });
  </script>
</body>
</html> --}}