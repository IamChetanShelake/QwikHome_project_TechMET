@php
    $price = $service->price_onetime
        ?? $service->price_weekly
        ?? $service->price_monthly
        ?? $service->price_yearly
        ?? 0;
    $description = $service->short_description ?: $service->description;
@endphp

<label class="cart-service-card" data-service-id="{{ $service->id }}" style="
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

            <div style="
                width:133px;
                height:161px;
                border-radius:15px;
                border:1px solid #B5B5B5;
                overflow:hidden;
                flex-shrink:0;
            ">
                <img src="{{ $service->image_url }}" style="width:100%; height:100%; object-fit:cover;">
            </div>
        </div>

        <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; padding-top:15px;">
            <div style="font-weight:600; font-size:20px; color:#353535;">{{ $service->name }}</div>
            <div style="font-size:16px; color:#353535; margin-top:8px;">{{ \Illuminate\Support\Str::limit(strip_tags($description ?: 'Professional home service.'), 80) }}</div>
            <div style="height:1px; background:#B5B5B5; margin:12px 0;"></div>
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="font-size:20px; color:#353535;">
                    AED {{ number_format((float) $price, 0) }}
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="
                        display: flex;
                        align-items: center;
                        border: 1px solid #E4F9FF;
                        border-radius: 15px;
                        overflow: hidden;
                        background-color: #E4F9FF;
                    ">
                        <button type="button" class="cart-quantity-minus" style="
                            color: #004271;
                            width: 28px;
                            height: 28px;
                            border: none;
                            background: transparent;
                            font-size: 25px;
                            cursor: pointer;
                        ">-</button>

                        <span class="cart-quantity-value" style="
                            color: #004271;
                            font-weight: 400;
                            width: 30px;
                            text-align: center;
                            font-size: 20px;
                            line-height: 28px;
                        ">{{ $quantity ?? 1 }}</span>

                        <button type="button" class="cart-quantity-plus" style="
                            color: #BABABA;
                            width: 28px;
                            height: 28px;
                            border: none;
                            background: transparent;
                            font-size: 25px;
                            cursor: pointer;
                        ">+</button>
                    </div>

                    <button type="button" class="cart-delete-btn" style="
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
