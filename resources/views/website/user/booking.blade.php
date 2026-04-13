{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Bookings</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      width: 1440px;
      min-height: 760px;
      background: #FFFFFF;
      font-family: 'Roboto', sans-serif;
      position: relative;
    }

    /* ── HEADER ── */
    .header {
      width: 1440px;
      height: 160px;
      background: #E4F9FF;
      box-shadow: 0px 4px 4px 0px #00000040;
      position: relative;
    }

    .back-btn {
      position: absolute;
      top: 54px;
      left: 40px;
      width: 26px;
      height: 52px;
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .page-title {
      position: absolute;
      top: 66px;
      left: 84px;
      width: 310px;
      height: 30px;
      font-family: 'Libre Baskerville', serif;
      font-weight: 700;
      font-size: 24px;
      line-height: 100%;
      letter-spacing: 3%;
      color: #004271;
      display: flex;
      align-items: center;
    }

    /* ── TABS ── */
    .tabs-container {
      position: relative;
      height: 60px;
      margin-top: 0;
    }

    .tab {
      position: absolute;
      top: 202px;
      width: 311px;
      height: 40px;
      border-radius: 15px;
      border: 1px solid #004271;
      background: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      user-select: none;
      transition: background 0.2s, color 0.2s;
    }

    .tab span {
      font-family: 'Roboto', sans-serif;
      font-weight: 300;
      font-size: 18px;
      line-height: 100%;
      letter-spacing: 0.05em;
      color: #004271;
    }

    .tab.active {
      background: #004271;
    }

    .tab.active span {
      font-weight: 500;
      color: #FFFFFF;
    }

    #tab-inprogress  { left: 40px; }
    #tab-upcoming    { left: 390px; }
    #tab-completed   { left: 740px; }
    #tab-cancelled   { left: 1090px; }

    /* ── CARDS AREA ── */
    .cards-area {
      position: absolute;
      top: 270px;
      left: 740px;
      width: 311px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .card {
      background: #FFFFFF;
      border-radius: 12px;
      border: 1px solid #e0e0e0;
      box-shadow: 0 1px 4px rgba(0,0,0,0.06);
      padding: 16px;
      width: 100%;
    }

    .card-top {
      display: flex;
      gap: 12px;
      margin-bottom: 12px;
    }

    .card-img {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      overflow: hidden;
      flex-shrink: 0;
      background: #d0e8f0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-info { flex: 1; }

    .card-title {
      font-family: 'Roboto', sans-serif;
      font-weight: 700;
      font-size: 16px;
      color: #004271;
      margin-bottom: 6px;
    }

    .card-desc {
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 13px;
      color: #555;
      line-height: 1.45;
    }

    .card-divider {
      height: 1px;
      background: #e0e0e0;
      margin-bottom: 12px;
    }

    .card-footer {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .badge-status {
      background: #E4F9FF;
      border-radius: 20px;
      padding: 6px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
      font-size: 14px;
      color: #C8A000;
      white-space: nowrap;
    }

    .badge-date {
      background: #004271;
      border-radius: 20px;
      padding: 6px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 500;
      font-size: 14px;
      color: #FFFFFF;
      flex: 1;
      text-align: center;
      white-space: nowrap;
    }

    .empty-msg {
      color: #aaa;
      font-size: 15px;
      text-align: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="header">
    <div class="back-btn">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
        <path d="M15 18L9 12L15 6" stroke="#004271" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="page-title">My Bookings</div>
  </div>

  <!-- TABS -->
  <div id="tab-inprogress"  class="tab" onclick="switchTab('inprogress')"><span>In progress</span></div>
  <div id="tab-upcoming"   class="tab" onclick="switchTab('upcoming')"><span>Upcoming</span></div>
  <div id="tab-completed"  class="tab active" onclick="switchTab('completed')"><span>Completed</span></div>
  <div id="tab-cancelled"  class="tab" onclick="switchTab('cancelled')"><span>Cancelled</span></div>

  <!-- CARDS AREA -->
  <div class="cards-area" id="cards-area"></div>

  <script>
    const data = {
      inprogress: [],
      upcoming: [],
      completed: [
        {
          title: "Laundry Collection",
          desc: "Deep cleaning for sofas to remove dirt, stains, and odors.",
          date: "Friday, Sep 28",
          status: "Completed"
        },
        {
          title: "Refrigerator Cleaning",
          desc: "At-home beauty and self-care services tailored just for you.",
          date: "Friday, Sep 28",
          status: "Completed"
        }
      ],
      cancelled: []
    };

    function serviceIcon() {
      return `<svg width="48" height="48" viewBox="0 0 48 48" fill="none">
        <circle cx="24" cy="13" r="7" fill="#7bb8cc"/>
        <rect x="14" y="23" width="20" height="16" rx="4" fill="#7bb8cc"/>
        <rect x="20" y="31" width="4" height="9" rx="1" fill="#004271"/>
        <rect x="10" y="29" width="6" height="11" rx="2" fill="#004271"/>
      </svg>`;
    }

    function renderCards(tab) {
      const area = document.getElementById('cards-area');
      const items = data[tab] || [];
      if (items.length === 0) {
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
            <div class="badge-status">${item.status}</div>
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

    // Init
    renderCards('completed');
  </script>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Bookings</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Roboto:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    html {
      overflow-x: hidden; /* kill horizontal scroll only */
    }

    body {
      width: 100%;
      min-height: 100vh;
      overflow-x: hidden;
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
      width: 26px; height: 26px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; flex-shrink: 0;
    }

    .page-title {
      font-family: 'Libre Baskerville', serif;
      font-weight: 700; font-size: 18px;
      letter-spacing: 0.03em; color: #004271;
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
      flex: 1; height: 40px;
      border-radius: 15px; border: 1px solid #004271;
      background: #FFFFFF;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; user-select: none;
      transition: background 0.2s;
    }

    .tab span {
      font-family: 'Roboto', sans-serif;
      font-weight: 300; font-size: 12px;
      letter-spacing: 0.04em; color: #004271;
      white-space: nowrap;
    }

    .tab.active { background: #004271; }
    .tab.active span { font-weight: 500; color: #FFFFFF; }

    /* ══════════════════════════════
       CARDS — mobile
    ══════════════════════════════ */
    .cards-area {
      width: 100%;
      padding: 18px 16px 30px;
      display: flex; flex-direction: column; gap: 16px;
    }

    .card {
      background: #FFFFFF;
      border-radius: 15px;
      border: 1px solid #E4E4E4;
      box-shadow: 0px 4px 4px 0px #0000000A;
      padding: 14px 12px;
      width: 100%;
    }

    .card-top { display: flex; gap: 11px; margin-bottom: 14px; }

    .card-img {
      width: 88px; height: 78px;
      border-radius: 15px; border: 1px solid #B5B5B5;
      flex-shrink: 0; background: #d0e8f0;
      display: flex; align-items: center; justify-content: center;
      overflow: hidden;
    }

    .card-info { flex: 1; display: flex; flex-direction: column; }

    .card-title {
      font-family: 'Roboto', sans-serif;
      font-weight: 600; font-size: 16px;
      line-height: 100%; color: #004271; margin-bottom: 6px;
    }

    .card-desc {
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 13px;
      line-height: 1.4; color: #353535;
    }

    .card-divider {
      height: 0; border: none;
      border-top: 0.25px solid #004271;
      margin-bottom: 14px;
    }

    .card-footer { display: flex; gap: 10px; align-items: center; }

    .badge-status {
      border-radius: 15px;
      border: 1px solid #E4F9FF; background: #E4F9FF;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 14px;
      white-space: nowrap;
    }

    .badge-status.status-completed  { color: #C8A000; }
    .badge-status.status-cancelled  { color: #D0021B; }
    .badge-status.status-inprogress { color: #1A7F3C; }
    .badge-status.status-upcoming   { color: #004271; }

    .badge-date {
      border-radius: 15px;
      border: 1px solid #004271; background: #004271;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 14px;
      color: #FFFFFF; flex: 1; text-align: center; white-space: nowrap;
    }

    .empty-msg {
      color: #aaa; font-size: 14px;
      text-align: center; margin-top: 30px;
    }

    /* ══════════════════════════════
       TABLET ≥ 600px
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
        gap: 20px; align-items: start;
      }
      .card-title { font-size: 17px; }
    }

    /* ══════════════════════════════
       DESKTOP ≥ 1024px
       Scale the 1440px canvas to fit
       viewport width — NO horizontal
       scroll. Vertical scroll is
       allowed naturally.
    ══════════════════════════════ */
    @media (min-width: 1024px) {

      /* scaler wraps everything, JS applies transform */
      #scaler {
        width: 1440px;
        position: relative;
        transform-origin: top left;
        /* height is auto so content is never clipped */
      }

      .header {
        width: 1440px;
        height: 160px;
        padding: 0 40px; gap: 18px;
      }

      .page-title { font-size: 24px; }

      .tabs-wrapper {
        padding: 0; height: 0;
        overflow: visible; display: block;
      }

      .tab {
        position: absolute; top: 202px;
        width: 311px; height: 40px; flex: none;
      }
      .tab span { font-size: 18px; }

      #tab-inprogress { left: 40px; }
      #tab-upcoming   { left: 390px; }
      #tab-completed  { left: 740px; }
      #tab-cancelled  { left: 1090px; }

      .cards-area {
        position: absolute;
        top: 280px; width: 311px;
        padding: 0;
        display: flex; flex-direction: column; gap: 20px;
      }

      .card { padding: 18px 12px 17px; }
      .card-title { font-size: 18px; }
      .card-desc  { font-size: 14px; }
      .badge-status, .badge-date { font-size: 16px; }
    }
  </style>
</head>
<body>
  <div id="scaler">

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
      <div id="tab-completed"  class="tab active" onclick="switchTab('completed')"><span>Completed</span></div>
      <div id="tab-cancelled"  class="tab" onclick="switchTab('cancelled')"><span>Cancelled</span></div>
    </div>

    <!-- CARDS -->
    <div class="cards-area" id="cards-area"></div>

  </div><!-- /scaler -->

  <script>
    const TAB_LEFT = {
      inprogress: 40,
      upcoming:   390,
      completed:  740,
      cancelled:  1090
    };

    const data = {
      inprogress: [],
      upcoming: [],
      completed: [
        { title: "Laundry Collection",    desc: "Deep cleaning for sofas to remove dirt, stains, and odors.",  date: "Friday, Sep 28", status: "Completed" },
        { title: "Refrigerator Cleaning", desc: "At-home beauty and self-care services tailored just for you.", date: "Friday, Sep 28", status: "Completed" }
      ],
      cancelled: []
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

    let currentTab = 'completed';

    function renderCards(tab) {
      const area  = document.getElementById('cards-area');
      const items = data[tab] || [];

      if (window.innerWidth >= 1024) {
        area.style.left = TAB_LEFT[tab] + 'px';
      } else {
        area.style.left = '';
      }

      area.innerHTML = items.length
        ? items.map(item => `
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
            </div>`).join('')
        : `<p class="empty-msg">No bookings found.</p>`;
    }

    function switchTab(tab) {
      currentTab = tab;
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      document.getElementById('tab-' + tab).classList.add('active');
      renderCards(tab);
    }

    function applyScale() {
      const scaler = document.getElementById('scaler');
      if (window.innerWidth >= 1024) {
        const scale = window.innerWidth / 1440;
        scaler.style.transform = `scale(${scale})`;
        /*
          After scale() the element still occupies its original 1440px
          layout space. We compensate the body height so the page
          height matches the SCALED height — this keeps the header
          visible and vertical scroll works naturally.
        */
        const scaledH = scaler.scrollHeight * scale;
        document.body.style.height = scaledH + 'px';
      } else {
        scaler.style.transform = '';
        document.body.style.height = '';
      }
      renderCards(currentTab);
    }

    window.addEventListener('resize', applyScale);
    switchTab('completed');
    applyScale();
  </script>
</body>
</html>