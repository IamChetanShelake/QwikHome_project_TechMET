<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Core Home Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Responsive Styles -->
    <style>
        /* Global Box Model */
        * {
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #FFFFFF;
            overflow-x: hidden; /* Prevent horizontal scroll on the whole page */
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            /* Header Adjustments */
            .header-container {
                flex-wrap: wrap !important;
                padding: 15px !important;
                gap: 10px !important;
            }
            
            .header-title {
                width: 100% !important;
                text-align: center;
                margin: 10px 0 0 0 !important;
                order: 2; /* Move title below logo/search if needed, or keep natural */
            }

            .search-container {
                width: 100% !important;
                margin-left: 0 !important;
                order: 3; /* Ensure search is at bottom of header */
                margin-top: 5px;
            }

            /* Service Cards (Explore) */
            .explore-scroll {
                padding: 0 15px !important;
            }

            /* Laundry Cards - Make them fit mobile screen width */
            .laundry-card {
                width: 85vw !important; /* 85% of viewport width */
                min-width: 280px !important;
            }

            /* Wardrobe Grid - Stack Columns */
            .wardrobe-grid {
                flex-direction: column !important;
                padding: 20px 15px !important;
            }
            .wardrobe-card {
                flex: 1 1 100% !important;
                margin-bottom: 20px;
            }

            /* Footer Adjustments */
            .footer-main {
                padding: 30px 15px !important;
            }
            .footer-flex {
                flex-direction: column !important;
            }
            .footer-links-container {
                flex-direction: column !important;
                gap: 30px !important;
                width: 100%;
            }
            .footer-bottom {
                flex-direction: column !important;
                text-align: center;
                gap: 15px !important;
            }
        }

        /* Tablet Adjustments */
        @media (min-width: 769px) and (max-width: 1024px) {
            .laundry-card {
                width: 60vw !important; /* Slightly smaller on tablet */
            }
            .wardrobe-card {
                flex: 1 1 100% !important; /* Stack cards on tablet too if they are too big */
            }
        }


         .page-container{
    max-width:1550px;
    margin:0 auto;
    width:100%;
    padding:0 20px;
    box-sizing:border-box;
}
    </style>
</head>
<body>

   <!-- Header -->
<div class="header-container" style="
    background-color:#E4F9FF; 
    padding:20px 40px; 
    display:flex; 
    align-items:center; 
    gap:15px;
    box-shadow: 0px 6px 8px rgba(0,0,0,0.18);
">

    <!-- Back Button Image -->
    <a href="{{ route('home') }}" style="display:flex; align-items:center; flex-shrink:0;">
        <img src="img/arrow.png" 
             alt="Back"
             style="
                width:26px;
                height:52px;
                cursor:pointer;
             ">
    </a>

    <!-- Title -->
    <h2 class="header-title" style="
        width:310px;
        height:30px;
        margin:0;
        font-family:'Libre Baskerville', serif;
        font-weight:700;
        font-size:24px;
        line-height:100%;
        letter-spacing:3%;
        color:#004271;
    ">
        Core Home Services
    </h2>

   <!-- Search Container -->
<div class="search-container" style="
    margin-left:auto;
    position:relative;
    width:350px;
    height:40px;
">

    <!-- Search Icon -->
    <img src="img/search.png"
         alt="Search"
         style="
            position:absolute;
            left:15px;
            top:50%;
            transform:translateY(-50%);
            width:22px;
            height:19.85px;
            padding:2px;
            border-radius:3px;
            z-index: 1;
         ">

    <!-- Search Input -->
    <input type="text"
        placeholder="Search here"
        style="
            width:100%;
            height:40px;
            padding-left:50px;
            border-radius:20px;
            border:1px solid #004271;
            outline:none;
            box-sizing:border-box;
            position: absolute;
            right: 0;
            top: 0;
        ">
</div>

</div>
 <div class="page-container">
<!-- Explore Services -->
<div class="explore-scroll" style="padding:20px 40px;"> 

    <h3 style="
        width: 100%; /* Changed to full width */
        height: 30px;
        font-family: 'Libre Baskerville', serif;
        font-weight: 700;
        font-size: 24px;
        line-height: 100%;
        letter-spacing: 3%;
        color: #004271;
        margin-bottom: 15px;
    ">
        Explore Services
    </h3>

    <div style="
        display:flex; 
        flex-wrap:nowrap; 
        gap:30px; 
        justify-content:flex-start;
        overflow-x:auto; 
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding-bottom: 15px;
    ">

        <!-- Laundry at Home Card -->
        <div style="
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 144px;
            height: 188px;
            cursor: pointer;
            border-radius: 20px;
            background-color: #fff;
            border: 1.5px solid #004271;
            box-shadow: 0px 4px 4px rgba(0,0,0,0.25);
            box-sizing: border-box;
            overflow: hidden;
            flex-shrink:0; 
        ">
            <div style="display: flex; justify-content: center; align-items: center; height: 133px; width: 100%; background-color: #fff;">
                <img src="img/img1.png" alt="Laundry at Home" style="width: 127px; height: 72px;">
            </div>
            <div style="width: 100%; height: 55px; background: #004271; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; display: flex; justify-content: center; align-items: center;">
                <p style="width: 95px; height: 32px; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; line-height: 100%; text-align: center; color: #ffffff; margin: 0;">
                    Laundry at Home
                </p>
            </div>
        </div>

        <!-- Laundry Collection Card -->
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: flex-start; width: 144px; height: 188px; cursor: pointer; border-radius: 20px; background-color: #fff; border: 1.5px solid #E0E0E0; overflow: hidden; flex-shrink:0; ">
            <div style="display: flex; justify-content: center; align-items: center; height: 133px; width: 100%; background-color: #fff;">
                <img src="img/img2.png" alt="Laundry Collection" style="width: 95px; height: 85px;">
            </div>
            <div style="width: 100%; height: 55px; background: #EAEAEA; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; display: flex; justify-content: center; align-items: center;">
                <p style="width: 95px; height: 32px; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; line-height: 100%; text-align: center; color: #1F1F1F; margin: 0;">
                    Laundry Collection
                </p>
            </div>
        </div>

        <!-- Deep Cleaning Card -->
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: flex-start; width: 144px; height: 188px; cursor: pointer; border-radius: 20px; background-color: #fff; border: 1.5px solid #E0E0E0; overflow: hidden; flex-shrink:0;">
            <div style="display: flex; justify-content: center; align-items: center; height: 133px; width: 100%; background-color: #fff;">
                <img src="img/img3.png" alt="Deep Cleaning" style="width: 
110.59px; height: 97.25px">
            </div>
            <div style="width: 100%; height: 55px; background: #EAEAEA; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; display: flex; justify-content: center; align-items: center;">
                <p style="width: 95px; height: 32px; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; line-height: 100%; text-align: center; color: #1F1F1F; margin: 0;">
                    Deep Cleaning
                </p>
            </div>
        </div>

        <!-- Move-in/Move-out Card -->
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:flex-start; width:144px; height:188px; cursor:pointer; border-radius:20px; background-color:#fff; border:1.5px solid #E0E0E0; overflow:hidden;flex-shrink:0; ">
            <div style="display:flex; justify-content:center; align-items:center; height:133px; width:100%; background-color:#fff;">
                <img src="img/img4.png" alt="Move-in/Move-out" style="width: 103px; height: 96px;">
            </div>
            <div style="width:100%; height:55px; background:#EAEAEA; border-bottom-left-radius:20px; border-bottom-right-radius:20px; display:flex; justify-content:center; align-items:center;">
                <p style="width:95px; height:32px; font-family:'Roboto', sans-serif; font-weight:400; font-size:14px; line-height:100%; text-align:center; color:#1F1F1F; margin:0;">
                    Move-in/Move-out
                </p>
            </div>
        </div>

        <!-- Disinfection Card -->
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:flex-start; width:144px; height:188px; cursor:pointer; border-radius:20px; background-color:#fff; border:1.5px solid #E0E0E0; overflow:hidden;flex-shrink:0; ">
            <div style="display:flex; justify-content:center; align-items:center; height:133px; width:100%; background-color:#fff;">
                <img src="img/img5.png" alt="Disinfection Services" style="width: 105px; height: 79px;">
            </div>
            <div style="width:100%; height:55px; background:#EAEAEA; border-bottom-left-radius:20px; border-bottom-right-radius:20px; display:flex; justify-content:center; align-items:center;">
                <p style="width:95px; height:32px; font-family:'Roboto', sans-serif; font-weight:400; font-size:14px; line-height:100%; text-align:center; color:#1F1F1F; margin:0;">
                    Disinfection
                </p>
            </div>
        </div>

        <!-- Refrigerator Cleaning Card -->
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:flex-start; width:144px; height:188px; cursor:pointer; border-radius:20px; background-color:#fff; border:1.5px solid #E0E0E0; overflow:hidden;flex-shrink:0; ">
            <div style="display:flex; justify-content:center; align-items:center; height:133px; width:100%; background-color:#fff;">
                <img src="img/img6.png" alt="Refrigerator Cleaning" style="width: 100px; height: 100px;">
            </div>
            <div style="width:100%; height:55px; background:#EAEAEA; border-bottom-left-radius:20px; border-bottom-right-radius:20px; display:flex; justify-content:center; align-items:center;">
                <p style="width:95px; height:32px; font-family:'Roboto', sans-serif; font-weight:400; font-size:14px; line-height:100%; text-align:center; color:#1F1F1F; margin:0;">
                    Refrigerator Cleaning
                </p>
            </div>
        </div>

        <!-- Pest Control Card -->
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:flex-start; width:144px; height:188px; cursor:pointer; border-radius:20px; background-color:#fff; border:1.5px solid #E0E0E0; overflow:hidden;flex-shrink:0; ">
            <div style="display:flex; justify-content:center; align-items:center; height:133px; width:100%; background-color:#fff;">
                <img src="img/img7.png" alt="Pest Control" style="width: 98px; height: 79px;">
            </div>
            <div style="width:100%; height:55px; background:#EAEAEA; border-bottom-left-radius:20px; border-bottom-right-radius:20px; display:flex; justify-content:center; align-items:center;">
                <p style="width:95px; height:32px; font-family:'Roboto', sans-serif; font-weight:400; font-size:14px; line-height:100%; text-align:center; color:#1F1F1F; margin:0;">
                    Pest Control
                </p>
            </div>
        </div>

        <!-- Movers & Packers Card -->
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:flex-start; width:144px; height:188px; cursor:pointer; border-radius:20px; background-color:#fff; border:1.5px solid #E0E0E0; overflow:hidden;flex-shrink:0; ">
            <div style="display:flex; justify-content:center; align-items:center; height:133px; width:100%; background-color:#fff;">
                <img src="img/img8.png" alt="Movers & Packers" style="width: 116px; height: 78px;">
            </div>
            <div style="width:100%; height:55px; background:#EAEAEA; border-bottom-left-radius:20px; border-bottom-right-radius:20px; display:flex; justify-content:center; align-items:center;">
                <p style="width:95px; height:32px; font-family:'Roboto', sans-serif; font-weight:400; font-size:14px; line-height:100%; text-align:center; color:#1F1F1F; margin:0;">
                    Movers & Packers
                </p>
            </div>
        </div>

    </div>
</div>

    <!-- Laundry at Home -->
<div style="padding: 0px;"> <!-- Removed side padding here, moved to inner flex -->
    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding: 20px 40px;
    ">
        <h3 style="
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 24px;
            color: #2D2D2D;
            margin: 0;
        ">
            Laundry at Home
        </h3>
        
        <a href="#" style="
            font-family: Roboto, sans-serif;
            font-weight: 400;
            font-size: 20px;
            text-decoration: underline;
            color: #004271;
            white-space: nowrap;
        ">
            See all
        </a>
    </div>

<!-- Horizontal Scroll Container -->
<div style="
    display: flex;
    flex-wrap: nowrap;
    gap: 30px;
    justify-content: flex-start;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding: 0 40px 20px 40px;
">
            
    <!-- Card 1: Ironing -->
    <div class="laundry-card" style="
        max-width: 538px;
        width: 520px;
        flex-shrink: 0;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        font-family: Roboto, sans-serif;
        position: relative;
        background: #fff;
        box-shadow: 0 8px 10px -6px rgba(0,0,0,0.2);
    ">

        <img src="img/heart.png" alt="Favorite" style="position: absolute; top: 20px; right: 20px; width: 23px; height: 20px; cursor: pointer;">

        <div style="display: flex; gap: 20px;">
            <img src="img/ironing.png" alt="Ironing" style="width: 118px; height: 132px; border-radius: 10px; border: 1px solid #B2B2B2; object-fit: cover; flex-shrink: 0;">

            <div style="flex: 1; display: flex; flex-direction: column;">
                <h3 style="margin: 0 0 8px 0; font-size: 20px; font-weight: 500; color: #353535;">Ironing</h3>
                <p style="margin: 0 0 25px 0; font-size: 16px; font-weight: 400; color: #353535; line-height: 1.4;">
                    Wrinkle-free clothes, crisp and neat – ready to wear anytime.
                </p>
                <p style="margin: 0; font-size: 20px; font-weight: 600; color: #353535;">
                    Starts at AED 499
                </p>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 25px; flex-wrap: wrap;">
                 <button style="width: 118px; height: 30px; border-radius: 10px; border: none; background: #E4F9FF; color: #004271; font-size: 15px; font-weight: 400; cursor: pointer;">
                    Book Now
                </button>
                <a href="/iron" style="font-size: 16px; font-weight: 500; color: #004271; text-decoration: none;">
                    View Details
                </a>
            </div>
            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 5px;">
                <span style="font-size: 25px; color: #6F6F6F;">★★★☆☆</span>
                <span style="font-size: 15px; color: #6F6F6F;">(30 k reviews)</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Folding -->
    <div class="laundry-card" style="
        width: 520px;
        flex-shrink: 0;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        font-family: Roboto, sans-serif;
        position: relative;
        background: #fff;
        box-shadow: 0 6px 12px -4px rgba(0,0,0,0.15);
    ">
        <img src="img/heart.png" alt="Favorite" style="position: absolute; top: 20px; right: 20px; width: 23px; height: 20px; cursor: pointer;">

        <div style="display: flex; gap: 20px;">
            <img src="img/folding.png" alt="Folding" style="width: 118px; height: 132px; border-radius: 10px; border: 1px solid #B2B2B2; object-fit: cover; flex-shrink: 0;">

            <div style="flex: 1; display: flex; flex-direction: column;">
                <h3 style="margin: 0 0 8px 0; font-size: 20px; font-weight: 500; color: #353535;">Folding</h3>
                <p style="margin: 0 0 25px 0; font-size: 16px; color: #353535; line-height: 1.4;">
                    Properly folded clothes to save space and keep organized.
                </p>
                <p style="margin: 0; font-size: 20px; font-weight: 600; color: #353535;">
                    Starts at AED 599
                </p>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 25px; flex-wrap: wrap;">
                <button style="width: 118px; height: 30px; border-radius: 10px; border: none; background: #E4F9FF; color: #004271; font-size: 15px; cursor: pointer;">
                    Book Now
                </button>
                <a href="#" style="font-size: 16px; font-weight: 500; color: #004271; text-decoration: none;">
                    View Details
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 5px;">
                <span style="font-size: 25px; color: #6F6F6F;">★★★★☆</span>
                <span style="font-size: 15px; color: #6F6F6F;">(18 k reviews)</span>
            </div>
        </div>
    </div>

    <!-- Card 3: Wardrobe Care Pack -->
    <div class="laundry-card" style="
        width: 520px;
        flex-shrink: 0;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        font-family: Roboto, sans-serif;
        position: relative;
        background: #fff;
        box-shadow: 0 6px 12px -4px rgba(0,0,0,0.15);
    ">

        <img src="img/heart.png" alt="Favorite" style="position: absolute; top: 20px; right: 20px; width: 23px; height: 20px; cursor: pointer;">

        <div style="display: flex; gap: 20px;">
            <img src="img/wardrobe.png" alt="Wardrobe Care Pack" style="width: 118px; height: 132px; border-radius: 10px; border: 1px solid #B2B2B2; object-fit: cover; flex-shrink: 0;">

            <div style="flex: 1; display: flex; flex-direction: column;">
                <h3 style="margin: 0 0 8px 0; font-size: 20px; font-weight: 500; color: #353535;">Wardrobe Care Pack</h3>
                <p style="margin: 0 0 25px 0; font-size: 16px; color: #353535; line-height: 1.4;">
                    Organize, clean, and refresh your wardrobe efficiently.
                </p>
                <p style="margin: 0; font-size: 20px; font-weight: 600; color: #353535;">
                    Starts at AED 799
                </p>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 25px; flex-wrap: wrap;">
                <button style="width: 118px; height: 30px; border-radius: 10px; border: none; background: #E4F9FF; color: #004271; font-size: 15px; cursor: pointer;">
                    Book Now
                </button>
                <a href="#" style="font-size: 16px; font-weight: 500; color: #004271; text-decoration: none;">
                    View Details
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 5px;">
                <span style="font-size: 25px; color: #6F6F6F;">★★★★★</span>
                <span style="font-size: 15px; color: #6F6F6F;">(25 k reviews)</span>
            </div>
        </div>
    </div>
</div>
</div>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

{{--  Wardrobe Care Pack Section  --}}
<div style="padding: 0px;">
<!-- ====== ROW WRAPPER (Grid Section) ====== -->
<div class="wardrobe-grid" style="
    display:flex;
    flex-wrap:wrap;
    gap:35px;
    padding:20px 40px;
    box-sizing:border-box;
">

  <!-- ================= CARD 1 ================= -->
  <div class="wardrobe-card" style="
      flex:1 1 48%;
      min-width:320px;
      font-family:Roboto, sans-serif;
  ">

    <h3 style="margin:0 0 16px 0;font-weight:500;font-size:24px;color:#2D2D2D;">
        Wardrobe Care Pack
    </h3>

    <div style="
        width:100%;
        aspect-ratio:658/261;
        position:relative;
        border:1px solid #DCDCDC;
        border-top-left-radius:15px;
        border-top-right-radius:15px;
        overflow:hidden;
    ">
        <img src="img/img9.png" alt="Wardrobe Care" style="width:100%; height:100%; object-fit:cover;">

        <div style="
            position:absolute;
            top:15px;
            left:15px;
            padding:6px 14px;
            border-radius:20px;
            background:#E4F9FF;
            font-size:20px;
            font-weight:300;
        ">
            Extra 15% off for new users with
            <span style="font-weight:600; color:#004271;">NEW15</span>
        </div>
    </div>

    <div style="
        width:100%;
        background:#FFFFFF;
        border:0.5px solid #DCDCDC;
        border-bottom-left-radius:20px;
        border-bottom-right-radius:20px;
        box-shadow:0px 4px 4px #00000017;
        padding:20px;
        box-sizing:border-box;
    ">

        <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">

            <p style="margin:0;font-weight:500;font-size:18px;color:#353535;flex:1 1 250px;">
                Ironing, folding & wardrobe refresh.
            </p>

            <div style="text-align:right;">
                <div style="font-weight:600;font-size:18px;color:#353535;">
                    AED 1,499
                </div>
                <div style="font-weight:300;font-size:14px;text-decoration:line-through;color:#6F6F6F;margin-top:6px;">
                    AED 1,999
                </div>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:8px; margin-top:14px; flex-wrap:wrap;">
            <span style="font-size:24px;color:#6F6F6F;padding:2px 6px;border-radius:4px;">
                ★★★☆☆
            </span>
            <span style="font-family:Poppins, sans-serif;font-weight:300;font-size:14px;color:#6F6F6F;">
                (30k reviews)
            </span>
        </div>

        <div style="display:flex; align-items:center; gap:20px; margin-top:18px; flex-wrap:wrap;">
            <button style="padding:8px 18px;border-radius:10px;border:none;background:#E4F9FF;font-family:Roboto, sans-serif;font-size:14px;color:#004271;cursor:pointer;">
                Book Now
            </button>
            <a href="#" style="font-family:Roboto, sans-serif;font-weight:500;font-size:14px;text-decoration:underline;color:#004271;">
                View Details
            </a>
        </div>

    </div>
  </div>


  <!-- ================= CARD 2 ================= -->
  <div class="wardrobe-card" style="
      flex:1 1 48%;
      min-width:320px;
      font-family:Roboto, sans-serif;
  ">

    <h3 style="margin:0 0 16px 0;font-weight:500;font-size:24px;color:#2D2D2D;">
        Festive Wardrobe Makeover
    </h3>

    <div style="
        width:100%;
        aspect-ratio:658/261;
        position:relative;
        border:1px solid #DCDCDC;
        border-top-left-radius:15px;
        border-top-right-radius:15px;
        overflow:hidden;
    ">
        <img src="img/img9.png" alt="Wardrobe Care" style="width:100%; height:100%; object-fit:cover;">

        <div style="
            position:absolute;
            top:15px;
            left:15px;
            padding:6px 14px;
            border-radius:20px;
            background:#E4F9FF;
            font-size:20px;
            font-weight:300;
        ">
            Extra 15% off for new users with
            <span style="font-weight:600; color:#004271;">NEW15</span>
        </div>
    </div>

    <div style="
        width:100%;
        background:#FFFFFF;
        border:0.5px solid #DCDCDC;
        border-bottom-left-radius:20px;
        border-bottom-right-radius:20px;
        box-shadow:0px 4px 4px #00000017;
        padding:20px;
        box-sizing:border-box;
    ">

        <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">

            <p style="margin:0;font-weight:500;font-size:18px;color:#353535;flex:1 1 250px;">
                Ironing, folding & wardrobe refresh.
            </p>

            <div style="text-align:right;">
                <div style="font-weight:600;font-size:18px;color:#353535;">
                    AED 1,499
                </div>
                <div style="font-weight:300;font-size:14px;text-decoration:line-through;color:#6F6F6F;margin-top:6px;">
                    AED 1,999
                </div>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:8px; margin-top:14px; flex-wrap:wrap;">
            <span style="font-size:24px;color:#6F6F6F;padding:2px 6px;border-radius:4px;">
                ★★★☆☆
            </span>
            <span style="font-family:Poppins, sans-serif;font-weight:300;font-size:14px;color:#6F6F6F;">
                (30k reviews)
            </span>
        </div>

        <div style="display:flex; align-items:center; gap:20px; margin-top:18px; flex-wrap:wrap;">
            <button style="padding:8px 18px;border-radius:10px;border:none;background:#E4F9FF;font-family:Roboto, sans-serif;font-size:14px;color:#004271;cursor:pointer;">
                Book Now
            </button>
            <a href="#" style="font-family:Roboto, sans-serif;font-weight:500;font-size:14px;text-decoration:underline;color:#004271;">
                View Details
            </a>
        </div>

    </div>
  </div>
</div>
</div>

  <!-- Footer -->
<div class="footer-main" style="background-color:#E4F9FF; padding:50px 40px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin-top: 40px; ">

    <!-- Main Container -->
    <div style="max-width:1200px; margin:0 auto;">
        
        <!-- Top Section: Brand Left | Links Right -->
        <div class="footer-flex" style="display:flex; flex-wrap:wrap; justify-content:space-between; gap:40px;">
            
            <!-- LEFT: Brand Info -->
            <div style="flex:1; min-width: 280px;">
               <img src="img/logo.png" alt="QwikHom Services" style="height:65px; width:auto; max-width:100%; display:block; margin:0 0 25px 0;">
               
               <h3 style="margin: 10px 0 20px 0; font-family: 'Libre Baskerville', serif; font-weight: 700; font-size: 20px; line-height: 1.2; letter-spacing: 0.05em; color: #2D2D2D;">
                 Comfort Delivered to Your Home
               </h3>
               
               <p style="width: 100%; max-width: 630px; font-family:'Roboto', sans-serif; font-weight:400; font-size:14px; line-height:1.1; letter-spacing:0.05em; color:#2D2D2D; margin:0;">
               Experience seamless, reliable, and professional solutions for all your home needs. Our trusted experts arrive at your doorstep to handle tasks with care, efficiency, and attention to detail. With easy booking, quick support, and quality you can count on, we make everyday living simpler, smoother, and stress-free.
               </p>
            </div>

            <!-- RIGHT: Link Columns -->
            <div class="footer-links-container" style="display:flex; gap:60px; min-width:280px;">
                
                <!-- Quick Links -->
                <div>
                   <h5 style="font-family:'Libre Baskerville', serif; font-weight:700; font-size:16px; line-height:100%; letter-spacing:0.05em; color:#2D2D2D; margin:0 0 20px 0;">
                    Quick Links
                   </h5>
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            About Us
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Services
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            How it Works
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Book & Service
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Offers & Campaigns
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Download App
                        </a>
                    </div>
                </div>

                <!-- Legal -->
                <div>
                    <h5 style="font-family:'Libre Baskerville', serif; font-weight:700; font-size:16px; line-height:100%; letter-spacing:0.05em; color:#2D2D2D; margin:0 0 20px 0;">Legal</h5>
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Terms & Conditions
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Privacy Policy
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Cancellation & Refund
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Help & Support
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Careers
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#565656; font-size:14px;">
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L10 5L0 10" fill="#565656"/></svg>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Line + Copyright Left + 3 Logos Right -->
        <div class="footer-bottom" style="border-top:2px solid #004271; margin-top:40px; padding-top:25px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px;">
            
            <!-- Left: Copyright -->
            <p style="margin:0; font-size:14px;font-family:'Roboto', sans-serif; color:#2D2D2D;">Copyright</p>

            <!-- Right: Exactly 3 Logos -->
            <div style="display:flex; gap:15px;">
                <a href="#" style="display:flex;">
                    <img src="img/facebook.png" alt="Facebook" style="width:35px; height:35px; object-fit:contain; display:block;">
                </a>
                <a href="#" style="display:flex;">
                    <img src="img/instagram.png" alt="Instagram" style="width:35px; height:35px; object-fit:contain; display:block;">
                </a>
                <a href="#" style="display:flex;">
                    <img src="img/youtube.png" alt="Youtube" style="width:35px; height:35px; object-fit:contain; display:block;">
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>