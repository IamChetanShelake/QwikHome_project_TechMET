<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QwikHom - Comfort Delivered to Your Home</title>

    {{-- Tailwind / CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Carousel Styles */
        .carousel-container {
            display: block;
            width: 100%;
            position: relative;
        }

        .carousel-slide {
            width: 100%;
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            padding: 0;
        }

        .carousel-slide.active {
            display: block;
            opacity: 1;
        }

        .carousel-slide.space-y-4 > li + li {
            margin-top: 1rem;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .slider-dot:hover {
            transform: scale(1.25);
        }

        .slider-dot.active {
            background-color: #004271 !important;
            transform: scale(1.1);
        }

        .offer-card {
            border: 1.5px solid #004271;
            border-radius: 16px;
            overflow: hidden;
            transition: border 0.3s ease;
        }

        /* image wrapper */
        .category-img-wrapper {
            overflow: hidden;
        }

        /* image normal state */
        .category-img-wrapper img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.4s ease;
        }

        /* zoom ONLY when hovering image container */
        .offer-img-container:hover .category-img-wrapper img {
            transform: scale(1.1);
        }

        /* container */
        .offer-img-container {
            position: relative;
        }

        /* overlay hidden by default */
        .offer-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #004271;
            height: 0;
            overflow: hidden;
            transition: height 0.3s ease;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 0 15px;              /* 🔥 vertical padding removed */
            box-sizing: border-box;
        }

        /* show overlay ONLY on image hover */
        .offer-img-container:hover .offer-overlay {
            height: 70px;
            padding: 12px 15px;           /* 🔥 padding ONLY on hover */
        }

        /* overlay text */
        .offer-overlay-left {
            color: white;
            font-weight: 600;
            font-size: 18px;
            white-space: nowrap;
            margin-top: 2px;
        }

        /* right section */
        .offer-overlay-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        /* icons */
        .offer-icons {
            display: flex;
            gap: 12px;
            flex-direction: row;
            
        }

        .offer-icon-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
            padding: 0;
        }

        /* DEFAULT STATE */
        .offer-icon-btn svg {
            width: 22px;
            height: 22px;
            fill: transparent;
            stroke: white;
            stroke-width: 1.5;
            transition: fill 0.3s ease, stroke 0.3s ease, transform 0.2s ease;
        }

        /* HEART HOVER - RED */
        .offer-icon-btn.heart-btn:hover svg {
            fill: #e53935;
            stroke: #e53935;
            transform: scale(1.15);
        }

        /* CART HOVER - WHITE */
        .offer-icon-btn.cart-btn:hover svg {
            fill: white;
            stroke: white;
            transform: scale(1.15);
        }

        .offer-icon-btn:hover {
            transform: scale(1.1);
        }

        /* know more */
        .offer-know-more {
            color: white;
            font-size: 12px;
            text-decoration: underline;
            cursor: pointer;
        }

        /* bold border when image is hovered */
        .offer-card:has(.offer-img-container:hover) {
            border-width: 3px;
        }

        /* hide scrollbar */
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .flex.hide-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }

        .flex.hide-scrollbar::-webkit-scrollbar {
            display: none !important;
        }

        /* Login Modal Styles */
        body.modal-open {
            overflow: hidden;
        }

        body.modal-open::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(12px); /* stronger blur */
            z-index: 99;
        }

        .login-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('img/bg.png') center / cover no-repeat fixed;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .login-modal-overlay.active {
            display: flex;
        }

        .login-modal {
            background: #ffffff;
            border-radius: 20px;
            border: 3px solid #004271;
            padding: 40px 35px;
            width: 420px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: slideIn 0.3s ease-out;
            margin-left: 30px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            margin-left: 30px;
            font-size: 28px;
            font-weight: bold;
            color: #004271;
            cursor: pointer;
            line-height: 1;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
        }

        .login-close-btn:hover {
            color: #e53935;
            margin-left: 30px;
        }

        .login-modal h2 {
            text-align: center;
            color: #004271;
            font-family: 'Libre Baskerville', serif;
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 30px 0;
            
        }

        .login-input-label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .login-phone-icon {
            width: 40px;
            height: 40px;
            background: #004271;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .login-phone-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .login-label-text {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .login-input {
            width: 100%;
            height: 50px;
            border-radius: 12px;
            border: 1.5px solid #ccc;
            padding: 0 16px;
            font-size: 16px;
            outline: none;
            margin-bottom: 25px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .login-input:focus {
            border-color: #004271;
        }

        .login-input::placeholder {
            color: #aaa;
        }

        .login-continue-btn {
            width: 100%;
            height: 50px;
            background: #004271;
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .login-continue-btn:hover {
            background: #003366;
        }

        .login-signup-text {
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .login-signup-text a {
            color: #004271;
            font-weight: 700;
            text-decoration: none;
        }

        .login-signup-text a:hover {
            text-decoration: underline;
        }

        /* Notification Popup Styles */
        .notification-popup {
            position: absolute;
            top: 55px;
            right: 0;
            background: white;
            border: 2px solid #004271;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 66, 113, 0.2);
            min-width: 280px;
            padding: 0;
            z-index: 100;
            display: none;
        }

        .notification-popup.active {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #e0e0e0;
        }

        .notification-popup-title {
            font-weight: 600;
            color: #004271;
            font-size: 16px;
            margin: 0;
        }

        .notification-close-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #666;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            transition: color 0.2s;
        }

        .notification-close-btn:hover {
            color: #e53935;
        }

        .notification-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notification-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background: #f5f5f5;
        }

        .notification-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #004271;
            font-size: 18px;
        }

        .notification-text {
            color: #333;
            font-weight: 500;
            font-size: 14px;
            margin: 0;
        }

        /* Header icon hover (search, cart, profile, notification) */
     .header-icon {
            width: 44px;
            height: 44px;
            border: 2px solid rgba(0,0,0,0.12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background: transparent;
            transition: background 0.18s ease, transform 0.12s ease, box-shadow 0.18s ease, border-color 0.18s ease;
            box-sizing: border-box;
        }

        .header-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: filter 0.18s ease, transform 0.12s ease;
            filter: none;
        }

        .header-icon:hover {
            background: rgba(225, 253, 255, 0.9); /* pale blue */
            border-color: rgba(0,66,113,0.25);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0,66,113,0.06);
        }

        .header-icon:hover img {
            filter: brightness(0) invert(1);
            transform: scale(1.02);
        }

        /* ================= responsive header wrapper & header ================= */
        .custom-header-wrapper {
            background: #E4F9FF;
            width: 100%;
            max-width: 1500px;
            padding: 40px;
            opacity: 1;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            margin: 0 auto;
            box-sizing: border-box;
        }

        .custom-header {
            width: 100%;
            max-width: 1420px;
            height: 76px;
            border-radius: 50px;
            border-width: 1px;
            opacity: 1;
            background: linear-gradient(90deg, rgba(198, 242, 255, 0.7) 6.42%, rgba(150, 206, 231, 0.7) 33.52%, rgba(117, 182, 218, 0.7) 57.58%, rgba(72, 159, 221, 0.7) 107.75%);
            margin: 0 auto;
            position: relative;
            box-sizing: border-box;
        }

        /* mobile phones */
        @media (max-width: 640px) {
            .custom-header {
                width: 100%;
                max-width: 100%;
            }
            .custom-header-wrapper {
                padding: 20px;
            }
            .custom-header {
                height: auto;
                padding: 12px 16px;
                border-radius: 24px;
                flex-direction: column;
                align-items: flex-start;
            }
            .custom-header img {
                max-height: 40px;
            }
        }

        /* tablets */
        @media (min-width: 641px) and (max-width: 1024px) {
            .custom-header {
                width: 100%;
                max-width: 100%;
            }
            .custom-header-wrapper {
                padding: 30px;
            }
            .custom-header {
                height: auto;
                padding: 16px 24px;
                border-radius: 40px;
            }
        }

        /* laptops and larger */
        @media (min-width: 1025px) {
            .custom-header {
                width: 100%;
                max-width: 1420px;
            }
            .custom-header-wrapper {
                padding: 40px;
            }
            .custom-header {
                height: 76px;
                padding: 20px 32px;
            }
        }

        /* ================= responsive services section ================= */
        .services-section {
            width: 100%;
            max-width: 1550px;
            margin: 0 auto;
            box-sizing: border-box;
        }
        .services-img {
            width: 60%;
        }
        .services-content {
            width: 40%;
            transition: all 0.3s ease;
        }

        /* mobile phones: stack image and show services below */
        @media (max-width: 640px) {
            .services-section {
                width: 100%;
                max-width: 100%;
                flex-direction: column;
                padding: 20px;
            }
            .services-img {
                width: 100%;
            }
            .services-content {
                display: block;
                width: 100%;
                margin-top: 16px;
            }
        }

        /* tablets: stack image over content */
        @media (min-width: 641px) and (max-width: 1024px) {
            .services-section {
                width: 100%;
                max-width: 100%;
                flex-direction: column;
                padding: 30px;
            }
            .services-img,
            .services-content {
                width: 100%;
            }
            .services-content {
                display: block;
            }
        }

        /* laptops and larger keep default two columns */
        @media (min-width: 1025px) {
            .services-section {
                width: 100%;
                max-width: 1550px;
                flex-direction: row;
                padding: 40px;
            }
            .services-img {
                width: 385px;
            }
            .services-content {
                width: 40%;
                display: block;
            }
        }

        /* ================= responsive categories section ================= */
        .categories-section {
            width: 100%;
            max-width: 1550px;
            margin: 0 auto;
            box-sizing: border-box;
        }
        .categories-section .flex-row {
            /* keep horizontal scroll behaviour */
        }

        /* mobile phones: ensure cards shrink and allow wrapping if needed */
        @media (max-width: 640px) {
            .categories-section {
                width: 100%;
                max-width: 100%;
                padding-left: 16px;
                padding-right: 16px;
            }
            .categories-section .flex-row {
                gap: 24px;
            }
            .categories-section .flex-row > div {
                flex-shrink: 0;
                width: 120px;
            }
        }

        /* tablets: moderate gaps and possible two per row by wrapping */
        @media (min-width: 641px) and (max-width: 1024px) {
            .categories-section {
                width: 100%;
                max-width: 100%;
            }
            .categories-section .flex-row {
                gap: 24px;
            }
            .categories-section .flex-row > div {
                flex-shrink: 0;
                width: 140px;
            }
        }

        /* laptops and larger: revert to original spacing */
        @media (min-width: 1025px) {
            .categories-section {
                width: 100%;
                max-width: 1550px;
                padding-left: 32px;
                padding-right: 32px;
            }
            .categories-section .flex-row {
                gap: 24px;
            }
            .categories-section .flex-row > div {
                width: 143px;
            }
        }

        /* ================= responsive offers, quick-picks & beauty sections ================= */
        .offers-section,
        .quick-picks-section,
        .beauty-section {
            width: 100%;
            max-width: 1550px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        /* mobile phones */
        @media (max-width: 640px) {
            .offers-section,
            .quick-picks-section,
            .beauty-section {
                width: 100%;
                max-width: 100%;
                padding-left: 16px;
                padding-right: 16px;
            }
            .quick-picks-section,
            .beauty-section {
                padding-left: 16px;
                padding-right: 16px;
            }
            .offers-section .flex-nowrap,
            .quick-picks-section .flex-nowrap,
            .beauty-section .flex-nowrap,
            .quick-picks-section .flex,
            .beauty-section .flex {
                gap: 24px;
            }
        }

        /* tablets */
        @media (min-width: 641px) and (max-width: 1024px) {
            .offers-section,
            .quick-picks-section,
            .beauty-section {
                width: 100%;
                max-width: 100%;
                padding-left: 24px;
                padding-right: 24px;
            }
            .offers-section .flex-nowrap,
            .quick-picks-section .flex-nowrap,
            .beauty-section .flex-nowrap,
            .quick-picks-section .flex,
            .beauty-section .flex {
                gap: 24px;
            }
        }

        /* laptops and larger */
        @media (min-width: 1025px) {
            .offers-section,
            .quick-picks-section,
            .beauty-section {
                width: 100%;
                max-width: 1550px;
                padding-left: 32px;
                padding-right: 32px;
            }
            .offers-section .flex-nowrap,
            .quick-picks-section .flex-nowrap,
            .beauty-section .flex-nowrap,
            .quick-picks-section .flex,
            .beauty-section .flex {
                gap: 24px;
            }
        }

        /* ================= responsive special offers section ================= */
        .special-offers-section {
            width: 100%;
            max-width: 1550px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        /* mobile phones: stack images vertically */
        @media (max-width: 640px) {
            .special-offers-section {
                width: 100%;
                max-width: 100%;
                padding-left: 16px;
                padding-right: 16px;
            }
            .special-offers-section .flex.gap-6 {
                flex-direction: column;
                gap: 16px;
            }
            .special-offers-section .flex.gap-6 > div {
                width: 100%;
                height: 350px;
            }
        }

        /* tablets: stack images vertically */
        @media (min-width: 641px) and (max-width: 1024px) {
            .special-offers-section {
                width: 100%;
                max-width: 100%;
                padding-left: 24px;
                padding-right: 24px;
            }
            .special-offers-section .flex.gap-6 {
                flex-direction: column;
                gap: 16px;
            }
            .special-offers-section .flex.gap-6 > div {
                width: 100%;
                height: 380px;
            }
        }

        /* laptops and larger: keep two columns side by side */
        @media (min-width: 1025px) {
            .special-offers-section {
                width: 100%;
                max-width: 1550px;
                padding-left: 32px;
                padding-right: 32px;
            }
            .special-offers-section .flex.gap-6 {
                flex-direction: row;
                gap: 24px;
            }
            .special-offers-section .flex.gap-6 > div {
                width: 50%;
                height: 420px;
            }
        }

        /* ================= responsive footer ================= */
        .custom-footer {
            width: 100%;
            box-sizing: border-box;
        }

        /* mobile phones */
        @media (max-width: 640px) {
            .custom-footer {
                width: 100%;
                max-width: 100%;
                padding: 20px 16px;
            }
            .custom-footer > div {
                max-width: 100% !important;
            }
            .custom-footer > div > div:first-child {
                flex-direction: column;
                gap: 30px;
            }
            .custom-footer > div > div:first-child > div:last-child {
                flex-direction: column;
                gap: 30px;
            }
            .custom-footer > div > div:last-child {
                flex-direction: column;
                gap: 20px;
            }
        }

        /* tablets */
        @media (min-width: 641px) and (max-width: 1024px) {
            .custom-footer {
                width: 100%;
                max-width: 100%;
                padding: 25px 24px;
            }
            .custom-footer > div {
                max-width: 100% !important;
            }
            .custom-footer > div > div:first-child {
                gap: 30px;
            }
            .custom-footer > div > div:first-child > div:last-child {
                gap: 40px;
            }
        }

        /* laptops and larger */
        @media (min-width: 1025px) {
            .custom-footer {
                width: 100%;
                max-width: 100%;
                padding: 30px 5%;
            }
            .custom-footer > div {
                max-width: 1200px;
            }
        }

        /* ===== HEADER RESPONSIVE FIX ===== */

@media (max-width: 1024px) {

    .location-section{
        display:none;
    }

    .icons-group{
        gap:14px;
    }

    .header-icon{
        width:38px;
        height:38px;
        padding:8px;
    }

}

@media (max-width: 640px){

    .header-wrapper{
        padding:20px !important;
    }

    .main-header-bar{
        height:auto !important;
        padding:12px 16px !important;
        border-radius:28px !important;
    }

    .icons-group{
        gap:10px;
    }

    .header-icon{
        width:34px;
        height:34px;
        padding:6px;
    }

}



/* ===== HERO SECTION RESPONSIVE ===== */

.hero-section{
    width:100%;
    max-width:1550px;
    margin:auto;
    box-sizing:border-box;
}

/* Tablets */
@media (max-width:1024px){

    .hero-section{
        flex-direction:column;
        padding:30px;
        gap:25px;
    }

    .hero-left{
        max-width:100%;
    }

    .hero-right{
        width:100% !important;
        padding:20px 10px !important;
    }

}

/* Mobile */
@media (max-width:640px){

    .hero-section{
        flex-direction:column;
        padding:20px;
        gap:20px;
    }

    .hero-left img{
        width:100%;
        border-radius:12px;
    }

    .hero-right{
        width:100% !important;
        padding:10px !important;
    }

    .hero-right h2{
        font-size:20px !important;
        line-height:1.3;
    }

    .hero-right li{
        gap:10px;
    }

    .hero-right img{
        width:30px !important;
    }

}


@media (max-width:640px){

    #search-bar{
        position:absolute !important;
        top:70px !important;   /* pushes it below header */
        right:50% !important;
        transform:translateX(50%) !important;

        width:90vw !important;
        max-width:350px !important;
    }
#loginPopup{
    position: fixed !important;
    top: 110px !important;   /* controls vertical position */
    left: 50% !important;
    right: auto !important;
    transform: translateX(-50%) !important;

    width: 168px !important;
}

}

/* ---------------------------------------- */

.hero-right{
margin-top:0;
}

@media (max-width:640px){

.hero-section{
flex-direction:column;
padding:16px;
gap:10px;
}

.hero-right{
width:100% !important;
padding:10px !important;
}

}

.hero-left{
    position:relative;
    width:100%;
    max-width:1200px;
    overflow:hidden;
}

@media (max-width:640px){

.categories-section{
padding-left:16px;
padding-right:16px;
}

.categories-section .flex{
gap:16px;
}

.categories-section .flex > div{
flex-shrink:0;
}

.categories-section .flex > div > div{
width:120px !important;
}

}

.slide-image{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    object-fit:cover;
    opacity:0;
    transition:opacity 0.6s ease-in-out;
}

.slide-image.active{
    opacity:1;
}

    </style>
</head>      
<body class="bg-white">

<!-- ================= HEADER ================= -->
<div class="header-wrapper" style="background:#E4F9FF; padding:40px; opacity:1; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);">
   <header class="main-header-bar bg-blue-100 px-8 py-4 flex justify-between items-center sticky top-0 z-50"
           style="height:76px; top:20px; border-radius:50px; border-width:1px; opacity:1;
           background: linear-gradient(90deg, rgba(198, 242, 255, 0.7) 6.42%, rgba(150, 206, 231, 0.7) 33.52%, rgba(117, 182, 218, 0.7) 57.58%, rgba(72, 159, 221, 0.7) 107.75%);">

    <!-- Left Section -->
    <div class="flex items-center gap-5">
       <img src="img/logo.png" class="h-[56px] max-h-[56px] w-auto object-contain">

        <!-- Added class="location-section" for responsive hiding -->
        <div class="location-section flex items-center gap-3">
            <img src="img/location_logo.png" class="h-6 object-contain">
            <div>
                <p class="font-semibold text-gray-800">Patil Classics</p>
                <p class="text-sm text-gray-600 flex items-center gap-1">
                    Tidake colony, Durwankur Lawns, Nashik ....
                    <img src="img/dropdown.png" class="w-[12px] h-[7px]">
                </p>
            </div>
        </div>
    </div>

    <!-- Right Section -->
    <!-- Added class="icons-group" for responsive gap -->
    <div class="icons-group flex items-center gap-6">

       <!-- Search Container -->
<div id="search-container" class="relative flex items-center">

    <!-- Search Icon -->
    <div id="search-btn" class="header-icon cursor-pointer">
        <img src="img/search.png" class="w-full h-full object-contain">
    </div>

    <!-- Search Bar -->
    <div id="search-bar"
        class="absolute hidden"
        style="right:0; top:50%; transform:translateY(-50%); width:350px; max-width:90vw;">

        <img src="img/small_search.png"
            style="position:absolute; left:15px; top:50%; transform:translateY(-50%);
            width:22px; height:auto;">

        <input id="search-input" type="text" placeholder="Search here"
            style="width:100%; height:45px; padding-left:50px; padding-right:40px;
            border-radius:25px; border:1px solid #004271; outline:none;
            background:#ffffff;">

 <button id="search-close"
style="
position:absolute;
right:18px;
top:48%;
transform:translateY(-50%);
background:none;
border:none;
font-size:34px;
font-weight:300;
cursor:pointer;
height:100%;
display:flex;
align-items:center;
justify-content:center;
line-height:1;
color:#333;
">
&times;
</button>
    </div>
</div>

        <!-- Cart -->
<a href="{{ route('cart.page') }}" class="header-icon cursor-pointer flex items-center justify-center">
    <img src="{{ asset('img/cart.png') }}" class="w-full h-full object-contain">
</a>
        <!-- Profile -->
        <div class="relative inline-block">
            <div onclick="toggleLoginPopup()" class="header-icon cursor-pointer">
                <img src="img/profile.png" class="w-full h-full object-contain">
            </div>

            <div id="loginPopup" class="absolute right-0 top-12 w-80 hidden z-50" style="border: 2px solid #004271; border-radius: 0px;">
                <div class="bg-white border-2 border-[#004271] rounded-xl shadow-lg px-4 py-3 flex items-center justify-between" style="border-radius: 0;">
                    <a href="{{ route('login') }}" class="flex items-center gap-2 text-[#004271] hover:underline text-lg">
                        <span>→]</span>
                        <span style="padding-right: 40px;">Login</span>
                    </a>
                    <button onclick="toggleLoginPopup()" class="text-gray-400 hover:text-red-500 text-2xl font-bold leading-none">
                        &times;
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="relative inline-block">
            <div onclick="toggleNotificationPopup()" class="header-icon cursor-pointer">
                <img src="img/notification.png" class="w-full h-full object-contain">
            </div>

            <div id="notificationPopup" class="notification-popup">
                <!-- Removed fixed absolute positioning (left:1224px) so it aligns to the icon correctly on mobile -->
                <div class="notification-popup-header" style="width: 168px; height: 137px; opacity: 1; border-width: 1px; border-style: solid; border-color: #004271; position: relative; background: white; z-index: 50; display: none;">
                    <button class="notification-close-btn" onclick="toggleNotificationPopup()">&times;</button>
                </div>
                
                <!-- Fixed HTML structure (removed nested ULs) -->
                <ul class="notification-items">
                    <li class="notification-item">
                        <div style="width:16.65px; height:16.3px; display:flex; align-items:center; justify-content:center; opacity:1; cursor:pointer; position:relative;">
                            <img src="img/n.png" alt="Notification" style="width:100%; height:100%; object-fit:contain; border-radius:50%;">
                        </div>
                        <p class="notification-text">My Notifications</p>
                    </li>
              <li class="notification-item">
    <a href="{{ url('/booking') }}" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:inherit; width:100%;">
        
        <div style="width:16.65px; height:16.3px; display:flex; align-items:center; justify-content:center;">
            <img src="{{ asset('img/booking.png') }}" alt="booking" style="width:100%; height:100%; object-fit:contain;">
        </div>

        <p class="notification-text" style="margin:0;">My Bookings</p>

    </a>
</li>
                    <li class="notification-item">
    <a href="/wishlist" style="display:flex; align-items:center; gap:8px; text-decoration:none;">
        
        <div style="width:16.65px; height:16.3px; display:flex; align-items:center; justify-content:center; opacity:1; cursor:pointer; position:relative;">
            <img src="{{ asset('img/like.png') }}" alt="like" style="width:100%; height:100%; object-fit:contain;">
        </div>

        <p class="notification-text">Wishlist</p>

    </a>
</li>
                </ul>
            </div>
        </div>
    </div>
   </header>
</div><!-- JS -->
<script>
    const searchBtn = document.getElementById('search-btn');
    const searchBar = document.getElementById('search-bar');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('search-input');

    searchBtn.addEventListener('click', () => {
        searchBtn.classList.add('hidden');
        searchBar.classList.remove('hidden');
        searchInput.focus();
    });

    searchClose.addEventListener('click', () => {
        searchBar.classList.add('hidden');
        searchBtn.classList.remove('hidden');
    });

    function toggleNotificationPopup() {
        const popup = document.getElementById('notificationPopup');
        popup.classList.toggle('active');
    }

    function toggleLoginPopup() {
        const popup = document.getElementById('loginPopup');
        popup.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        const loginPopup = document.getElementById('loginPopup');
        const notificationPopup = document.getElementById('notificationPopup');
        const profileTrigger = event.target.closest('.relative');
        
        // Close login popup if clicking outside
        if (!profileTrigger && !loginPopup.classList.contains('hidden')) {
            loginPopup.classList.add('hidden');
        }

        // Close notification popup if clicking outside
        const notificationContainer = document.querySelector('.relative.inline-block');
        if (!event.target.closest('.relative.inline-block') && notificationPopup.classList.contains('active')) {
            notificationPopup.classList.remove('active');
        }
    });

    function closeAndGoHome() {
      document.getElementById('loginPopup').classList.add('hidden');
       window.location.href = "{{ route('home') }}";
    }

    // Carousel Functions
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.slider-dot');

    function showSlide(n) {
        // Handle circular navigation
        if (n >= slides.length) {
            currentSlide = 0;
        } else if (n < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = n;
        }

        // Hide all slides and remove active class
        slides.forEach((slide, index) => {
            slide.classList.remove('active');
        });
        
        // Update all dots
        dots.forEach((dot, index) => {
            dot.classList.remove('active');
            if (index === currentSlide) {
                dot.classList.add('active');
                dot.style.backgroundColor = '#004271';
            } else {
                dot.style.backgroundColor = 'rgba(0,66,113,0.48)';
            }
        });

        // Show current slide
        slides[currentSlide].classList.add('active');
    }

    function goToSlide(n) {
        showSlide(n);
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Initialize carousel on page load
    window.addEventListener('DOMContentLoaded', () => {
        showSlide(0);
    });

    // Login Modal Functions
    function openLoginModal() {
        const modalOverlay = document.getElementById('loginModalOverlay');
        modalOverlay.classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeLoginModal() {
        const modalOverlay = document.getElementById('loginModalOverlay');
        modalOverlay.classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    // Close modal when clicking on the overlay (outside the modal)
    document.getElementById('loginModalOverlay').addEventListener('click', (e) => {
        if (e.target.id === 'loginModalOverlay') {
            closeLoginModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeLoginModal();
        }
    });

</script>

<!-- HERO SECTION -->
<section class="hero-section flex gap-8 p-8" style="width: 100%; max-width: 1550px; margin: 0 auto;">
    
    <!-- Left Image Slider -->
    <!-- Added relative and h-[500px] for stacking context --><div class="hero-left w-full max-w-[1200px] relative h-[220px] sm:h-[320px] md:h-[420px] rounded-[15px] overflow-hidden">
    <!-- Image 1 -->
    <img src="{{ asset('img/w.png') }}"
         class="slide-image active absolute inset-0 w-full h-auto rounded-[15px] ">

    <!-- Image 2 -->
    <img src="{{ asset('img/Festive2.png') }}"
         class="slide-image absolute inset-0 w-full h-auto rounded-[15px]">

    <!-- Image 3 -->
    <img src="{{ asset('img/festive_offer2.png') }}"
         class="slide-image absolute inset-0 w-full h-auto rounded-[15px]">

</div>

    <!-- Right Content -->  
    <div class="hero-right w-2/5 pl-2 pr-8 py-8 flex flex-col justify-center rounded-r-lg">

        <!-- Heading -->
        <h2 style="
            font-family:'Libre Baskerville', serif;
            font-weight:700;
            font-size:24px;
            line-height:100%;
            letter-spacing:0.03em;
            color:#004271;
             
            margin-bottom:10px;">
            Services Delivered Right to Your Home
        </h2>

        <ul class="space-y-5">
            <li class="flex items-center gap-4">
                <img src="{{ asset('img/service1.png') }}" style="width:38px;">
                <p class="text-[#353535] text-[15px]" style="line-height:100%; letter-spacing:0.03em;">
                    Expert Professionals at Your Doorstep
                </p>
            </li>
            <li class="flex items-center gap-4">
                <img src="{{ asset('img/service2.png') }}" style="width:38px;">
                <p class="text-[#353535] text-[15px] whitespace-nowrap" style="line-height:100%; letter-spacing:0.03em;">
                    Repairs, Cleaning & Complete Home Services
                </p>
            </li>
            <li class="flex items-center gap-4">
                <img src="{{ asset('img/service3.png') }}" style="width:38px;">
                <p class="text-[#353535] text-[15px]" style="line-height:100%; letter-spacing:0.03em;">
                    High-Quality & Reliable Work
                </p>
            </li>
            <li class="flex items-center gap-4">
                <img src="{{ asset('img/service4.png') }}" style="width:38px;">
                <p class="text-[#353535] text-[15px]" style="line-height:100%; letter-spacing:0.03em;">
                    Easy & Convenient Booking
                </p>
            </li>
            <li class="flex items-center gap-4">
                <img src="{{ asset('img/service5.png') }}" style="width:38px;">
                <p class="text-[#353535] text-[15px]" style="line-height:100%; letter-spacing:0.03em;">
                    On-Time and Trustworthy Service
                </p>
            </li>
        </ul>

        <!-- Slider dots -->
        <div class="flex justify-center gap-3 mt-8">
            <span class="slider-dot w-2.5 h-2.5 bg-[#004271] rounded-full cursor-pointer" data-index="0"></span> 
            <span class="slider-dot w-2.5 h-2.5 bg-[#004271]/40 rounded-full cursor-pointer" data-index="1"></span> 
            <span class="slider-dot w-2.5 h-2.5 bg-[#004271]/40 rounded-full cursor-pointer" data-index="2"></span> 
        </div>
    </div>
</section>

<!-- Updated JavaScript with Auto-Loop -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const images = document.querySelectorAll(".slide-image");
    const dots = document.querySelectorAll(".slider-dot");

    let currentIndex = 0;
    let slideInterval;

    function goToSlide(index) {

        images.forEach((img, i) => {
            img.classList.remove("active");
            if (i === index) {
                img.classList.add("active");
            }
        });

        dots.forEach((dot, i) => {
            dot.classList.remove("bg-[#004271]");
            dot.classList.add("bg-[#004271]/40");

            if (i === index) {
                dot.classList.remove("bg-[#004271]/40");
                dot.classList.add("bg-[#004271]");
            }
        });

        currentIndex = index;
    }

    function nextSlide() {
        let next = currentIndex + 1;
        if (next >= images.length) next = 0;
        goToSlide(next);
    }

    function startSlider() {
        slideInterval = setInterval(nextSlide, 3000);
    }

    dots.forEach(dot => {
        dot.addEventListener("click", function () {
            const index = Number(this.dataset.index);
            goToSlide(index);
            clearInterval(slideInterval);
            startSlider();
        });
    });

    goToSlide(0);
    startSlider();

});
</script>
{{------------------------------------All Categories--------------------------------------------}}
<section class="categories-section px-8 py-12" style="background: linear-gradient(to bottom, transparent 65%, #E4F9FF 65%);">
    <h2 class="text-2xl font-bold mb-8" style="color:#004271; font-family: 'Libre Baskerville'">All Categories</h2>

    <div class="flex flex-row flex-nowrap gap-6 overflow-x-auto hide-scrollbar pb-4">
        @foreach ($categories as $category)
        @php
            $categoryLink = $category->name === 'Core Home Services' ? route('coreservices.page') : '#';
        @endphp
        <a href="{{ $categoryLink }}" style="text-decoration:none;">
        <div class="flex-shrink-0">
            <div style="width: 143px; border-radius: 20px; overflow: hidden; background: white; border: 1.5px solid #004271; box-shadow: 0 4px 15px rgba(0, 66, 113, 0.15);">
                <div style="width: 100%; height: 133px; display: flex; align-items: center; justify-content: center; background: white;" class="category-img-wrapper">
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" style="width: 100px; height: 100px; object-fit: contain;">
                </div>
                <div style="height: 55px; background-color: #004271; display: flex; align-items: center; justify-content: center; padding: 0 10px;">
                    <p style="color: white; font-weight: 600; font-size: 14px; text-align: center; line-height: 1.3; margin: 0;">
                        {{ $category->name }}
                    </p>
                </div>
            </div>
        </div>
        </a>
        @endforeach
           

    </div>
</section>

<!-- ================= EVERYTHING WE OFFER ================= -->
<section class="offers-section px-8 py-12 bg-white">
     <h2 class="text-2xl font-bold mb-8" style="color:#004271;font-family: 'Libre Baskerville';">
            Everything We Offer
        </h2>

    <div class="flex flex-nowrap gap-6 overflow-x-auto hide-scrollbar pb-4">

        <div class="rounded-3xl overflow-hidden cursor-pointer relative flex-shrink-0 offer-card" style="width: 281px; height: 220px;">
            <div class="offer-img-container">
                <img src="img/we_offer1.png" alt="Professional Cleaning" class="w-full h-full object-cover rounded-3xl"style=" transform: scale(1.15);">
                <div class="offer-overlay">
                    <div class="offer-overlay-left">Maids</div>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden cursor-pointer relative flex-shrink-0 offer-card" style="width: 281px; height: 220px;">
            <div class="offer-img-container">
                <img src="img/we_offer2.png" alt="Laundry Services" class="w-full h-full object-cover rounded-3xl" style=" transform: scale(1.15);">
                <div class="offer-overlay">
                    <div class="offer-overlay-left">Laundry at Home</div>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden cursor-pointer relative flex-shrink-0 offer-card" style="width: 281px; height: 220px;">
            <div class="offer-img-container">
                <img src="img/we_offer3.png" alt="Shoe Cleaning" class="w-full h-full object-cover rounded-3xl"style=" transform: scale(1.15);">
                <div class="offer-overlay">
                    <div class="offer-overlay-left">Laundry Collection </div>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden cursor-pointer relative flex-shrink-0 offer-card" style="width: 281px; height: 220px;">
            <div class="offer-img-container">
                <img src="img/we_offer4.png" alt="Professional Services" class="w-full h-full object-cover rounded-3xl"style=" transform: scale(1.15);">
                <div class="offer-overlay">
                    <div class="offer-overlay-left"> Deep Cleaning</div>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden cursor-pointer relative flex-shrink-0 offer-card" style="width: 281px; height: 220px;">
            <div class="offer-img-container">
                <img src="img/we_offer5.png" alt="Home Services" class="w-full h-full object-cover rounded-3xl"style=" transform: scale(1.15);">
                <div class="offer-overlay">
                    <div class="offer-overlay-left">Move-in/Move-out Cleaning</div>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="quick-picks-section bg-white px-8 py-6 relative w-full">

    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold mb-8" style="color:#004271;font-family: 'Libre Baskerville';">
             Quick Picks
        </h2>
        <a href="#" class="text-blue-600 text-sm">See all</a>
    </div>

    <div class="flex gap-6 overflow-x-auto hide-scrollbar pb-4">
        
        {{-- Card 1 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                
                <div class="category-img-wrapper h-full">
                    <img src="img/quick_picks1.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Maids</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/quick_picks2.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Laundry at Home</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/quick_picks3.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Laundry Collection</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/quick_picks4.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Deep Cleaning</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 5 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/quick_picks5.png" class="w-full h-full object-cover" style=" transform: scale(1.15);">
                </div>
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Move-in/Move-out Cleaning</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- BOTTOM SECTION: Special Offers (Two Images) -->
<!-- Added pb-0 to remove section bottom whitespace -->
<section class="special-offers-section bg-white px-8 pt-6 pb-0 relative w-full">
    
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold mb-8" style="color:#004271;font-family: 'Libre Baskerville'">Special Offers & Campaigns</h2>
    </div>

   
    <!-- Added items-start so columns don't stretch to match heights, preventing white space in shorter cards -->
    <div class="flex gap-6 w-full items-start">
        
        <!-- Left Image (Offer 1) -->
        <div class="w-1/2 flex-shrink-0 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer">
            <!-- Added block to remove bottom whitespace under image -->
            <img src="img/Festive2.png" class="w-full h-auto object-cover block">
        </div>

        <!-- Right Image (Offer 2) -->
        <div class="w-1/2 flex-shrink-0 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer">
            <!-- Added block to remove bottom whitespace under image -->
            <img src="img/Festive3.png" class="w-full h-auto object-cover block">
        </div>

    </div>
</section>
<!-- ================= BEAUTY, QWIK & EASY ================= -->
<section class="beauty-section bg-white px-8 py-6 relative w-full">

    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold mb-8" style="color:#004271;font-family: 'Libre Baskerville';">
            Beauty, Qwik & Easy
        </h2>
        <a href="#" class="text-blue-600 text-sm">See all</a>
    </div>

    <div class="flex gap-6 overflow-x-auto hide-scrollbar pb-4">
        
        {{-- Card 1 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/beauty1.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Beauty</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/beauty2.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Spa</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/beauty3.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Salon</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/beauty4.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Makeup</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 5 --}}
        <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
            <div class="offer-img-container h-full">
                <div class="category-img-wrapper h-full">
                    <img src="img/beauty5.png" class="w-full h-full object-cover"style=" transform: scale(1.15);">
                </div>
                <div class="offer-overlay">
                    <span class="offer-overlay-left">Skin Care</span>
                    <div class="offer-overlay-right">
                        <div class="offer-icons">
                            <button class="offer-icon-btn cart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="9" cy="21" r="1.5"/>
                                    <circle cx="20" cy="21" r="1.5"/>
                                </svg>
                            </button>
                            <button class="offer-icon-btn heart-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="offer-know-more">Know More</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer>
  <div class="custom-footer" style="background:#E4F9FF; padding:10px 5%; font-family:Arial, sans-serif;">
    
    <div style="max-width:1200px; margin:auto;">

      <!-- TOP SECTION -->
      <div style="display:flex; flex-wrap:wrap; justify-content:space-between; gap:40px;">

        <!-- LEFT BRAND -->
        <div style="flex:1; min-width:280px;">
          <img src="img/logo.png" alt="QwikHom"
               style="height:60px; margin-bottom:20px;">

          <h3 style="font-size:18px; margin-bottom:15px; font-family:'Libre Baskerville'">
            Comfort Delivered to Your Home
          </h3>

          <p style="font-size:14px; color:#333; line-height:1.6; max-width:600px; font-family:'Libre Baskerville'">
            Experience seamless, reliable, and professional solutions for all your home needs. Our trusted experts arrive at your doorstep to handle tasks with care, efficiency, and attention to detail. With easy booking, quick support, and quality you can count on, we make everyday living simpler, smoother, and stress-free.
          </p>
        </div>

        <!-- RIGHT LINKS -->
        <div style="display:flex; gap:60px; flex-wrap:wrap;">

          <!-- QUICK LINKS -->
          <div>
            <h4 style="margin-bottom:15px; font-family:'Libre Baskerville'">Quick Links</h4>
<ul style="list-style:none; padding:0; font-size:14px;">
  <li style="margin-bottom:10px;">
    <a href="#" style="color:#555; text-decoration:none;">▶ About Us</a>
  </li>

  <li style="margin-bottom:10px;">
    <a href="#" style="color:#555; text-decoration:none;">▶ Services</a>
  </li>

  <li style="margin-bottom:10px;">
    <a href="#" style="color:#555; text-decoration:none;">▶ How it Works</a>
  </li>

  <li style="margin-bottom:10px;">
    <a href="#" style="color:#555; text-decoration:none;">▶ Book & Service</a>
  </li>

  <li style="margin-bottom:10px;">
    <a href="#" style="color:#555; text-decoration:none;">▶ Offers</a>
  </li>

  <li>
    <a href="#" style="color:#555; text-decoration:none;">▶ Download App</a>
  </li>
</ul>        </div>

          <!-- LEGAL -->
<div>
  <h4 style="margin-bottom:15px; font-family:'Libre Baskerville'">Legal</h4>
  <ul style="list-style:none; padding:0; font-size:14px;">
    <li style="margin-bottom:8px;">
      <a href="#" style="color:#555; text-decoration:none;">▶ Terms & Conditions</a>
    </li>
    <li style="margin-bottom:8px;">
      <a href="#" style="color:#555; text-decoration:none;">▶ Privacy Policy</a>
    </li>
    <li style="margin-bottom:8px;">
      <a href="#" style="color:#555; text-decoration:none;">▶ Refund Policy</a>
    </li>
    <li style="margin-bottom:8px;">
      <a href="#" style="color:#555; text-decoration:none;">▶ Help & Support</a>
    </li>
    <li style="margin-bottom:8px;">
      <a href="#" style="color:#555; text-decoration:none;">▶ Careers</a>
    </li>
    <li>
      <a href="#" style="color:#555; text-decoration:none;">▶ Contact Us</a>
    </li>
  </ul>
</div>
        </div>
      </div>

      <!-- BOTTOM SECTION -->
      <div style="border-top:1px solid #004271; margin-top:40px; padding-top:20px;
                  display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap;">

        <p style="font-size:14px; margin:0;">Copyright</p>

        <div style="display:flex; gap:15px;">
          <img src="img/facebook.png" width="32">
          <img src="img/instagram.png" width="32">
          <img src="img/utube.png" width="32">
        </div>

      </div>

    </div>
  </div>
</footer>

<!-- Login Modal Overlay -->
<div id="loginModalOverlay" class="login-modal-overlay">
    <div class="login-modal">
        <!-- Close Button -->
        <button class="login-close-btn" onclick="closeLoginModal()">&times;</button>

        <h2>Login</h2>

        <!-- Label with Icon -->
        <div class="login-input-label">
            <div class="login-phone-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                </svg>
            </div>
            <span class="login-label-text">Enter your Phone Number</span>
        </div>

        <!-- Login Form -->
        <form action="{{ route('verification') }}" method="GET">
            <input 
                type="text" 
                name="phone" 
                class="login-input" 
                placeholder="Enter your Phone Number"
                required
            >

            <button type="submit" class="login-continue-btn">Continue</button>
        </form>

        <div class="login-signup-text">
            Don't have an account? <a href="{{ route('signup.page') }}">Sign up here</a>
        </div>
    </div>
</div>

</body>
</html>
