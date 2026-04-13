<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Bookings</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Roboto:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { overflow-x: hidden; }
    body {
      width: 100%; min-height: 100vh;
      overflow-x: hidden; background: #FFFFFF;
      font-family: 'Roboto', sans-serif;
    }

   /* HEADER */
.header {
  width: 100%; height: 80px;
  background: #E4F9FF;
  box-shadow: 0px 4px 4px 0px #00000040;
  display: flex; align-items: center;
  padding: 0 20px; gap: 14px;
}

.back-btn {
  width: 60px;      /* Changed from 26px to 40px */
  height: 60px;     /* Changed from 26px to 40px */
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; flex-shrink: 0;
}

.page-title {
  font-family: 'Libre Baskerville', serif;
  font-weight: 700; font-size: 18px;
  letter-spacing: 0.03em; color: #004271;
}
    /* TABS */
    .tabs-wrapper {
      width: 100%; padding: 18px 16px 0;
      display: flex; gap: 8px;
    }
    .tab {
      flex: 1; height: 40px;
      border-radius: 15px; border: 1px solid #004271;
      background: #FFFFFF;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; user-select: none; transition: background 0.2s;
    }
    .tab span {
      font-family: 'Roboto', sans-serif;
      font-weight: 300; font-size: 12px;
      letter-spacing: 0.04em; color: #004271; white-space: nowrap;
    }
    .tab.active { background: #004271; }
    .tab.active span { font-weight: 500; color: #FFFFFF; }

    /* CARDS */
    .cards-area {
      width: 100%; padding: 18px 16px 30px;
      display: flex; flex-direction: column; gap: 16px;
    }
    .card {
      background: #FFFFFF; border-radius: 15px;
      border: 1px solid #E4E4E4;
      box-shadow: 0px 4px 4px 0px #0000000A;
      padding: 14px 12px; width: 100%;
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
      color: #004271; margin-bottom: 6px;
    }
    .card-desc {
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 13px;
      line-height: 1.4; color: #353535;
    }
    .card-divider {
      height: 0; border: none;
      border-top: 0.25px solid #004271; margin-bottom: 14px;
    }
    .card-footer { display: flex; gap: 10px; align-items: center; }
    .badge-status {
      border-radius: 15px;
      border: 1px solid #E4F9FF; background: #E4F9FF;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 14px; white-space: nowrap;
    }
    .status-inprogress { color: #1A7F3C; }
    .status-upcoming   { color: #004271; }
    .status-completed  { color: #C8A000; }
    .status-cancelled  { color: #D0021B; }
    .badge-date {
      border-radius: 15px;
      border: 1px solid #004271; background: #004271;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 14px;
      color: #FFFFFF; flex: 1; text-align: center; white-space: nowrap;
    }
    .empty-msg { color: #aaa; font-size: 14px; text-align: center; margin-top: 30px; }

    /* TABLET */
    @media (min-width: 600px) {
      .header { height: 110px; padding: 0 32px; }
      .page-title { font-size: 22px; }
      .tabs-wrapper { padding: 22px 32px 0; gap: 12px; }
      .tab span { font-size: 15px; }
      .cards-area {
        padding: 22px 32px 40px;
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 20px; align-items: start;
      }
      .card-title { font-size: 17px; }
    }

    /* DESKTOP */
    @media (min-width: 1024px) {
      #scaler {
        width: 1440px; min-height: 760px;
        position: relative; transform-origin: top left;
      }
      .header { width: 1440px; height: 160px; padding: 0 40px; }
      .page-title { font-size: 24px; }
      .tabs-wrapper { padding: 0; height: 0; overflow: visible; display: block; }
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
        position: absolute; top: 280px; width: 311px;
        padding: 0; display: flex; flex-direction: column; gap: 20px;
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

  <div class="header">
    <div class="back-btn" onclick="window.location='{{ route('home') }}'">
      <!-- Updated size to match the CSS container -->
      <svg width="60" height="60" viewBox="0 0 24 24" fill="none">
        <path d="M15 18L9 12L15 6" stroke="#004271" stroke-width="1.5"
              stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="page-title">My Bookings</div>
</div>

  <div class="tabs-wrapper">
    <div id="tab-inprogress" class="tab" onclick="switchTab('inprogress')"><span>In Progress</span></div>
    <div id="tab-upcoming"   class="tab" onclick="switchTab('upcoming')"><span>Upcoming</span></div>
    <div id="tab-completed"  class="tab" onclick="switchTab('completed')"><span>Completed</span></div>
    <div id="tab-cancelled"  class="tab" onclick="switchTab('cancelled')"><span>Cancelled</span></div>
  </div>

  <div class="cards-area" id="cards-area"></div>

</div>

<script>
  const TAB_LEFT = { inprogress: 40, upcoming: 390, completed: 740, cancelled: 1090 };

  /* Exact data from all 4 screenshots */
  const data = {
    inprogress: [
      { title: "Home Deep Cleaning",     desc: "Comprehensive cleaning for a spotless and fresh home, done by expert professionals.", date: "Friday, Sep 28", status: "In Progress", cls: "status-inprogress" }
    ],
    upcoming: [
      { title: "Disinfection Services",  desc: "Convenient and thorough car cleaning services wherever you are.",                     date: "Friday, Sep 28", status: "Upcoming",     cls: "status-upcoming"   },
      { title: "Pest Control",           desc: "At-home beauty and self-care services tailored just for you.",                        date: "Friday, Sep 28", status: "Upcoming",     cls: "status-upcoming"   }
    ],
    completed: [
      { title: "Laundry Collection",     desc: "Deep cleaning for sofas to remove dirt, stains, and odors.",                         date: "Friday, Sep 28", status: "Completed",    cls: "status-completed"  },
      { title: "Refrigerator Cleaning",  desc: "At-home beauty and self-care services tailored just for you.",                        date: "Friday, Sep 28", status: "Completed",    cls: "status-completed"  }
    ],
    cancelled: [
      { title: "Disinfection Services",  desc: "Convenient and thorough car cleaning services wherever you are.",                     date: "Friday, Sep 28", status: "Cancelled",    cls: "status-cancelled"  },
      { title: "Pest Control",           desc: "At-home beauty and self-care services tailored just for you.",                        date: "Friday, Sep 28", status: "Cancelled",    cls: "status-cancelled"  }
    ]
  };

  function serviceIcon() {
    return `<img src="{{ asset('assets/images/booking.png') }}" alt="Service" style="width:100%;height:100%;object-fit:cover;border-radius:14px;" />`;
  }

  let currentTab = 'inprogress';

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
              <div class="badge-status ${item.cls}">${item.status}</div>
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
      document.body.style.height = (scaler.scrollHeight * scale) + 'px';
    } else {
      scaler.style.transform = '';
      document.body.style.height = '';
    }
    renderCards(currentTab);
  }

  window.addEventListener('resize', applyScale);
  switchTab('inprogress');
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
    html { overflow-x: hidden; }
    body {
      width: 100%; min-height: 100vh;
      overflow-x: hidden; background: #FFFFFF;
      font-family: 'Roboto', sans-serif;
    }

    /* HEADER */
    .header {
      width: 100%; height: 80px;
      background: #E4F9FF;
      box-shadow: 0px 4px 4px 0px #00000040;
      display: flex; align-items: center;
      padding: 0 20px; gap: 14px;
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

    /* TABS */
    .tabs-wrapper {
      width: 100%; padding: 18px 16px 0;
      display: flex; gap: 8px;
    }
    .tab {
      flex: 1; height: 40px;
      border-radius: 15px; border: 1px solid #004271;
      background: #FFFFFF;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; user-select: none; transition: background 0.2s;
    }
    .tab span {
      font-family: 'Roboto', sans-serif;
      font-weight: 300; font-size: 12px;
      letter-spacing: 0.04em; color: #004271; white-space: nowrap;
    }
    .tab.active { background: #004271; }
    .tab.active span { font-weight: 500; color: #FFFFFF; }

    /* CARDS */
    .cards-area {
      width: 100%; padding: 18px 16px 30px;
      display: flex; flex-direction: column; gap: 16px;
    }
    .card {
      background: #FFFFFF; border-radius: 15px;
      border: 1px solid #E4E4E4;
      box-shadow: 0px 4px 4px 0px #0000000A;
      padding: 14px 12px; width: 100%;
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
      color: #004271; margin-bottom: 6px;
    }
    .card-desc {
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 13px;
      line-height: 1.4; color: #353535;
    }
    .card-divider {
      height: 0; border: none;
      border-top: 0.25px solid #004271; margin-bottom: 14px;
    }
    .card-footer { display: flex; gap: 10px; align-items: center; }
    .badge-status {
      border-radius: 15px;
      border: 1px solid #E4F9FF; background: #E4F9FF;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 14px; white-space: nowrap;
    }
    .status-inprogress { color: #1A7F3C; }
    .status-upcoming   { color: #004271; }
    .status-completed  { color: #C8A000; }
    .status-cancelled  { color: #D0021B; }
    .badge-date {
      border-radius: 15px;
      border: 1px solid #004271; background: #004271;
      padding: 7px 18px;
      font-family: 'Roboto', sans-serif;
      font-weight: 400; font-size: 14px;
      color: #FFFFFF; flex: 1; text-align: center; white-space: nowrap;
    }
    .empty-msg { color: #aaa; font-size: 14px; text-align: center; margin-top: 30px; }

    /* TABLET */
    @media (min-width: 600px) {
      .header { height: 110px; padding: 0 32px; }
      .page-title { font-size: 22px; }
      .tabs-wrapper { padding: 22px 32px 0; gap: 12px; }
      .tab span { font-size: 15px; }
      .cards-area {
        padding: 22px 32px 40px;
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 20px; align-items: start;
      }
      .card-title { font-size: 17px; }
    }

    /* DESKTOP */
    @media (min-width: 1024px) {
      #scaler {
        width: 1440px; min-height: 760px;
        position: relative; transform-origin: top left;
      }
      .header { width: 1440px; height: 160px; padding: 0 40px; }
      .page-title { font-size: 24px; }
      .tabs-wrapper { padding: 0; height: 0; overflow: visible; display: block; }
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
        position: absolute; top: 280px; width: 311px;
        padding: 0; display: flex; flex-direction: column; gap: 20px;
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

  <div class="header">
    <div class="back-btn">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
        <path d="M15 18L9 12L15 6" stroke="#004271" stroke-width="2.5"
              stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="page-title">My Bookings</div>
  </div>

  <div class="tabs-wrapper">
    <div id="tab-inprogress" class="tab" onclick="switchTab('inprogress')"><span>In Progress</span></div>
    <div id="tab-upcoming"   class="tab" onclick="switchTab('upcoming')"><span>Upcoming</span></div>
    <div id="tab-completed"  class="tab" onclick="switchTab('completed')"><span>Completed</span></div>
    <div id="tab-cancelled"  class="tab" onclick="switchTab('cancelled')"><span>Cancelled</span></div>
  </div>

  <div class="cards-area" id="cards-area"></div>

</div>

<script>
  const TAB_LEFT = { inprogress: 40, upcoming: 390, completed: 740, cancelled: 1090 };

  /* Exact data from all 4 screenshots */
  const data = {
    inprogress: [
      { title: "Home Deep Cleaning",     desc: "Comprehensive cleaning for a spotless and fresh home, done by expert professionals.", date: "Friday, Sep 28", status: "In Progress", cls: "status-inprogress" }
    ],
    upcoming: [
      { title: "Disinfection Services",  desc: "Convenient and thorough car cleaning services wherever you are.",                     date: "Friday, Sep 28", status: "Upcoming",     cls: "status-upcoming"   },
      { title: "Pest Control",           desc: "At-home beauty and self-care services tailored just for you.",                        date: "Friday, Sep 28", status: "Upcoming",     cls: "status-upcoming"   }
    ],
    completed: [
      { title: "Laundry Collection",     desc: "Deep cleaning for sofas to remove dirt, stains, and odors.",                         date: "Friday, Sep 28", status: "Completed",    cls: "status-completed"  },
      { title: "Refrigerator Cleaning",  desc: "At-home beauty and self-care services tailored just for you.",                        date: "Friday, Sep 28", status: "Completed",    cls: "status-completed"  }
    ],
    cancelled: [
      { title: "Disinfection Services",  desc: "Convenient and thorough car cleaning services wherever you are.",                     date: "Friday, Sep 28", status: "Cancelled",    cls: "status-cancelled"  },
      { title: "Pest Control",           desc: "At-home beauty and self-care services tailored just for you.",                        date: "Friday, Sep 28", status: "Cancelled",    cls: "status-cancelled"  }
    ]
  };

  function serviceIcon() {
    return `<svg width="50" height="50" viewBox="0 0 56 56" fill="none">
      <circle cx="28" cy="15" r="9" fill="#7bb8cc"/>
      <rect x="16" y="27" width="24" height="18" rx="5" fill="#7bb8cc"/>
      <rect x="23" y="36" width="5" height="10" rx="1.5" fill="#004271"/>
      <rect x="11" y="33" width="7" height="13" rx="2" fill="#004271"/>
    </svg>`;
  }

  let currentTab = 'inprogress';

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
              <div class="badge-status ${item.cls}">${item.status}</div>
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
      document.body.style.height = (scaler.scrollHeight * scale) + 'px';
    } else {
      scaler.style.transform = '';
      document.body.style.height = '';
    }
    renderCards(currentTab);
  }

  window.addEventListener('resize', applyScale);
  switchTab('inprogress');
  applyScale();
</script>
</body>
</html> --}}