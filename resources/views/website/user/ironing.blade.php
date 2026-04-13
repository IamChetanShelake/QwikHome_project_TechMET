<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ironing – QwikHom</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Libre+Baskerville:wght@700&family=Roboto:wght@300;400;500;600;700&family=Poppins:wght@400&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet"/>
<style>
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { scroll-behavior:smooth; }
body { font-family:'Inter',sans-serif; background:#FFFFFF; color:#1a1a1a; font-size:15px; }
img { display:block; max-width:100%; }
a { text-decoration:none; color:inherit; }
button { font-family:'Inter',sans-serif; cursor:pointer; }

:root {
  --navy:    #0d3c4f;
  --blue-bg: #d6edf4;
  --blue-pale:#e4f2f7;
  --border:  #e2e8ed;
  --text:    #1a1a1a;
  --muted:   #6b7280;
  --page-max: 1440px;
  --page-px: clamp(16px, 4vw, 42px);
}

.band { width:100%; padding:0 var(--page-px); }
.band__inner { max-width:var(--page-max); margin:0 auto; padding:32px 0; }

/* ── HEADER ── */
.header { background:#E4F9FF; border-bottom:1px solid #c2dce6; position: relative;; top:0; z-index:200; padding:60px 40px; display:flex; align-items:center; gap:18px; box-shadow: 0px 4px 4px 0px #00000040; }
.header__back {
    width:60px;
    height:60px;
    background:none;
    border:none;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;

    position:absolute;
    top:10px;
    left:40px;
}
.header__back:hover { background:none; }
.header__back svg { width:60px; height:60px; stroke:var(--navy); stroke-width:1; fill:none; stroke-linecap:round; stroke-linejoin:round; }
.header__title {
    font-family:'Libre Baskerville', serif;
    font-size:24px;
    font-weight:700;
    line-height:1;
    letter-spacing:0.03em;
    color:#004271;

    width:310px;
    height:30px;

    position:absolute;
    top:25px;
    left:100px;
}
/* ── HERO ── */
.hero { display:flex; gap:40px; align-items:flex-start; padding:0 2px; }
.hero__img { width:618px; flex-shrink:0; height:377px; border-radius:15px; overflow:hidden; border:0.25px solid #B3B3B3; box-shadow:0px 4px 4px 0px rgba(0,0,0,0.09); }
.hero__img img { width:100%; height:100%; object-fit:cover; }
.hero__body { flex:1; display:flex; flex-direction:column; padding-top:4px; }
.hero__title { 
  font-family:'Roboto',sans-serif; 
  font-size:24px; 
  font-weight:500; 
  color:#004271; 
  letter-spacing:0.04em; 
  line-height:1; 
  margin-bottom:12px; /* top:258-202-28=28px gap */
}
.hero__tag { 
  font-family:'Roboto',sans-serif; 
  font-size:18px; 
  font-weight:400; 
  color:#353535; 
  line-height:1; /* Figma: 100% not 1.4 */
  letter-spacing:0;
  margin-bottom:24px; /* top:306-258-24=24px gap */
}
.price-row { display:flex; align-items:center; gap:16px; margin-bottom:20px; }
.price { 
  font-family:'Roboto',sans-serif; 
  font-size:20px; 
  font-weight:600; 
  color:#353535; /* Figma: #353535 not #1a1a1a */
  letter-spacing:0;
  line-height:1;
}
.qty { 
  display:flex; 
  align-items:center; 
  background:#E4F9FF; /* Figma: #E4F9FF not var(--blue-pale) */
  border-radius:10px; /* Figma: 10px not 8px */
  overflow:hidden; 
  height:33px; /* Figma: 32.77px ≈ 33px */
  width:111px; /* Figma: exact width */
}
.qty__btn { width:34px; height:34px; background:none; border:none; font-size:20px; font-weight:300; color:#444; display:flex; align-items:center; justify-content:center; transition:background .15s; }
.qty__btn:hover { background:rgba(0,0,0,.07); }
.qty__val { width:28px; text-align:center; font-size:14px; font-weight:600; color:var(--text); }
.hero__divider { 
  border:none; 
  border-top:0.5px solid #D1D1D1; /* Figma: 0.5px #D1D1D1 not 1px var(--border) */
  margin-bottom:18px; /* top:400-371=29px gap */
}
.about__title { 
  font-family:'Roboto',sans-serif; 
  font-size:24px; 
  font-weight:500; 
  color:#2D2D2D; 
  letter-spacing:0.04em; 
  line-height:1; 
  text-transform:capitalize; 
  margin-bottom:25px; /* top:453-400-28=25px gap */
}
.about__desc { 
  font-family:'Roboto',sans-serif; 
  font-size:18px; 
  font-weight:400; 
  color:#353535; 
  line-height:1; /* Figma: 100% not 1.5 */
  letter-spacing:0;
  margin-bottom:20px; /* top:550-453-77=20px gap */
}
.stars-row { 
  display:flex; 
  align-items:center; 
  gap:7px; /* left:844-700-123=21px — keep 7px visual gap */
}
.stars { 
  display:flex; 
  gap:3px; 
  width:123px; /* Figma: 122.99px */
  height:21px; /* Figma: 21.2px */
}
.star { 
  width:18px; 
  height:18px; 
  color:#6F6F6F; /* Figma: #6F6F6F for all */
}
.star--on { color:#6F6F6F; }
.star--off { 
  color:#6F6F6F; 
  opacity:0.3; 
}

.reviews { 
  font-family:'Poppins',sans-serif; /* Figma: Poppins not Inter */
  font-size:16px; /* Figma: 16px not 13px */
  font-weight:300; /* Figma: Light 300 */
  color:#353535; /* Figma: #353535 not var(--muted) */
  line-height:1;
  letter-spacing:0;
}
.section-title { font-family:'Roboto',sans-serif; font-size:24px; font-weight:500; color:#004271; letter-spacing:0.04em; line-height:1; margin-bottom:18px; }

/* ══════════════════════════
   SELECT REQUIREMENTS
══════════════════════════ */
.req__grid {
  display:grid;
  grid-template-columns:repeat(4, 1fr);
  gap:15px;
}
.req__col { position:relative; display:flex; flex-direction:column; gap:10px; }

/* TRIGGER */
.req__trigger {
  width:100%; height:40px;
  border:0.5px solid #818181; border-radius:8px;
  padding:0 12px 0 16px;
  font-family:'Roboto',sans-serif; font-size:18px; font-weight:400;
  color:#353535; background:#fff; outline:none;
  display:flex; align-items:center; justify-content:space-between; gap:8px;
  text-align:left; white-space:nowrap;
  transition:border-color .2s;
}
.req__trigger.locked { cursor:default; pointer-events:none; }
.req__trigger:not(.locked) { cursor:pointer; }
.req__trigger:not(.locked):hover { border-color:#004271; }
.req__trigger.is-open { border-color:#004271; }
.req__chevron {
  width:16px; height:16px; flex-shrink:0; pointer-events:none;
  background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E") no-repeat center/contain;
  transition:transform .25s;
}
.req__trigger.is-open .req__chevron { transform:rotate(180deg); }

/* PANEL BASE */
.req__panel { display:none; position:absolute; top:50px; left:0; z-index:400; box-shadow:0 8px 24px rgba(0,0,0,0.13); border-radius:8px; }
.req__panel.is-open { display:block; }

/* ══════════════════════════
   Q1 — PLAN PANEL
   Frame62: w329 h301 bg#fff
══════════════════════════ */
#panel-plan {
  width: 329px;
  height: 301px;
  background: #fff;
  overflow: hidden;
  position: absolute;
}

/* Inner scroll — Frame61: w243 h268 top19 left26 */
#panel-plan .plan-scroll {
  position: absolute;
  top: 19px;
  left: 26px;
  width: 243px;
  height: 268px;
  overflow-y: scroll;
  overflow-x: hidden;
  scrollbar-width: none;
}
#panel-plan .plan-scroll::-webkit-scrollbar { display:none; }

/* Custom scrollbar track — Rect281: w11 h262 top25 left299 r20 bg#A9A9A9 */
#panel-plan .plan-scrollbar-track {
  position: absolute;
  top: 25px;
  left: 299px;
  width: 11px;
  height: 262px;
  border-radius: 20px;
  background: #A9A9A9;
  overflow: hidden;
}
#panel-plan .plan-scrollbar-thumb {
  position: absolute;
  left: 0; top: 0;
  width: 11px;
  border-radius: 20px;
  background: #0d3c4f;
  transition: top 0.05s linear;
}

/* Q1 CARDS — UNSELECTED
   top: w230 h72 border-top-r15 border:1.5 #D1D1D1 bg#fff
   label: w230 h38 border-bottom-r15 bg#D1D1D1 border:1.5 #D1D1D1
   gap between cards: 25px
   left: 3px
   Total per card: 72+38+25 = 135px → 4 cards = 540px > 268px → scrolls ✓
*/
.plan-card {
  width: 230px;
  margin-left: 3px;
  margin-bottom: 25px;
  cursor: pointer;
  flex-shrink: 0;
  transition: opacity .15s;
}
.plan-card:last-child { margin-bottom: 8px; }
.plan-card:hover { opacity:.88; }
.plan-card__top {
  width: 230px;
  height: 72px;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
  border: 1.5px solid #D1D1D1;
  border-bottom: none;
  background: #fff;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  gap: 7px;
  box-sizing: border-box;
}
/* Roboto 400 14px #353535 */
.plan-card__desc {
  font-family:'Roboto',sans-serif;
  font-size:14px; font-weight:400;
  color:#353535; line-height:1; letter-spacing:0;
  text-align:center; margin:0;
}
/* Source Sans 3 600 16px #2D2D2D ls5% */
.plan-card__price {
  font-family:'Source Sans 3','Source Sans Pro',sans-serif;
  font-size:16px; font-weight:600;
  color:#2D2D2D; line-height:1; letter-spacing:0.05em;
  text-align:center; margin:0;
}
/* Roboto 400 16px #353535 bg#D1D1D1 */
.plan-card__label {
  width: 230px;
  height: 38px;
  border-bottom-left-radius: 15px;
  border-bottom-right-radius: 15px;
  border: 1.5px solid #D1D1D1;
  border-top: none;
  background: #D1D1D1;
  display: flex; align-items: center; justify-content: center;
  font-family:'Roboto',sans-serif;
  font-size:16px; font-weight:400;
  color:#353535; line-height:1; letter-spacing:0;
  text-align:center; box-sizing:border-box;
}

/* Q1 SELECTED — light blue top + navy label */
.sel-plan { cursor:pointer; width:100%; }
.sel-plan__top {
  border-top-left-radius:15px; border-top-right-radius:15px;
  border:1.5px solid #D1D1D1; border-bottom:none;
  background:#d6edf4;
  display:flex; flex-direction:column;
  align-items:center; justify-content:center;
  gap:7px; padding:10px; min-height:72px;
}
.sel-plan__desc { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; text-align:center; margin:0; }
.sel-plan__price { font-family:'Source Sans 3','Source Sans Pro',sans-serif; font-size:16px; font-weight:600; color:#2D2D2D; line-height:1; letter-spacing:0.05em; text-align:center; margin:0; }
.sel-plan__label {
  border-bottom-left-radius:15px; border-bottom-right-radius:15px;
  border:1.5px solid #004271; border-top:none;
  background:#004271; color:#fff;
  display:flex; align-items:center; justify-content:center;
  min-height:38px; padding:8px;
  font-family:'Roboto',sans-serif; font-size:16px; font-weight:400;
  line-height:1; text-align:center; letter-spacing:0;
}


/* ══════════════════════════
   Q2 — CLEANERS PANEL
   Rect892: w329 h295 bg#F2F2F2
   inner top27 left49
══════════════════════════ */
#panel-cleaners {
  width:329px; height:295px;
  background:#F2F2F2;
  padding:27px 0 0 49px;
  box-sizing:border-box;
}

/* Q2 PILLS — UNSELECTED: w230 h47 r15 border:1.5 #D1D1D1 bg#fff  Roboto 600 16px gap18 */
.cleaner-pill {
  width:230px; height:47px;
  border-radius:15px; border:1.5px solid #D1D1D1;
  background:#fff;
  display:flex; align-items:center; justify-content:center;
  margin-bottom:18px; cursor:pointer;
  font-family:'Roboto',sans-serif; font-size:16px; font-weight:600;
  color:#353535; line-height:1; letter-spacing:0; text-align:center;
  transition:background .15s, border-color .15s;
  box-sizing:border-box;
}
.cleaner-pill:last-child { margin-bottom:0; }
.cleaner-pill:hover { background:#e8f4f8; border-color:#aacfda; }

/* ── Q2 SELECTED ──
   Figma Rect704: w230 h77 r15 border:1.5 #D1D1D1 bg:#E4F9FF
   text: Roboto 600 16px #353535 centered
   top:824-795=29px → vertically centered in 77px ✓
*/
.sel-cleaners {
  width:100%; height:77px;
  border-radius:15px;
  border:1.5px solid #D1D1D1;
  background:#E4F9FF;                /* ← Figma exact */
  display:flex; align-items:center; justify-content:center;
  cursor:pointer;
  font-family:'Roboto',sans-serif; font-size:16px; font-weight:600;
  color:#353535; line-height:1; letter-spacing:0; text-align:center;
  box-sizing:border-box;
  transition:background .15s;
}
.sel-cleaners:hover { background:#c8f1fd; }


/* ══════════════════════════
   Q3 — HOURS PANEL
   Rect893: w329 h295 bg#F2F2F2
   inner top28 left50
══════════════════════════ */
#panel-hours {
  width:329px; height:295px;
  background:#F2F2F2;
  padding:28px 0 0 50px;
  box-sizing:border-box;
}

/* Q3 PILLS — UNSELECTED: w230 h47 r15 border:1.5 #D1D1D1 bg#fff val-left sub-right gap18 */
.hour-pill {
  width:230px; height:47px;
  border-radius:15px; border:1.5px solid #D1D1D1;
  background:#fff;
  display:flex; align-items:center; justify-content:space-between;
  padding:0 16px; margin-bottom:18px; cursor:pointer;
  transition:background .15s, border-color .15s;
  box-sizing:border-box;
}
.hour-pill:last-child { margin-bottom:0; }
.hour-pill:hover { background:#e8f4f8; border-color:#aacfda; }
/* Roboto 600 16px #353535 */
.hour-pill__val { font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; letter-spacing:0; }
/* Roboto 400 14px #353535 right */
.hour-pill__sub { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; letter-spacing:0; text-align:right; }

/* ── Q3 SELECTED ──
   Figma Group474: w230 h77 r15 border:1.5 #D1D1D1
   No bg fill specified → from screenshot = #E4F9FF (same light blue as Q2)
   val "1 hr": Roboto 600 16px #353535 — top:824-795=29px (centered)
   sub "AED 60/service": Roboto 400 14px #353535 right — top:826 (same row as val)
   → both on same horizontal line, space-between layout
*/
.sel-hours {
  width:100%; height:77px;
  border-radius:15px;
  border:1.5px solid #D1D1D1;
  background:#E4F9FF;                /* ← same light blue as Q2, confirmed by screenshot */
  display:flex; align-items:center; justify-content:space-between;
  padding:0 16px; cursor:pointer;
  transition:background .15s;
  box-sizing:border-box;
}
.sel-hours:hover { background:#c8f1fd; }
/* Roboto 600 16px #353535 */
.sel-hours__val { font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; letter-spacing:0; }
/* Roboto 400 14px #353535 right */
.sel-hours__sub { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; letter-spacing:0; text-align:right; }


/* ══════════════════════════
   Q4 — MATERIALS PANEL
   Rect893(Q4): w329 h227 bg#F2F2F2
   inner top18 left50
══════════════════════════ */
#panel-materials {
  width:329px; height:227px;
  background:#F2F2F2;
  padding:18px 0 0 50px;
  box-sizing:border-box;
}

/* Q4 CARDS — UNSELECTED: w230 h77 r15 border:1.5 #D1D1D1 bg#fff stacked center gap13 */
.material-card {
  width:230px; height:77px;
  border-radius:15px; border:1.5px solid #D1D1D1;
  background:#fff;
  display:flex; flex-direction:column;
  align-items:center; justify-content:center;
  gap:13px;
  margin-bottom:18px; cursor:pointer;
  transition:background .15s, border-color .15s;
  box-sizing:border-box;
}
.material-card:last-child { margin-bottom:0; }
.material-card:hover { background:#e8f4f8; border-color:#aacfda; }
/* Roboto 600 16px #353535 */
.material-card__title { font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; letter-spacing:0; text-align:center; margin:0; }
/* Roboto 400 14px #353535 */
.material-card__sub { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; letter-spacing:0; text-align:center; margin:0; }

/* ── Q4 SELECTED ──
   Figma Group473: w230 h77 r15 border:1.5 #D1D1D1
   No bg fill = white (confirmed by screenshot — bold white card)
   title "With Material": Roboto 600 16px #353535 — top:810-795=15px from top
   sub "+AED 10/service": Roboto 400 14px #353535 — top:842-795=47px from top
   Gap between: 842-810-19 = 13px → flex column gap:13px centered
*/
.sel-material {
  width:100%; height:77px;
  border-radius:15px;
  border:1.5px solid #D1D1D1;
  background:#E4F9FF;                   /* ← white, no fill, confirmed screenshot */
  display:flex; flex-direction:column;
  align-items:center; justify-content:center;
  gap:13px;
  cursor:pointer;
  transition:background .15s;
  box-sizing:border-box;
}
.sel-material:hover { background:#f5f5f5; }
/* Roboto 600 16px #353535 */
.sel-material__title { font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; letter-spacing:0; text-align:center; margin:0; }
/* Roboto 400 14px #353535 */
.sel-material__sub { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; letter-spacing:0; text-align:center; margin:0; }


/* ══════════════════════════
   REST OF PAGE
══════════════════════════ */
.process__labels { display:grid; grid-template-columns:repeat(4,1fr); text-align:center; margin-bottom:12px; }
.process__label { font-family:'Roboto',sans-serif; font-size:20px; font-weight:400; color:#353535; line-height:1; text-align:center; }
.process__timeline { display:flex; align-items:center; justify-content:space-between; position:relative; margin-bottom:24px; padding:0 36px; }
.step-circle { width:60px; height:60px; border-radius:50%; background:#004271; color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:700; position:relative; z-index:1; flex-shrink:0; border:1px solid #004271; }
.step-dash {
  flex: 1;
  height: 0;
  border-top: 2px dashed #004271;
  stroke-dasharray: 5, 5;
  margin: 0 2px;
  background: none;
  /* Replicate Figma 5,5 dash pattern */
  border-image: repeating-linear-gradient(
    90deg,
    #004271 0px,
    #004271 5px,
    transparent 5px,
    transparent 10px
  ) 1;
}
.process__grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
.proc-item { display:flex; flex-direction:column; align-items:center; gap:10px; }
.proc-item img { width:267px; height:178px; object-fit:cover; border-radius:15px; border:1px solid #999999; }
.proc-item p { font-family:'Roboto',sans-serif; font-size:18px; font-weight:300; color:#353535; text-align:center; line-height:1.5; width:260px; }
/* .included__list { display:flex; flex-wrap:wrap; align-items:center; gap:0 24px; }
.included__item { font-family:'Roboto',sans-serif; font-size:18px; font-weight:400; color:#353535; line-height:1; display:flex; align-items:center; gap:8px; white-space:nowrap; }
.included__item::before { content:'•'; color:#353535; font-size:16px; } */
.included-section { padding-top:32px; padding-bottom:32px; }
/* Adjusted gap to 20px to fit content perfectly in one row */
.included__list { display:flex; flex-wrap:nowrap; align-items:center; gap:20px; }
/* Reduced font-size to 16px to prevent overflow */
.included__item { font-family:'Roboto',sans-serif; font-size:16px; font-weight:400; color:#353535; line-height:1.2; display:flex; align-items:center; gap:8px; white-space:nowrap; flex-shrink:0; }
.included__item::before { content:'•'; color:#353535; font-size:14px; }


.need__grid { 
  display:grid; 
  grid-template-columns: 292px 292px 292px 293px; /* Figma: last card is 293px */
  gap:24px; /* left:397-41-292=63px... keep 24px for responsive */
  justify-content:start; 
}
.need-card { 
  width:100%; /* flex with grid column */
  height:260px; 
  border:1.5px solid #EAEAEA; 
  border-radius:12px; /* no border-radius in Figma — but keeping for visual */
  overflow:hidden; 
  display:flex; 
  flex-direction:column; 
  background:#fff; 
}
.need-card__img { 
  flex:1; 
  display:flex; 
  align-items:center; 
  justify-content:center; 
  padding:16px; 
  background:#fff; 
}
.need-card:nth-child(1) .need-card__img img { width:199px; height:151px; object-fit:contain; }
.need-card:nth-child(2) .need-card__img img { width:173px; height:148px; object-fit:contain; }
.need-card:nth-child(3) .need-card__img img { width:190px; height:165px; object-fit:contain; }
.need-card:nth-child(4) .need-card__img img { width:243px; height:150px; object-fit:contain; border-top-left-radius:15px; border-top-right-radius:15px; }
.need-card__label { 
  background:#EAEAEA; 
  width:100%; 
  height:74px; 
  display:flex; 
  align-items:center; 
  justify-content:center; 
  padding:0 16px; 
  border-bottom-left-radius:12px; /* match card radius */
  border-bottom-right-radius:12px; 
  font-family:'Roboto',sans-serif; 
  font-size:18px; 
  font-weight:300; 
  color:#030303; 
  text-align:center;
  line-height:1;
  letter-spacing:0;
}
.faq__item { width:100%; height:54px; background:#E4F9FF38; border:1px solid #004271; border-radius:15px; overflow:hidden; margin-bottom:12px; }
.faq__item.open { height:auto; }
.faq__q { width:100%; height:54px; background:#E4F9FF38; border:none; display:flex; justify-content:space-between; align-items:center; padding:0 20px 0 36px; font-family:'Roboto',sans-serif; font-size:18px; font-weight:400; color:#5B5B5B; text-align:left; gap:12px; }
.faq__plus { width:16px; height:15px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:400; color:#004271; transition:transform .25s; line-height:1; }
.faq__item.open .faq__plus { transform:rotate(45deg); }
.faq__a { display:none; padding:0 20px 16px 36px; font-family:'Poppins',sans-serif; font-size:14px; font-weight:400; color:#5B5B5B; line-height:1.7; }
.faq__item.open .faq__a { display:block; }
.bottom-bar { position:relative; bottom:0; z-index:150; background:#fff; padding:12px var(--page-px); }
.bottom-bar__inner { max-width:var(--page-max); margin:0 auto; display:flex; align-items:center; gap:12px; width:100%; }
.bottom-bar__cost { background:var(--navy); color:#fff; border:none; display:flex; align-items:center; justify-content: center; width: 252px; height: 55px; gap:14px; padding:12px 22px; font-size:14px; font-weight:600; white-space:nowrap; border-radius: 15px; box-sizing: border-box; }
.bottom-bar__cost-label { font-size:16px; color:#fff; font-weight:400; opacity:1; font-family: 'Roboto',sans-serif; line-height:1; letter-spacing: 0; }
.bottom-bar__done { 
  background:var(--blue-pale); 
  border:none; 
  font-family:'Roboto',sans-serif;
  font-size:18px; /* Figma: 18px not 14px */
  font-weight:600; /* Figma: SemiBold */
  color:#004271; /* Figma: #004271 exact */
  width:252px; 
  height:55px; 
  box-sizing:border-box; 
  display:flex; 
  align-items:center; 
  justify-content:center; 
  border-radius:15px; 
  transition:background .2s;
  line-height:1;
  letter-spacing:0;
}
.bottom-bar__cost span:last-child {
  font-family:'Roboto',sans-serif;
  font-size:18px; /* Figma: 18px not 14px */
  font-weight:600;
  color:#fff;
  line-height:1;
  letter-spacing:0;
}

.bottom-bar__done:hover { background:#c9e3ed; }
footer { 
  background: #E4F9FF; /* Figma: #E4F9FF not #d6edf4 */
  padding:48px var(--page-px) 0; 
}
.footer__inner { max-width:var(--page-max); margin:0 auto; }
.footer__top { display:grid; grid-template-columns:1fr 170px 200px; gap:clamp(24px,5vw,80px); padding-bottom:32px; }
.footer__logo { display:flex; flex-direction:column; margin-bottom:27px; }
.footer__tagline { font-family:'Libre Baskerville',serif; font-size:20px; font-weight:700; color:#2D2D2D; letter-spacing:0.05em; line-height:1; margin-bottom:16px; }
.footer__desc { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#2D2D2D; letter-spacing:0.07em; line-height:1; max-width:647px; }
.footer__col h5 { font-family:'Libre Baskerville',serif; font-size:16px; font-weight:700; color:#2D2D2D; letter-spacing:0.05em; line-height:1; margin-bottom:16px; }
.footer__col ul { list-style:none; }
.footer__col ul li { margin-bottom:20px; }
.footer__col ul li a { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#2D2D2D; letter-spacing:0.05em; line-height:1; text-transform:capitalize; display:flex; align-items:center; gap:10px; transition:color .15s; }
.footer__col ul li a:hover { color:#004271; }
.footer__col ul li a::before { content:''; display:inline-block; width:0; height:0; border-style:solid; border-width:5px 0 5px 7px; border-color:transparent transparent transparent #565656; flex-shrink:0; }
.footer__bottom { border-top:1.5px solid #004271; padding:18px 0; display:flex; justify-content:space-between; align-items:center; }
.footer__copy { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#2D2D2D; letter-spacing:0.05em; line-height:1; text-transform:capitalize; }
.footer__socials { display:flex; gap:20px; align-items:center; }
.social-btn { width:35px; height:35px; border-radius:50%; background:var(--navy); border:none; display:flex; align-items:center; justify-content:center; transition:opacity .2s; text-decoration:none; }
.social-btn:hover { opacity:.8; }
.social-btn svg { width:16px; height:16px; fill:#fff; }

/* RESPONSIVE */
@media (max-width:1024px) {
  .hero__img { width:42%; min-height:260px; }
  .req__grid { grid-template-columns:repeat(2,1fr); }
  .process__grid { grid-template-columns:repeat(2,1fr); }
  .process__labels { grid-template-columns:repeat(2,1fr); }
  .need__grid { grid-template-columns:repeat(2,1fr); }
  .footer__top { grid-template-columns:1fr 1fr; }
  #panel-plan, #panel-cleaners, #panel-hours, #panel-materials { width:100%; }
  .plan-card, .plan-card__top, .plan-card__label { width:100%; }
  .cleaner-pill, .hour-pill, .material-card { width:100%; }
}
@media (max-width:767px) {
  :root { --page-px:16px; }
  .header { height:58px; padding:0 16px; }
  .header__title { font-size:18px; }
  .hero { flex-direction:column; gap:16px; }
  .hero__img { width:100%; height:220px; }
  .req__grid { grid-template-columns:repeat(2,1fr); }
  .process__labels { grid-template-columns:repeat(2,1fr); }
  .step-circle { width:38px; height:38px; font-size:15px; }
  .process__grid { grid-template-columns:repeat(2,1fr); }
  .proc-item img { height:110px; }
  .included__list { flex-direction:column; gap:2px; }
  .need__grid { grid-template-columns:repeat(2,1fr); gap:10px; }
  .faq__q { font-size:13px; padding:13px 16px; }
  .bottom-bar__cost { padding:10px 16px; font-size:13px; }
  .bottom-bar__done { padding:10px 24px; font-size:13px; }
  .footer__top { grid-template-columns:1fr; gap:28px; }
  .footer__bottom { flex-direction:column; gap:14px; text-align:center; }
  #panel-cleaners, #panel-hours, #panel-materials { height:auto; padding:16px; }
}
@media (max-width:480px) {
  .req__grid { grid-template-columns:1fr; }
  .process__grid { grid-template-columns:1fr; }
  .process__labels { grid-template-columns:1fr; }
  .process__timeline { flex-direction:column; gap:10px; padding:0; }
}


/* ===== PROCESS SECTION FIX ===== */

.process__labels{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  text-align:center;
  margin-bottom:16px;
}

.process__label{
  font-family:'Roboto',sans-serif;
  font-size:20px;
  font-weight:400;
  color:#353535;
  text-align:center;
}

/* timeline alignment fix */
.process__timeline{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  align-items:center;
  position:relative;
  margin-bottom:24px;
  padding:0;
}

/* single dashed line */
.process__timeline::before{
  content:"";
  position:absolute;
  top:30px;
  left:calc(12.5% + 30px);
  right:calc(12.5% + 30px);
  border-top:2px dashed #004271;
  z-index:0;
}

/* circles */
.step-circle{
  width:60px;
  height:60px;
  border-radius:50%;
  background:#004271;
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:18px;
  font-weight:700;
  margin:auto;
  position:relative;
  z-index:1;
}

/* hide old dash elements */
.step-dash{
  display:none;
}
</style>
</head>
<body>

<header class="header">
  <button class="header__back" aria-label="Back"
        onclick="window.location='{{ route('coreservices.page') }}'">
    <svg viewBox="0 0 24 24">
        <path d="M15 19l-7-7 7-7"/>
    </svg>
</button>
  <span class="header__title">Ironing</span>
</header>

<div class="band">
  <div class="band__inner">
    <div class="hero">
      <div class="hero__img">
        <img src="{{ asset('assets/images/image.png') }}" alt="Ironing Service"
             onerror="this.src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=700&q=80';this.onerror=null;"/>
      </div>
      <div class="hero__body">
        <h2 class="hero__title">Ironing</h2>
        <p class="hero__tag">Wrinkle-free clothes, crisp and neat – ready to wear anytime.</p>
        <div class="price-row">
          <span class="price">AED 4,99</span>
          <div class="qty">
            <button class="qty__btn" onclick="changeQty(-1)" aria-label="Decrease">−</button>
            <span class="qty__val" id="qty">1</span>
            <button class="qty__btn" onclick="changeQty(1)" aria-label="Increase">+</button>
          </div>
        </div>
        <hr class="hero__divider"/>
        <p class="about__title">About The Service</p>
        <p class="about__desc">Say goodbye to wrinkles and creases! Our professional ironing service ensures your clothes look crisp, neat, and perfectly pressed – ready to wear for work, casual outings, or special occasions.</p>
        <div class="stars-row">
          <div class="stars">
            <svg class="star star--on" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <svg class="star star--on" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <svg class="star star--on" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <svg class="star star--on" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <svg class="star star--off" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          </div>
          <span class="reviews">(30 k reviews)</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SELECT REQUIREMENTS -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">Select Requirements</h2>
      <div class="req__grid">

        <!-- Q1: PLAN -->
        <div class="req__col">
          <button class="req__trigger" id="trig-plan" type="button" onclick="togglePanel('plan')">
            <span>Pick a Plan That Fits You</span>
            <span class="req__chevron"></span>
          </button>
          <div id="sel-plan" style="display:none;">
            <div class="sel-plan" onclick="togglePanel('plan')">
              <div class="sel-plan__top">
                <p class="sel-plan__desc" id="sel-plan-desc"></p>
                <p class="sel-plan__price" id="sel-plan-price"></p>
              </div>
              <div class="sel-plan__label" id="sel-plan-label"></div>
            </div>
          </div>
          <div class="req__panel" id="panel-plan">
            <div class="plan-scroll" id="planScroll">
              <div class="plan-card" onclick="selectPlan(this)" data-desc="For quick, one-time service" data-price="AED 1,999" data-label="One -Time Quick Fix">
                <div class="plan-card__top">
                  <p class="plan-card__desc">For quick, one-time service</p>
                  <p class="plan-card__price">AED 1,999</p>
                </div>
                <div class="plan-card__label">One -Time Quick Fix</div>
              </div>
              <div class="plan-card" onclick="selectPlan(this)" data-desc="Short-term plan with weekly savings" data-price="AED 3,999" data-label="QwikCare Weekly">
                <div class="plan-card__top">
                  <p class="plan-card__desc">Short-term plan with weekly savings</p>
                  <p class="plan-card__price">AED 3,999</p>
                </div>
                <div class="plan-card__label">QwikCare Weekly</div>
              </div>
              <div class="plan-card" onclick="selectPlan(this)" data-desc="Best value monthly subscription" data-price="AED 9,999" data-label="QwikCare Monthly">
                <div class="plan-card__top">
                  <p class="plan-card__desc">Best value monthly subscription</p>
                  <p class="plan-card__price">AED 9,999</p>
                </div>
                <div class="plan-card__label">QwikCare Monthly</div>
              </div>
              <div class="plan-card" onclick="selectPlan(this)" data-desc="Long-term plan with max savings" data-price="AED 14,999" data-label="QwikCare Annual">
                <div class="plan-card__top">
                  <p class="plan-card__desc">Long-term plan with max savings</p>
                  <p class="plan-card__price">AED 14,999</p>
                </div>
                <div class="plan-card__label">QwikCare Annual</div>
              </div>
            </div>
            <div class="plan-scrollbar-track">
              <div class="plan-scrollbar-thumb" id="planThumb"></div>
            </div>
          </div>
        </div>

        <!-- Q2: CLEANERS -->
        <div class="req__col">
          <button class="req__trigger locked" id="trig-cleaners" type="button" onclick="togglePanel('cleaners')">
            <span>How many cleaners do you need?</span>
            <span class="req__chevron"></span>
          </button>
          <!-- SELECTED: #E4F9FF bg, h77 r15, Roboto 600 16px centered -->
          <div id="sel-cleaners" style="display:none;">
            <div class="sel-cleaners" id="sel-cleaners-card" onclick="togglePanel('cleaners')"></div>
          </div>
          <div class="req__panel" id="panel-cleaners">
            <button class="cleaner-pill" onclick="selectCleaner(this)" data-val="1 cleaner" type="button">1 cleaner</button>
            <button class="cleaner-pill" onclick="selectCleaner(this)" data-val="2 cleaners" type="button">2 cleaners</button>
            <button class="cleaner-pill" onclick="selectCleaner(this)" data-val="3 cleaners" type="button">3 cleaners</button>
            <button class="cleaner-pill" onclick="selectCleaner(this)" data-val="4 cleaners" type="button">4 cleaners</button>
          </div>
        </div>

        <!-- Q3: HOURS -->
        <div class="req__col">
          <button class="req__trigger locked" id="trig-hours" type="button" onclick="togglePanel('hours')">
            <span>How many hours should they stay?</span>
            <span class="req__chevron"></span>
          </button>
          <!-- SELECTED: #E4F9FF bg, h77 r15, val left Roboto 600 16px + sub right Roboto 400 14px -->
          <div id="sel-hours" style="display:none;">
            <div class="sel-hours" onclick="togglePanel('hours')">
              <span class="sel-hours__val" id="sel-hours-val"></span>
              <span class="sel-hours__sub" id="sel-hours-sub"></span>
            </div>
          </div>
          <div class="req__panel" id="panel-hours">
            <button class="hour-pill" onclick="selectHours(this)" data-val="1 hr" data-sub="AED 60/service" type="button">
              <span class="hour-pill__val">1 hr</span><span class="hour-pill__sub">AED 60/service</span>
            </button>
            <button class="hour-pill" onclick="selectHours(this)" data-val="1.5 hrs" data-sub="AED 80/service" type="button">
              <span class="hour-pill__val">1.5 hrs</span><span class="hour-pill__sub">AED 80/service</span>
            </button>
            <button class="hour-pill" onclick="selectHours(this)" data-val="2 hrs" data-sub="AED 100/service" type="button">
              <span class="hour-pill__val">2 hrs</span><span class="hour-pill__sub">AED 100/service</span>
            </button>
            <button class="hour-pill" onclick="selectHours(this)" data-val="3 hrs" data-sub="AED 150/service" type="button">
              <span class="hour-pill__val">3 hrs</span><span class="hour-pill__sub">AED 150/service</span>
            </button>
          </div>
        </div>

        <!-- Q4: MATERIALS -->
        <div class="req__col">
          <button class="req__trigger locked" id="trig-materials" type="button" onclick="togglePanel('materials')">
            <span>Do you need cleaning materials?</span>
            <span class="req__chevron"></span>
          </button>
          <!-- SELECTED: white bg, h77 r15, title Roboto 600 16px + sub Roboto 400 14px stacked centered gap13 -->
          <div id="sel-materials" style="display:none;">
            <div class="sel-material" onclick="togglePanel('materials')">
              <div class="sel-material__title" id="sel-material-val"></div>
              <div class="sel-material__sub" id="sel-material-sub"></div>
            </div>
          </div>
          <div class="req__panel" id="panel-materials">
            <div class="material-card" onclick="selectMaterial(this)" data-val="With Material" data-sub="+AED 10/service">
              <div class="material-card__title">With Material</div>
              <div class="material-card__sub">+AED 10/service</div>
            </div>
            <div class="material-card" onclick="selectMaterial(this)" data-val="Without Material" data-sub="+AED 10/service">
              <div class="material-card__title">Without Material</div>
              <div class="material-card__sub">+AED 10/service</div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
</div>

<!-- OUR PROCESS -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">Our Process</h2>
      <div class="process__labels">
        <span class="process__label">Book Service</span>
        <span class="process__label">We Arrive</span>
        <span class="process__label">At-Home Ironing</span>
        <span class="process__label">Ready to Wear</span>
      </div>
      <div class="process__timeline">
        <div class="step-circle">1</div><div class="step-dash"></div>
        <div class="step-circle">2</div><div class="step-dash"></div>
        <div class="step-circle">3</div><div class="step-dash"></div>
        <div class="step-circle">4</div>
      </div>
      <div class="process__grid">
        <div class="proc-item">
          <img src="{{ asset('assets/images/image 55.png') }}" alt="Book Service" onerror="this.src='https://placehold.co/400x150/e8f2f6/0d3c4f?text=App';this.onerror=null;"/>
          <p>Schedule ironing at your preferred time through the app.</p>
        </div>
        <div class="proc-item">
          <img src="{{ asset('assets/images/image 54.png') }}" alt="We Arrive" onerror="this.src='https://placehold.co/400x150/e8f2f6/0d3c4f?text=Arrive';this.onerror=null;"/>
          <p>Our professional staff comes to your doorstep with all essentials.</p>
        </div>
        <div class="proc-item">
          <img src="{{ asset('assets/images/image 56.png') }}" alt="At-Home Ironing" onerror="this.src='https://placehold.co/400x150/e8f2f6/0d3c4f?text=Ironing';this.onerror=null;"/>
          <p>Clothes are ironed neatly at your place, hassle-free.</p>
        </div>
        <div class="proc-item">
          <img src="{{ asset('assets/images/image 57 (1).png') }}" alt="Ready to Wear" onerror="this.src='https://placehold.co/400x150/e8f2f6/0d3c4f?text=Done';this.onerror=null;"/>
          <p>Crisp, wrinkle-free outfits handed over instantly.</p>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- WHAT'S INCLUDED -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">What's Includes?</h2>
      <div class="included__list">
        <span class="included__item">Professional at-home ironing</span>
        <span class="included__item">Use of safe, quality equipment</span>
        <span class="included__item">Neat folding/hanging after ironing</span>
        <span class="included__item">Quick service with zero hassle</span>
        <span class="included__item">Clothes ready to wear instantly</span>
      </div>
    </section>
  </div>
</div>

<!-- WHAT WE NEED FROM YOU -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">What We Need From You</h2>
      <div class="need__grid">
        <div class="need-card">
          <div class="need-card__img"><img src="{{ asset('assets/images/image 57.png') }}" alt="Clean clothes" onerror="this.src='https://cdn-icons-png.flaticon.com/128/2088/2088617.png';this.onerror=null;"/></div>
          <div class="need-card__label">Clean clothes, ready to iron</div>
        </div>
        <div class="need-card">
          <div class="need-card__img"><img src="{{ asset('assets/images/image 58.png') }}" alt="Ironing board" onerror="this.src='https://cdn-icons-png.flaticon.com/128/1792/1792931.png';this.onerror=null;"/></div>
          <div class="need-card__label">Ironing board or flat surface</div>
        </div>
        <div class="need-card">
          <div class="need-card__img"><img src="{{ asset('assets/images/image 59.png') }}" alt="Electricity" onerror="this.src='https://cdn-icons-png.flaticon.com/128/3050/3050177.png';this.onerror=null;"/></div>
          <div class="need-card__label">Access to electricity</div>
        </div>
        <div class="need-card">
          <div class="need-card__img"><img src="{{ asset('assets/images/image 37.png') }}" alt="Fabric instructions" onerror="this.src='https://cdn-icons-png.flaticon.com/128/1067/1067244.png';this.onerror=null;"/></div>
          <div class="need-card__label">Delicate fabric instructions</div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- FAQ -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">Frequently asked questions</h2>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)"><span>1. Do I need to provide an iron?</span><span class="faq__plus">+</span></button>
        <div class="faq__a">No, our professionals bring their own high-quality steam iron. You just need to provide an ironing board or a flat surface.</div>
      </div>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)"><span>2. How much space do you need for ironing?</span><span class="faq__plus">+</span></button>
        <div class="faq__a">A standard ironing board space (roughly 1.5m × 0.5m) is sufficient. We can also use a large flat table if needed.</div>
      </div>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)"><span>3.&nbsp; How long does the service take?</span><span class="faq__plus">+</span></button>
        <div class="faq__a">It depends on the number of items. Typically, 10–15 items take about 1 hour. We'll give a more accurate estimate when you book.</div>
      </div>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)"><span>4.  How is this different from deep cleaning?</span><span class="faq__plus">+</span></button>
        <div class="faq__a">Ironing focuses solely on pressing and de-wrinkling your clothes, while deep cleaning is a comprehensive home cleaning service.</div>
      </div>
    </section>
  </div>
</div>

<!-- STICKY BOTTOM BAR -->
<div class="bottom-bar">
  <div class="bottom-bar__inner">
    <button class="bottom-bar__cost">
      <span class="bottom-bar__cost-label">Service Cost</span>
      <span>AED 4,99</span>
    </button>
    <button class="bottom-bar__done">Done</button>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer__inner">
    <div class="footer__top">
      <div class="footer__brand">
        <div class="footer__logo">
          <img src="{{ asset('assets/images/logo.png') }}" alt="QwikHom Logo" style="max-width:180px;height:auto;" onerror="this.style.display='none'"/>
        </div>
        <p class="footer__tagline">Comfort Delivered to Your Home</p>
        <p class="footer__desc">Experience seamless, reliable, and professional solutions for all your home needs. Our trusted experts arrive at your doorstep to handle tasks with care, efficiency, and attention to detail. With easy booking, quick support, and quality you can count on, we make everyday living simpler, smoother, and stress-free.</p>
      </div>
      <div class="footer__col">
        <h5>Quick Links</h5>
        <ul>
          <li><a href="#">About Us</a></li><li><a href="#">Services</a></li>
          <li><a href="#">How It Works</a></li><li><a href="#">Book A Service</a></li>
          <li><a href="#">Offers &amp; Campaigns</a></li><li><a href="#">Download App</a></li>
        </ul>
      </div>
      <div class="footer__col">
        <h5>Legal</h5>
        <ul>
          <li><a href="#">Terms &amp; Conditions</a></li><li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Cancellation &amp; Refund Policy</a></li><li><a href="#">Help &amp; Support</a></li>
          <li><a href="#">Careers</a></li><li><a href="#">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <div class="footer__bottom">
      <span class="footer__copy">Copyright</span>
      <div class="footer__socials">
        <a href="#" class="social-btn" aria-label="Facebook"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
        <a href="#" class="social-btn" aria-label="Instagram"><svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="#fff" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="#fff" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1" fill="#fff"/></svg></a>
        <a href="#" class="social-btn" aria-label="YouTube"><svg viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#0d3c4f"/></svg></a>
      </div>
    </div>
  </div>
</footer>

<script>
function changeQty(d) {
  var el = document.getElementById('qty');
  var v = parseInt(el.textContent) + d;
  if (v < 1) v = 1;
  el.textContent = v;
}

function toggleFaq(btn) {
  var item = btn.closest('.faq__item');
  var wasOpen = item.classList.contains('open');
  document.querySelectorAll('.faq__item.open').forEach(function(i){ i.classList.remove('open'); });
  if (!wasOpen) item.classList.add('open');
}

function closeAllPanels() {
  ['plan','cleaners','hours','materials'].forEach(function(key) {
    var p = document.getElementById('panel-' + key);
    var t = document.getElementById('trig-' + key);
    if (p) p.classList.remove('is-open');
    if (t) t.classList.remove('is-open');
  });
}

function togglePanel(key) {
  var trig  = document.getElementById('trig-' + key);
  var panel = document.getElementById('panel-' + key);
  if (!trig || !panel) return;
  if (trig.classList.contains('locked')) return;
  var isOpen = panel.classList.contains('is-open');
  closeAllPanels();
  if (!isOpen) {
    panel.classList.add('is-open');
    trig.classList.add('is-open');
    if (key === 'plan') setTimeout(syncPlanThumb, 10);
  }
}

function unlockNext(key) {
  var order = ['plan','cleaners','hours','materials'];
  var idx = order.indexOf(key);
  if (idx < order.length - 1) {
    var next = document.getElementById('trig-' + order[idx + 1]);
    if (next) next.classList.remove('locked');
  }
}

/* Q1 */
function selectPlan(card) {
  document.getElementById('sel-plan-desc').textContent  = card.dataset.desc;
  document.getElementById('sel-plan-price').textContent = card.dataset.price;
  document.getElementById('sel-plan-label').textContent = card.dataset.label;
  document.getElementById('sel-plan').style.display = 'block';
  closeAllPanels();
  unlockNext('plan');
}

/* Q2 — selected card: #E4F9FF bg, text centered Roboto 600 16px */
function selectCleaner(btn) {
  document.getElementById('sel-cleaners-card').textContent = btn.dataset.val;
  document.getElementById('sel-cleaners').style.display = 'block';
  closeAllPanels();
  unlockNext('cleaners');
}

/* Q3 — selected card: #E4F9FF bg, val left + sub right on same row */
function selectHours(btn) {
  document.getElementById('sel-hours-val').textContent = btn.dataset.val;
  document.getElementById('sel-hours-sub').textContent = btn.dataset.sub;
  document.getElementById('sel-hours').style.display = 'block';
  closeAllPanels();
  unlockNext('hours');
}

/* Q4 — selected card: white bg, title + sub stacked centered */
function selectMaterial(card) {
  document.getElementById('sel-material-val').textContent = card.dataset.val;
  document.getElementById('sel-material-sub').textContent = card.dataset.sub;
  document.getElementById('sel-materials').style.display = 'block';
  closeAllPanels();
}

/* ── Q1 SCROLLBAR SYNC ──
   4 cards × (72+38+25)px = 540px total content
   scrollFrame h=268px → scrollable range = 540−268 = 272px → thumb will move
*/
function syncPlanThumb() {
  var scroll = document.getElementById('planScroll');
  var thumb  = document.getElementById('planThumb');
  if (!scroll || !thumb) return;
  var trackH = 262;
  var scrollH = scroll.scrollHeight;
  var clientH = scroll.clientHeight;
  if (scrollH <= clientH) {
    thumb.style.height = trackH + 'px';
    thumb.style.top = '0px';
    return;
  }
  var ratio   = scroll.scrollTop / (scrollH - clientH);
  var thumbH  = Math.max(40, (clientH / scrollH) * trackH);
  thumb.style.height = thumbH + 'px';
  thumb.style.top    = (ratio * (trackH - thumbH)) + 'px';
}

document.addEventListener('DOMContentLoaded', function() {
  var scroll = document.getElementById('planScroll');
  if (scroll) {
    scroll.addEventListener('scroll', syncPlanThumb);
  }
  setTimeout(syncPlanThumb, 150);
});

document.addEventListener('click', function(e) {
  if (!e.target.closest('.req__col')) closeAllPanels();
});
</script>
</body>
</html>


































{{-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ironing – QwikHom</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Libre+Baskerville:wght@700&family=Roboto:wght@300;400;500;600&family=Poppins:wght@400&display=swap" rel="stylesheet"/>
<style>
/* ── RESET ── */
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { scroll-behavior:smooth; }
body { font-family:'Inter',sans-serif; background:#fff; color:#1a1a1a; font-size:15px; }
img { display:block; max-width:100%; }
a { text-decoration:none; color:inherit; }
button { font-family:'Inter',sans-serif; cursor:pointer; }

/* ── CSS VARIABLES ── */
:root {
  --navy:    #0d3c4f;
  --navy-lt: #1a5570;
  --blue-bg: #d6edf4;
  --blue-pale:#e4f2f7;
  --border:  #e2e8ed;
  --text:    #1a1a1a;
  --muted:   #6b7280;
  --gold:    #f59e0b;
  --page-max:1160px;
  --page-px: clamp(16px, 4vw, 60px);
}

/* ══════════════════════════════
   BAND PATTERN  (like footer)
   Every section = full-width band
   Content capped at --page-max
══════════════════════════════ */
.band {
  width: 100%;
  padding: 0 var(--page-px);
}
.band__inner {
  max-width: var(--page-max);
  margin: 0 auto;
  padding: 32px 0;
}

/* ── HEADER ── */
.header {
  background: var(--blue-bg);
  border-bottom: 1px solid #c2dce6;
  position: sticky; top: 0; z-index: 200;
  padding: 0 40px;
  height: 80px;
  display: flex; align-items: center; gap: 18px;
}
.header__back {
  width: 26px; height: 52px;
  background: none; border: none;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.header__back:hover { background: rgba(13,60,79,.1); }
.header__back svg { width:20px; height:20px; stroke:var(--navy); stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round; }
.header__title {
  font-family: 'Libre Baskerville', serif;
  font-size: 24px;
  font-weight: 700;
  color: var(--navy);
  letter-spacing: 0.03em;
  line-height: 1;
}

/* ══════════════════════════════
   SECTION 1 — HERO
══════════════════════════════ */
.hero {
  display: flex;
  gap: 40px;
  align-items: flex-start;
  background: transparent;
  box-shadow: none;
  border-radius: 0;
  overflow: visible;
  padding: 0 2px;
}
.hero__img {
  width: 618px;
  flex-shrink: 0;
  height: 377px;
  border-radius: 15px;
  overflow: hidden;
  border: 0.25px solid #B3B3B3;
  box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.09);
}
.hero__img img { width:100%; height:100%; object-fit:cover; }
.hero__body {
  flex: 1;
  display: flex; flex-direction: column;
  padding-top: 4px;
}
.hero__title {
  font-family: 'Roboto', sans-serif;
  font-size: 24px; font-weight: 500;
  color: #1a1a1a;
  letter-spacing: 0.04em;
  line-height: 1;
  margin-bottom: 12px;
}
.hero__tag {
  font-family: 'Roboto', sans-serif;
  font-size: 18px; font-weight: 400;
  color: #353535;
  letter-spacing: 0; line-height: 1.4;
  margin-bottom: 20px;
}

/* price + qty */
.price-row { display:flex; align-items:center; gap:16px; margin-bottom:20px; }
.price {
  font-family: 'Roboto', sans-serif;
  font-size: 20px; font-weight: 600;
  color: #1a1a1a; letter-spacing: 0;
}
.qty {
  display:flex; align-items:center;
  background: var(--blue-pale);
  border-radius: 8px; overflow:hidden; height:34px;
}
.qty__btn {
  width:34px; height:34px; background:none; border:none;
  font-size:20px; font-weight:300; color:#444;
  display:flex; align-items:center; justify-content:center;
  transition: background .15s;
}
.qty__btn:hover { background: rgba(0,0,0,.07); }
.qty__val { width:28px; text-align:center; font-size:14px; font-weight:600; color:var(--text); }

.hero__divider { border:none; border-top:1px solid var(--border); margin-bottom:18px; }

.about__title {
  font-family: 'Roboto', sans-serif;
  font-size: 24px; font-weight: 500;
  color: #2D2D2D;
  letter-spacing: 0.04em; line-height: 1;
  text-transform: capitalize;
  margin-bottom: 10px;
}
.about__desc {
  font-family: 'Roboto', sans-serif;
  font-size: 18px; font-weight: 400;
  color: #353535;
  letter-spacing: 0; line-height: 1.5;
  margin-bottom: 20px;
}

/* stars */
.stars-row { display:flex; align-items:center; gap:7px; }
.stars { display:flex; gap:3px; }
.star { width:18px; height:18px; }
.star--on  { color: #6F6F6F; }
.star--off { color: #6F6F6F; opacity: 0.3; }
.reviews   { font-size:13px; color:var(--muted); }

/* ══════════════════════════════
   SECTION 2 — SELECT REQUIREMENTS
══════════════════════════════ */
.section-title {
  font-family: 'Roboto', sans-serif;
  font-size: 24px; font-weight: 500;
  color: #004271;
  letter-spacing: 0.04em; line-height: 1;
  margin-bottom: 18px;
}
.req__row {
  display: flex; flex-wrap: wrap; gap: 16px;
}
.req__drop {
  flex: 1; min-width: 200px; position: relative;
}
.req__drop select {
  width: 100%; appearance: none;
  height: 40px;
  border: 0.5px solid #818181;
  border-radius: 8px;
  padding: 0 36px 0 16px;
  font-family: 'Roboto', sans-serif;
  font-size: 14px; font-weight: 400;
  color: #353535;
  background: #fff; outline: none;
  cursor: pointer; transition: border-color .2s;
}
.req__drop select:focus { border-color: #004271; }
.req__drop::after {
  content:'';
  position:absolute; right:13px; top:50%; transform:translateY(-50%);
  pointer-events:none; width:16px; height:16px;
  background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E") no-repeat center/contain;
}

/* ══════════════════════════════
   SECTION 3 — OUR PROCESS
══════════════════════════════ */
.process__labels {
  display:grid; grid-template-columns:repeat(4,1fr);
  text-align:center; margin-bottom:12px;
}
.process__label {
  font-family: 'Roboto', sans-serif;
  font-size: 20px;
  font-weight: 400;
  color: #353535;
  letter-spacing: 0;
  line-height: 1;
  text-align: center;
}

.process__timeline {
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
  margin-bottom: 24px;
  padding: 0 36px;
}
.process__timeline::before {
  display: none;   /* remove old single line — we use gaps between circles instead */
}

.step-circle {
  width: 60px;                      /* exact Figma */
  height: 60px;                     /* exact Figma */
  border-radius: 50%;
  background: var(--navy);
  color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; font-weight: 700;
  position: relative; z-index: 1;
  flex-shrink: 0;
  border: 1px solid #004271;        /* exact Figma */
}

/* dashed lines between circles */
.step-dash {
  flex: 1;
  height: 0;
  border-top: 2px dashed #004271;   /* exact Figma */
  margin: 0 2px;
}

.process__grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
.proc-item { display:flex; flex-direction:column; align-items:center; gap:10px; }
.proc-item img {
  width: 267px;                     /* exact Figma */
  height: 178px;                    /* exact Figma */
  object-fit: cover;
  border-radius: 15px;              /* exact Figma */
  border: 1px solid #999999;        /* exact Figma */
}
.proc-item p {
  font-family: 'Roboto', sans-serif;
  font-size: 18px;                  /* exact Figma */
  font-weight: 300;                 /* Light */
  color: #353535;                   /* exact Figma */
  text-align: center;
  line-height: 1.5;
  letter-spacing: 0;
  width: 260px;                     /* exact Figma */
}
/* ══════════════════════════════
   SECTION 4 — WHAT'S INCLUDED
══════════════════════════════ */
.included__list {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0 24px;
}
.included__item {
  font-family: 'Roboto', sans-serif;
  font-size: 18px;              /* exact Figma */
  font-weight: 400;
  color: #353535;               /* exact Figma */
  letter-spacing: 0;
  line-height: 1;
  display: flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
}
.included__item::before {
  content: '•';
  color: #353535;
  font-size: 16px;
}

/* ══════════════════════════════
   SECTION 5 — WHAT WE NEED
══════════════════════════════ */
.need__grid {
  display: grid;
  grid-template-columns: repeat(4, 292px);   /* exact Figma width */
  gap: 24px;                                  /* left:397 - left:41 - width:292 = ~64px... use visual gap */
  justify-content: start;
}
.need-card {
  width: 292px;                        /* exact Figma width */
  height: 260px;                       /* exact Figma height */
  border: 1.5px solid #EAEAEA;         /* exact Figma border */
  border-radius: 12px;
  overflow: hidden;
  display: flex; flex-direction: column;
  background: #fff;
}
/* shared container stays same */
.need-card__img {
  flex: 1;
  display: flex; align-items: center; justify-content: center;
  padding: 16px;
  background: #fff;
}

/* individual image sizes */
.need-card:nth-child(1) .need-card__img img {
  width: 199px;
  height: 151px;
  object-fit: contain;
}

.need-card:nth-child(2) .need-card__img img {
  width: 173px;
  height: 148px;
  object-fit: contain;
}

.need-card:nth-child(3) .need-card__img img {
  width: 190px;
  height: 165px;
  object-fit: contain;
}

.need-card:nth-child(4) .need-card__img img {
  width: 243px;
  height: 150px;
  object-fit: contain;
  border-top-left-radius: 15px;    /* exact Figma */
  border-top-right-radius: 15px;   /* exact Figma */
}

.need-card__label {
  background: #EAEAEA;                    /* exact Figma color */
  width: 100%;
  height: 74px;                           /* exact Figma height */
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 16px;
  border-bottom-left-radius: 15px;        /* exact Figma */
  border-bottom-right-radius: 15px;       /* exact Figma */
  font-family: 'Roboto', sans-serif;
  font-size: 18px;                        /* exact Figma */
  font-weight: 300;                       /* Light */
  color: #030303;                         /* exact Figma */
  letter-spacing: 0;
  line-height: 1;
  text-align: center;
}

/* ══════════════════════════════
   SECTION 6 — FAQ
══════════════════════════════ */
.faq__item {
  width: 100%;
  height: 54px;                        /* exact Figma */
  background: #E4F9FF38;               /* exact Figma */
  border: 1px solid #004271;           /* exact Figma */
  border-radius: 15px;                 /* exact Figma */
  overflow: hidden;
  margin-bottom: 12px;
}
.faq__item.open {
  height: auto;                        /* expand when open */
}
.faq__q {
  width: 100%;
  height: 54px;
  background: #E4F9FF38;
  border: none;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px 0 36px;             /* left padding matches Figma left:80-42=38px */
  font-family: 'Roboto', sans-serif;
  font-size: 18px;                     /* exact Figma */
  font-weight: 400;
  color: #5B5B5B;                      /* exact Figma */
  letter-spacing: 0;
  text-align: left;
  gap: 12px;
}
.faq__plus {
  width: 16px;                         /* exact Figma */
  height: 15px;                        /* exact Figma */
  flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
  font-weight: 400;
  color: #004271;                      /* exact Figma */
  transition: transform .25s;
  line-height: 1;
}
.faq__item.open .faq__plus {
  transform: rotate(45deg);
}
.faq__a {
  display: none;
  padding: 0 20px 16px 36px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 400;
  color: #5B5B5B;
  line-height: 1.7;
}
.faq__item.open .faq__a { display: block; }

/* ══════════════════════════════
   STICKY BOTTOM BAR
══════════════════════════════ */
.bottom-bar {
  position:sticky; bottom:0; z-index:150;
  background:#fff;
  border-top: none;
  padding:12px var(--page-px);
}
.bottom-bar__inner {
  max-width: var(--page-max);
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 12px;        /* gap between the two buttons */
  width: 100%;
}
.bottom-bar__cost {
  background: var(--navy); color: #fff; border: none;
  display: flex; align-items: center; gap: 14px;
  padding: 12px 22px;
  font-size: 14px; font-weight: 600;
  white-space: nowrap;
  border-radius: 8px;    /* all corners rounded — separate button */
}
.bottom-bar__cost-label { font-size:11px; font-weight:400; opacity:.8; }
.bottom-bar__done {
  background: var(--blue-pale); border: none;
  font-size: 14px; font-weight: 600; color: var(--navy);
  padding: 12px 60px;
  border-radius: 8px;    /* all corners rounded — separate button */
  transition: background .2s;
}
.bottom-bar__done:hover { background: #c9e3ed; }

/* ══════════════════════════════
   FOOTER
══════════════════════════════ */
footer {
  background:var(--blue-bg);
  padding:48px var(--page-px) 0;
}
.footer__inner {
  max-width:var(--page-max);
  margin:0 auto;
}
.footer__top {
  display:grid;
  grid-template-columns:1fr 170px 200px;
  gap:clamp(24px,5vw,80px);
  padding-bottom:32px;
}
.footer__logo { display:flex; flex-direction:column; margin-bottom:20px; }
.footer__logo-name {
  font-size:26px; font-weight:800;
  color:var(--text); letter-spacing:-0.5px; line-height:1;
}
.footer__logo-name span { font-style:italic; }
.footer__logo-sub {
  font-size:9px; letter-spacing:3px; text-transform:uppercase;
  color:var(--muted); margin-top:3px; margin-left:2px;
}
.footer__tagline {
  font-family: 'Libre Baskerville', serif;
  font-size: 20px;
  font-weight: 700;
  color: #2D2D2D;
  letter-spacing: 0.05em;    /* 5% */
  line-height: 1;
  margin-bottom: 12px;
}
.footer__desc {
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
  font-weight: 400;
  color: #2D2D2D;
  letter-spacing: 0.07em;    /* 7% */
  line-height: 1.6;
  max-width: 647px;
}
.footer__col h5 {
  font-family: 'Libre Baskerville', serif;   /* exact Figma */
  font-size: 16px;                            /* exact Figma */
  font-weight: 700;
  color: #2D2D2D;                             /* exact Figma */
  letter-spacing: 0.05em;                     /* 5% */
  line-height: 1;
  margin-bottom: 16px;
}
.footer__col ul { list-style:none; }
.footer__col ul li {
  margin-bottom: 20px;    /* gap between items: top:2534 - top:2504 = 30px approx */
}
.footer__col ul li a {
  font-family: 'Roboto', sans-serif;          /* exact Figma */
  font-size: 14px;                            /* exact Figma */
  font-weight: 400;
  color: #2D2D2D;                             /* exact Figma */
  letter-spacing: 0.05em;                     /* 5% */
  line-height: 1;
  text-transform: capitalize;                 /* exact Figma */
  display: flex;
  align-items: center;
  gap: 10px;
  transition: color .15s;
}
.footer__col ul li a:hover { color: #004271; }
.footer__col ul li a::before {
  content: '';
  display: inline-block;
  width: 0; height: 0;
  border-style: solid;
  border-width: 5px 0 5px 7px;
  border-color: transparent transparent transparent #565656;  /* exact Figma polygon color */
  flex-shrink: 0;
}
.footer__bottom {
  border-top: 1.5px solid #004271;    /* exact Figma: color #004271, width 1.5px */
  padding: 18px 0;
  display: flex; justify-content: space-between; align-items: center;
}
.footer__copy {
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
  font-weight: 400;
  color: #2D2D2D;
  letter-spacing: 0.05em;    /* 5% */
  line-height: 1;
  text-transform: capitalize;
}
.footer__socials {
  display: flex;
  gap: 20px;                      /* left:1273 - left:1218 - width:35 = 20px exact */
  align-items: center;
}
.social-btn {
  width: 35px;                    /* exact Figma */
  height: 35px;                   /* exact Figma */
  border-radius: 50%;
  background: var(--navy);
  border: none;
  display: flex; align-items: center; justify-content: center;
  transition: opacity .2s;
  text-decoration: none;
}
.social-btn:hover { opacity: .8; }
.social-btn svg { width: 16px; height: 16px; fill: #fff; }

/* ══════════════════════════════
   RESPONSIVE
══════════════════════════════ */
/* Tablet ≤ 1024px */
@media (max-width:1024px) {
  .hero__img { width:42%; min-height:260px; }
  .process__grid { grid-template-columns:repeat(2,1fr); }
  .process__labels { grid-template-columns:repeat(2,1fr); }
  .process__timeline { padding:0 20px; }
  .process__timeline::before { left:40px; right:40px; }
  .need__grid { grid-template-columns:repeat(2,1fr); }
  .footer__top { grid-template-columns:1fr 1fr; }
  .footer__brand { grid-column:1/-1; }
}

/* Mobile ≤ 767px */
@media (max-width:767px) {
  :root { --page-px:16px; }
  .header { height:58px; padding:0 16px; }
  .header__title { font-size:18px; }
  .hero { flex-direction:column; gap:16px; }
  .hero__img { width:100%; height:220px; }
  .req__drop { min-width:calc(50% - 8px); }
  .process__labels { grid-template-columns:repeat(2,1fr); }
  .process__timeline { padding:0 10px; }
  .process__timeline::before { left:28px; right:28px; }
  .step-circle { width:38px; height:38px; font-size:15px; }
  .process__grid { grid-template-columns:repeat(2,1fr); }
  .proc-item img { height:110px; }
  .included__list { flex-direction:column; gap:2px; }
  .need__grid { grid-template-columns:repeat(2,1fr); gap:10px; }
  .need-card__img { min-height:100px; padding:16px; }
  .need-card__img img { width:65px; height:65px; }
  .faq__q { font-size:13px; padding:13px 16px; }
  .bottom-bar__cost { padding:10px 16px; font-size:13px; }
  .bottom-bar__done { padding:10px 24px; font-size:13px; }
  .footer__top { grid-template-columns:1fr; gap:28px; }
  .footer__logo-name { font-size:22px; }
  .footer__bottom { flex-direction:column; gap:14px; text-align:center; }
}

/* Small ≤ 480px */
@media (max-width:480px) {
  .req__drop { min-width:100%; }
  .process__grid { grid-template-columns:1fr; }
  .process__labels { grid-template-columns:1fr; }
  .process__timeline { flex-direction:column; gap:10px; padding:0; }
  .process__timeline::before { display:none; }
}
</style>
</head>
<body>

<!-- ══════════════════════════
     HEADER
══════════════════════════ -->
<header class="header">
  <button class="header__back" aria-label="Back">
    <svg viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
  </button>
  <span class="header__title">Ironing</span>
</header>

<!-- ══════════════════════════
     HERO
══════════════════════════ -->
<div class="band">
  <div class="band__inner">
    <div class="hero">
      <div class="hero__img">
        <img
          src="{{ asset('assets/images/image.png') }}"
          alt="Ironing Service"
          onerror="this.src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=700&q=80';this.onerror=null;"
        />
      </div>
      <div class="hero__body">
        <h2 class="hero__title">Ironing</h2>
        <p class="hero__tag">Wrinkle-free clothes, crisp and neat – ready to wear anytime.</p>
        <div class="price-row">
          <span class="price">AED 4,99</span>
          <div class="qty">
            <button class="qty__btn" onclick="changeQty(-1)" aria-label="Decrease">−</button>
            <span class="qty__val" id="qty">1</span>
            <button class="qty__btn" onclick="changeQty(1)" aria-label="Increase">+</button>
          </div>
        </div>
        <hr class="hero__divider"/>
        <p class="about__title">About The Service</p>
        <p class="about__desc">Say goodbye to wrinkles and creases! Our professional ironing service ensures your clothes look crisp, neat, and perfectly pressed – ready to wear for work, casual outings, or special occasions.</p>
        <div class="stars-row">
          <div class="stars">
            <svg class="star star--on" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <svg class="star star--on" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <svg class="star star--on" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <svg class="star star--on" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <svg class="star star--off" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          </div>
          <span class="reviews">(30 k reviews)</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════
     SELECT REQUIREMENTS
══════════════════════════ -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">Select Requirements</h2>
      <div class="req__row">
        <div class="req__drop">
          <select><option>Pick a Plan That Fits You</option><option>Standard Plan</option><option>Premium Plan</option></select>
        </div>
        <div class="req__drop">
          <select><option>How many cleaners do you need?</option><option>1 Cleaner</option><option>2 Cleaners</option><option>3 Cleaners</option></select>
        </div>
        <div class="req__drop">
          <select><option>How many hours should they stay?</option><option>1 Hour</option><option>2 Hours</option><option>3 Hours</option></select>
        </div>
        <div class="req__drop">
          <select><option>Do you need cleaning materials?</option><option>Yes</option><option>No</option></select>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- ══════════════════════════
     OUR PROCESS
══════════════════════════ -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">Our Process</h2>
      <div class="process__labels">
        <span class="process__label" style="text-align:center">Book Service</span>
        <span class="process__label" style="text-align:center">We Arrive</span>
        <span class="process__label" style="text-align:center">At-Home Ironing</span>
        <span class="process__label" style="text-align:center">Ready to Wear</span>
      </div>
     <div class="process__timeline">
     <div class="step-circle">1</div>
     <div class="step-dash"></div>
     <div class="step-circle">2</div>
     <div class="step-dash"></div>
     <div class="step-circle">3</div>
     <div class="step-dash"></div>
     <div class="step-circle">4</div>
     </div>
      <div class="process__grid">
        <div class="proc-item">
          <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&q=75" alt="Book Service"
               onerror="this.src='https://placehold.co/400x150/e8f2f6/0d3c4f?text=App';this.onerror=null;"/>
          <p>Schedule ironing at your preferred time through the app.</p>
        </div>
        <div class="proc-item">
          <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=400&q=75" alt="We Arrive"
               onerror="this.src='https://placehold.co/400x150/e8f2f6/0d3c4f?text=Arrive';this.onerror=null;"/>
          <p>Our professional staff comes to your doorstep with all essentials.</p>
        </div>
        <div class="proc-item">
          <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&q=75" alt="At-Home Ironing"
               onerror="this.src='https://placehold.co/400x150/e8f2f6/0d3c4f?text=Ironing';this.onerror=null;"/>
          <p>Clothes are ironed neatly at your place, hassle-free.</p>
        </div>
        <div class="proc-item">
          <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=400&q=75" alt="Ready to Wear"
               onerror="this.src='https://placehold.co/400x150/e8f2f6/0d3c4f?text=Done';this.onerror=null;"/>
          <p>Crisp, wrinkle-free outfits handed over instantly.</p>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- ══════════════════════════
     WHAT'S INCLUDED
══════════════════════════ -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">What's Includes?</h2>
      <div class="included__list">
        <span class="included__item">Professional at-home ironing</span>
        <span class="included__item">Use of safe, quality equipment</span>
        <span class="included__item">Neat folding/hanging after ironing</span>
        <span class="included__item">Quick service with zero hassle</span>
        <span class="included__item">Clothes ready to wear instantly</span>
      </div>
    </section>
  </div>
</div>

<!-- ══════════════════════════
     WHAT WE NEED FROM YOU
══════════════════════════ -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">What We Need From You</h2>
      <div class="need__grid">
        <div class="need-card">
          <div class="need-card__img">
            <img src="{{ asset('assets/images/image 57.png') }}" alt="Clean clothes"
                 onerror="this.src='https://cdn-icons-png.flaticon.com/128/2088/2088617.png';this.onerror=null;"/>
          </div>
          <div class="need-card__label">Clean clothes, ready to iron</div>
        </div>
        <div class="need-card">
          <div class="need-card__img">
            <img src="{{ asset('assets/images/image 58.png') }}" alt="Ironing board"
                 onerror="this.src='https://cdn-icons-png.flaticon.com/128/1792/1792931.png';this.onerror=null;"/>
          </div>
          <div class="need-card__label">Ironing board or flat surface</div>
        </div>
        <div class="need-card">
          <div class="need-card__img">
            <img src="{{ asset('assets/images/image 59.png') }}" alt="Electricity"
                 onerror="this.src='https://cdn-icons-png.flaticon.com/128/3050/3050177.png';this.onerror=null;"/>
          </div>
          <div class="need-card__label">Access to electricity</div>
        </div>
        <div class="need-card">
          <div class="need-card__img">
            <img src="{{ asset('assets/images/image 37.png') }}" alt="Fabric instructions"
                 onerror="this.src='https://cdn-icons-png.flaticon.com/128/1067/1067244.png';this.onerror=null;"/>
          </div>
          <div class="need-card__label">Delicate fabric instructions</div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- ══════════════════════════
     FAQ
══════════════════════════ -->
<div class="band">
  <div class="band__inner">
    <section>
      <h2 class="section-title">Frequently asked questions</h2>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)">
          <span>1. Do I need to provide an iron?</span>
          <span class="faq__plus">+</span>
        </button>
        <div class="faq__a">No, our professionals bring their own high-quality steam iron. You just need to provide an ironing board or a flat surface.</div>
      </div>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)">
          <span>2. How much space do you need for ironing?</span>
          <span class="faq__plus">+</span>
        </button>
        <div class="faq__a">A standard ironing board space (roughly 1.5m × 0.5m) is sufficient. We can also use a large flat table if needed.</div>
      </div>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)">
          <span>3.&nbsp; How long does the service take?</span>
          <span class="faq__plus">+</span>
        </button>
        <div class="faq__a">It depends on the number of items. Typically, 10–15 items take about 1 hour. We'll give a more accurate estimate when you book.</div>
      </div>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)">
          <span>4.  How is this different from deep cleaning?</span>
          <span class="faq__plus">+</span>
        </button>
        <div class="faq__a">Ironing focuses solely on pressing and de-wrinkling your clothes, while deep cleaning is a comprehensive home cleaning service.</div>
      </div>
    </section>
  </div>
</div>

<!-- ══════════════════════════
     STICKY BOTTOM BAR
══════════════════════════ -->
<div class="bottom-bar">
  <div class="bottom-bar__inner">
    <button class="bottom-bar__cost">
      <span class="bottom-bar__cost-label">Service Cost</span>
      <span>AED 4,99</span>
    </button>
    <button class="bottom-bar__done">Done</button>
  </div>
</div>

<!-- ══════════════════════════
     FOOTER
══════════════════════════ -->
<footer>
  <div class="footer__inner">
    <div class="footer__top">
      <div class="footer__brand">
        <div class="footer__logo">
        <img src="{{ asset('assets/images/logo.png') }}" alt="QwikHom Logo" 
        style="max-width:180px; height:auto;"
        onerror="this.style.display='none'"/>
        </div>
        <p class="footer__tagline">Comfort Delivered to Your Home</p>
        <p class="footer__desc">Experience seamless, reliable, and professional solutions for all your home needs. Our trusted experts arrive at your doorstep to handle tasks with care, efficiency, and attention to detail. With easy booking, quick support, and quality you can count on, we make everyday living simpler, smoother, and stress-free.</p>
      </div>
      <div class="footer__col">
        <h5>Quick Links</h5>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">How It Works</a></li>
          <li><a href="#">Book A Service</a></li>
          <li><a href="#">Offers &amp; Campaigns</a></li>
          <li><a href="#">Download App</a></li>
        </ul>
      </div>
      <div class="footer__col">
        <h5>Legal</h5>
        <ul>
          <li><a href="#">Terms &amp; Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Cancellation &amp; Refund Policy</a></li>
          <li><a href="#">Help &amp; Support</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <div class="footer__bottom">
      <span class="footer__copy">Copyright</span>
      <div class="footer__socials">
        <a href="#" class="social-btn" aria-label="Facebook">
          <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
        </a>
        <a href="#" class="social-btn" aria-label="Instagram">
          <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="#fff" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="#fff" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1" fill="#fff"/></svg>
        </a>
        <a href="#" class="social-btn" aria-label="YouTube">
          <svg viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#0d3c4f"/></svg>
        </a>
      </div>
    </div>
  </div>
</footer>

<script>
  function changeQty(d) {
    const el = document.getElementById('qty');
    let v = parseInt(el.textContent) + d;
    if (v < 1) v = 1;
    el.textContent = v;
  }
  function toggleFaq(btn) {
    const item = btn.closest('.faq__item');
    const wasOpen = item.classList.contains('open');
    document.querySelectorAll('.faq__item.open').forEach(i => i.classList.remove('open'));
    if (!wasOpen) item.classList.add('open');
  }
</script>
</body>
</html> --}}