<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Libre+Baskerville:wght@700&family=Roboto:wght@300;400;500;600&family=Poppins:wght@300;400&display=swap" rel="stylesheet"/>
    <style>
        /* ── RESET ── */
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }
        img { display:block; max-width:100%; }
        a { text-decoration:none; color:inherit; }
        button { font-family:'Inter', sans-serif; cursor:pointer; }

        /* ══════════════════════════
           HEADER
        ══════════════════════════ */
        .header {
            background: #d6edf4;
            padding: 0 40px;
            height: 160px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #c0dde8;
            position: sticky;
            top: 0;
            z-index: 200;
            box-shadow: 0px 4px 4px 0px #00000040;
        }
        .header__left {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .header__back {
            width: 26px;
            height: 52px;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            padding: 0;
        }
        .header__back img {
            width: 26px;
            height: 52px;
            object-fit: contain;
        }
        .header__title {
            font-family: 'Libre Baskerville', serif;
            font-size: 24px;
            font-weight: 700;
            color: #004271;
            letter-spacing: 0.03em;
            line-height: 1;
        }
        
        /* Cart Button - Image swap on hover */
        .header__cart {
            width: 50px;
            height: 50px;
            background: none;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
        }
        
        .header__cart img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            transition: opacity 0.2s ease;
        }

        /* ══════════════════════════
           MAIN / GRID
        ══════════════════════════ */
        .main {
            padding: 40px;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ══════════════════════════
           WISHLIST CARD
        ══════════════════════════ */
        .wishlist-card {
            background: #FFFFFF;
            border-radius: 20px;
            border: 0.25px solid #B3B3B3;
            box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.09);
            padding: 16px;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .wishlist-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        }

        /* delete button */
        .delete-btn {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 14px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            z-index: 10;
            transition: transform 0.2s ease;
            padding: 0;
            cursor: pointer;
        }
        .delete-btn:hover { transform: scale(1.1); }
        .delete-btn img {
            width: 14px;
            height: 18px;
            object-fit: contain;
        }

        /* card top: image + content */
        .card__top {
            display: flex;
            gap: 14px;
            margin-bottom: 14px;
        }
        .card__img {
            flex-shrink: 0;
            width: 94px;
            height: 106px;
            border-radius: 10px;
            border: 1px solid #B2B2B2;
            overflow: hidden;
        }
        .card__img img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .card__content {
            flex: 1;
            padding-right: 28px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .card__title {
            font-family: 'Roboto', sans-serif;
            font-size: 20px;
            font-weight: 500;
            color: #353535;
            letter-spacing: 0;
            line-height: 1;
            margin-bottom: 8px;
        }
        .card__desc {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            font-weight: 400;
            color: #353535;
            letter-spacing: 0;
            line-height: 1.5;
            margin-bottom: 10px;
        }
        .card__price {
            font-family: 'Roboto', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: #353535;
            letter-spacing: 0;
            line-height: 1;
        }
        .card__price span { color: #353535; }

        /* card bottom: actions */
        .card__actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 30px;
        }
        .book-btn {
            background: #E4F9FF;
            color: #004271;
            width: 94px;
            height: 24px;
            border-radius: 10px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            font-weight: 400;
            border: none;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .book-btn:hover { background: #004271; color: #fff; }

        .view-btn {
            color: #004271;
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            font-weight: 500;
            background: none;
            border: none;
            flex-shrink: 0;
            cursor: pointer;
        }
        .view-btn:hover { text-decoration: underline; }

        /* stars */
        .card__rating {
            display: flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
        }
        .stars img {
            width: 75px;
            height: 13px;
            object-fit: contain;
        }
        .card__reviews {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 300;
            color: #353535;
            white-space: nowrap;
        }

        /* ══════════════════════════
           RESPONSIVE
        ══════════════════════════ */
        @media (max-width:1100px) {
            .cards-grid { grid-template-columns: repeat(2,1fr); }
        }
        @media (max-width:767px) {
            .header { padding:0 16px; height:60px; }
            .header__title { font-size:18px; }
            .main { padding:16px; }
            .cards-grid { grid-template-columns:1fr; gap:14px; }
            .card__img { width:75px; height:85px; }
            .card__title { font-size:16px; }
            .card__price { font-size:14px; }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header__left">
            <button class="header__back" aria-label="Back" onclick="window.location='{{ route('home') }}'">
                <img src="{{ asset('assets/images/weui_back-outlined.png') }}"
                     alt="Back"
                     onerror="this.style.display='none';this.onerror=null;"/>
            </button>
            <h1 class="header__title">My Wishlist</h1>
        </div>
        <button class="header__cart" id="cartBtn" aria-label="Cart">
            <img id="cartImage" src="{{ asset('assets/images/Group 317.png') }}" alt="Cart" />
        </button>
    </header>

    <!-- CARDS -->
    <main class="main">
        <div class="cards-grid">

            <!-- Card 1 - Ironing -->
            <div class="wishlist-card">
                <button class="delete-btn" aria-label="Delete">
                    <img src="{{ asset('assets/images/Vector.png') }}" alt="Delete"
                         onerror="this.src='https://cdn-icons-png.flaticon.com/16/3096/3096673.png';this.onerror=null;"/>
                </button>
                <div class="card__top">
                    <div class="card__img">
                        <img src="{{ asset('assets/images/image.png') }}" alt="Ironing Service"
                             onerror="this.src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=200&q=80';this.onerror=null;"/>
                    </div>
                    <div class="card__content">
                        <h3 class="card__title">Ironing</h3>
                        <p class="card__desc">Wrinkle-free clothes, crisp and neat – ready to wear anytime.</p>
                        <p class="card__price">Starts at <span>AED 499</span></p>
                    </div>
                </div>
                <div class="card__actions">
                    <button class="book-btn">Book Now</button>
                    <button class="view-btn">View Details</button>
                    <div class="card__rating">
                        <div class="stars">
                            <img src="{{ asset('assets/images/Group 84.png') }}" alt="Rating stars"/>
                        </div>
                        <span class="card__reviews">(30 k reviews)</span>
                    </div>
                </div>
            </div>

            <!-- Card 2 - Folding -->
            <div class="wishlist-card">
                <button class="delete-btn" aria-label="Delete">
                    <img src="{{ asset('assets/images/Vector.png') }}" alt="Delete"
                         onerror="this.src='https://cdn-icons-png.flaticon.com/16/3096/3096673.png';this.onerror=null;"/>
                </button>
                <div class="card__top">
                    <div class="card__img">
                        <img src="{{ asset('assets/images/image.png') }}" alt="Folding Service"
                             onerror="this.src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=200&q=80';this.onerror=null;"/>
                    </div>
                    <div class="card__content">
                        <h3 class="card__title">Folding</h3>
                        <p class="card__desc">Properly folded clothes to save space and keep your wardrobe tidy.</p>
                        <p class="card__price">Starts at <span>AED 599</span></p>
                    </div>
                </div>
                <div class="card__actions">
                    <button class="book-btn">Book Now</button>
                    <button class="view-btn">View Details</button>
                    <div class="card__rating">
                        <div class="stars">
                            <img src="{{ asset('assets/images/Group 84.png') }}" alt="Rating stars"/>
                        </div>
                        <span class="card__reviews">(30 k reviews)</span>
                    </div>
                </div>
            </div>

            <!-- Card 3 - Laundry Collection -->
            <div class="wishlist-card">
                <button class="delete-btn" aria-label="Delete">
                    <img src="{{ asset('assets/images/Vector.png') }}" alt="Delete"
                         onerror="this.src='https://cdn-icons-png.flaticon.com/16/3096/3096673.png';this.onerror=null;"/>
                </button>
                <div class="card__top">
                    <div class="card__img">
                        <img src="{{ asset('assets/images/image.png') }}" alt="Laundry Collection"
                             onerror="this.src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=200&q=80';this.onerror=null;"/>
                    </div>
                    <div class="card__content">
                        <h3 class="card__title">Laundry Collection</h3>
                        <p class="card__desc">Properly folded clothes to save space and keep your wardrobe tidy.</p>
                        <p class="card__price">Starts at <span>AED 599</span></p>
                    </div>
                </div>
                <div class="card__actions">
                    <button class="book-btn">Book Now</button>
                    <button class="view-btn">View Details</button>
                    <div class="card__rating">
                        <div class="stars">
                            <img src="{{ asset('assets/images/Group 84.png') }}" alt="Rating stars"/>
                        </div>
                        <span class="card__reviews">(30 k reviews)</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        lucide.createIcons();

        // Cart image swap on hover
        const cartBtn = document.getElementById('cartBtn');
        const cartImage = document.getElementById('cartImage');

        cartBtn.addEventListener('mouseenter', () => {
            cartImage.src = "{{ asset('assets/images/cart.png') }}";
        });

        cartBtn.addEventListener('mouseleave', () => {
            cartImage.src = "{{ asset('assets/images/Group 317.png') }}";
        });

        // Delete button
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.wishlist-card');
                card.style.transform = 'scale(0.9)';
                card.style.opacity = '0';
                setTimeout(() => card.remove(), 200);
            });
        });

        // Book Now button
        document.querySelectorAll('.book-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.wishlist-card');
                const title = card.querySelector('.card__title').textContent;
                alert(`Booking: ${title}`);
            });
        });
    </script>

</body>
</html>