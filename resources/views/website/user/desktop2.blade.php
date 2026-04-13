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

    /* ── SECTION DIVIDER ── */
    .section-divider {
      width: 100%; border: none;
      border-top: 1px solid #D9D9D9;
      margin: 10px 0 0 0;
    }

    /* ── ADDRESS SECTION ── */
    .address-section {
      padding: 0 40px 50px 40px;
    }

    /* stepper inside address section */
    .address-section .stepper-wrap {
      margin-top: 40px;
      margin-bottom: 36px;
    }

    /* Your Address block */
    .your-address-row {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      margin-bottom: 6px;
    }
    .addr-pin-icon {
      margin-top: 2px;
      flex-shrink: 0;
    }
    .addr-label {
      font-weight: 600;
      font-size: 20px;
      color: #1a1a1a;
      line-height: 100%;
    }
    .addr-text-row {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-left: 0;
      margin-bottom: 28px;
    }
    .addr-text {
      font-weight: 400;
      font-size: 15px;
      color: #555;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .addr-chevron {
      display: inline-flex;
      align-items: center;
    }
    .btn-change {
      border: 1.5px solid #E8450A;
      background: #fff;
      border-radius: 20px;
      padding: 5px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 14px;
      color: #E8450A;
      cursor: pointer;
      white-space: nowrap;
      transition: background 0.2s;
    }
    .btn-change:hover { background: #fff5f2; }

    /* Add Detailed Address */
    .detail-title {
      font-weight: 700;
      font-size: 20px;
      color: #1a1a1a;
      margin-bottom: 20px;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 16px;
    }

    .form-input {
      height: 52px;
      border: 1px solid #C8C8C8;
      border-radius: 10px;
      padding: 0 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 15px;
      color: #353535;
      background: #fff;
      outline: none;
      transition: border-color 0.2s;
      width: 100%;
    }
    .form-input::placeholder { color: #9E9E9E; }
    .form-input:focus { border-color: #004271; }

    /* Save As */
    .save-as-title {
      font-weight: 700;
      font-size: 20px;
      color: #1a1a1a;
      margin: 28px 0 16px 0;
    }
    .save-as-btns {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
    }
    .save-btn {
      height: 46px;
      padding: 0 28px;
      border-radius: 12px;
      border: 1.5px solid #C8C8C8;
      background: #fff;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 16px;
      color: #505050;
      cursor: pointer;
      transition: all 0.2s;
      min-width: 110px;
    }
    .save-btn.active {
      background: #004271;
      border-color: #004271;
      color: #fff;
      font-weight: 600;
    }
    .save-btn:not(.active):hover {
      border-color: #004271;
      color: #004271;
    }

    /* Add Slot button */
    .slot-actions {
      display: flex;
      justify-content: flex-end;
      margin-top: 40px;
    }
    .btn-add-slot {
      width: 198px;
      height: 54px;
      border-radius: 15px;
      border: none;
      background: #004271;
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 18px;
      color: #fff;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-add-slot:hover { background: #005a9e; }

    /* RESPONSIVE */
    @media (max-width: 900px) {
      .cart-card { width: 420px; min-width: 420px; }
      .form-grid { grid-template-columns: repeat(2, 1fr); }
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
      .address-section { padding: 0 16px 40px 16px; }
      .form-grid { grid-template-columns: 1fr; }
      .btn-add-slot { width: 148px; height: 46px; font-size: 14px; }
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
    <button class="btn-filled" onclick="openAddressSection()">Add address &amp; slot</button>
  </div>

  <!-- SECTION DIVIDER -->
  <hr class="section-divider" id="section-divider" style="display:none"/>

  <!-- ADDRESS SECTION -->
  <div class="address-section" id="address-section" style="display:none">

    <!-- Stepper — ADDRESS active -->
    <div class="stepper-wrap">
      <span class="step-label inactive">CART</span>
      <hr class="step-line"/>
      <span class="step-label active">ADDRESS</span>
      <hr class="step-line"/>
      <span class="step-label inactive">PAYMENT</span>
    </div>

    <!-- Your Address -->
    <div class="your-address-row">
      <span class="addr-pin-icon">
        <svg width="22" height="28" viewBox="0 0 22 28" fill="none">
          <path d="M11 0C7.13 0 4 3.13 4 7c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 11 4.5a2.5 2.5 0 0 1 0 5z" fill="#1a1a1a"/>
        </svg>
      </span>
      <span class="addr-label">Your Address</span>
    </div>

    <div class="addr-text-row">
      <span class="addr-text">
        Tidake colony, Durwankur Lawns, Nashik .....
        <span class="addr-chevron">
          <svg width="14" height="9" viewBox="0 0 14 9" fill="none">
            <path d="M1 1L7 7L13 1" stroke="#555" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </span>
      <button class="btn-change">Change</button>
    </div>

    <!-- Add Detailed Address Form -->
    <div class="detail-title">Add Detailed Address</div>

    <div class="form-grid">
      <input class="form-input" type="text" placeholder="Enter Name *"/>
      <input class="form-input" type="tel"  placeholder="Enter Phone Number *"/>
      <input class="form-input" type="email" placeholder="Enter Email ID *"/>
    </div>
    <div class="form-grid">
      <input class="form-input" type="text" placeholder="City *"/>
      <input class="form-input" type="text" placeholder="Flat No/ Building name / Street name *"/>
      <input class="form-input" type="text" placeholder="Enter Full Address *"/>
    </div>

    <!-- Save As -->
    <div class="save-as-title">Save As</div>
    <div class="save-as-btns">
      <button class="save-btn active" onclick="selectSaveAs(this)">Home</button>
      <button class="save-btn" onclick="selectSaveAs(this)">Office</button>
      <button class="save-btn" onclick="selectSaveAs(this)">Other</button>
    </div>

    <!-- Add Slot -->
    <div class="slot-actions">
      <button class="btn-add-slot" onclick="openSlotSection()">Add Slot</button>
    </div>

  </div>

  <!-- SLOT SECTION DIVIDER -->
  <hr class="section-divider" id="slot-divider" style="display:none"/>

  <!-- SLOT SECTION -->
  <div class="slot-section" id="slot-section" style="display:none">

    <div class="slot-inner">
      <!-- LEFT: Calendar -->
      <div class="slot-left">
        <h2 class="slot-main-title">Your Qwik Slot - Choose Date &amp; Time</h2>
        <div class="calendar-box">
          <div class="cal-header">
            <button class="cal-nav" onclick="prevMonth()">
              <svg width="9" height="15" viewBox="0 0 9 15" fill="none"><path d="M8 1L2 7.5L8 14" stroke="#004271" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <span class="cal-month-label" id="cal-month-label">December</span>
            <button class="cal-nav" onclick="nextMonth()">
              <svg width="9" height="15" viewBox="0 0 9 15" fill="none"><path d="M1 1L7 7.5L1 14" stroke="#004271" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
          </div>
          <div class="cal-grid">
            <div class="cal-day-name">Sun</div><div class="cal-day-name">Mon</div><div class="cal-day-name">Tue</div><div class="cal-day-name">Wed</div><div class="cal-day-name">Thu</div><div class="cal-day-name">Fri</div><div class="cal-day-name">Sat</div>
          </div>
          <div class="cal-grid" id="cal-days"></div>
        </div>
      </div>

      <!-- RIGHT: Time + Expert -->
      <div class="slot-right">
        <h3 class="slot-sub-title">Select Time</h3>
        <div class="time-grid">
          <button class="time-btn" onclick="selectTime(this)">03:30 PM</button>
          <button class="time-btn" onclick="selectTime(this)">04:30 PM</button>
          <button class="time-btn" onclick="selectTime(this)">05:00 PM</button>
          <button class="time-btn" onclick="selectTime(this)">05:30 PM</button>
          <button class="time-btn" onclick="selectTime(this)">06:00 PM</button>
          <button class="time-btn" onclick="selectTime(this)">06:30 PM</button>
          <button class="time-btn" onclick="selectTime(this)">07:00 PM</button>
          <button class="time-btn" onclick="selectTime(this)">07:30 PM</button>
        </div>

        <h3 class="slot-sub-title" style="margin-top:28px">Choose Your Expert</h3>
        <div class="expert-row">
          <div class="expert-card active-expert" onclick="selectExpert(this)">
            <div class="expert-avatar best-match">
              <svg width="36" height="36" viewBox="0 0 36 36" fill="none"><circle cx="18" cy="14" r="7" fill="#004271"/><path d="M4 34c0-7.732 6.268-14 14-14s14 6.268 14 14" stroke="#004271" stroke-width="2"/></svg>
            </div>
            <span class="expert-name">Best Match<br/>for Your Service</span>
          </div>
          <div class="expert-card" onclick="selectExpert(this)">
            <div class="expert-avatar">
              <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&q=80" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" alt="Megha"/>
            </div>
            <span class="expert-name">Megha</span>
          </div>
        </div>

        <div class="slot-actions" style="margin-top:32px">
          <button class="btn-add-slot" onclick="openPaymentSection()">Payment details</button>
        </div>
      </div>
    </div>
  </div>

  <!-- PAYMENT SECTION DIVIDER -->
  <hr class="section-divider" id="payment-divider" style="display:none"/>

  <!-- PAYMENT SECTION -->
  <div class="payment-section" id="payment-section" style="display:none">

    <!-- Stepper — PAYMENT active -->
    <div class="stepper-wrap" style="margin-top:40px; margin-bottom:30px;">
      <span class="step-label inactive">CART</span>
      <hr class="step-line"/>
      <span class="step-label inactive">ADDRESS</span>
      <hr class="step-line"/>
      <span class="step-label active">PAYMENT</span>
    </div>

    <div class="payment-inner">

      <!-- LEFT COLUMN -->
      <div class="payment-left">

        <!-- Address + Time edit rows -->
        <div class="pay-info-row">
          <div class="pay-info-left">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 12L12 3L21 12V21H15V15H9V21H3V12Z" stroke="#353535" stroke-width="1.5" stroke-linejoin="round"/></svg>
            <span class="pay-info-text"><strong>Home</strong> - Tidake colony, Durwankur Lawns, Nashik</span>
          </div>
          <button class="pay-edit-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
        <div class="pay-info-row" style="margin-top:10px;">
          <div class="pay-info-left">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#353535" stroke-width="1.5"/><path d="M12 7v5l3 3" stroke="#353535" stroke-width="1.5" stroke-linecap="round"/></svg>
            <span class="pay-info-text">Tue, oct 07 - 4:30 PM</span>
          </div>
          <button class="pay-edit-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>

        <!-- Service Card -->
        <div class="pay-service-card">
          <img class="pay-service-img"
            src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&q=80"
            alt="Home Deep Cleaning"/>
          <div class="pay-service-info">
            <div class="pay-service-title">Home Deep Cleaning</div>
            <div class="pay-service-desc">Comprehensive cleaning for a spotless home.</div>
            <div class="pay-service-price">AED 2499</div>
          </div>
          <button class="delete-btn" style="margin-left:auto;align-self:center;">
            <svg width="18" height="23" viewBox="0 0 18 23" fill="none"><path d="M1 5.5H17M6.5 5.5V2.5H11.5V5.5M3 5.5L4 20.5H14L15 5.5H3Z" stroke="#353535" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>

        <!-- Coupons -->
        <div class="pay-coupon-row">
          <div style="display:flex;align-items:center;gap:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="2" y="7" width="20" height="10" rx="2" stroke="#353535" stroke-width="1.5"/><path d="M15 7v10M9 7v10" stroke="#353535" stroke-width="1" stroke-dasharray="2 2"/></svg>
            <span class="coupon-label">COUPONS</span>
          </div>
          <div style="display:flex;align-items:center;gap:6px;cursor:pointer;color:#004271;font-weight:600;font-size:15px;">
            All Coupons
            <svg width="8" height="13" viewBox="0 0 8 13" fill="none"><path d="M1 1L7 6.5L1 12" stroke="#004271" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>

        <!-- Cancellation Policy -->
        <div class="cancel-box">
          <div class="cancel-title">Cancellation policy</div>
          <div class="cancel-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</div>
          <a href="#" class="view-more">View More</a>
        </div>
      </div>

      <!-- RIGHT COLUMN: Price Details -->
      <div class="payment-right">
        <div class="price-box">
          <div class="price-title">Price Details</div>
          <div class="price-row">
            <span class="price-label">Item total</span>
            <span class="price-val">AED 2,499</span>
          </div>
          <div class="price-row">
            <span class="price-label">Taxes and fee</span>
            <span class="price-val">AED 50</span>
          </div>
          <div class="price-row total-row">
            <span class="price-label-bold">Total amount</span>
            <span class="price-val-bold">AED 2,549</span>
          </div>
          <div class="price-divider"></div>
          <div class="price-row">
            <span class="price-label-bold">Amount to pay</span>
            <span class="price-val-bold">AED 2,549</span>
          </div>
        </div>

        <!-- Pay bar -->
        <div class="pay-bar">
          <div class="pay-bar-top">
            <span class="pay-bar-title">Pay AED 2,549</span>
            <button class="pay-bar-close" onclick="document.getElementById('payment-section').style.display='none';document.getElementById('payment-divider').style.display='none';">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 1L13 13M13 1L1 13" stroke="#353535" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>
          </div>
          <div class="pay-bar-method">
            <svg width="28" height="22" viewBox="0 0 28 22" fill="none"><rect x="1" y="1" width="26" height="20" rx="3" stroke="#004271" stroke-width="1.5"/><circle cx="10" cy="11" r="4" fill="#004271" opacity="0.3"/><circle cx="16" cy="11" r="4" fill="#004271"/></svg>
            <span class="pay-method-label">Cash on Delivery</span>
            <button class="pay-change-btn">Change</button>
          </div>
        </div>

        <button class="btn-pay-now">Pay AED 2,549</button>
      </div>

    </div>
  </div>

  <style>
    /* ── SLOT SECTION ── */
    .slot-section {
      padding: 36px 40px 40px 40px;
    }
    .slot-inner {
      display: flex;
      gap: 48px;
      align-items: flex-start;
      flex-wrap: wrap;
    }
    .slot-left { flex: 0 0 auto; }
    .slot-right { flex: 1; min-width: 280px; }

    .slot-main-title {
      font-family: 'Roboto', sans-serif;
      font-weight: 700; font-size: 20px;
      color: #1a1a1a; margin-bottom: 20px;
    }
    .slot-sub-title {
      font-family: 'Roboto', sans-serif;
      font-weight: 700; font-size: 18px; color: #1a1a1a;
    }

    /* Calendar */
    .calendar-box {
      background: #F4F4F4;
      border-radius: 12px;
      padding: 18px 22px;
      width: 340px;
    }
    .cal-header {
      display: flex; align-items: center;
      justify-content: space-between; margin-bottom: 16px;
    }
    .cal-month-label {
      font-weight: 700; font-size: 18px; color: #1a1a1a;
    }
    .cal-nav {
      background: none; border: none; cursor: pointer;
      width: 30px; height: 30px; display: flex;
      align-items: center; justify-content: center;
      border-radius: 50%;
    }
    .cal-nav:hover { background: #e0e0e0; }
    .cal-grid {
      display: grid; grid-template-columns: repeat(7, 1fr);
      gap: 4px; text-align: center;
    }
    .cal-day-name {
      font-size: 13px; font-weight: 600; color: #888;
      padding-bottom: 6px;
    }
    .cal-day {
      font-size: 14px; color: #353535;
      padding: 7px 4px; border-radius: 50%;
      cursor: pointer; transition: background 0.15s;
      aspect-ratio: 1; display: flex;
      align-items: center; justify-content: center;
    }
    .cal-day:hover { background: #d6eef8; }
    .cal-day.selected {
      background: #004271; color: #fff; font-weight: 600;
    }
    .cal-day.empty { cursor: default; }

    /* Time slots */
    .time-grid {
      display: grid;
      grid-template-columns: repeat(3, auto);
      gap: 12px; margin-top: 14px;
    }
    .time-btn {
      padding: 10px 18px; border-radius: 10px;
      border: 1.5px solid #C8C8C8; background: #fff;
      font-family: 'Roboto', sans-serif; font-weight: 400;
      font-size: 15px; color: #353535; cursor: pointer;
      transition: all 0.15s; white-space: nowrap;
    }
    .time-btn:hover { border-color: #004271; color: #004271; }
    .time-btn.selected {
      background: #004271; border-color: #004271;
      color: #fff; font-weight: 600;
    }

    /* Experts */
    .expert-row {
      display: flex; gap: 24px; margin-top: 14px;
      align-items: flex-start;
    }
    .expert-card {
      display: flex; flex-direction: column;
      align-items: center; gap: 8px; cursor: pointer;
    }
    .expert-avatar {
      width: 60px; height: 60px; border-radius: 50%;
      border: 2px solid #C8C8C8;
      display: flex; align-items: center; justify-content: center;
      overflow: hidden; background: #E4F9FF;
      transition: border-color 0.15s;
    }
    .active-expert .expert-avatar,
    .expert-card.selected .expert-avatar {
      border-color: #004271; border-width: 3px;
    }
    .expert-name {
      font-size: 13px; color: #353535; text-align: center;
      line-height: 1.3;
    }

    /* ── PAYMENT SECTION ── */
    .payment-section {
      padding: 0 40px 60px 40px;
    }
    .payment-inner {
      display: flex; gap: 40px; align-items: flex-start; flex-wrap: wrap;
    }
    .payment-left { flex: 1; min-width: 280px; }
    .payment-right { flex: 0 0 360px; }

    /* Info rows */
    .pay-info-row {
      display: flex; align-items: center;
      justify-content: space-between;
      border: 1px solid #E0E0E0; border-radius: 10px;
      padding: 14px 16px; gap: 12px;
    }
    .pay-info-left {
      display: flex; align-items: center; gap: 10px;
    }
    .pay-info-text { font-size: 15px; color: #353535; }
    .pay-edit-btn {
      background: none; border: none; cursor: pointer;
      display: flex; align-items: center; padding: 4px;
    }

    /* Payment service card */
    .pay-service-card {
      display: flex; align-items: center; gap: 14px;
      border: 1px solid #E0E0E0; border-radius: 12px;
      padding: 14px 16px; margin-top: 14px;
    }
    .pay-service-img {
      width: 90px; height: 90px; border-radius: 10px;
      object-fit: cover; flex-shrink: 0;
    }
    .pay-service-info { flex: 1; }
    .pay-service-title { font-weight: 600; font-size: 16px; color: #353535; }
    .pay-service-desc { font-size: 14px; color: #777; margin: 4px 0 8px; }
    .pay-service-price { font-size: 16px; color: #353535; }

    /* Coupons row */
    .pay-coupon-row {
      display: flex; align-items: center;
      justify-content: space-between;
      border: 1px solid #E0E0E0; border-radius: 10px;
      padding: 14px 16px; margin-top: 14px;
    }
    .coupon-label {
      font-weight: 600; font-size: 15px; color: #353535;
    }

    /* Cancellation */
    .cancel-box {
      margin-top: 16px; padding: 16px;
      border: 1px solid #E0E0E0; border-radius: 10px;
    }
    .cancel-title { font-weight: 700; font-size: 15px; color: #1a1a1a; margin-bottom: 8px; }
    .cancel-text { font-size: 13px; color: #777; line-height: 1.5; }
    .view-more {
      display: inline-block; margin-top: 8px;
      font-size: 14px; color: #004271;
      font-weight: 600; text-decoration: none;
    }

    /* Price details box */
    .price-box {
      border: 1px solid #E0E0E0; border-radius: 12px;
      padding: 20px 22px; margin-bottom: 16px;
    }
    .price-title {
      font-weight: 700; font-size: 18px; color: #1a1a1a; margin-bottom: 14px;
    }
    .price-row {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 10px;
    }
    .price-label { font-size: 15px; color: #555; }
    .price-val { font-size: 15px; color: #353535; }
    .price-label-bold { font-size: 15px; color: #1a1a1a; font-weight: 700; }
    .price-val-bold { font-size: 15px; color: #1a1a1a; font-weight: 700; }
    .price-divider {
      border: none; border-top: 1px solid #E0E0E0;
      margin: 12px 0;
    }
    .total-row { margin-top: 6px; }

    /* Pay bar */
    .pay-bar {
      border: 1px solid #E0E0E0; border-radius: 12px;
      padding: 16px 18px; margin-bottom: 14px;
    }
    .pay-bar-top {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 12px;
    }
    .pay-bar-title { font-weight: 700; font-size: 17px; color: #1a1a1a; }
    .pay-bar-close {
      background: none; border: none; cursor: pointer;
      display: flex; align-items: center;
    }
    .pay-bar-method {
      display: flex; align-items: center; gap: 12px;
    }
    .pay-method-label { font-size: 15px; color: #353535; flex: 1; }
    .pay-change-btn {
      background: none; border: none;
      font-family: 'Roboto', sans-serif;
      font-weight: 600; font-size: 14px;
      color: #004271; cursor: pointer;
    }

    /* Pay now button */
    .btn-pay-now {
      width: 100%; height: 54px; border-radius: 15px;
      border: none; background: #004271;
      font-family: 'Roboto', sans-serif;
      font-weight: 600; font-size: 18px;
      color: #fff; cursor: pointer;
      transition: background 0.2s;
    }
    .btn-pay-now:hover { background: #005a9e; }

    @media (max-width: 800px) {
      .slot-section, .payment-section { padding: 24px 16px 36px 16px; }
      .calendar-box { width: 100%; }
      .time-grid { grid-template-columns: repeat(2, 1fr); }
      .payment-right { flex: 1 1 100%; }
    }
  </style>

  <script>
    /* ── Calendar ── */
    let calYear = 2024, calMonth = 11; // December 2024
    let selectedDay = null;

    function renderCalendar() {
      const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
      document.getElementById('cal-month-label').textContent = monthNames[calMonth] + ' ' + calYear;
      const grid = document.getElementById('cal-days');
      grid.innerHTML = '';
      const firstDay = new Date(calYear, calMonth, 1).getDay();
      const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
      for (let i = 0; i < firstDay; i++) {
        const blank = document.createElement('div');
        blank.className = 'cal-day empty';
        grid.appendChild(blank);
      }
      for (let d = 1; d <= daysInMonth; d++) {
        const el = document.createElement('div');
        el.className = 'cal-day' + (d === selectedDay ? ' selected' : '');
        el.textContent = d;
        el.onclick = () => {
          selectedDay = d;
          renderCalendar();
        };
        grid.appendChild(el);
      }
    }
    function prevMonth() {
      calMonth--; if (calMonth < 0) { calMonth = 11; calYear--; }
      renderCalendar();
    }
    function nextMonth() {
      calMonth++; if (calMonth > 11) { calMonth = 0; calYear++; }
      renderCalendar();
    }

    function selectTime(btn) {
      document.querySelectorAll('.time-btn').forEach(b => b.classList.remove('selected'));
      btn.classList.add('selected');
    }
    function selectExpert(card) {
      document.querySelectorAll('.expert-card').forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
    }

    function openSlotSection() {
      document.getElementById('slot-divider').style.display = 'block';
      const sec = document.getElementById('slot-section');
      sec.style.display = 'block';
      renderCalendar();
      sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    function openPaymentSection() {
      document.getElementById('payment-divider').style.display = 'block';
      const sec = document.getElementById('payment-section');
      sec.style.display = 'block';
      sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function openAddressSection() {
      document.getElementById('section-divider').style.display = 'block';
      const section = document.getElementById('address-section');
      section.style.display = 'block';
      section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    function selectSaveAs(btn) {
      document.querySelectorAll('.save-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    }
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

    /* ── SECTION DIVIDER ── */
    .section-divider {
      width: 100%; border: none;
      border-top: 1px solid #D9D9D9;
      margin: 10px 0 0 0;
    }

    /* ── ADDRESS SECTION ── */
    .address-section {
      padding: 0 40px 50px 40px;
    }

    /* stepper inside address section */
    .address-section .stepper-wrap {
      margin-top: 40px;
      margin-bottom: 36px;
    }

    /* Your Address block */
    .your-address-row {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      margin-bottom: 6px;
    }
    .addr-pin-icon {
      margin-top: 2px;
      flex-shrink: 0;
    }
    .addr-label {
      font-weight: 600;
      font-size: 20px;
      color: #1a1a1a;
      line-height: 100%;
    }
    .addr-text-row {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-left: 0;
      margin-bottom: 28px;
    }
    .addr-text {
      font-weight: 400;
      font-size: 15px;
      color: #555;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .addr-chevron {
      display: inline-flex;
      align-items: center;
    }
    .btn-change {
      border: 1.5px solid #E8450A;
      background: #fff;
      border-radius: 20px;
      padding: 5px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 14px;
      color: #E8450A;
      cursor: pointer;
      white-space: nowrap;
      transition: background 0.2s;
    }
    .btn-change:hover { background: #fff5f2; }

    /* Add Detailed Address */
    .detail-title {
      font-weight: 700;
      font-size: 20px;
      color: #1a1a1a;
      margin-bottom: 20px;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 16px;
    }

    .form-input {
      height: 52px;
      border: 1px solid #C8C8C8;
      border-radius: 10px;
      padding: 0 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 15px;
      color: #353535;
      background: #fff;
      outline: none;
      transition: border-color 0.2s;
      width: 100%;
    }
    .form-input::placeholder { color: #9E9E9E; }
    .form-input:focus { border-color: #004271; }

    /* Save As */
    .save-as-title {
      font-weight: 700;
      font-size: 20px;
      color: #1a1a1a;
      margin: 28px 0 16px 0;
    }
    .save-as-btns {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
    }
    .save-btn {
      height: 46px;
      padding: 0 28px;
      border-radius: 12px;
      border: 1.5px solid #C8C8C8;
      background: #fff;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 16px;
      color: #505050;
      cursor: pointer;
      transition: all 0.2s;
      min-width: 110px;
    }
    .save-btn.active {
      background: #004271;
      border-color: #004271;
      color: #fff;
      font-weight: 600;
    }
    .save-btn:not(.active):hover {
      border-color: #004271;
      color: #004271;
    }

    /* Add Slot button */
    .slot-actions {
      display: flex;
      justify-content: flex-end;
      margin-top: 40px;
    }
    .btn-add-slot {
      width: 198px;
      height: 54px;
      border-radius: 15px;
      border: none;
      background: #004271;
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 18px;
      color: #fff;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-add-slot:hover { background: #005a9e; }

    /* RESPONSIVE */
    @media (max-width: 900px) {
      .cart-card { width: 420px; min-width: 420px; }
      .form-grid { grid-template-columns: repeat(2, 1fr); }
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
      .address-section { padding: 0 16px 40px 16px; }
      .form-grid { grid-template-columns: 1fr; }
      .btn-add-slot { width: 148px; height: 46px; font-size: 14px; }
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

  <!-- SECTION DIVIDER -->
  <hr class="section-divider"/>

  <!-- ADDRESS SECTION -->
  <div class="address-section">

    <!-- Stepper — ADDRESS active -->
    <div class="stepper-wrap">
      <span class="step-label inactive">CART</span>
      <hr class="step-line"/>
      <span class="step-label active">ADDRESS</span>
      <hr class="step-line"/>
      <span class="step-label inactive">PAYMENT</span>
    </div>

    <!-- Your Address -->
    <div class="your-address-row">
      <span class="addr-pin-icon">
        <svg width="22" height="28" viewBox="0 0 22 28" fill="none">
          <path d="M11 0C7.13 0 4 3.13 4 7c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 11 4.5a2.5 2.5 0 0 1 0 5z" fill="#1a1a1a"/>
        </svg>
      </span>
      <span class="addr-label">Your Address</span>
    </div>

    <div class="addr-text-row">
      <span class="addr-text">
        Tidake colony, Durwankur Lawns, Nashik .....
        <span class="addr-chevron">
          <svg width="14" height="9" viewBox="0 0 14 9" fill="none">
            <path d="M1 1L7 7L13 1" stroke="#555" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </span>
      <button class="btn-change">Change</button>
    </div>

    <!-- Add Detailed Address Form -->
    <div class="detail-title">Add Detailed Address</div>

    <div class="form-grid">
      <input class="form-input" type="text" placeholder="Enter Name *"/>
      <input class="form-input" type="tel"  placeholder="Enter Phone Number *"/>
      <input class="form-input" type="email" placeholder="Enter Email ID *"/>
    </div>
    <div class="form-grid">
      <input class="form-input" type="text" placeholder="City *"/>
      <input class="form-input" type="text" placeholder="Flat No/ Building name / Street name *"/>
      <input class="form-input" type="text" placeholder="Enter Full Address *"/>
    </div>

    <!-- Save As -->
    <div class="save-as-title">Save As</div>
    <div class="save-as-btns">
      <button class="save-btn active" onclick="selectSaveAs(this)">Home</button>
      <button class="save-btn" onclick="selectSaveAs(this)">Office</button>
      <button class="save-btn" onclick="selectSaveAs(this)">Other</button>
    </div>

    <!-- Add Slot -->
    <div class="slot-actions">
      <button class="btn-add-slot">Add Slot</button>
    </div>

  </div>

  <script>
    function selectSaveAs(btn) {
      document.querySelectorAll('.save-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    }
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
</html> --}}