<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Bookings</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Roboto:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    html, body {
      width: 100%;
      overflow-x: hidden; /* prevent horizontal scroll at all times */
    }

    body {
      min-height: 100vh;
      background: #FFFFFF;
      font-family: 'Roboto', sans-serif;
    }

    /* ══════════════════════════════
       HEADER
    ══════════════════════════════ */
    .header {
      width: 100%;
      height: 80px;
      background: #E4F9FF;
      box-shadow: 0px 4px 4px 0px #00000040;
      display: flex;
      align-items: center;
      padding: 0 20px;
      gap: 14px;
    }

    .back-btn {
      width: 26px;
      height: 26px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      flex-shrink: 0;
    }

    .page-title {
      font-family: 'Libre Baskerville', serif;
      font-weight: 700;
      font-size: 18px;
      letter-spacing: 0.03em;
      color: #004271;
    }

    /* ══════════════════════════════
       TABS
    ══════════════════════════════ */
    .tabs-wrapper {
      width: 100%;
      padding: 18px 16px 0;
      display: flex;
      gap: 8px;
    }

    .tab {
      flex: 1;
      height: 40px;
      border-radius: 15px;
      border: 1px solid #004271;
      background: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      user-select: none;
      transition: background 0.2s;
    }

    .tab span {
      font-family: 'Roboto', sans-serif;
      font-weight: 300;
      font-size: 12px;
      letter-spacing: 0.04em;
      color: #004271;
      white-space: nowrap;
    }

    .tab.active { background: #004271; }
    .tab.active span { font-weight: 500; color: #FFFFFF; }

    /* ══════════════════════════════
       CARDS AREA — mobile default
    ══════════════════════════════ */
    .cards-area {
      width: 100%;
      padding: 18px 16px 30px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .card {
      background: #FFFFFF;
      border-radius: 15px;
      border: 1px solid #E4E4E4;
      box-shadow: 0px 4px 4px 0px #0000000A;
      padding: 14px 12px;
      width: 100%;
    }

    .card-top {
      display: flex;
      gap: 11px;
      margin-bottom: 14px;
    }

    .card-img {
      width: 88px;
      height: 78px;
      border-radius: 15px;
      border: 1px solid #B5B5B5;
      flex-shrink: 0;
      background: #d0e8f0;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .card-info {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .card-title {
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 16px;
      line-height: 100%;
      color: #004271;
      margin-bottom: 6px;
    }

    .card-desc {
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 13px;
      line-height: 1.4;
      color: #353535;
    }

    .card-divider {
      height: 0;
      border: none;
      border-top: 0.25px solid #004271;
      margin-bottom: 14px;
    }

    .card-footer {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .badge-status {
      border-radius: 15px;
      border: 1px solid #E4F9FF;
      background: #E4F9FF;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 14px;
      line-height: 100%;
      white-space: nowrap;
    }

    .badge-status.status-completed  { color: #C8A000; }
    .badge-status.status-cancelled  { color: #D0021B; }
    .badge-status.status-inprogress { color: #1A7F3C; }
    .badge-status.status-upcoming   { color: #004271; }

    .badge-date {
      border-radius: 15px;
      border: 1px solid #004271;
      background: #004271;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 14px;
      line-height: 100%;
      color: #FFFFFF;
      flex: 1;
      text-align: center;
      white-space: nowrap;
    }

    .empty-msg {
      color: #aaa;
      font-size: 14px;
      text-align: center;
      margin-top: 30px;
    }

    /* ══════════════════════════════
       TABLET  ≥ 600px
    ══════════════════════════════ */
    @media (min-width: 600px) {
      .header { height: 110px; padding: 0 32px; gap: 18px; }
      .page-title { font-size: 22px; }

      .tabs-wrapper { padding: 22px 32px 0; gap: 12px; }
      .tab span { font-size: 15px; }

      .cards-area {
        padding: 22px 32px 40px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
      }
    }

    /* ══════════════════════════════
       DESKTOP  ≥ 1024px
    ══════════════════════════════ */
    @media (min-width: 1024px) {

      /* 
        The page is designed for 1440px.
        We use a wrapper that scales down on smaller viewports
        so nothing ever overflows.
      */
      body {
        min-height: 760px;
        position: relative;
      }

      .desktop-scaler {
        width: 1440px;
        min-height: 760px;
        position: relative;
        transform-origin: top left;
        /* JS sets the scale dynamically */
      }

      /* Header fills the scaler */
      .header {
        width: 1440px;
        height: 160px;
        padding: 0 40px;
        gap: 18px;
      }

      .page-title { font-size: 24px; }

      /* Tabs — Figma exact absolute positions */
      .tabs-wrapper {
        padding: 0;
        height: 0;
        overflow: visible;
        display: block;
      }

      .tab {
        position: absolute;
        top: 202px;
        width: 311px;
        height: 40px;
        flex: none;
      }
      .tab span { font-size: 18px; }

      #tab-inprogress { left: 40px; }
      #tab-upcoming   { left: 390px; }
      #tab-completed  { left: 740px; }
      #tab-cancelled  { left: 1090px; }

      /* Cards — absolute, JS sets left per active tab */
      .cards-area {
        position: absolute;
        top: 280px;
        width: 311px;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 20px;
      }

      .card { padding: 18px 12px 17px 12px; }
      .card-title { font-size: 18px; }
      .card-desc  { font-size: 14px; }
      .badge-status, .badge-date { font-size: 16px; }
    }
  </style>
</head>
<body>

  <!-- On desktop this wrapper is scaled to fit the viewport -->
  <div class="desktop-scaler" id="scaler">

    <!-- HEADER -->
    <div class="header">
      <div class="back-btn">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
          <path d="M15 18L9 12L15 6" stroke="#004271" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="page-title">My Bookings</div>
    </div>

    <!-- TABS -->
    <div class="tabs-wrapper">
      <div id="tab-inprogress" class="tab" onclick="switchTab('inprogress')"><span>In progress</span></div>
      <div id="tab-upcoming"   class="tab" onclick="switchTab('upcoming')"><span>Upcoming</span></div>
      <div id="tab-completed"  class="tab" onclick="switchTab('completed')"><span>Completed</span></div>
      <div id="tab-cancelled"  class="tab" onclick="switchTab('cancelled')"><span>Cancelled</span></div>
    </div>

    <!-- CARDS -->
    <div class="cards-area" id="cards-area"></div>

  </div><!-- /desktop-scaler -->

  <script>
    const TAB_LEFT = {
      inprogress: 40,
      upcoming:   390,
      completed:  740,
      cancelled:  1090
    };

    const data = {
      inprogress: [
        { title: "Sofa Deep Cleaning",  desc: "Professional deep cleaning for sofas and upholstery at your doorstep.", date: "Friday, Sep 28", status: "In progress" },
        { title: "Home Sanitization",   desc: "Complete home sanitization service to keep your space germ-free.",       date: "Friday, Sep 28", status: "In progress" }
      ],
      upcoming: [
        { title: "AC Servicing",    desc: "Expert AC maintenance and servicing for optimal cooling performance.", date: "Monday, Oct 7",   status: "Upcoming" },
        { title: "Plumbing Service",desc: "Reliable plumbing repairs and installations by certified professionals.",date: "Tuesday, Oct 8",  status: "Upcoming" }
      ],
      completed: [
        { title: "Laundry Collection",    desc: "Deep cleaning for sofas to remove dirt, stains, and odors.",         date: "Friday, Sep 28", status: "Completed" },
        { title: "Refrigerator Cleaning", desc: "At-home beauty and self-care services tailored just for you.",        date: "Friday, Sep 28", status: "Completed" }
      ],
      cancelled: [
        { title: "Disinfection Services", desc: "Convenient and thorough car cleaning services wherever you are.",     date: "Friday, Sep 28", status: "Cancelled" },
        { title: "Pest Control",          desc: "At-home beauty and self-care services tailored just for you.",        date: "Friday, Sep 28", status: "Cancelled" }
      ]
    };

    const STATUS_CLASS = {
      "Completed":   "status-completed",
      "Cancelled":   "status-cancelled",
      "In progress": "status-inprogress",
      "Upcoming":    "status-upcoming"
    };

    function serviceIcon() {
      return `<svg width="50" height="50" viewBox="0 0 56 56" fill="none">
        <circle cx="28" cy="15" r="9" fill="#7bb8cc"/>
        <rect x="16" y="27" width="24" height="18" rx="5" fill="#7bb8cc"/>
        <rect x="23" y="36" width="5" height="10" rx="1.5" fill="#004271"/>
        <rect x="11" y="33" width="7" height="13" rx="2" fill="#004271"/>
      </svg>`;
    }

    let currentTab = 'cancelled';

    function renderCards(tab) {
      const area  = document.getElementById('cards-area');
      const items = data[tab] || [];

      if (window.innerWidth >= 1024) {
        area.style.left = TAB_LEFT[tab] + 'px';
      } else {
        area.style.left = '';
        area.style.position = '';
      }

      if (!items.length) {
        area.innerHTML = `<p class="empty-msg">No bookings found.</p>`;
        return;
      }

      area.innerHTML = items.map(item => `
        <div class="card">
          <div class="card-top">
            <div class="card-img">${serviceIcon()}</div>
            <div class="card-info">
              <div class="card-title">${item.title}</div>
              <div class="card-desc">${item.desc}</div>
            </div>
          </div>
          <div class="card-divider"></div>
          <div class="card-footer">
            <div class="badge-status ${STATUS_CLASS[item.status] || ''}">${item.status}</div>
            <div class="badge-date">${item.date}</div>
          </div>
        </div>
      `).join('');
    }

    function switchTab(tab) {
      currentTab = tab;
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      document.getElementById('tab-' + tab).classList.add('active');
      renderCards(tab);
    }

    /* ── Scale the 1440px design to fit the actual viewport on desktop ── */
    function applyScale() {
      const scaler = document.getElementById('scaler');
      if (window.innerWidth >= 1024) {
        const scale = window.innerWidth / 1440;
        scaler.style.transform = `scale(${scale})`;
        // Height compensation so body doesn't leave empty space
        scaler.style.marginBottom = ((760 * scale) - 760) + 'px';
        document.body.style.height = (760 * scale) + 'px';
        // Re-position cards after scale change
        renderCards(currentTab);
      } else {
        scaler.style.transform = '';
        scaler.style.marginBottom = '';
        document.body.style.height = '';
        renderCards(currentTab);
      }
    }

    window.addEventListener('resize', applyScale);

    /* Init */
    switchTab('cancelled');
    applyScale();
  </script>
</body>
</html>
































{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Bookings</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Roboto:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      width: 100%;
      min-height: 100vh;
      background: #FFFFFF;
      font-family: 'Roboto', sans-serif;
    }

    /* ══════════════════════════════
       HEADER
    ══════════════════════════════ */
    .header {
      width: 100%;
      height: 80px;
      background: #E4F9FF;
      box-shadow: 0px 4px 4px 0px #00000040;
      display: flex;
      align-items: center;
      padding: 0 20px;
      gap: 14px;
    }

    .back-btn {
      width: 26px;
      height: 26px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      flex-shrink: 0;
    }

    .page-title {
      font-family: 'Libre Baskerville', serif;
      font-weight: 700;
      font-size: 18px;
      letter-spacing: 0.03em;
      color: #004271;
    }

    /* ══════════════════════════════
       TABS
    ══════════════════════════════ */
    .tabs-wrapper {
      width: 100%;
      padding: 18px 16px 0;
      display: flex;
      gap: 8px;
    }

    .tab {
      flex: 1;
      height: 40px;
      border-radius: 15px;
      border: 1px solid #004271;
      background: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      user-select: none;
      transition: background 0.2s;
    }

    .tab span {
      font-family: 'Roboto', sans-serif;
      font-weight: 300;
      font-size: 12px;
      letter-spacing: 0.04em;
      color: #004271;
      white-space: nowrap;
    }

    .tab.active { background: #004271; }
    .tab.active span { font-weight: 500; color: #FFFFFF; }

    /* ══════════════════════════════
       CARDS AREA
    ══════════════════════════════ */
    .cards-area {
      width: 100%;
      padding: 18px 16px 30px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    /* ── CARD ── */
    .card {
      background: #FFFFFF;
      border-radius: 15px;
      border: 1px solid #E4E4E4;
      box-shadow: 0px 4px 4px 0px #0000000A;
      padding: 14px 12px;
      width: 100%;
    }

    .card-top {
      display: flex;
      gap: 11px;
      margin-bottom: 14px;
    }

    /* Figma: 88×78, border-radius:15, border:1px solid #B5B5B5 */
    .card-img {
      width: 88px;
      height: 78px;
      border-radius: 15px;
      border: 1px solid #B5B5B5;
      flex-shrink: 0;
      background: #d0e8f0;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .card-info {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

    /* Figma: Roboto SemiBold 18px #004271 */
    .card-title {
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 18px;
      line-height: 100%;
      color: #004271;
      margin-bottom: 6px;
    }

    /* Figma: Roboto Regular 14px #353535 */
    .card-desc {
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 14px;
      line-height: 1.4;
      color: #353535;
    }

    /* Figma: 0.25px solid #004271 */
    .card-divider {
      height: 0;
      border: none;
      border-top: 0.25px solid #004271;
      margin-bottom: 14px;
    }

    .card-footer {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    /* Status badge — color changes per tab */
    .badge-status {
      border-radius: 15px;
      border: 1px solid #E4F9FF;
      background: #E4F9FF;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 16px;
      line-height: 100%;
      white-space: nowrap;
    }

    /* Status text colours per state */
    .badge-status.status-completed  { color: #C8A000; }
    .badge-status.status-cancelled  { color: #D0021B; }
    .badge-status.status-inprogress { color: #1A7F3C; }
    .badge-status.status-upcoming   { color: #004271; }

    /* Date badge */
    .badge-date {
      border-radius: 15px;
      border: 1px solid #004271;
      background: #004271;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 16px;
      line-height: 100%;
      color: #FFFFFF;
      flex: 1;
      text-align: center;
      white-space: nowrap;
    }

    .empty-msg {
      color: #aaa;
      font-size: 14px;
      text-align: center;
      margin-top: 30px;
    }

    /* ══════════════════════════════
       TABLET  ≥ 600px
    ══════════════════════════════ */
    @media (min-width: 600px) {
      .header { height: 110px; padding: 0 32px; gap: 18px; }
      .page-title { font-size: 22px; }

      .tabs-wrapper { padding: 22px 32px 0; gap: 12px; }
      .tab span { font-size: 15px; }

      .cards-area {
        padding: 22px 32px 40px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
      }

      .card-title { font-size: 17px; }
    }

    /* ══════════════════════════════
       DESKTOP  ≥ 1024px
    ══════════════════════════════ */
    @media (min-width: 1024px) {
      body {
        max-width: 1440px;
        margin: 0 auto;
        position: relative;
        min-height: 760px;
      }

      .header { height: 160px; padding: 0 40px; gap: 18px; }
      .page-title { font-size: 24px; }

      /* Tabs — Figma exact absolute positions */
      .tabs-wrapper {
        padding: 0;
        height: 0;
        overflow: visible;
        display: block;
      }

      .tab {
        position: absolute;
        top: 202px;
        width: 311px;
        height: 40px;
        flex: none;
      }
      .tab span { font-size: 18px; }

      #tab-inprogress { left: 40px; }
      #tab-upcoming   { left: 390px; }
      #tab-completed  { left: 740px; }
      #tab-cancelled  { left: 1090px; }

      /* Cards positioned under the ACTIVE tab */
      .cards-area {
        position: absolute;
        top: 280px;
        width: 311px;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 20px;
        /* left is set dynamically via JS */
      }

      .card { padding: 18px 12px 17px 12px; }
      .card-title { font-size: 18px; }
      .card-desc  { font-size: 14px; }
      .badge-status, .badge-date { font-size: 16px; }
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="header">
    <div class="back-btn">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
        <path d="M15 18L9 12L15 6" stroke="#004271" stroke-width="2.5"
              stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="page-title">My Bookings</div>
  </div>

  <!-- TABS -->
  <div class="tabs-wrapper">
    <div id="tab-inprogress" class="tab" onclick="switchTab('inprogress')"><span>In progress</span></div>
    <div id="tab-upcoming"   class="tab" onclick="switchTab('upcoming')"><span>Upcoming</span></div>
    <div id="tab-completed"  class="tab" onclick="switchTab('completed')"><span>Completed</span></div>
    <div id="tab-cancelled"  class="tab" onclick="switchTab('cancelled')"><span>Cancelled</span></div>
  </div>

  <!-- CARDS -->
  <div class="cards-area" id="cards-area"></div>

  <script>
    /* ── Tab → desktop left position (px) matching Figma ── */
    const TAB_LEFT = {
      inprogress: 40,
      upcoming:   390,
      completed:  740,
      cancelled:  1090
    };

    const data = {
      inprogress: [
        {
          title: "Sofa Deep Cleaning",
          desc:  "Professional deep cleaning for sofas and upholstery at your doorstep.",
          date:  "Friday, Sep 28",
          status: "In progress"
        },
        {
          title: "Home Sanitization",
          desc:  "Complete home sanitization service to keep your space germ-free.",
          date:  "Friday, Sep 28",
          status: "In progress"
        }
      ],
      upcoming: [
        {
          title: "AC Servicing",
          desc:  "Expert AC maintenance and servicing for optimal cooling performance.",
          date:  "Monday, Oct 7",
          status: "Upcoming"
        },
        {
          title: "Plumbing Service",
          desc:  "Reliable plumbing repairs and installations by certified professionals.",
          date:  "Tuesday, Oct 8",
          status: "Upcoming"
        }
      ],
      completed: [
        {
          title: "Laundry Collection",
          desc:  "Deep cleaning for sofas to remove dirt, stains, and odors.",
          date:  "Friday, Sep 28",
          status: "Completed"
        },
        {
          title: "Refrigerator Cleaning",
          desc:  "At-home beauty and self-care services tailored just for you.",
          date:  "Friday, Sep 28",
          status: "Completed"
        }
      ],
      cancelled: [
        {
          title: "Disinfection Services",
          desc:  "Convenient and thorough car cleaning services wherever you are.",
          date:  "Friday, Sep 28",
          status: "Cancelled"
        },
        {
          title: "Pest Control",
          desc:  "At-home beauty and self-care services tailored just for you.",
          date:  "Friday, Sep 28",
          status: "Cancelled"
        }
      ]
    };

    /* Status → CSS class */
    const STATUS_CLASS = {
      "Completed":  "status-completed",
      "Cancelled":  "status-cancelled",
      "In progress":"status-inprogress",
      "Upcoming":   "status-upcoming"
    };

    function serviceIcon() {
      return `<svg width="50" height="50" viewBox="0 0 56 56" fill="none">
        <circle cx="28" cy="15" r="9" fill="#7bb8cc"/>
        <rect x="16" y="27" width="24" height="18" rx="5" fill="#7bb8cc"/>
        <rect x="23" y="36" width="5" height="10" rx="1.5" fill="#004271"/>
        <rect x="11" y="33" width="7" height="13" rx="2" fill="#004271"/>
      </svg>`;
    }

    function renderCards(tab) {
      const area  = document.getElementById('cards-area');
      const items = data[tab] || [];

      /* On desktop: move cards under the active tab */
      if (window.innerWidth >= 1024) {
        area.style.left = TAB_LEFT[tab] + 'px';
      } else {
        area.style.left = '';
      }

      if (!items.length) {
        area.innerHTML = `<p class="empty-msg">No bookings found.</p>`;
        return;
      }

      area.innerHTML = items.map(item => `
        <div class="card">
          <div class="card-top">
            <div class="card-img">${serviceIcon()}</div>
            <div class="card-info">
              <div class="card-title">${item.title}</div>
              <div class="card-desc">${item.desc}</div>
            </div>
          </div>
          <div class="card-divider"></div>
          <div class="card-footer">
            <div class="badge-status ${STATUS_CLASS[item.status] || ''}">${item.status}</div>
            <div class="badge-date">${item.date}</div>
          </div>
        </div>
      `).join('');
    }

    function switchTab(tab) {
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      document.getElementById('tab-' + tab).classList.add('active');
      renderCards(tab);
    }

    /* On resize, reapply left position */
    window.addEventListener('resize', () => {
      const activeTab = document.querySelector('.tab.active');
      if (activeTab) {
        const id = activeTab.id.replace('tab-', '');
        renderCards(id);
      }
    });

    /* Default: Cancelled tab active (matching this Figma page) */
    switchTab('cancelled');
  </script>
</body>
</html> --}}