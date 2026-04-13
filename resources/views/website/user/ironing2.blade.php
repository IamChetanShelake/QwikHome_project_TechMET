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
body { font-family:'Inter',sans-serif; background:#fff; color:#1a1a1a; font-size:15px; }
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
  --page-max:1280px;
  --page-px: 60px;
}

/* ── HEADER ── */
.header { background:var(--blue-bg); border-bottom:1px solid #c2dce6; position:sticky; top:0; z-index:200; width:100%; }
.header__inner { max-width:var(--page-max); margin:0 auto; height:80px; display:flex; align-items:center; gap:18px; padding:0 var(--page-px); }
.header__back { width:26px; height:52px; background:none; border:none; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.header__back:hover { background:rgba(13,60,79,.1); border-radius:4px; }
.header__back svg { width:20px; height:20px; stroke:var(--navy); stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round; }
.header__title { font-family:'Libre Baskerville',serif; font-size:24px; font-weight:700; color:var(--navy); letter-spacing:0.03em; line-height:1; }

/* ── CONTENT BANDS ── */
.band { width:100%; }
.band__inner { max-width:var(--page-max); margin:0 auto; padding:32px var(--page-px); }

/* ── HERO ── */
.hero { display:flex; gap:40px; align-items:flex-start; }
.hero__img { width:618px; flex-shrink:0; height:377px; border-radius:15px; overflow:hidden; border:0.25px solid #B3B3B3; box-shadow:0px 4px 4px 0px rgba(0,0,0,0.09); }
.hero__img img { width:100%; height:100%; object-fit:cover; }
.hero__body { flex:1; display:flex; flex-direction:column; padding-top:4px; }
.hero__title { font-family:'Roboto',sans-serif; font-size:24px; font-weight:500; color:#1a1a1a; letter-spacing:0.04em; line-height:1; margin-bottom:12px; }
.hero__tag { font-family:'Roboto',sans-serif; font-size:18px; font-weight:400; color:#353535; line-height:1.4; margin-bottom:20px; }
.price-row { display:flex; align-items:center; gap:16px; margin-bottom:20px; }
.price { font-family:'Roboto',sans-serif; font-size:20px; font-weight:600; color:#1a1a1a; }
.qty { display:flex; align-items:center; background:var(--blue-pale); border-radius:8px; overflow:hidden; height:34px; }
.qty__btn { width:34px; height:34px; background:none; border:none; font-size:20px; font-weight:300; color:#444; display:flex; align-items:center; justify-content:center; transition:background .15s; }
.qty__btn:hover { background:rgba(0,0,0,.07); }
.qty__val { width:28px; text-align:center; font-size:14px; font-weight:600; color:var(--text); }
.hero__divider { border:none; border-top:1px solid var(--border); margin-bottom:18px; }
.about__title { font-family:'Roboto',sans-serif; font-size:24px; font-weight:500; color:#2D2D2D; letter-spacing:0.04em; line-height:1; text-transform:capitalize; margin-bottom:10px; }
.about__desc { font-family:'Roboto',sans-serif; font-size:18px; font-weight:400; color:#353535; line-height:1.5; margin-bottom:20px; }
.stars-row { display:flex; align-items:center; gap:7px; }
.stars { display:flex; gap:3px; }
.star { width:18px; height:18px; }
.star--on { color:#6F6F6F; }
.star--off { color:#6F6F6F; opacity:0.3; }
.reviews { font-size:13px; color:var(--muted); }
.section-title { font-family:'Roboto',sans-serif; font-size:24px; font-weight:500; color:#004271; letter-spacing:0.04em; line-height:1; margin-bottom:18px; }

/* ══════════════════════════
   SELECT REQUIREMENTS
══════════════════════════ */
.req-section { padding-top:24px; padding-bottom:32px; }
.req__grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
.req__col { position:relative; display:flex; flex-direction:column; gap:10px; }

/* TRIGGER */
.req__trigger {
  width:100%; height:40px;
  border:0.5px solid #818181; border-radius:8px;
  padding:0 12px 0 16px;
  font-family:'Roboto',sans-serif; font-size:14px; font-weight:400;
  color:#353535; background:#fff; outline:none;
  display:flex; align-items:center; justify-content:space-between; gap:8px;
  text-align:left; white-space:nowrap;
  transition:border-color .2s;
}
.req__trigger.locked { cursor:default; pointer-events:none; opacity:0.8; }
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

/* Q1 — PLAN PANEL */
#panel-plan { width:329px; height:301px; background:#fff; overflow:hidden; position:absolute; }
#panel-plan .plan-scroll { position:absolute; top:19px; left:26px; width:243px; height:268px; overflow-y:scroll; overflow-x:hidden; scrollbar-width:none; }
#panel-plan .plan-scroll::-webkit-scrollbar { display:none; }
#panel-plan .plan-scrollbar-track { position:absolute; top:25px; left:299px; width:11px; height:262px; border-radius:20px; background:#A9A9A9; overflow:hidden; }
#panel-plan .plan-scrollbar-thumb { position:absolute; left:0; top:0; width:11px; border-radius:20px; background:#0d3c4f; transition:top 0.05s linear; }

.plan-card { width:230px; margin-left:3px; margin-bottom:25px; cursor:pointer; flex-shrink:0; transition:opacity .15s; }
.plan-card:last-child { margin-bottom:8px; }
.plan-card:hover { opacity:.88; }
.plan-card__top { width:230px; height:72px; border-top-left-radius:15px; border-top-right-radius:15px; border:1.5px solid #D1D1D1; border-bottom:none; background:#fff; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:7px; box-sizing:border-box; }
.plan-card__desc { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; text-align:center; margin:0; }
.plan-card__price { font-family:'Source Sans 3','Source Sans Pro',sans-serif; font-size:16px; font-weight:600; color:#2D2D2D; line-height:1; letter-spacing:0.05em; text-align:center; margin:0; }
.plan-card__label { width:230px; height:38px; border-bottom-left-radius:15px; border-bottom-right-radius:15px; border:1.5px solid #D1D1D1; border-top:none; background:#D1D1D1; display:flex; align-items:center; justify-content:center; font-family:'Roboto',sans-serif; font-size:16px; font-weight:400; color:#353535; line-height:1; text-align:center; box-sizing:border-box; }

/* Q1 SELECTED */
.sel-plan { cursor:pointer; width:100%; }
.sel-plan__top { border-top-left-radius:15px; border-top-right-radius:15px; border:1.5px solid #D1D1D1; border-bottom:none; background:#d6edf4; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:5px; padding:10px; min-height:60px; }
.sel-plan__desc { font-family:'Roboto',sans-serif; font-size:12px; font-weight:400; color:#353535; line-height:1; text-align:center; margin:0; }
.sel-plan__price { font-family:'Source Sans 3','Source Sans Pro',sans-serif; font-size:14px; font-weight:600; color:#2D2D2D; line-height:1; letter-spacing:0.05em; text-align:center; margin:0; }
.sel-plan__label { border-bottom-left-radius:15px; border-bottom-right-radius:15px; border:1.5px solid #0d3c4f; border-top:none; background:#0d3c4f; color:#fff; display:flex; align-items:center; justify-content:center; min-height:38px; padding:8px; font-family:'Roboto',sans-serif; font-size:14px; font-weight:600; line-height:1; text-align:center; }

/* Q2 — CLEANERS PANEL */
#panel-cleaners { width:329px; height:295px; background:#F2F2F2; padding:27px 0 0 49px; box-sizing:border-box; }
.cleaner-pill { width:230px; height:47px; border-radius:15px; border:1.5px solid #D1D1D1; background:#fff; display:flex; align-items:center; justify-content:center; margin-bottom:18px; cursor:pointer; font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; transition:background .15s, border-color .15s; box-sizing:border-box; }
.cleaner-pill:last-child { margin-bottom:0; }
.cleaner-pill:hover { background:#e8f4f8; border-color:#aacfda; }
.sel-cleaners { width:100%; height:77px; border-radius:15px; border:1.5px solid #D1D1D1; background:#E4F9FF; display:flex; align-items:center; justify-content:center; cursor:pointer; font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; box-sizing:border-box; transition:background .15s; }
.sel-cleaners:hover { background:#c8f1fd; }

/* Q3 — HOURS PANEL */
#panel-hours { width:329px; height:295px; background:#F2F2F2; padding:28px 0 0 50px; box-sizing:border-box; }
.hour-pill { width:230px; height:47px; border-radius:15px; border:1.5px solid #D1D1D1; background:#fff; display:flex; align-items:center; justify-content:space-between; padding:0 16px; margin-bottom:18px; cursor:pointer; transition:background .15s, border-color .15s; box-sizing:border-box; }
.hour-pill:last-child { margin-bottom:0; }
.hour-pill:hover { background:#e8f4f8; border-color:#aacfda; }
.hour-pill__val { font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; }
.hour-pill__sub { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; text-align:right; }
.sel-hours { width:100%; height:77px; border-radius:15px; border:1.5px solid #D1D1D1; background:#E4F9FF; display:flex; align-items:center; justify-content:space-between; padding:0 16px; cursor:pointer; transition:background .15s; box-sizing:border-box; }
.sel-hours:hover { background:#c8f1fd; }
.sel-hours__val { font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; }
.sel-hours__sub { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; text-align:right; }

/* Q4 — MATERIALS PANEL */
#panel-materials { width:329px; height:227px; background:#F2F2F2; padding:18px 0 0 50px; box-sizing:border-box; }
.material-card { width:230px; height:77px; border-radius:15px; border:1.5px solid #D1D1D1; background:#fff; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:13px; margin-bottom:18px; cursor:pointer; transition:background .15s, border-color .15s; box-sizing:border-box; }
.material-card:last-child { margin-bottom:0; }
.material-card:hover { background:#e8f4f8; border-color:#aacfda; }
.material-card__title { font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; text-align:center; margin:0; }
.material-card__sub { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; text-align:center; margin:0; }
.sel-material { width:100%; height:77px; border-radius:15px; border:1.5px solid #D1D1D1; background:#E4F9FF; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:13px; cursor:pointer; transition:background .15s; box-sizing:border-box; }
.sel-material:hover { background:#f5f5f5; }
.sel-material__title { font-family:'Roboto',sans-serif; font-size:16px; font-weight:600; color:#353535; line-height:1; text-align:center; margin:0; }
.sel-material__sub { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#353535; line-height:1; text-align:center; margin:0; }

/* ══════════════════════════
   OUR PROCESS
══════════════════════════ */
.process-section { padding-top:32px; padding-bottom:32px; }
.process__labels { display:grid; grid-template-columns:repeat(4,1fr); text-align:center; margin-bottom:12px; }
.process__label { font-family:'Roboto',sans-serif; font-size:20px; font-weight:400; color:#353535; line-height:1; text-align:center; }
.process__timeline { display:flex; align-items:center; justify-content:space-between; position:relative; margin-bottom:24px; padding:0 36px; }
.step-circle { width:60px; height:60px; border-radius:50%; background:var(--navy); color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:700; position:relative; z-index:1; flex-shrink:0; border:1px solid #004271; }
.step-dash { flex:1; height:0; border-top:2px dashed #004271; margin:0 2px; }
.process__grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
.proc-item { display:flex; flex-direction:column; align-items:center; gap:10px; }
.proc-item img { width:267px; height:178px; object-fit:cover; border-radius:15px; border:1px solid #999999; }
.proc-item p { font-family:'Roboto',sans-serif; font-size:18px; font-weight:300; color:#353535; text-align:center; line-height:1.5; width:260px; }

/* ══════════════════════════
   WHAT'S INCLUDED
══════════════════════════ */
/* .included-section { padding-top:32px; padding-bottom:32px; }
.included__list { display:flex; flex-wrap:wrap; align-items:center; gap:0 24px; }
.included__item { font-family:'Roboto',sans-serif; font-size:18px; font-weight:400; color:#353535; line-height:1; display:flex; align-items:center; gap:8px; white-space:nowrap; }
.included__item::before { content:'•'; color:#353535; font-size:16px; } */
.included-section { padding-top:32px; padding-bottom:32px; }
/* Adjusted gap to 20px to fit content perfectly in one row */
.included__list { display:flex; flex-wrap:nowrap; align-items:center; gap:20px; }
/* Reduced font-size to 16px to prevent overflow */
.included__item { font-family:'Roboto',sans-serif; font-size:16px; font-weight:400; color:#353535; line-height:1.2; display:flex; align-items:center; gap:8px; white-space:nowrap; flex-shrink:0; }
.included__item::before { content:'•'; color:#353535; font-size:14px; }

/* ══════════════════════════
   WHAT WE NEED FROM YOU
══════════════════════════ */
.need-section { padding-top:32px; padding-bottom:32px; }
.need__grid { display:grid; grid-template-columns:repeat(4,1fr); gap:24px; justify-content:start; }
.need-card { height:260px; border:1.5px solid #EAEAEA; border-radius:12px; overflow:hidden; display:flex; flex-direction:column; background:#fff; }
.need-card__img { flex:1; display:flex; align-items:center; justify-content:center; padding:16px; background:#fff; }
.need-card__img img { max-width:90%; max-height:90%; object-fit:contain; }
.need-card__label { background:#EAEAEA; width:100%; height:74px; display:flex; align-items:center; justify-content:center; padding:0 16px; font-family:'Roboto',sans-serif; font-size:18px; font-weight:300; color:#030303; text-align:center; }

/* ══════════════════════════
   FAQ
══════════════════════════ */
.faq-section { padding-top:32px; padding-bottom:32px; }
.faq__item { width:100%; height:54px; background:rgba(228,249,255,0.22); border:1px solid #004271; border-radius:15px; overflow:hidden; margin-bottom:12px; }
.faq__item.open { height:auto; }
.faq__q { width:100%; height:54px; background:rgba(228,249,255,0.22); border:none; display:flex; justify-content:space-between; align-items:center; padding:0 20px 0 36px; font-family:'Roboto',sans-serif; font-size:18px; font-weight:400; color:#5B5B5B; text-align:left; gap:12px; }
.faq__plus { width:16px; height:15px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:400; color:#004271; transition:transform .25s; line-height:1; }
.faq__item.open .faq__plus { transform:rotate(45deg); }
.faq__a { display:none; padding:0 20px 16px 36px; font-family:'Poppins',sans-serif; font-size:14px; font-weight:400; color:#5B5B5B; line-height:1.7; }
.faq__item.open .faq__a { display:block; }

/* ══════════════════════════
   BOTTOM BAR
══════════════════════════ */
.bottom-bar { position:sticky; bottom:0; z-index:150; background:#fff; padding:12px 0; box-shadow:0 -2px 10px rgba(0,0,0,0.05); }
.bottom-bar__inner { max-width:var(--page-max); margin:0 auto; display:flex; align-items:center; gap:12px; padding:0 var(--page-px); }
.bottom-bar__cost { background:var(--navy); color:#fff; border:none; display:flex; align-items:center; gap:14px; padding:12px 22px; font-size:14px; font-weight:600; white-space:nowrap; border-radius:8px; }
.bottom-bar__cost-label { font-size:11px; font-weight:400; opacity:.8; }
.bottom-bar__done { background:var(--blue-pale); border:none; font-size:14px; font-weight:600; color:var(--navy); padding:12px 60px; border-radius:8px; transition:background .2s; }
.bottom-bar__done:hover { background:#c9e3ed; }

/* ══════════════════════════
   FOOTER
══════════════════════════ */
footer { background:var(--blue-bg); padding:48px 0 0; width:100%; }
.footer__inner { max-width:var(--page-max); margin:0 auto; padding:0 var(--page-px); }
.footer__top { display:grid; grid-template-columns:1fr 170px 200px; gap:80px; padding-bottom:32px; }
.footer__logo { display:flex; flex-direction:column; margin-bottom:20px; }
.footer__tagline { font-family:'Libre Baskerville',serif; font-size:20px; font-weight:700; color:#2D2D2D; letter-spacing:0.05em; line-height:1; margin-bottom:12px; }
.footer__desc { font-family:'Roboto',sans-serif; font-size:14px; font-weight:400; color:#2D2D2D; letter-spacing:0.07em; line-height:1.6; max-width:647px; }
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
@media (max-width:1200px) {
  .need__grid { grid-template-columns:repeat(2,1fr); }
}

@media (max-width:1024px) {
  :root { --page-px: 40px; --page-max: 100%; }
  .hero { flex-direction:column; }
  .hero__img { width:100%; height:300px; }
  .req__grid { grid-template-columns:repeat(2,1fr); }
  .process__grid { grid-template-columns:repeat(2,1fr); }
  .process__labels { grid-template-columns:repeat(2,1fr); }
  .footer__top { grid-template-columns:1fr 1fr; gap:40px; }
}

@media (max-width:767px) {
  :root { --page-px: 16px; }
  .header__inner { height:58px; }
  .header__title { font-size:18px; }
  .hero__img { height:220px; }
  .req__grid { grid-template-columns:1fr; }
  .process__labels { grid-template-columns:repeat(2,1fr); }
  .step-circle { width:44px; height:44px; font-size:16px; }
  .process__timeline { padding:0 20px; }
  .process__grid { grid-template-columns:1fr; }
  .proc-item img { width:100%; height:auto; }
  .proc-item p { width:100%; }
  .included__list { flex-direction:column; gap:12px; align-items:flex-start; }
  .need__grid { grid-template-columns:1fr; }
  .footer__top { grid-template-columns:1fr; gap:28px; }
  .footer__bottom { flex-direction:column; gap:14px; text-align:center; }
}
</style>
</head>
<body>

<header class="header">
  <div class="header__inner">
    <button class="header__back" aria-label="Back">
      <svg viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
    </button>
    <span class="header__title">Ironing</span>
  </div>
</header>

<div class="band">
  <div class="band__inner">
    <div class="hero">
      <div class="hero__img">
        <img src="{{ asset('assets/images/image.png') }}" alt="Ironing Service"/>
      </div>
      <div class="hero__body">
        <h2 class="hero__title">Ironing</h2>
        <p class="hero__tag">Wrinkle-free clothes, crisp and neat – ready to wear anytime.</p>
        <div class="price-row">
          <span class="price">AED 4.99</span>
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
    <section class="req-section">
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
                <div class="plan-card__top"><p class="plan-card__desc">For quick, one-time service</p><p class="plan-card__price">AED 1,999</p></div>
                <div class="plan-card__label">One -Time Quick Fix</div>
              </div>
              <div class="plan-card" onclick="selectPlan(this)" data-desc="Short-term plan with weekly savings" data-price="AED 3,999" data-label="QwikCare Weekly">
                <div class="plan-card__top"><p class="plan-card__desc">Short-term plan with weekly savings</p><p class="plan-card__price">AED 3,999</p></div>
                <div class="plan-card__label">QwikCare Weekly</div>
              </div>
              <div class="plan-card" onclick="selectPlan(this)" data-desc="Best value monthly subscription" data-price="AED 9,999" data-label="QwikCare Monthly">
                <div class="plan-card__top"><p class="plan-card__desc">Best value monthly subscription</p><p class="plan-card__price">AED 9,999</p></div>
                <div class="plan-card__label">QwikCare Monthly</div>
              </div>
              <div class="plan-card" onclick="selectPlan(this)" data-desc="Long-term plan with max savings" data-price="AED 14,999" data-label="QwikCare Annual">
                <div class="plan-card__top"><p class="plan-card__desc">Long-term plan with max savings</p><p class="plan-card__price">AED 14,999</p></div>
                <div class="plan-card__label">QwikCare Annual</div>
              </div>
            </div>
            <div class="plan-scrollbar-track"><div class="plan-scrollbar-thumb" id="planThumb"></div></div>
          </div>
        </div>
        <!-- Q2: CLEANERS -->
        <div class="req__col">
          <button class="req__trigger locked" id="trig-cleaners" type="button" onclick="togglePanel('cleaners')"><span>How many cleaners do you need?</span><span class="req__chevron"></span></button>
          <div id="sel-cleaners" style="display:none;"><div class="sel-cleaners" id="sel-cleaners-card" onclick="togglePanel('cleaners')"></div></div>
          <div class="req__panel" id="panel-cleaners">
            <button class="cleaner-pill" onclick="selectCleaner(this)" data-val="1 cleaner" type="button">1 cleaner</button>
            <button class="cleaner-pill" onclick="selectCleaner(this)" data-val="2 cleaners" type="button">2 cleaners</button>
            <button class="cleaner-pill" onclick="selectCleaner(this)" data-val="3 cleaners" type="button">3 cleaners</button>
            <button class="cleaner-pill" onclick="selectCleaner(this)" data-val="4 cleaners" type="button">4 cleaners</button>
          </div>
        </div>
        <!-- Q3: HOURS -->
        <div class="req__col">
          <button class="req__trigger locked" id="trig-hours" type="button" onclick="togglePanel('hours')"><span>How many hours should they stay?</span><span class="req__chevron"></span></button>
          <div id="sel-hours" style="display:none;"><div class="sel-hours" onclick="togglePanel('hours')"><span class="sel-hours__val" id="sel-hours-val"></span><span class="sel-hours__sub" id="sel-hours-sub"></span></div></div>
          <div class="req__panel" id="panel-hours">
            <button class="hour-pill" onclick="selectHours(this)" data-val="1 hr" data-sub="AED 60/service" type="button"><span class="hour-pill__val">1 hr</span><span class="hour-pill__sub">AED 60/service</span></button>
            <button class="hour-pill" onclick="selectHours(this)" data-val="1.5 hrs" data-sub="AED 80/service" type="button"><span class="hour-pill__val">1.5 hrs</span><span class="hour-pill__sub">AED 80/service</span></button>
            <button class="hour-pill" onclick="selectHours(this)" data-val="2 hrs" data-sub="AED 100/service" type="button"><span class="hour-pill__val">2 hrs</span><span class="hour-pill__sub">AED 100/service</span></button>
            <button class="hour-pill" onclick="selectHours(this)" data-val="3 hrs" data-sub="AED 150/service" type="button"><span class="hour-pill__val">3 hrs</span><span class="hour-pill__sub">AED 150/service</span></button>
          </div>
        </div>
        <!-- Q4: MATERIALS -->
        <div class="req__col">
          <button class="req__trigger locked" id="trig-materials" type="button" onclick="togglePanel('materials')"><span>Do you need cleaning materials?</span><span class="req__chevron"></span></button>
          <div id="sel-materials" style="display:none;"><div class="sel-material" onclick="togglePanel('materials')"><div class="sel-material__title" id="sel-material-val"></div><div class="sel-material__sub" id="sel-material-sub"></div></div></div>
          <div class="req__panel" id="panel-materials">
            <div class="material-card" onclick="selectMaterial(this)" data-val="With Material" data-sub="+AED 10/service"><div class="material-card__title">With Material</div><div class="material-card__sub">+AED 10/service</div></div>
            <div class="material-card" onclick="selectMaterial(this)" data-val="Without Material" data-sub="+AED 10/service"><div class="material-card__title">Without Material</div><div class="material-card__sub">+AED 10/service</div></div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- OUR PROCESS -->
<div class="band">
  <div class="band__inner">
    <section class="process-section">
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
        <div class="proc-item"><img src="{{ asset('assets/images/image 55.png') }}" alt="Book Service"/><p>Schedule ironing at your preferred time through the app.</p></div>
        <div class="proc-item"><img src="{{ asset('assets/images/image 54.png') }}" alt="We Arrive"/><p>Our professional staff comes to your doorstep with all essentials.</p></div>
        <div class="proc-item"><img src="{{ asset('assets/images/image 56.png') }}" alt="At-Home Ironing"/><p>Clothes are ironed neatly at your place, hassle-free.</p></div>
        <div class="proc-item"><img src="{{ asset('assets/images/image 57 (1).png') }}" alt="Ready to Wear"/><p>Crisp, wrinkle-free outfits handed over instantly.</p></div>
      </div>
    </section>
  </div>
</div>

<!-- WHAT'S INCLUDED -->
<div class="band">
  <div class="band__inner">
    <section class="included-section">
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
    <section class="need-section">
      <h2 class="section-title">What We Need From You</h2>
      <div class="need__grid">
        <div class="need-card"><div class="need-card__img"><img src="{{ asset('assets/images/image 57.png') }}" alt="Clean clothes"/></div><div class="need-card__label">Clean clothes, ready to iron</div></div>
        <div class="need-card"><div class="need-card__img"><img src="{{ asset('assets/images/image 58.png') }}" alt="Ironing board"/></div><div class="need-card__label">Ironing board or flat surface</div></div>
        <div class="need-card"><div class="need-card__img"><img src="{{ asset('assets/images/image 59.png') }}" alt="Electricity"/></div><div class="need-card__label">Access to electricity</div></div>
        <div class="need-card"><div class="need-card__img"><img src="{{ asset('assets/images/image 37.png') }}" alt="Fabric instructions"/></div><div class="need-card__label">Delicate fabric instructions</div></div>
      </div>
    </section>
  </div>
</div>

<!-- FAQ -->
<div class="band">
  <div class="band__inner">
    <section class="faq-section">
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
        <button class="faq__q" onclick="toggleFaq(this)"><span>3. How long does the service take?</span><span class="faq__plus">+</span></button>
        <div class="faq__a">It depends on the number of items. Typically, 10–15 items take about 1 hour. We'll give a more accurate estimate when you book.</div>
      </div>
      <div class="faq__item">
        <button class="faq__q" onclick="toggleFaq(this)"><span>4. How is this different from deep cleaning?</span><span class="faq__plus">+</span></button>
        <div class="faq__a">Ironing focuses solely on pressing and de-wrinkling your clothes, while deep cleaning is a comprehensive home cleaning service.</div>
      </div>
    </section>
  </div>
</div>

<!-- STICKY BOTTOM BAR -->
<div class="bottom-bar">
  <div class="bottom-bar__inner">
    <button class="bottom-bar__cost"><span class="bottom-bar__cost-label">Service Cost</span><span>AED 4.99</span></button>
    <button class="bottom-bar__done">Done</button>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer__inner">
    <div class="footer__top">
      <div class="footer__brand">
        <div class="footer__logo"><svg width="140" height="40" viewBox="0 0 140 40" fill="none"><text x="0" y="28" font-family="Libre Baskerville" font-size="24" font-weight="700" fill="#0d3c4f">QwikHom</text></svg></div>
        <p class="footer__tagline">Comfort Delivered to Your Home</p>
        <p class="footer__desc">Experience seamless, reliable, and professional solutions for all your home needs. Our trusted experts arrive at your doorstep to handle tasks with care, efficiency, and attention to detail. With easy booking, quick support, and quality you can count on, we make everyday living simpler, smoother, and stress-free.</p>
      </div>
      <div class="footer__col">
        <h5>Quick Links</h5>
        <ul><li><a href="#">About Us</a></li><li><a href="#">Services</a></li><li><a href="#">How It Works</a></li><li><a href="#">Book A Service</a></li><li><a href="#">Offers &amp; Campaigns</a></li><li><a href="#">Download App</a></li></ul>
      </div>
      <div class="footer__col">
        <h5>Legal</h5>
        <ul><li><a href="#">Terms &amp; Conditions</a></li><li><a href="#">Privacy Policy</a></li><li><a href="#">Cancellation &amp; Refund Policy</a></li><li><a href="#">Help &amp; Support</a></li><li><a href="#">Careers</a></li><li><a href="#">Contact Us</a></li></ul>
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
function changeQty(d) { var el = document.getElementById('qty'); var v = parseInt(el.textContent) + d; if (v < 1) v = 1; el.textContent = v; }
function toggleFaq(btn) { var item = btn.closest('.faq__item'); var wasOpen = item.classList.contains('open'); document.querySelectorAll('.faq__item.open').forEach(function(i){ i.classList.remove('open'); }); if (!wasOpen) item.classList.add('open'); }
function closeAllPanels() { ['plan','cleaners','hours','materials'].forEach(function(key) { var p = document.getElementById('panel-' + key); var t = document.getElementById('trig-' + key); if (p) p.classList.remove('is-open'); if (t) t.classList.remove('is-open'); }); }
function togglePanel(key) { var trig = document.getElementById('trig-' + key); var panel = document.getElementById('panel-' + key); if (!trig || !panel) return; if (trig.classList.contains('locked')) return; var isOpen = panel.classList.contains('is-open'); closeAllPanels(); if (!isOpen) { panel.classList.add('is-open'); trig.classList.add('is-open'); if (key === 'plan') setTimeout(syncPlanThumb, 10); } }
function unlockNext(key) { var order = ['plan','cleaners','hours','materials']; var idx = order.indexOf(key); if (idx < order.length - 1) { var next = document.getElementById('trig-' + order[idx + 1]); if (next) next.classList.remove('locked'); } }
function selectPlan(card) { document.getElementById('sel-plan-desc').textContent = card.dataset.desc; document.getElementById('sel-plan-price').textContent = card.dataset.price; document.getElementById('sel-plan-label').textContent = card.dataset.label; document.getElementById('sel-plan').style.display = 'block'; closeAllPanels(); unlockNext('plan'); }
function selectCleaner(btn) { document.getElementById('sel-cleaners-card').textContent = btn.dataset.val; document.getElementById('sel-cleaners').style.display = 'block'; closeAllPanels(); unlockNext('cleaners'); }
function selectHours(btn) { document.getElementById('sel-hours-val').textContent = btn.dataset.val; document.getElementById('sel-hours-sub').textContent = btn.dataset.sub; document.getElementById('sel-hours').style.display = 'block'; closeAllPanels(); unlockNext('hours'); }
function selectMaterial(card) { document.getElementById('sel-material-val').textContent = card.dataset.val; document.getElementById('sel-material-sub').textContent = card.dataset.sub; document.getElementById('sel-materials').style.display = 'block'; closeAllPanels(); }
function syncPlanThumb() { var scroll = document.getElementById('planScroll'); var thumb = document.getElementById('planThumb'); if (!scroll || !thumb) return; var trackH = 262; var scrollH = scroll.scrollHeight; var clientH = scroll.clientHeight; if (scrollH <= clientH) { thumb.style.height = trackH + 'px'; thumb.style.top = '0px'; return; } var ratio = scroll.scrollTop / (scrollH - clientH); var thumbH = Math.max(40, (clientH / scrollH) * trackH); thumb.style.height = thumbH + 'px'; thumb.style.top = (ratio * (trackH - thumbH)) + 'px'; }
document.addEventListener('DOMContentLoaded', function() { var scroll = document.getElementById('planScroll'); if (scroll) { scroll.addEventListener('scroll', syncPlanThumb); } setTimeout(syncPlanThumb, 150); });
document.addEventListener('click', function(e) { if (!e.target.closest('.req__col')) closeAllPanels(); });
</script>
</body>
</html>