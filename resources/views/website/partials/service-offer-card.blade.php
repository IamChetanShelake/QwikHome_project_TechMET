@php
    $variant = $variant ?? 'default';
@endphp

@if ($variant === 'everything')
    <div class="rounded-3xl overflow-hidden cursor-pointer relative flex-shrink-0 offer-card" style="width: 281px; height: 220px;">
        <div class="offer-img-container h-full">
            <div class="category-img-wrapper h-full">
                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover rounded-3xl" style=" transform: scale(1.15);">
            </div>
            <div class="offer-overlay">
                <div class="offer-overlay-left">{{ $service->name }}</div>
                <div class="offer-overlay-right">
                    <div class="offer-icons">
                        <button class="offer-icon-btn cart-btn" data-service-id="{{ $service->id }}" onclick="addServiceToCart(event, {{ $service->id }})">
                            <svg viewBox="0 0 24 24">
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                <circle cx="9" cy="21" r="1.5"/>
                                <circle cx="20" cy="21" r="1.5"/>
                            </svg>
                        </button>
                        <button class="offer-icon-btn heart-btn" data-service-id="{{ $service->id }}" onclick="addServiceToWishlist(event, {{ $service->id }})">
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
@else
    <div class="offer-card w-[281px] h-[220px] flex-shrink-0">
        <div class="offer-img-container h-full">
            <div class="category-img-wrapper h-full">
                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover" style=" transform: scale(1.15);">
            </div>
            <div class="offer-overlay">
                <span class="offer-overlay-left">{{ $service->name }}</span>
                <div class="offer-overlay-right">
                    <div class="offer-icons">
                        <button class="offer-icon-btn cart-btn" data-service-id="{{ $service->id }}" onclick="addServiceToCart(event, {{ $service->id }})">
                            <svg viewBox="0 0 24 24">
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                <circle cx="9" cy="21" r="1.5"/>
                                <circle cx="20" cy="21" r="1.5"/>
                            </svg>
                        </button>
                        <button class="offer-icon-btn heart-btn" data-service-id="{{ $service->id }}" onclick="addServiceToWishlist(event, {{ $service->id }})">
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
@endif
