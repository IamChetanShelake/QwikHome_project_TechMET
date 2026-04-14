<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Cart</title>

    
<style>
    /* ================= GLOBAL FIX ================= */
    * {
        box-sizing: border-box;
     
      
    }

    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    /* ================= RESPONSIVE FIXES ================= */

    @media (max-width: 1100px) {
        /* 1. FIX SLOT SECTION LAYOUT */
        div[style*="gap: 50px"][style*="align-items: flex-start"] {
            flex-direction: column !important;
            gap: 20px !important;
        }

        div[style*="flex: 0 0 659px"] {
            flex: 1 1 100% !important;
            max-width: 100% !important;
            width: 100% !important;
            height: auto !important;
        }

        div[style*="min-width: 600px"] {
            min-width: auto !important;
            width: 100% !important;
        }

        /* 2. FIX CALENDAR HEADER */
        #slot-section div[style*="background-color: #D9D9D9"] {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            padding: 0 10px !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        #prev-month, #next-month {
            flex: 0 0 25px !important;
            width: 25px !important;
            height: 25px !important;
            display: block !important;
            visibility: visible !important;
        }

        #month-year-label {
            flex: 1 1 auto !important;
            text-align: center !important;
            white-space: nowrap !important;
            font-size: 16px !important;
            padding: 0 5px !important;
        }

        /* 3. FIX "SELECT TIME" POSITION */
        div[style*="gap: 330px"] > div:nth-child(2) {
            display: none !important;
        }
        
        div[style*="gap: 330px"] {
            gap: 20px !important;
            flex-wrap: wrap !important;
        }

        #time-slots::before {
            content: "Select Time";
            display: block;
            width: 100%;
            font-family: 'Roboto', sans-serif;
            font-weight: 600;
            font-size: clamp(18px, 4vw, 24px);
            color: #353535;
            margin-bottom: 15px;
        }

        /* 4. FIX PAYMENT SECTION (Exact Selectors without spaces) */
        
        /* A. Force Main Container to Stack (Targets gap:40px) */
        div[style*="gap:40px"][style*="align-items:flex-start"] {
            flex-direction: column !important;
            width: 100% !important;
            padding: 0 20px !important;
            box-sizing: border-box !important;
        }

        /* B. Force Right Column to fit screen (Targets min-width:801px) */
        div[style*="min-width:801px"] {
            min-width: auto !important;
            width: 100% !important;
            flex: none !important;
        }

        /* C. Force Inner Price Boxes to fit screen */
        div[style*="max-width:801px"],
        div[style*="max-width:780px"] {
            max-width: 100% !important;
            width: 100% !important;
        }
    }

    @media (max-width: 600px) {
        /* Cart Item Adjustments */
        label div[style*="justify-content: space-between"][style*="align-items: center"] {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
        }

        .hide-scroll {
            flex-direction: column !important;
            overflow-x: hidden !important;
        }

        .hide-scroll label {
            max-width: 100% !important;
        }

        div[style*="justify-content: flex-end"] {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 15px !important;
        }

        #time-slots > div {
            width: calc((100% - 15px) / 2) !important;
        }

        div[style*="background-color:#E4F9FF"] {
            padding: 20px !important;
            flex-wrap: wrap !important;
        }

        div[style*="padding:45px 50px"] {
            padding: 20px !important;
        }

        /* Reduce Padding for Price Details Box */
        div[style*="padding:32px 44px"],
        div[style*="padding:42px 52px"] {
            padding: 20px !important;
        }

        /* Fix Pay Button */
        div[style*="margin-top: 40px"][style*="justify-content: flex-end"] {
            justify-content: center !important;
            margin-right: 0 !important;
        }
        
        button[style*="margin-right: 60px"] {
            margin-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
    }

    @media (max-width: 480px) {
        #time-slots > div {
            width: 100% !important;
        }
        h2 { font-size: 22px !important; }
        h3 { font-size: 20px !important; }
    }

    /* ================= GENERAL LAYOUT CLASSES ================= */
    .main-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    .checkout-container {
        display: flex;
        gap: 40px;
    }

    .page-container{
    max-width:1550px;
    margin:0 auto;
    width:100%;
    padding:0 20px;
    box-sizing:border-box;
}
</style>
<body style="margin:0;">
{{-- main start tag --}}
   


       <!-- Header -->
<div style="
    background-color:#E4F9FF; 
    padding:50px; 
    display:flex; 
    align-items:center; 
    gap:15px;
   box-shadow: 0px 6px 8px rgba(0,0,0,0.18);


">

    <!-- Back Button Image -->
   <a href="{{ route('website.home') }}" style="display:flex; align-items:center;">
        <img src="img/arrow.png" 
             alt="Back"
             style="
                width:26px;
                height:52px;
                cursor:pointer;
             ">
    </a>
      <!-- Title -->
    <h2 style="
        width:310px;
        height:30px;
        margin:0;
        font-family:'Libre Baskerville', serif;
        font-weight:700;
        font-size:30px;
        line-height:100%;
        letter-spacing:3%;
        color:#004271;
    ">
        Your Cart
    </h2>
   </div>

  <div class="page-container">

 {{-- middle part start--}}
<div style="
    width:100%;
   
    margin:0 auto;
    padding:20px 30px;
    box-sizing:border-box;
">


{{-- CART---ADDRESS----PAYMENT --}}
<div style="width:100%; 
            margin:0 auto; 
            padding:45px 50px; 
            box-sizing:border-box;">


<div style="display: flex; align-items: center; width: 100%; margin: 0 auto;  height: 23px; max-width: 516px;  font-family: Roboto, sans-serif;">
    <!-- CART -->
    <span style="color: #004271; font-size: 20px; font-weight: 600; letter-spacing: 0.05em; white-space: wrap;">CART</span>
    
    <!-- Line 1-->
    <div style="flex: 1; height: 1.5px; background-image: linear-gradient(to right, #004271 4px, transparent 4px); background-size: 8px 1.5px; background-repeat: repeat-x; margin-left: 10px; margin-right: 12px;"></div>
    
    <!-- ADDRESS -->
    <span style="color: #4E4F4F; font-size: 20px; font-weight: 400; letter-spacing: 0.05em; white-space: wrap;">ADDRESS</span>
    
    <!-- Line 2:  -->
    <div style="flex: 1; height: 1.5px; background-image: linear-gradient(to right, #004271 4px, transparent 4px); background-size: 8px 1.5px; background-repeat: repeat-x; margin-left: 10px; margin-right: 12px;"></div>
    
    <!-- PAYMENT -->
    <span style="color: #4E4F4F; font-size: 20px; font-weight: 400; letter-spacing: 0.05em; white-space: wrap;">PAYMENT</span>
</div>
</div>
{{-- CART---ADDRESS----PAYMENT --}}



<style>
    /* CSS to hide the scrollbar for Chrome, Safari and Opera */
    .hide-scroll::-webkit-scrollbar {
        display: none;
    }
    
    /* CSS to hide the scrollbar for IE, Edge and Firefox */
    .hide-scroll {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<!-- SCROLL CONTAINER -->
<style>
/* Hide scrollbar */
.hide-scroll {
    scrollbar-width: none; /* Firefox */
}
.hide-scroll::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
}
</style>

<div class="hide-scroll" style="
    width: 100%;
    margin-top: 5px;
    display: flex;
    gap: 40px;
    overflow-x: auto;
    padding-bottom: 20px;
    box-sizing: border-box;
">

    <!-- BOX 1 -->
    <label style="
        width:100%;
        max-width:519px;
        flex-shrink:0;
        background:#ffffff;
        border-radius:15px;
        border:1px solid #B5B5B5;
        box-sizing:border-box;
        font-family:Roboto, sans-serif;
        padding:20px;
        cursor:pointer;
    ">

        <input type="checkbox" style="display:none;"
        onchange="
            let circle=this.nextElementSibling.querySelector('.outer');
            let dot=this.nextElementSibling.querySelector('.inner');
            if(this.checked){
                this.closest('label').style.border='1px solid #004271';
                circle.style.borderColor='#004271';
                dot.style.display='block';
            }else{
                this.closest('label').style.border='1px solid #B5B5B5';
                circle.style.borderColor='#B5B5B5';
                dot.style.display='none';
            }
        ">

        <div style="display:flex; gap:20px; flex-wrap:wrap;">

            <div style="display:flex; align-items:center; gap:15px;">
                
                <!-- Circle -->
                <div class="outer" style="
                    width:22px;
                    height:22px;
                    border:2px solid #B5B5B5;
                    border-radius:50%;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    flex-shrink:0;
                ">
                    <div class="inner" style="
                        width:12px;
                        height:12px;
                        background:#004271;
                        border-radius:50%;
                        display:none;
                    "></div>
                </div>

                <!-- Image -->
                <div style="
                    width:133px;
                    height:161px;
                    border-radius:15px;
                    border:1px solid #B5B5B5;
                    overflow:hidden;
                    flex-shrink:0;
                ">
                    <img src="img/img_1.png" style="width:100%; height:100%; object-fit:cover;">
                </div>
            </div>

            <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; padding-top:15px;">
                <div style="font-weight:600; font-size:20px; color:#353535;">Home Deep Cleaning</div>
                <div style="font-size:16px; color:#353535; margin-top:8px;">Comprehensive cleaning for a spotless home.</div>
                <div style="height:1px; background:#B5B5B5; margin:12px 0;"></div>
                <div style="display:flex; align-items:center; justify-content:space-between;">

    <!-- Price -->
    <div style="font-size:20px; color:#353535;">
        AED 2499
    </div>

    <!-- Quantity + Delete -->
    <div style="display: flex; align-items: center; gap: 12px;">

        <!-- Quantity Box -->
        <div style="
            display: flex;
            align-items: center;
            border: 1px solid #E4F9FF;
            border-radius: 15px;
            overflow: hidden;
            background-color: #E4F9FF;
        ">
            <button style="
                color: #004271;
                width: 28px;
                height: 28px;
                border: none;
                background: transparent;
                font-size: 25px;
                cursor: pointer;
            ">−</button>

            <span style="
                color: #004271;
                font-weight: 400;
                width: 30px;
                text-align: center;
                font-size: 20px;
                line-height: 28px;
            ">1</span>

            <button style="
                color: #BABABA;
                width: 28px;
                height: 28px;
                border: none;
                background: transparent;
                font-size: 25px;
                cursor: pointer;
            ">+</button>
        </div>

        <!-- Delete Button -->
        <button style="
            display:flex;
            align-items:center;
            justify-content:center;
            width:28px;
            height:28px;
            background:transparent;
            border:none;
            border-radius:6px;
            cursor:pointer;
        ">
            <img src="img/delete.png" 
                 alt="Delete" 
                 style="width:18px; height:23px;">
        </button>

    </div>

</div>
                
            </div>

        </div>
    </label>

    <!-- BOX 2 -->
    <label style="
        width:100%;
        max-width:519px;
        flex-shrink:0;
        background:#ffffff;
        border-radius:15px;
        border:1px solid #B5B5B5;
        box-sizing:border-box;
        font-family:Roboto, sans-serif;
        padding:20px;
        cursor:pointer;
    ">

        <input type="checkbox" style="display:none;"
        onchange="
            let circle=this.nextElementSibling.querySelector('.outer');
            let dot=this.nextElementSibling.querySelector('.inner');
            if(this.checked){
                this.closest('label').style.border='1px solid #004271';
                circle.style.borderColor='#004271';
                dot.style.display='block';
            }else{
                this.closest('label').style.border='1px solid #B5B5B5';
                circle.style.borderColor='#B5B5B5';
                dot.style.display='none';
            }
        ">

        <div style="display:flex; gap:20px; flex-wrap:wrap;">
            <div style="display:flex; align-items:center; gap:15px;">
                <div class="outer" style="width:22px;height:22px;border:2px solid #B5B5B5;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <div class="inner" style="width:12px;height:12px;background:#004271;border-radius:50%;display:none;"></div>
                </div>
                <div style="width:133px;height:161px;border-radius:15px;border:1px solid #B5B5B5;overflow:hidden;">
                    <img src="img/img_2.png" style="width:100%; height:100%; object-fit:cover;">
                </div>
            </div>
            <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; padding-top:15px;">
                <div style="font-weight:600; font-size:20px; color:#353535;">AC Repair & Servicing</div>
                <div style="font-size:16px; color:#353535; margin-top:8px;">Quick and professional AC maintenance</div>
                <div style="height:1px; background:#B5B5B5; margin:12px 0;"></div>
                <div style="display:flex; align-items:center; justify-content:space-between;">

    <!-- Price -->
    <div style="font-size:20px; color:#353535;">
        AED 2499
    </div>

    <!-- Quantity + Delete -->
    <div style="display: flex; align-items: center; gap: 12px;">

        <!-- Quantity Box -->
        <div style="
            display: flex;
            align-items: center;
            border: 1px solid #E4F9FF;
            border-radius: 15px;
            overflow: hidden;
            background-color: #E4F9FF;
        ">
            <button style="
                color: #004271;
                width: 28px;
                height: 28px;
                border: none;
                background: transparent;
                font-size: 25px;
                cursor: pointer;
            ">−</button>

            <span style="
                color: #004271;
                font-weight: 400;
                width: 30px;
                text-align: center;
                font-size: 20px;
                line-height: 28px;
            ">1</span>

            <button style="
                color: #BABABA;
                width: 28px;
                height: 28px;
                border: none;
                background: transparent;
                font-size: 25px;
                cursor: pointer;
            ">+</button>
        </div>

        <!-- Delete Button -->
        <button style="
            display:flex;
            align-items:center;
            justify-content:center;
            width:28px;
            height:28px;
            background:transparent;
            border:none;
            border-radius:6px;
            cursor:pointer;
        ">
            <img src="img/delete.png" 
                 alt="Delete" 
                 style="width:18px; height:23px;">
        </button>

    </div>

</div>
            </div>
        </div>
    </label>

    <!-- BOX 3 -->
<label style="
    width:100%;
    max-width:519px;
    flex-shrink:0;
    background:#ffffff;
    border-radius:15px;
    border:1px solid #B5B5B5;
    box-sizing:border-box;
    font-family:Roboto, sans-serif;
    padding:20px;
    cursor:pointer;
">

    <input type="checkbox" style="display:none;"
    onchange="
        let circle=this.nextElementSibling.querySelector('.outer');
        let dot=this.nextElementSibling.querySelector('.inner');
        if(this.checked){
            this.closest('label').style.border='1px solid #004271';
            circle.style.borderColor='#004271';
            dot.style.display='block';
        }else{
            this.closest('label').style.border='1px solid #B5B5B5';
            circle.style.borderColor='#B5B5B5';
            dot.style.display='none';
        }
    ">

    <div style="display:flex; gap:20px; flex-wrap:wrap;">

        <div style="display:flex; align-items:center; gap:15px;">
            
            <!-- Circle -->
            <div class="outer" style="
                width:22px;
                height:22px;
                border:2px solid #B5B5B5;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
                flex-shrink:0;
            ">
                <div class="inner" style="
                    width:12px;
                    height:12px;
                    background:#004271;
                    border-radius:50%;
                    display:none;
                "></div>
            </div>

            <!-- Image -->
            <div style="
                width:133px;
                height:161px;
                border-radius:15px;
                border:1px solid #B5B5B5;
                overflow:hidden;
                flex-shrink:0;
            ">
                <img src="img/img_3.png" style="width:100%; height:100%; object-fit:cover;">
            </div>
        </div>

        <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; padding-top:15px;">
            <div style="font-weight:600; font-size:20px; color:#353535;">Salon for Women</div>
            <div style="font-size:16px; color:#353535; margin-top:8px;">
                At-home beauty and self-care services, customized for you.
            </div>
            <div style="height:1px; background:#B5B5B5; margin:12px 0;"></div>
            <div style="display:flex; align-items:center; justify-content:space-between;">

    <!-- Price -->
    <div style="font-size:20px; color:#353535;">
        AED 2499
    </div>

    <!-- Quantity + Delete -->
    <div style="display: flex; align-items: center; gap: 12px;">

        <!-- Quantity Box -->
        <div style="
            display: flex;
            align-items: center;
            border: 1px solid #E4F9FF;
            border-radius: 15px;
            overflow: hidden;
            background-color: #E4F9FF;
        ">
            <button style="
                color: #004271;
                width: 28px;
                height: 28px;
                border: none;
                background: transparent;
                font-size: 25px;
                cursor: pointer;
            ">−</button>

            <span style="
                color: #004271;
                font-weight: 400;
                width: 30px;
                text-align: center;
                font-size: 20px;
                line-height: 28px;
            ">1</span>

            <button style="
                color: #BABABA;
                width: 28px;
                height: 28px;
                border: none;
                background: transparent;
                font-size: 25px;
                cursor: pointer;
            ">+</button>
        </div>

        <!-- Delete Button -->
        <button style="
            display:flex;
            align-items:center;
            justify-content:center;
            width:28px;
            height:28px;
            background:transparent;
            border:none;
            border-radius:6px;
            cursor:pointer;
        ">
            <img src="img/delete.png" 
                 alt="Delete" 
                 style="width:18px; height:23px;">
        </button>

    </div>

</div>
        </div>

    </div>
</label>

</div>
{{-- end slider --}}

{{-- botton --}}
<div style="display: flex; justify-content: flex-end; gap: 22px; font-family: 'Roboto', sans-serif; align-items: center;margin-top: 40px;  ">

  <!-- Left Button: Add Services -->
  <div style="
    width: 198px;
    height: 54px;
    border: 1px solid #004271;
    border-radius: 15px;
    background-color: transparent;
    color: #004271;
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    cursor: pointer;
  ">
    Add Services
  </div>

  <!-- Right Button: Add address & slot -->
  <div onclick="openAddressSection()" style="
    width: 198px;
    height: 54px;
    border-radius: 15px;
    background-color: #004271;
    color: #FFFFFF;
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    
">
    Add address & slot
</div>

</div>
{{-- botton --}}



{{----------------------------------------Desktop-16----------------------------------------------------- --}}
<div id="address-section" style="display: none;">

<hr style="margin-top: 50px;">


{{-- CART---ADDRESS----PAYMENT --}}
<div style="width:100%; 
            margin:0 auto; 
            padding:45px 50px; 
            box-sizing:border-box;">


<div style="display: flex; align-items: center; width: 100%; margin: 0 auto;  height: 23px; max-width: 516px;  font-family: Roboto, sans-serif;">
    <!-- CART -->
    <span style="color: #4E4F4F; font-size: 20px; font-weight: 400; letter-spacing: 0.05em; white-space: wrap;">CART</span>
    
    <!-- Line 1-->
    <div style="flex: 1; height: 1.5px; background-image: linear-gradient(to right, #004271 4px, transparent 4px); background-size: 8px 1.5px; background-repeat: repeat-x; margin-left: 10px; margin-right: 12px;"></div>
    
    <!-- ADDRESS -->
    <span style="color: #004271; font-size: 20px; font-weight: 600; letter-spacing: 0.05em; white-space: wrap;">ADDRESS</span>
    
    <!-- Line 2:  -->
    <div style="flex: 1; height: 1.5px; background-image: linear-gradient(to right, #004271 4px, transparent 4px); background-size: 8px 1.5px; background-repeat: repeat-x; margin-left: 10px; margin-right: 12px;"></div>
    
    <!-- PAYMENT -->
    <span style="color: #4E4F4F; font-size: 20px; font-weight: 400; letter-spacing: 0.05em; white-space: wrap;">PAYMENT</span>
</div>
</div>
{{-- CART---ADDRESS----PAYMENT --}}


<!-- Address Form Section -->
<div style="width:100%; padding: 0px; margin: 0 auto 40px auto; background-color: #ffffff; ; font-family: 'Roboto', sans-serif;">
    
    <!-- Header -->
  <div style="
    padding: 5px; 
    display: flex;
    align-items: center;
    gap: 12px;
">
    <img src="img/location.png" 
         alt="Location"
         style="width: 23px; height: 34px;">
         
    <h2 style="
        margin: 0; 
        font-size: 20px; 
        color:#353535
        font-weight: 700;
    ">
        Your Address
    </h2>
</div>

    <!-- Current Address Display -->
    <div style="display: flex; align-items: center; width: 100%; font-family: Roboto, sans-serif;">
    <div style="display: flex; align-items: center; flex: 0 1 auto; min-width: 0;">
        <span style="font-size: 18px; font-weight: 300; color: #353535; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Tidake colony, Durwankur Lawns, Nashik .....</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-left: 4px;">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </div>
    <button style="flex-shrink: 0; margin-left: 8px; width: 128px; height: 35px; background-color: transparent; color: #FF1818; font-family: Roboto, sans-serif; font-size: 18px; font-weight: 400; border: 1px solid #B4B4B4; border-radius: 15px; cursor: pointer; white-space: nowrap;">Change</button>
</div>

    <!-- Form Section -->
<div style="padding: 0px; margin-top: 50px;">

    <h3 style="margin: 0 0 20px 0; font-size: 24px; color: #353535; font-weight: 600;">
        Add Detailed Address
    </h3>

    <!-- Responsive Styling -->
    <style>
        .form-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 21px;
        }

        .form-col {
            flex: 0 0 calc(33.333% - 14px);
            display: flex;
            flex-direction: column;
            margin-top: -5px;

        }

        .form-col-full {
            flex: 0 0 100%;
            display: flex;
            flex-direction: column;
        }

        .form-input {
            padding: 12px;
            border: 1px solid #B5B5B5;
            border-radius: 15px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            outline: none;
            font-family: 'Roboto', sans-serif;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .form-col {
                flex: 0 0 100%;
            }
        }
    </style>

    <div class="form-grid">

        <style>
.form-input {
    width: 100%;
    max-width: 430px;
    height: 60px;
    padding: 0 15px;
    border-radius: 15px;
    border: 0.25px solid #454545;
    font-size: 14px;
    box-sizing: border-box;
    outline: none;
    color:#2D2D2D
}
</style>
        <!-- Row 1 -->
        <div class="form-col" >
            
            <input type="text" placeholder="Enter Name*" class="form-input">
        </div>

        <div class="form-col" >
            
            <input type="text" placeholder="Enter Phone Number*" class="form-input">
        </div>

        <div class="form-col">
            
            <input type="email" placeholder="Enter Email ID*" class="form-input">
        </div>

        <!-- Row 2 -->
        <div class="form-col" >
           
            <input type="text" placeholder="City*" class="form-input">
        </div>

        <div class="form-col">
            
            <input type="text" placeholder="Flat No/ Building name / Street name *" class="form-input">
        </div>

        <div class="form-col">
            
            <textarea rows="3" placeholder="Enter Full Address *" class="form-input" style="resize: vertical;"></textarea>
        </div>

    </div>
</div>
        <!-- Save As Section -->
        <div style="margin-top: 24px;">
            <p style="margin: 0 0 20px 0; font-size: 24px; color: #353535; font-weight: 600;">Save As</p>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                
               <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;600&display=swap" rel="stylesheet">

<div style="display: flex; flex-wrap: wrap; gap: 28px; font-family: 'Roboto', sans-serif;">
  <!-- Home Button - Selected/Active State -->
  <div style="
    min-width: 140px;
    height: 51px;
    background: #E4F9FF;
    border: 1px solid #004271;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
  ">
    <span style="
      font-weight: 600;
      font-size: 18px;
      line-height: 100%;
      letter-spacing: 0;
      color: #004271;
    ">Home</span>
  </div>

  <!-- Office Button -->
  <div style="
    min-width: 140px;
    height: 51px;
    background: #FFFFFF;
    border: 1px solid #B4B4B4;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
  ">
    <span style="
      font-weight: 300;
      font-size: 18px;
      line-height: 100%;
      letter-spacing: 0;
      color: #353535;
    ">Office</span>
  </div>

  <!-- Other Button -->
  <div style="
    min-width: 140px;
    height: 51px;
    background: #FFFFFF;
    border: 1px solid #B4B4B4;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
  ">
    <span style="
      font-weight: 300;
      font-size: 18px;
      line-height: 100%;
      letter-spacing: 0;
      color: #353535;
    ">Other</span>
  </div>
</div>
            </div>
        </div>
    </div>

    <!-- Footer / Action Button -->
    <div style="padding: 5px 5px 0px 5px; display: flex; justify-content: flex-end; flex-wrap: wrap;margin-top: 10px; ">
    
   <button onclick="openSlotSection()" 
    style="
        width: 100%;
        max-width: 198px;
        height: 54px;
        background-color: #004271;
        color: #FFFFFF;
        border: none;
        border-radius: 15px;
        font-family: 'Roboto', sans-serif;
        font-weight: 600;
        font-size: 18px;
        cursor: pointer;
       
">
    Add Slot
</button>
</div>
</div>


</div>
{{----------------------------------------Desktop-17----------------------------------------------------- --}}



<div id="slot-section" style="display: none;">
 
<hr style="margin-top: 5px 0;">

<div style=" margin: 10px 40px; ">

{{-- <div id="booking-widget" style="
  font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
  max-width: 1100px;
  margin: 20px 40px;
  display: flex;
  flex-direction: column;
"> --}}

<!-- Header Row -->
<div style="
    padding: 25px 16px;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 330px;
    flex-wrap: wrap;
">

    <!-- Left Title -->
    <div style="
        font-family: 'Roboto', sans-serif;
        font-weight: 600;
        font-size: clamp(18px, 4vw, 24px);
        line-height: 1.2;
        color: #353535;
    ">
        Your Qwik Slot - Choose Date & Time
    </div>

    <!-- Right Title -->
    <div style="
        font-family: 'Roboto', sans-serif;
        font-weight: 600;
        font-size: clamp(18px, 4vw, 24px);
        line-height: 1.2;
        color: #353535;
       padding: 25px 0px;
       margin-left: -16px;
     
        
    ">
        Select Time
    </div>

</div>

  <!-- Main Content -->
  <div style="display: flex;
    gap: 30px;
    align-items: flex-start;">

    <!-- Calendar -->
    <div style="
        flex: 0 0 659px;
        height: 374px;
        border: 1px solid #8D8D8D;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        background: #fff;
        
    ">

      <!-- Month Header -->
          <!-- Month Header -->
<div style="
height: 58px;
background-color: #D9D9D9;
display: flex;
justify-content: space-between;
align-items: center;
padding: 0 90px;
border-bottom: 1px solid #8D8D8D;">

<!-- Left Arrow -->
<img id="prev-month" src="img/left-arrow.png" 
style="width:25px;height:25px;cursor:pointer;">

<!-- Month Label -->
<span id="month-year-label" style="
font-family: Roboto;
font-weight: 600;
font-size: 24px;
color: #353535;">
</span>

<!-- Right Arrow -->
<img id="next-month" src="img/right-arrow.png" 
style="width:25px;height:25px;cursor:pointer;">

</div>


      <!-- Calendar Body -->
      <div style="background: #ffffff; padding: 15px; flex-grow: 1;">
        
        <div style="
          display: grid;
          grid-template-columns: repeat(7, 1fr);
          text-align: center;
          font-size: 18px;
          font-weight: 600;
          color: #004271;
          margin-bottom: 10px;">
          <div>Sun</div><div>Mon</div><div>Tue</div>
          <div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
        </div>

        <div id="calendar-grid" style="
          display: grid;
          grid-template-columns: repeat(7, 1fr);
          text-align: center;
          row-gap: 5px;">
        </div>

      </div>
    </div>

    
    <!-- Right Section -->
<div style="
    flex: 1;
    width:100%;
    min-width: 600px;
    padding: 25px 16px;
    display: flex;
    flex-direction: column;
    margin: 0;

">



  <div id="time-slots" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: flex-start; margin-top: -20px;">
    <!-- Calculation: (100% - 2 gaps) / 3  -->
    <div onclick="selectTime(this)" style="width: calc((100% - 30px) / 3); padding: 12px 0; background: white; border: 1px solid #004271; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #353535; box-sizing: border-box;">03:30 PM</div>
    <div onclick="selectTime(this)" style="width: calc((100% - 30px) / 3); padding: 12px 0; background: white; border: 1px solid #004271; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #004271; box-sizing: border-box;">04:30 PM</div>
    <div onclick="selectTime(this)" style="width: calc((100% - 30px) / 3); padding: 12px 0; background: white; border: 1px solid #004271; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #004271; box-sizing: border-box;">05:00 PM</div>

    <div onclick="selectTime(this)" style="width: calc((100% - 30px) / 3); padding: 12px 0; background: white; border: 1px solid #004271; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #004271; box-sizing: border-box;">05:30 PM</div>
    <div onclick="selectTime(this)" style="width: calc((100% - 30px) / 3); padding: 12px 0; background: white; border: 1px solid #004271; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #004271; box-sizing: border-box;">06:00 PM</div>
    <div onclick="selectTime(this)" style="width: calc((100% - 30px) / 3); padding: 12px 0; background: white; border: 1px solid #004271; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #004271; box-sizing: border-box;">06:30 PM</div>

    <div onclick="selectTime(this)" style="width: calc((100% - 30px) / 3); padding: 12px 0; background: white; border: 1px solid #004271; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #004271; box-sizing: border-box;">07:00 PM</div>
    <div onclick="selectTime(this)" style="width: calc((100% - 30px) / 3); padding: 12px 0; background: white; border: 1px solid #004271; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #004271; box-sizing: border-box;">07:30 PM</div>
</div>
    

      <!-- Expert -->
      <div style="flex-grow: 1;">
        <div style="font-size: 18px; font-weight: 600; margin-bottom: 15px; margin-top: 30px;">
          Choose Your Expert
        </div>

      <div style="display: flex; gap: 20px; align-items: flex-start;">
    
    <!-- Best Match for Your Service -->
    <div style="display: flex; flex-direction: column; align-items: center;">
        <img src="img/img.png" alt="Best Match" style="width: 70px; height: 70px; border-radius: 15px; object-fit: cover;">
        <div style="margin-top: 5px; font-size: 15px; color: #404040; text-align: center; font-weight: 500;">Best Match for<br>Your Service</div>
    </div>

    <!-- Megha -->
    <div style="display: flex; flex-direction: column; align-items: center;">
        <img src="img/megha.png" alt="Megha" style="width: 70px; height: 70px; border-radius: 15px; object-fit: cover;">
        <div style="margin-top: 5px; font-size: 15px; color: #404040; text-align: center; font-weight: 500;">Megha</div>
    </div>

</div>
      </div>

     <!-- Payment -->
<div style="
    margin-top: 30px;
    width: 100%;
    display: flex;
    justify-content: flex-end;
">

    <button type="button" onclick="openPaymentSection()" style="
        width: 198px;
        height: 54px;
        background-color: #004271;
        color: #FFFFFF;
        border: none;
        border-radius: 15px;
        font-family: 'Roboto', sans-serif;
        font-weight: 600;
        font-size: 18px;
        cursor: pointer;
    ">
        Payment Details
    </button>

</div>
  </div>

    </div>
  </div>
</div>

</div>


{{----------------------------------------Desktop-19----------------------------------------------------- --}}



<div id="paymentSection" style="display: none;">
 
<hr style="margin-top: 15px;">


{{-- <div style=" margin: 20px 40px; "> --}}


{{-- CART---ADDRESS----PAYMENT --}}
<div style="width:100%; 
            margin:0 auto; 
            padding:45px 50px; 
            box-sizing:border-box;">


<div style="display: flex; align-items: center; width: 100%; margin: 0 auto;  height: 23px; max-width: 516px;  font-family: Roboto, sans-serif;">
    <!-- CART -->
    <span style="color: #4E4F4F; font-size: 20px; font-weight: 400; letter-spacing: 0.05em; white-space: wrap;">CART</span>
    
    <!-- Line 1-->
    <div style="flex: 1; height: 1.5px; background-image: linear-gradient(to right, #004271 4px, transparent 4px); background-size: 8px 1.5px; background-repeat: repeat-x; margin-left: 10px; margin-right: 12px;"></div>
    
    <!-- ADDRESS -->
    <span style="color: #4E4F4F; font-size: 20px; font-weight: 400; letter-spacing: 0.05em; white-space: wrap;">ADDRESS</span>
    
    <!-- Line 2:  -->
    <div style="flex: 1; height: 1.5px; background-image: linear-gradient(to right, #004271 4px, transparent 4px); background-size: 8px 1.5px; background-repeat: repeat-x; margin-left: 10px; margin-right: 12px;"></div>
    
    <!-- PAYMENT -->
    <span style="color: #004271; font-size: 20px; font-weight: 600; letter-spacing: 0.05em; white-space: wrap;">PAYMENT</span>
</div>
</div>
{{-- CART---ADDRESS----PAYMENT --}}

<div style="
display:flex;
justify-content:center;
flex-wrap:wrap;
gap:35px;
width:100%;
font-family:'Roboto', sans-serif;

">

  <!-- Address Box -->
  <div style="
  flex:2;
  height:55px;
  background-color:rgba(244,242,242,0.3);
  border:0.5px solid #D2D2D2;
  border-radius:10px;
  box-shadow:0px 4px 4px rgba(0,0,0,0.05);
  display:flex;
  align-items:center;
  padding:0 16px;
  box-sizing:border-box;
  gap:12px;
  width:100%;
  max-width:620px;
  ">

    <img src="img/home.png" style="width:21px;height:24px;object-fit:contain;flex-shrink:0;">

    <div style="flex:1;display:flex;align-items:center;min-width:0;white-space:nowrap;overflow:hidden;">
      <span style="font-size:18px;font-weight:500;letter-spacing:0.05em;">Home -&nbsp;</span>
      <span style="font-size:18px;font-weight:300;overflow:hidden;text-overflow:ellipsis;">Tidake colony, Durwankur Lawns, Nashik</span>
    </div>

    <img src="img/pencile.png" style="width:24px;height:24px;object-fit:contain;cursor:pointer;">
  </div>


  <!-- Time Box -->
  <div style="
  flex:1;
  height:55px;
  background-color:rgba(244,242,242,0.3);
  border:0.5px solid #D2D2D2;
  border-radius:10px;
  box-shadow:0px 4px 4px rgba(0,0,0,0.05);
  display:flex;
  align-items:center;
  padding:0 16px;
  box-sizing:border-box;
  gap:12px;
  width:100%;
  max-width:620px;
  
  ">

    <img src="img/time.png" style="width:22px;height:22px;object-fit:contain;flex-shrink:0;">

    <span style="flex:1;font-size:18px;font-weight:500;white-space:nowrap;">
      Tue, Oct 07 - 4:30 PM
    </span>

    <img src="img/pencile.png" style="width:24px;height:24px;object-fit:contain;cursor:pointer;">
  </div>

</div>

<div style="width:100%; display:flex; justify-content:center;">
{{-- ==================== NEW MAIN CONTAINER START ==================== --}}
<div style="
display:flex;
flex-direction:row;
align-items:flex-start;
gap:40px;
width:100%;
max-width:1400px;
padding:0 40px;
box-sizing:border-box;
margin-top:45px;
">

    {{-- LEFT COLUMN WRAPPER --}}
    <div style="flex: 1; display: flex;  flex-direction: column; gap: 40px;">

        {{-- 1. HOME DEEP CLEANING CARD --}}
        <div style="width: 100%; max-width: 519px; background: #ffffff; border-radius: 15px; border: 1px solid #B5B5B5; box-sizing: border-box; font-family: Roboto, sans-serif; padding: 20px;">
            <!-- Card content... -->
             <div style="display: flex; gap: 20px; flex-wrap: wrap; align-items: center;">
                <div style="width: 133px; height: 161px; border-radius: 15px; border: 1px solid #B5B5B5; overflow: hidden; flex-shrink: 0;">
                    <img src="img/img_1.png" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; min-width: 200px;">
                    <div style="font-weight: 600; font-size: 20px; color: #353535;">Home Deep Cleaning</div>
                    <div style="font-size: 16px; color: #353535; margin-top: 8px;">Comprehensive cleaning for a spotless home.</div>
                    <div style="height: 1px; background: #B5B5B5; margin: 12px 0;"></div>
                    <div style="font-size: 20px; color: #353535;">AED 2499</div>
                </div>
            </div>
        </div>
{{------------ COUPONS----------- --}}
     <div id="couponBox" style="background-color: rgba(244,242,242,0.3);
border:0.5px solid #D2D2D2;
border-radius:10px;
box-shadow:0px 4px 4px rgba(0,0,0,0.05);
padding:12px 16px;
width:100%;
max-width:519px;
box-sizing:border-box;">

  <!-- Row 1 -->
  <div style="display:flex; align-items:center; gap:12px;">
    
    <img src="img/coupons.png" style="width:22px;height:22px;">

    <span style="flex:1;font-size:18px;font-weight:500;">COUPONS</span>

    <div onclick="openCouponsModal()" style="display:flex;align-items:center;gap:6px;cursor:pointer;">
      <span style="font-size:16px;font-weight:500;color:#1E5AA5;">All Coupons</span>
      <span style="font-size:20px;color:#1E5AA5;">›</span>
    </div>

  </div>

  <!-- Row 2 (Applied Coupon) -->
  <div id="appliedCouponRow" style="display:none; margin-top:8px; padding-left:34px; font-size:16px;">
      
    <span style="color:#10B000;font-weight:600;">GPAY20</span>
    <span style="color:#555;"> applied</span>

    <span onclick="removeCoupon(event)" 
    style="color:#555;cursor:pointer;">Remove</span>

  </div>

</div>

     



        {{-- 3. CANCELLATION POLICY BOX --}}
        <div style="width: 100%; max-width: 520px; min-height: 178px; background: #FFFFFF; border: 0.25px solid #A8A8A8; border-radius: 10px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.05); box-sizing: border-box; padding: 22px 25px 24px 25px; display: flex; flex-direction: column; font-family: 'Roboto', sans-serif;">
            <!-- Policy content... -->
            <div style="font-weight: 600; font-size: 18px; letter-spacing: 0.05em; color: #2D2D2D; margin-bottom: 13px;">Cancellation policy</div>
            <div style="font-weight: 400; font-size: 16px; letter-spacing: 0.05em; color: #353535; margin-bottom: auto;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </div>
            <a href="#" style="font-weight: 500; font-size: 18px; letter-spacing: 0.05em; color: #0056D2; text-decoration: underline; margin-top: 20px; display: inline-block;">View More</a>
        </div>

    </div> {{-- END LEFT COLUMN --}}

    {{-- RIGHT COLUMN (Price Details) --}}
  <div style="flex:1; width:100%; min-width:801px; display:flex; flex-direction:column;">
        
        {{-- PRICE DETAILS CODE --}}
      <div style="
width:100%;
max-width:801px;
min-height:280px;
background:#E4F9FF;
border-radius:15px;
border:0.25px solid #EAEAEA;
box-shadow:0px 4px 4px rgba(0,0,0,0.05);
padding:32px 44px;
box-sizing:border-box;
font-family:Roboto, Arial, sans-serif;
">
            
            <div style="font-weight: 600; font-size: clamp(18px, 3vw, 24px); letter-spacing: 0.05em; color: #2D2D2D; margin-bottom: 24px;">Price Details</div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; font-size: 18px; color: #2D2D2D;">
                <span>Item total</span>
                <span>AED 2,499</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 18px; color: #2D2D2D;">
                <span>Taxes and fee</span>
                <span>AED 50</span>
            </div>
            
            <div style="width: 100%; height: 1px; background: #D1D1D1; margin-bottom: 20px;"></div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 18px; font-weight: 700; color: #2D2D2D;">
                <span>Total amount</span>
                <span>AED 2,549</span>
            </div>
            
            <div style="width: 100%; height: 1px; background: #D1D1D1; margin-bottom: 20px;"></div>
            
            <div style="display: flex; justify-content: space-between; align-items: center;  font-size: clamp(15px, 2.5vw, 18px); font-weight: 700; color: #2D2D2D;">
                <span>Amount to pay</span>
                <span>AED 2,549</span>
            </div>
            
        </div>

       <div style="
width:100%;
max-width:780px;
min-height:178px;
background:#E4F9FF;
padding:42px 52px;
border-radius:15px;
border:0.5px solid #EAEAEA;
font-family:Arial, sans-serif;
position:relative;
box-sizing:border-box;
margin-top:40px;
">

  <div style="font-size:26px;font-weight:600;color:#1f2a33;">
    Pay AED 2,549
  </div>

  <div style="display:flex;align-items:center;margin-top:28px;justify-content:space-between;">

    <div style="display:flex;align-items:center;gap:18px;">

      <!-- Wallet Icon -->
      <div style="position:relative;width:48px;height:32px;border:2px solid #1f2a33;border-radius:4px;">
        <div style="position:absolute;top:-8px;left:8px;width:36px;height:20px;border:2px solid #1f2a33;border-radius:4px;background:transparent;"></div>
        <div style="position:absolute;top:10px;right:8px;width:6px;height:6px;border:2px solid #1f2a33;border-radius:50%;"></div>
      </div>

      <div style="font-size:18px;color:#1f2a33;">
        Cash on Delivery
      </div>

    </div>

    <div style="font-size:18px;color:#0b5e8e;font-weight:600;cursor:pointer;">
      Change
    </div>

  </div>

  <div style="position:absolute;top:22px;right:24px;font-size:24px;color:#1f2a33;cursor:pointer;">
    ×
  </div>

</div>

    </div> {{-- END RIGHT COLUMN --}}

</div>
{{-- ==================== NEW MAIN CONTAINER END ==================== --}}
</div>

 <!-- Payment -->
      <div style="margin-top: 40px; display: flex;
    justify-content: flex-end;">
        <button type="button" onclick="processPayment()" style="
    width: 100%;
    max-width: 268px;
    height: 54px;
    background-color: #004271;
    color: #FFFFFF;
    border: none;
    border-radius: 15px;
    font-family: 'Roboto', sans-serif;
    font-weight: 600;
    font-size: 18px;
    cursor: pointer;
    margin-right: 60px;
    margin-bottom: clamp(20px,5vw,60px);
    ">
  Pay AED 2,549
</button>
      </div>

</div>
</div>

<script>
function openAddressSection() {
    const section = document.getElementById("address-section");

    section.style.display = "block";

    // Smooth scroll
    section.scrollIntoView({
        behavior: "smooth"
    });
}
</script>

<script>
function openSlotSection() {
    const section = document.getElementById("slot-section");

    if (section) {
        section.style.display = "block";
        section.scrollIntoView({ behavior: "smooth" });
    }
}

function openPaymentSection() {
    var content = document.getElementById("paymentSection");
    if (content) {
        content.style.display = "block";
        content.scrollIntoView({ behavior: "smooth" });
    }
}

</script>

<script>
let currentDate = new Date();
let selectedDate = null;
let selectedTime = null;
let selectedExpert = false;

const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];

function renderCalendar() {
  const grid = document.getElementById('calendar-grid');
  const label = document.getElementById('month-year-label');
  grid.innerHTML = '';

  label.innerText = monthNames[currentDate.getMonth()] + " " + currentDate.getFullYear();

  const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
  const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth()+1, 0).getDate();

  for(let i=0;i<firstDay;i++){
    const empty = document.createElement('div');
    empty.style.padding="10px";
    grid.appendChild(empty);
  }

  for(let d=1; d<=daysInMonth; d++){
    const day=document.createElement('div');
    day.innerText=d;
    day.style.padding="10px";
    day.style.cursor="pointer";
    day.style.borderRadius="50%";

    day.onclick=function(){selectDate(this,d)};
    grid.appendChild(day);
  }
}

function selectDate(el,day){
  const children=document.getElementById('calendar-grid').children;
  for(let c of children){
    c.style.background="transparent";
    c.style.color="#353535";
  }
  el.style.background="#004271";
  el.style.color="white";
  selectedDate=new Date(currentDate.getFullYear(),currentDate.getMonth(),day);
}

function selectTime(el){
  const items=document.getElementById('time-slots').children;
  for(let i of items){
    i.style.background="white";
    i.style.color="#000";
  }
  el.style.background="#2563eb";
  el.style.color="white";
  selectedTime=el.innerText;
}

function selectExpert(){
  const check=document.getElementById('expert-check');
  const card=document.getElementById('expert-card');
  selectedExpert=!selectedExpert;
  if(selectedExpert){
    check.style.color="#2563eb";
    card.style.border="2px solid #2563eb";
  } else {
    check.style.color="transparent";
    card.style.border="1px solid #e5e7eb";
  }
}


document.getElementById('prev-month').onclick=()=>{
  currentDate.setMonth(currentDate.getMonth()-1);
  renderCalendar();
};
document.getElementById('next-month').onclick=()=>{
  currentDate.setMonth(currentDate.getMonth()+1);
  renderCalendar();
};

renderCalendar();
</script>

<!-- 3. JavaScript to handle the toggle -->
<script>
    function submitBooking() {
        var content = document.getElementById("paymentSection");
        if (content.style.display === "none") {
            content.style.display = "block";
        } else {
            content.style.display = "none";
        }
    }
</script>


</div>
{{-- middle part close--}}



    </div> 
{{-- end main tag --}}

<!-- COUPONS MODAL BACKDROP -->
<div class="coupon-backdrop" id="couponBackdrop" onclick="closeOnCouponBackdrop(event)" style="display:none;">
  <div class="coupon-modal" id="couponModal">

    <!-- Header -->
    <div class="coupon-header">
      <div class="coupon-title">Coupons</div>
      <div class="coupon-close" onclick="closeCouponModal()">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
          <path d="M1 1L13 13M13 1L1 13" stroke="#353535" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </div>
    </div>

    <!-- Coupon Input -->
    <div class="coupon-input-wrap">
      <input type="text" placeholder="Enter Coupon code" id="couponInput"/>
      <span class="coupon-apply-btn" onclick="applyCode()">Apply</span>
    </div>

    <!-- Divider -->
    <div class="coupon-divider"></div>

    <!-- Special Offers Label -->
    <div class="special-offers-label">Special Offers</div>

    <!-- Offers List -->
    <div class="offers-list">

      <!-- 1. Google Pay -->
     <div class="offer-card" onclick="applyCoupon('GPAY20')" style="cursor:pointer;">
        <div class="offer-logo">
          <span class="logo-placeholder">
            <span style="color:#4285F4">G</span><span style="color:#EA4335">o</span><span style="color:#FBBC05">o</span><span style="color:#4285F4">g</span><span style="color:#34A853">l</span><span style="color:#EA4335">e</span><br/>
            <span style="color:#555; font-size:11px; font-weight:400;">Pay</span>
          </span>
        </div>
        <div class="offer-content">
          <div class="offer-name">Up to AED 20 cashback</div>
          <div class="offer-validity">Valid for Gpay app only</div>
          <span class="offer-seemore" onclick="openOfferModal()">See more</span>
        </div>
        <div class="offer-right">
          <span class="coupon-code-badge">GPAY20</span>
        </div>
      </div>

      <!-- 2. Careem Pay -->
      <div class="offer-card">
        <div class="offer-logo">
          <span class="logo-placeholder" style="color:#1DB954;">
            <span style="font-size:22px;">☺</span><br/>
            <span style="color:#555; font-size:12px; font-weight:500;">Pay</span>
          </span>
        </div>
        <div class="offer-content">
          <div class="offer-name">Get AED 15 off with Careem Pay</div>
          <div class="offer-validity">Valid for Careem Pay only</div>
          <span class="offer-seemore" onclick="openOfferModal()">See more</span>
        </div>
        <div class="offer-right">
          <span class="coupon-code-badge">Careem15</span>
        </div>
      </div>

      <!-- 3. e& money -->
      <div class="offer-card">
        <div class="offer-logo">
          <span class="logo-placeholder">
            <span style="color:#E8001C; font-size:18px; font-weight:800;">e&amp;</span><br/>
            <span style="color:#E8001C; font-size:11px; font-weight:600;">money</span>
          </span>
        </div>
        <div class="offer-content">
          <div class="offer-name">Get AED 10 back via e&amp; money</div>
          <div class="offer-validity">Valid for e&amp; money only</div>
          <span class="offer-seemore" onclick="openOfferModal()">See more</span>
        </div>
        <div class="offer-right">
          <span class="coupon-code-badge">e&amp;m10</span>
        </div>
      </div>

      <!-- 4. Network -->
      <div class="offer-card">
        <div class="offer-logo">
          <span class="logo-placeholder">
            <span style="color:#004FA3; font-size:13px; font-weight:700;">network</span><span style="color:#E8001C; font-size:14px; font-weight:700;">›</span>
          </span>
        </div>
        <div class="offer-content">
          <div class="offer-name">Get 5% off at Network terminals</div>
          <div class="offer-validity">Valid for Network terminals only</div>
          <span class="offer-seemore" onclick="openOfferModal()">See more</span>
        </div>
        <div class="offer-right">
          <span class="coupon-code-badge">net5</span>
        </div>
      </div>

    </div><!-- /offers-list -->
  </div><!-- /coupon-modal -->
</div><!-- /backdrop -->

<!-- See More Detail Modal -->
<div class="offer-detail-backdrop" id="offerDetailBackdrop" onclick="closeOfferDetailBackdrop(event)" style="display:none;">
  <div class="offer-detail-modal">
    <div class="offer-detail-header">
      <div class="offer-detail-title">See More</div>
      <div onclick="closeOfferModal()" style="cursor:pointer; width:28px; height:28px; display:flex; align-items:center; justify-content:center;">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
          <path d="M1 1L13 13M13 1L1 13" stroke="#353535" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </div>
    </div>
    <div class="offer-detail-divider"></div>
    <ul class="offer-detail-terms">
      <li>Offer valid till 30th November 2025</li>
      <li>Minimum spend of AED 100 required</li>
      <li>Cashback will be credited within 24 hours</li>
      <li>Applicable only once per user during the offer period</li>
    </ul>
    <button class="offer-detail-btn" onclick="closeOfferModal()">Got It</button>
  </div>
</div>

<style>
  /* ── BACKDROP ── */
  .coupon-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.35);
    display: flex; align-items: center; justify-content: center;
    z-index: 9998;
  }

  /* ── MODAL — Figma: 520×597 ── */
  .coupon-modal {
    width: 520px;
    background: #E4F9FF;
    border-radius: 15px;
    padding: 24px 27px 28px;
    box-shadow: 0px 8px 24px rgba(0,0,0,0.12);
    max-height: 90vh; overflow-y: auto;
  }

  /* Header */
  .coupon-header {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 20px;
  }
  /* Figma: Roboto SemiBold 24px #353535 */
  .coupon-title {
    font-family: 'Roboto', sans-serif;
    font-weight: 600; font-size: 24px;
    color: #353535; text-transform: uppercase;
  }
  .coupon-close {
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
  }

  /* Figma: 465×40, border-radius:20, border:0.25px #A1A1A1 */
  .coupon-input-wrap {
    width: 100%; height: 40px;
    border-radius: 20px; border: 0.25px solid #A1A1A1;
    background: #FFFFFF;
    box-shadow: 0px 4px 4px 0px #00000008;
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 0 16px; margin-bottom: 20px;
  }
  .coupon-input-wrap input {
    border: none; outline: none; background: transparent;
    font-family: 'Roboto', sans-serif;
    font-weight: 300; font-size: 14px; color: #353535; flex: 1;
  }
  .coupon-input-wrap input::placeholder { color: #A1A1A1; }
  .coupon-apply-btn {
    font-family: 'Roboto', sans-serif;
    font-weight: 300; font-size: 14px;
    color: #353535; cursor: pointer; white-space: nowrap;
  }

  /* Figma: Line 0.5px #A1A1A1 */
  .coupon-divider { width: 100%; border-top: 0.5px solid #A1A1A1; margin-bottom: 14px; }

  /* Figma: Roboto SemiBold 14px */
  .special-offers-label {
    font-family: 'Roboto', sans-serif;
    font-weight: 600; font-size: 14px;
    color: #353535; margin-bottom: 12px;
  }

  .offers-list { display: flex; flex-direction: column; gap: 10px; }

  /* Figma: Rectangle 906 — 465×82, border-radius:15, bg:#FFFFFF */
  .offer-card {
    width: 100%; background: #FFFFFF;
    border-radius: 15px; padding: 12px 14px;
    display: flex; align-items: center;
  }

  /* Left logo with dashed separator */
  .offer-logo {
    width: 80px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    padding-right: 12px; margin-right: 14px;
    border-right: 1px dashed #004271;
    align-self: stretch;
  }
  .logo-placeholder {
    font-family: 'Roboto', sans-serif;
    font-weight: 700; font-size: 15px;
    text-align: center; line-height: 1.3;
    letter-spacing: -0.5px;
  }

  .offer-content { flex: 1; display: flex; flex-direction: column; gap: 4px; }

  /* Figma: Roboto SemiBold 14px */
  .offer-name { font-family: 'Roboto', sans-serif; font-weight: 600; font-size: 14px; color: #353535; }

  /* Figma: Roboto Regular 12px */
  .offer-validity { font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 12px; color: #353535; }

  /* Figma Group 351: See more underlined */
  .offer-seemore {
    font-family: 'Roboto', sans-serif;
    font-weight: 500; font-size: 14px;
    color: #353535; cursor: pointer;
    text-decoration: underline;
    width: fit-content; margin-top: 2px;
  }

  /* Badge pinned to bottom-right of card */
  .offer-right {
    flex-shrink: 0; margin-left: 8px;
    align-self: flex-end; padding-bottom: 2px;
  }

  /* Figma Group 375: dashed border, bg:#E4F9FF */
  .coupon-code-badge {
    border-radius: 5px;
    border: 1px dashed #004271;
    background: #E4F9FF;
    padding: 3px 10px;
    font-family: 'Roboto', sans-serif;
    font-weight: 400; font-size: 12px;
    color: #004271; white-space: nowrap;
  }

  /* ── Offer Detail Modal ── */
  .offer-detail-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.35);
    align-items: center; justify-content: center;
    z-index: 9999;
  }
  .offer-detail-modal {
    width: 520px; background: #E4F9FF;
    border-radius: 15px; padding: 28px 27px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    max-width: calc(100vw - 32px);
  }
  .offer-detail-header {
    display: flex; justify-content: space-between;
    align-items: center; margin-bottom: 18px;
  }
  .offer-detail-title {
    font-family: 'Roboto', sans-serif;
    font-weight: 600; font-size: 24px; color: #353535;
  }
  .offer-detail-divider { border-top: 0.5px solid #A1A1A1; margin-bottom: 22px; }
  .offer-detail-terms {
    list-style: none; display: flex;
    flex-direction: column; gap: 16px; margin-bottom: 28px;
  }
  .offer-detail-terms li {
    font-family: 'Roboto', sans-serif;
    font-weight: 400; font-size: 18px; color: #353535;
    display: flex; gap: 10px; align-items: flex-start;
  }
  .offer-detail-terms li::before { content: "•"; flex-shrink: 0; }
  .offer-detail-btn {
    width: 100%; height: 44px; border-radius: 15px;
    background: #004271; border: none; cursor: pointer;
    font-family: 'Roboto', sans-serif; font-weight: 600;
    font-size: 16px; color: #FFFFFF;
  }

  /* ── Responsive ── */
  @media (max-width: 580px) {
    .coupon-modal { width: calc(100vw - 32px); padding: 20px 16px; }
    .coupon-title { font-size: 20px; }
    .offer-name { font-size: 13px; }
    .offer-validity, .coupon-code-badge { font-size: 11px; }
    .offer-logo { width: 60px; }
    .offer-detail-terms li { font-size: 15px; }
  }
</style>

<script>
  function openCouponsModal() {
    document.getElementById('couponBackdrop').style.display = 'flex';
  }
  function closeCouponModal() {
    document.getElementById('couponBackdrop').style.display = 'none';
  }
  function closeOnCouponBackdrop(e) {
    if (e.target === document.getElementById('couponBackdrop')) closeCouponModal();
  }
  function applyCode() {
    const val = document.getElementById('couponInput').value.trim();
    if (val) alert('Coupon "' + val + '" applied!');
  }
function openOfferModal() {
  // hide coupons modal
  document.getElementById('couponBackdrop').style.display = 'none';

  // show offer detail modal
  document.getElementById('offerDetailBackdrop').style.display = 'flex';
}
 function closeOfferModal() {
  // hide offer modal
  document.getElementById('offerDetailBackdrop').style.display = 'none';

  // show coupons again
  document.getElementById('couponBackdrop').style.display = 'flex';
}
  function closeOfferDetailBackdrop(e) {
    if (e.target === document.getElementById('offerDetailBackdrop')) closeOfferModal(); 
  }


  function applyCoupon(code){

document.getElementById("couponAction").innerHTML = `
<span style="color:#10B000;font-weight:600">${code}</span>
<span style="color:#555">applied</span>
<span onclick="removeCoupon(event)" style="margin-left:20px;color:#555;cursor:pointer">Remove</span>
`;

closeCouponModal();

}

function removeCoupon(e){
e.stopPropagation();

document.getElementById("couponAction").innerHTML = `
<span style="font-size:16px;font-weight:500;color:#1E5AA5;">All Coupons</span>
<span style="font-size:20px;color:#1E5AA5;">›</span>
`;
}




function applyCoupon(code){

document.getElementById("appliedCouponRow").style.display="block";

document.getElementById("appliedCouponRow").innerHTML = `
<span style="color:#10B000;font-weight:600">${code}</span>
<span style="color:#555;"> applied</span>
<span onclick="removeCoupon(event)" style="margin-left:20px;color:#555;cursor:pointer;">Remove</span>
`;

closeCouponModal();

}

function removeCoupon(e){
e.stopPropagation();
document.getElementById("appliedCouponRow").style.display="none";
}
</script>

</body>
</html>