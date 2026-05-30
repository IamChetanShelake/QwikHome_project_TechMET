@php
    $price = $service->price_onetime
        ?? $service->price_weekly
        ?? $service->price_monthly
        ?? $service->price_yearly
        ?? 0;
    $description = $service->short_description ?: $service->description;
@endphp

<div class="wishlist-card">
    <button class="delete-btn" aria-label="Delete">
        <img src="{{ asset('assets/images/Vector.png') }}" alt="Delete"
             onerror="this.src='https://cdn-icons-png.flaticon.com/16/3096/3096673.png';this.onerror=null;"/>
    </button>
    <div class="card__top">
        <div class="card__img">
            <img src="{{ $service->image_url }}" alt="{{ $service->name }}"
                 onerror="this.src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=200&q=80';this.onerror=null;"/>
        </div>
        <div class="card__content">
            <h3 class="card__title">{{ $service->name }}</h3>
            <p class="card__desc">{{ \Illuminate\Support\Str::limit(strip_tags($description ?: 'Professional home service.'), 90) }}</p>
            <p class="card__price">Starts at <span>AED {{ number_format((float) $price, 0) }}</span></p>
        </div>
    </div>
    <div class="card__actions">
        <button class="book-btn" data-service-id="{{ $service->id }}">Book Now</button>
        <button class="view-btn">View Details</button>
        <div class="card__rating">
            <div class="stars">
                <img src="{{ asset('assets/images/Group 84.png') }}" alt="Rating stars"/>
            </div>
            <span class="card__reviews">({{ number_format($service->total_reviews ?? 0) }} reviews)</span>
        </div>
    </div>
</div>
