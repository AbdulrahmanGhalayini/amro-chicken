@props(['offers', 'themeColor' => '#000'])

@if($offers && $offers->isNotEmpty())
<style>
    /* Offers Carousel Styles */
    .offers_overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .offers_overlay.show {
        display: block;
        opacity: 1;
    }
    
    .offers_container {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 480px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        overflow: hidden;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .offers_container.show {
        display: block;
        opacity: 1;
    }
    
    .offers_close_btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--offers-theme-color, #000);
        border: none;
        font-size: 28px;
        cursor: pointer;
        color: #333;
        z-index: 1001;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s ease;
    }
    
    .offers_close_btn:hover {
        background: rgba(0, 0, 0, 0.1);
    }
    
    .offers_carousel {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    
    .offers_slides {
        display: flex;
        transition: transform 0.4s ease;
        width: 100%;
    }
    
    .offers_slide {
        min-width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0;
    }
    
    .offer_image {
        width: 100%;
        height: auto;
        object-fit: contain;
        border-radius: 0;
        margin-bottom: 0;
    }
    
    .offer_content {
        width: 100%;
    }
    
    .offer_title {
        margin: 0 0 10px 0;
        color: var(--offers-theme-color, #000);
        font-size: 18px;
        font-weight: 600;
    }
    
    .offer_description {
        margin: 0;
        color: #666;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .offers_nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: var(--offers-theme-color, #000);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
        z-index: 10;
    }
    
    .offers_nav:hover {
        opacity: 0.8;
    }
    
    .offers_prev {
        left: 10px;
    }
    
    .offers_next {
        right: 10px;
    }
    
    .offers_indicators {
        display: flex;
        justify-content: center;
        gap: 8px;
        padding: 15px 20px;
        background: #f9f9f9;
    }
    
    .indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ddd;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    
    .indicator.active {
        background: var(--offers-theme-color, #000);
    }
</style>

<!-- Offers Carousel Overlay -->
<div class="offers_overlay" id="offers_overlay" onclick="closeOffers(event)"></div>
<div class="offers_container" id="offers_container" style="--offers-theme-color: {{ $themeColor }}">
    <button class="offers_close_btn" onclick="closeOffers()">&times;</button>
    <div class="offers_carousel">
        <div class="offers_slides" id="offers_slides">
            @foreach($offers as $offer)
            <div class="offers_slide">
                @if($offer->image)
                <img src="{{ Storage::disk('public')->url($offer->image) }}" class="offer_image">
                @endif
            </div>
            @endforeach
        </div>
        <button class="offers_nav offers_prev" onclick="prevOffer()">&lt;</button>
        <button class="offers_nav offers_next" onclick="nextOffer()">&gt;</button>
    </div>
    <div class="offers_indicators" id="offers_indicators">
        @foreach($offers as $index => $offer)
        <span class="indicator @if($index === 0) active @endif" onclick="goToOffer({{ $index }})"></span>
        @endforeach
    </div>
</div>

<script>
    let currentOfferIndex = 0;
    let offersAutoPlayInterval;
    const totalOffers = document.querySelectorAll('.offers_slide')?.length || 0;
    
    const showOffers = () => {
        if (totalOffers === 0) return;
        document.body.style.overflow = 'hidden';
        document.getElementById('offers_overlay').classList.add('show');
        document.getElementById('offers_container').classList.add('show');
        startOffersAutoPlay();
    };
    
    const closeOffers = (event) => {
        if (event && event.target.id === 'offers_overlay') {
            document.getElementById('offers_overlay').classList.remove('show');
            document.getElementById('offers_container').classList.remove('show');
            document.body.style.overflow = 'auto';
            stopOffersAutoPlay();
        } else if (!event) {
            document.getElementById('offers_overlay').classList.remove('show');
            document.getElementById('offers_container').classList.remove('show');
            document.body.style.overflow = 'auto';
            stopOffersAutoPlay();
        }
    };
    
    const updateOffersCarousel = (index) => {
        const slidesContainer = document.getElementById('offers_slides');
        const offset = -index * 100;
        slidesContainer.style.transform = `translateX(${offset}%)`;
        
        document.querySelectorAll('.indicator').forEach((indicator, i) => {
            if (i === index) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    };
    
    const nextOffer = () => {
        currentOfferIndex = (currentOfferIndex + 1) % totalOffers;
        updateOffersCarousel(currentOfferIndex);
        resetOffersAutoPlay();
    };
    
    const prevOffer = () => {
        currentOfferIndex = (currentOfferIndex - 1 + totalOffers) % totalOffers;
        updateOffersCarousel(currentOfferIndex);
        resetOffersAutoPlay();
    };
    
    const goToOffer = (index) => {
        currentOfferIndex = index;
        updateOffersCarousel(currentOfferIndex);
        resetOffersAutoPlay();
    };
    
    const startOffersAutoPlay = () => {
        offersAutoPlayInterval = setInterval(() => {
            nextOffer();
        }, 5000);
    };
    
    const stopOffersAutoPlay = () => {
        clearInterval(offersAutoPlayInterval);
    };
    
    const resetOffersAutoPlay = () => {
        stopOffersAutoPlay();
        startOffersAutoPlay();
    };
    
    // Initialize offers on page load
    document.addEventListener('DOMContentLoaded', () => {
        if (totalOffers > 0) {
            showOffers();
        }
    });
</script>
@endif
