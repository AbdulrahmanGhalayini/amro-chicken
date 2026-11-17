<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Primary Meta Tags -->
    <title>{{ $business->name }}</title>
    <meta name="title" content="{{ $business->name }}">
    @if ($business->slogan)
    <meta name="description" content="{{ $business->slogan }}">
    @endif
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('menu.show', ['slug' => $business->slug]) }}">
    <meta property="og:title" content="{{ $business->name }}">
    @if ($business->slogan)
    <meta property="og:description" content="{{ $business->slogan }}">
    @endif
    <meta property="og:image" content="{{ Storage::disk('public')->url($business->profile_photo) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('menu.show', $business->slug) }}">
    <meta property="twitter:title" content="{{ $business->name }}">


    @if ($business->slogan)
    <meta property="twitter:description" content="{{ $business->slogan }}">
    @endif
    <meta property="twitter:image" content="{{ Storage::disk('public')->url($business->profile_photo) }}">


    


    <style>
        :root {
            --theme-color: {{ $business->theme_color }};
        }
        
        .header {
            transition: all 0.3s ease;
        }
        
        .header.scrolled {
            padding: 10px 0 !important;
        }
        
        
        
        
       
    </style>
    <link rel="stylesheet" href="{{ asset('css/style1.css?v=1') }}">
	<style>
	.product_list_item.active {
    display: block;
}
.per_kg_label { font-size: 13px; color: #777; margin-inline-start: 4px; }
.weight_picker { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; padding: 8px 0 2px; }
.weight_label { font-size: 13px; color: #555; }
body.rtl .weight_picker { flex-direction: row-reverse; }
.cart_item_weight { font-size: 13px; color: #555; }
.weight_input {
    width: 72px; padding: 4px 8px; font-size: 14px; font-family: inherit;
    border: 1px solid var(--theme-color); border-radius: 999px; text-align: center; direction: ltr;
}
.weight_input.invalid { border-color: #e00; background: #fff0f0; }
.weight_unit { font-size: 13px; color: #555; }
.qty_display.weight_qty { display: inline-flex; align-items: center; gap: 4px; width: auto; min-width: 0; white-space: nowrap; }
.cart_weight_input { width: 70px; padding: 4px 6px; font-size: 15px; font-family: inherit; text-align: center; border: 1px solid #ccc; border-radius: 6px; direction: ltr; }
</style>
</head>
@php
$rate = -1;
if($business->use_rate==1) {
    $rate = 0;
    if(request()->has('rate') && request()->get('rate') == 1) {
        $rate = 1;
    }
}

@endphp
<body class="@if(app()->getLocale() == 'ar') rtl @else ltr @endif c">
        <div class="menu">
            <header class="header">
                <div class="cover_photo" style="background-image: url('{{ Storage::disk('public')->url($business->cover_photo) }}');"></div>
                <div class="business_main_details">
                    <div class="logo_col">
                        <div class="logo_div" style="background:{{ $business->theme_color }};">
                            <img src="{{ Storage::disk('public')->url($business->profile_photo) }}" alt="{{ $business->name }}" class="profile_photo">
                        </div>
                    </div>
                    <div class="details_col">
                        <h2 class="c_theme b_name">{{ $business->name }}</h2>
                    </div>
                </div>
                <div class="b_details">
                    @if ($business->slogan)
                        <h3 class="b_slogan">{{ $business->slogan }}</h3>
                    @endif
                    
                    <div style="margin: 10px 0px;">
                        <a href="{{ $business->location_url }}" target="_blank" rel="noopener noreferrer" style=" text-decoration: none; font-style: italic" aria-label="Visit our location on map">
                            <div class="b_address">
                                <div class="dinb vm"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 100 100"><path fill="{{ $business->theme_color }}" d="M22.5 0a5 5 0 0 0-5 5v90a5 5 0 0 0 5 5h55a5 5 0 0 0 5-5V5a5 5 0 0 0-5-5zm5 10h45.271v76h-15.43c1.24-.551 2.473-1.195 3.653-2.025l.004-.004l.004-.002a13.4 13.4 0 0 0 2.092-1.813l-2.865-3.115c-.415.447-.905.86-1.448 1.246h-.002c-1.427 1.005-3.084 1.762-4.843 2.412L54.976 86h-4.285l-.488-2.13c-2.547.685-5.153 1.207-7.789 1.65l.068.48H27.5zM56 13.99c-5.34 0-9.715 4.363-9.715 9.688c0 2.063.658 3.982 1.774 5.558l6.755 11.678c.947 1.236 1.577 1.002 2.364-.064l7.45-12.682a5.5 5.5 0 0 0 .372-.857c.46-1.124.715-2.35.715-3.633c0-5.325-4.375-9.688-9.715-9.688m0 4.54a5.124 5.124 0 0 1 5.162 5.148A5.124 5.124 0 0 1 56 28.826a5.124 5.124 0 0 1-5.162-5.148A5.124 5.124 0 0 1 56 18.529m-.916 25.288c-2.753.342-5.527.83-8.272 1.612l1.034 4.252c2.493-.711 5.078-1.17 7.703-1.496zM42.704 46.9c-.805.358-1.605.77-2.384 1.256l-.002.004l-.005.002c-1.091.687-2.24 1.558-3.178 2.824c-.68.918-1.236 2.079-1.365 3.452l4.04.447c.031-.323.194-.747.49-1.147h.003v-.002c.479-.646 1.196-1.236 2.049-1.773h.002a16 16 0 0 1 1.894-.996zm-2.081 9.944l-2.62 3.36a11 11 0 0 0 1.901 1.366l.008.004l.01.006c2.088 1.187 4.239 1.858 6.234 2.494l1.149-4.219c-1.995-.636-3.876-1.25-5.489-2.166a7 7 0 0 1-1.193-.845m10.576 4.197l-1.119 4.227l.53.164l.65.207c2.153.7 4.215 1.448 6.058 2.484l1.871-3.902c-2.23-1.253-4.543-2.07-6.773-2.795l-.006-.002l-.668-.213zm11.791 6.107l-2.87 3.11c.678.735 1.185 1.62 1.433 2.533l.002.006v.006c.295 1.067.297 2.322.066 3.59l3.984.85c.326-1.79.379-3.755-.156-5.694a10.6 10.6 0 0 0-2.459-4.4M45 90.41h10V95H45z" color="currentColor"/></svg></div>
                                <div class="dinb vm">{{ $business->location }}</div>
                            </div>
                        </a>
                    </div>
                    <div style="margin: 10px 0px; display: flex; align-items: center; gap: 20px; justify-content: space-between;  @if(app()->getLocale() == 'ar') flex-direction: row-reverse;  @endif">
                        @if($business->phone)
                            <div style="">
                                <a href="tel:{{ $business->phone }}" aria-label="Call us" style="text-decoration: none; font-style: italic">
                                    <div class="b_address">
                                        {{-- <div class="dinb vm"><svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 512 512"><path fill="{{ $business->theme_color }}" d="M256 92.6c-69.6-.1-139.1 11.6-208.56 35.4c0 0-9.87 22.6-17.98 41.3a47 47 0 0 0-3.49 12.2c48.55-18.4 97.13-31 145.63-38c4.5-8.8 13.7-14.6 23.9-14.6h17.3c7.9 0 15.1 3.4 20.1 8.9c15.4-.6 30.8-.7 46.4-.1c4.9-5.5 12.1-8.8 19.8-8.8h17.3c10.1 0 19.1 5.6 23.7 14.1c48.7 6.6 97.2 19.4 145.9 38.3c-.7-4-1.8-8.2-3.5-12c-8.1-18.7-18-41.3-18-41.3c-69.5-23.4-139-35.33-208.5-35.4m-60.5 53.6c-4.7 0-8.8 3.4-9.6 8.1l-6.7 40.4c-12.1 2.2-23.9 5-35.3 8.4c-9.8 3-17.6 10.4-21.2 19.9c-13.8 37-48.72 130.6-48.72 130.6H438s-34.8-93.5-48.7-130.6c-3.5-9.5-11.4-17-21.2-19.9c-11.4-3.4-23.2-6.2-35.3-8.4l-6.8-40.4c-.8-4.7-4.8-8.1-9.6-8.1h-17.3c-4.6 0-8.7 3.2-9.5 7.8l-2.2 10.6h-62.9l-2.2-10.6c-.8-4.6-4.8-7.8-9.5-7.8zm163.8 17.3l-2.7 18.6c5.6 1.4 11.1 2.8 16.4 4.5c14 6.2 25.7 15.7 31.1 27.2l64.8 15.5c6.4-9.8 13.6-18.7 16.3-29.8c-42-16.6-83.9-28.7-125.9-36m-206.5.5c-42 7.5-84.01 19.4-126.02 35.6c3.05 11.7 9.6 19.6 16.31 29.7l64.81-15.5c5.9-13 17.2-23 31-27.2q8.25-2.4 16.5-4.5zM256 197.3c44.7 0 81 30.9 81 69s-36.3 68.9-81 68.9s-81.1-30.8-81.1-68.9s36.4-69 81.1-69m0 17.6c-30.1 0-54.5 20.8-54.5 46.4s24.4 46.4 54.5 46.4s54.4-20.8 54.4-46.4s-24.3-46.4-54.4-46.4M73.97 376.5l21.76 42.9H416.2l21.7-42.9z"/></svg></div> --}}
                                        <div class="dinb vm"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><g fill="none" stroke="{{ $business->theme_color }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M14.138 17.687h.007a3.225 3.225 0 0 0 4.014-.44l.452-.452a1.076 1.076 0 0 0 0-1.52l-1.9-1.9a1.076 1.076 0 0 0-1.52 0a1.077 1.077 0 0 1-1.522 0l-3.042-3.044a1.076 1.076 0 0 1 0-1.52a1.076 1.076 0 0 0 0-1.522l-1.9-1.9A1.076 1.076 0 0 0 7.2 5.387l-.452.451a3.23 3.23 0 0 0-.44 4.015v.007a29.1 29.1 0 0 0 7.829 7.827"/><path d="M21 18.751a11.25 11.25 0 1 0-9 4.5c4.418 0 6.446-2.136 5.215-5.344"/></g></svg></div>
                                        <div class="dinb vm" style="font-weight: 500; font-size:16px">{{ $business->phone }}</div>
                                    </div>
                                </a>
                            </div>
                        @endif    
                        @if($business->language =='both')
                            <div>
                                @if(app()->getLocale() == 'en')
                                    <a href="{{ route('switch.language', ['lang' => 'ar']) }}" class="language_switcher" aria-label="Switch to Arabic">
                                        <div class="b_address">
                                            <div class="dinb vm"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 32 32"><path fill="{{ $business->theme_color }}" d="M.034 16.668C.388 25.179 7.403 32 16 32s15.612-6.821 15.966-15.332A.5.5 0 0 0 32 16.5c0-.036-.013-.067-.02-.1c.003-.134.02-.265.02-.4c0-8.822-7.178-16-16-16S0 7.178 0 16c0 .135.017.266.02.4c-.007.033-.02.064-.02.1c0 .06.015.115.034.168m24.887 6.074a22 22 0 0 0-4.215-1.271c.158-1.453.251-2.962.28-4.47h4.98c-.091 2.054-.456 3.993-1.045 5.741M26.965 17h3.984a14.9 14.9 0 0 1-2.663 7.579a17 17 0 0 0-2.457-1.44c.645-1.869 1.042-3.943 1.136-6.139m-14.576 5.286A23.4 23.4 0 0 1 16 22c1.224 0 2.433.102 3.61.286C18.916 27.621 17.4 31 16 31s-2.916-3.379-3.611-8.714m1.519 8.378c-2.751-.882-5.078-3.471-6.482-6.984a21 21 0 0 1 3.99-1.217c.459 3.496 1.298 6.542 2.492 8.201m-1.634-19.955A24.4 24.4 0 0 0 16 11a24.4 24.4 0 0 0 3.726-.291c.172 1.62.274 3.388.274 5.291h-8c0-1.903.102-3.671.274-5.291M19.985 17a49 49 0 0 1-.26 4.291A24.4 24.4 0 0 0 16 21a24.4 24.4 0 0 0-3.726.291a49 49 0 0 1-.26-4.291zm.6 5.463c1.404.282 2.743.692 3.99 1.217c-1.404 3.513-3.731 6.102-6.482 6.984c1.193-1.659 2.032-4.705 2.492-8.201M21 16c0-1.836-.102-3.696-.294-5.47c1.48-.292 2.896-.72 4.215-1.271C25.605 11.288 26 13.574 26 16zm-.415-6.463c-.46-3.496-1.298-6.543-2.493-8.201c2.751.882 5.078 3.471 6.482 6.984a20.8 20.8 0 0 1-3.989 1.217m-.974.177C18.433 9.898 17.224 10 16 10s-2.433-.102-3.611-.286C13.084 4.379 14.6 1 16 1s2.916 3.379 3.611 8.714m-8.196-.177a21 21 0 0 1-3.99-1.217c1.404-3.513 3.731-6.102 6.482-6.984c-1.193 1.659-2.032 4.705-2.492 8.201m-.121.993A51 51 0 0 0 11 16H6c0-2.426.395-4.712 1.079-6.742c1.319.552 2.735.979 4.215 1.272m-.28 6.47c.029 1.508.122 3.017.28 4.471c-1.48.292-2.896.72-4.215 1.271c-.589-1.748-.954-3.687-1.045-5.742zM6.17 23.139a17 17 0 0 0-2.456 1.44A14.9 14.9 0 0 1 1.051 17h3.984c.094 2.196.491 4.27 1.135 6.139M4.313 25.38a16 16 0 0 1 2.207-1.305c1.004 2.485 2.449 4.548 4.186 5.943a15.05 15.05 0 0 1-6.393-4.638m16.981 4.637c1.738-1.394 3.182-3.458 4.186-5.943c.79.384 1.522.826 2.207 1.305a15.03 15.03 0 0 1-6.393 4.638M27 16c0-2.567-.428-4.987-1.17-7.139c.88-.422 1.698-.907 2.457-1.44A14.9 14.9 0 0 1 31 16zm.688-9.38c-.685.479-1.417.921-2.207 1.305c-1.004-2.485-2.449-4.549-4.186-5.943a15.06 15.06 0 0 1 6.393 4.638M10.706 1.983C8.968 3.377 7.524 5.441 6.52 7.926A16 16 0 0 1 4.313 6.62a15.04 15.04 0 0 1 6.393-4.637M3.714 7.421a17 17 0 0 0 2.456 1.44A22 22 0 0 0 5 16H1c0-3.19 1.009-6.145 2.714-8.579"/></svg></div>
                                            <div class="dinb vm" style="font-weight: 500; font-size:16px">AR</div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('switch.language', ['lang' => 'en']) }}" class="language_switcher" aria-label="Switch to English">
                                        <div class="b_address">
                                            <div class="dinb vm"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 32 32"><path fill="{{ $business->theme_color }}" d="M.034 16.668C.388 25.179 7.403 32 16 32s15.612-6.821 15.966-15.332A.5.5 0 0 0 32 16.5c0-.036-.013-.067-.02-.1c.003-.134.02-.265.02-.4c0-8.822-7.178-16-16-16S0 7.178 0 16c0 .135.017.266.02.4c-.007.033-.02.064-.02.1c0 .06.015.115.034.168m24.887 6.074a22 22 0 0 0-4.215-1.271c.158-1.453.251-2.962.28-4.47h4.98c-.091 2.054-.456 3.993-1.045 5.741M26.965 17h3.984a14.9 14.9 0 0 1-2.663 7.579a17 17 0 0 0-2.457-1.44c.645-1.869 1.042-3.943 1.136-6.139m-14.576 5.286A23.4 23.4 0 0 1 16 22c1.224 0 2.433.102 3.61.286C18.916 27.621 17.4 31 16 31s-2.916-3.379-3.611-8.714m1.519 8.378c-2.751-.882-5.078-3.471-6.482-6.984a21 21 0 0 1 3.99-1.217c.459 3.496 1.298 6.542 2.492 8.201m-1.634-19.955A24.4 24.4 0 0 0 16 11a24.4 24.4 0 0 0 3.726-.291c.172 1.62.274 3.388.274 5.291h-8c0-1.903.102-3.671.274-5.291M19.985 17a49 49 0 0 1-.26 4.291A24.4 24.4 0 0 0 16 21a24.4 24.4 0 0 0-3.726.291a49 49 0 0 1-.26-4.291zm.6 5.463c1.404.282 2.743.692 3.99 1.217c-1.404 3.513-3.731 6.102-6.482 6.984c1.193-1.659 2.032-4.705 2.492-8.201M21 16c0-1.836-.102-3.696-.294-5.47c1.48-.292 2.896-.72 4.215-1.271C25.605 11.288 26 13.574 26 16zm-.415-6.463c-.46-3.496-1.298-6.543-2.493-8.201c2.751.882 5.078 3.471 6.482 6.984a20.8 20.8 0 0 1-3.989 1.217m-.974.177C18.433 9.898 17.224 10 16 10s-2.433-.102-3.611-.286C13.084 4.379 14.6 1 16 1s2.916 3.379 3.611 8.714m-8.196-.177a21 21 0 0 1-3.99-1.217c1.404-3.513 3.731-6.102 6.482-6.984c-1.193 1.659-2.032 4.705-2.492 8.201m-.121.993A51 51 0 0 0 11 16H6c0-2.426.395-4.712 1.079-6.742c1.319.552 2.735.979 4.215 1.272m-.28 6.47c.029 1.508.122 3.017.28 4.471c-1.48.292-2.896.72-4.215 1.271c-.589-1.748-.954-3.687-1.045-5.742zM6.17 23.139a17 17 0 0 0-2.456 1.44A14.9 14.9 0 0 1 1.051 17h3.984c.094 2.196.491 4.27 1.135 6.139M4.313 25.38a16 16 0 0 1 2.207-1.305c1.004 2.485 2.449 4.548 4.186 5.943a15.05 15.05 0 0 1-6.393-4.638m16.981 4.637c1.738-1.394 3.182-3.458 4.186-5.943c.79.384 1.522.826 2.207 1.305a15.03 15.03 0 0 1-6.393 4.638M27 16c0-2.567-.428-4.987-1.17-7.139c.88-.422 1.698-.907 2.457-1.44A14.9 14.9 0 0 1 31 16zm.688-9.38c-.685.479-1.417.921-2.207 1.305c-1.004-2.485-2.449-4.549-4.186-5.943a15.06 15.06 0 0 1 6.393 4.638M10.706 1.983C8.968 3.377 7.524 5.441 6.52 7.926A16 16 0 0 1 4.313 6.62a15.04 15.04 0 0 1 6.393-4.637M3.714 7.421a17 17 0 0 0 2.456 1.44A22 22 0 0 0 5 16H1c0-3.19 1.009-6.145 2.714-8.579"/></svg></div>
                                            <div class="dinb vm" style="font-weight: 500; font-size:16px">EN</div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @endif
                         @if($business->use_rate==1)
                            <div>
                                @if($rate == 1)
                                    <a href="{{ route('menu.show', ['slug' => $business->slug, 'rate' => 0]) }}" class="currency_symbol" aria-label="Switch to local currency">
                                        <div class="b_address">
                                            <div class="dinb vm"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="none" stroke="{{ $business->theme_color }}" d="M12 9h-1a1 1 0 0 0-1 1v.375a1 1 0 0 0 .72.96l2.56.747a1 1 0 0 1 .72.96V14a1 1 0 0 1-1 1h-1m0-6h1a1 1 0 0 1 1 1v.5M12 9V7.5m0 7.5h-1a1 1 0 0 1-1-1v-.5m2 1.5v1.5M1 3h12a8 8 0 0 1 8 8M1 3c.41 0 .99-.247 1.41-.503a5.6 5.6 0 0 0 1.458-1.305C4.186.792 4.5.318 4.5 0M1 3c.41 0 .99.247 1.41.503a5.6 5.6 0 0 1 1.458 1.305c.318.4.632.874.632 1.192M23 21H11a8 8 0 0 1-8-8m20 8c-.41 0-.99.247-1.41.503a5.6 5.6 0 0 0-1.458 1.305c-.318.4-.632.874-.632 1.192m3.5-3c-.41 0-.99-.247-1.41-.503a5.6 5.6 0 0 1-1.458-1.305c-.318-.4-.632-.874-.632-1.192M18 12a6 6 0 1 0-12 0a6 6 0 0 0 12 0Z" stroke-width="1"/></svg></div>
                                            <div class="dinb vm" style="font-weight: 500; font-size:16px">{{ $business->currency }}</div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('menu.show', ['slug' => $business->slug, 'rate' => 1]) }}" class="currency_symbol" aria-label="Switch to US dollars">
                                        <div class="b_address">
                                            <div class="dinb vm"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="none" stroke="{{ $business->theme_color }}" d="M12 9h-1a1 1 0 0 0-1 1v.375a1 1 0 0 0 .72.96l2.56.747a1 1 0 0 1 .72.96V14a1 1 0 0 1-1 1h-1m0-6h1a1 1 0 0 1 1 1v.5M12 9V7.5m0 7.5h-1a1 1 0 0 1-1-1v-.5m2 1.5v1.5M1 3h12a8 8 0 0 1 8 8M1 3c.41 0 .99-.247 1.41-.503a5.6 5.6 0 0 0 1.458-1.305C4.186.792 4.5.318 4.5 0M1 3c.41 0 .99.247 1.41.503a5.6 5.6 0 0 1 1.458 1.305c.318.4.632.874.632 1.192M23 21H11a8 8 0 0 1-8-8m20 8c-.41 0-.99.247-1.41.503a5.6 5.6 0 0 0-1.458 1.305c-.318.4-.632.874-.632 1.192m3.5-3c-.41 0-.99-.247-1.41-.503a5.6 5.6 0 0 1-1.458-1.305c-.318-.4-.632-.874-.632-1.192M18 12a6 6 0 1 0-12 0a6 6 0 0 0 12 0Z" stroke-width="1"/></svg></div>
                                            <div class="dinb vm" style="font-weight: 500; font-size:16px">$</div>
                                        </div>
                                    </a>
                                @endif
                            </div>

                        @endif
                    </div>
                    
                    
                </div>
                
            </header>
            <main>
                <div class="category_flex">
                    @foreach ($categories as $category)
                        <div class="category_item @if($loop->first) active @endif" id="cat-{{ $category->id }}" onclick="showCategory({{ $category->id }})">{{ $category->name }}</div>
                    @endforeach
                </div>
                <div class="product_list" >
                    @foreach ($categories as $category)
                        <div class="product_list_item @if($loop->first) active @endif"" id="products-cat-{{ $category->id }}" >
                            {{-- <h2 class="category_heading" style="font-size: 18px; margin: 0;">{{ $category->name }}</h2> --}}
                            @foreach ($category->products as $product)
                                <div class="product_container">
                                    <div class="product_item">
                                        <div class="product_image_wrapper" style="width:100px; height:100px; overflow:hidden; border-radius:10px;">
                                            @if($product->image_1)
                                                <img class="product_image" loading="lazy" src="{{ Storage::disk('public')->url('thumbnail/' . $product->image_1) }}" data-src="{{ Storage::disk('public')->url($product->image_1) }}" alt="{{ $product->name }}" onclick="openImageCarousel({{ $product->id }})" style="cursor: pointer;">
                                            @else
                                                <img class="product_image" loading="lazy" src="{{ Storage::disk('public')->url($business->profile_photo) }}" alt="{{ $product->name }}">
                                            @endif
                                            @if($product->is_new == 1)
                                                <span class="new_badge">@if(app()->getLocale() == 'ar')جديد@else New @endif</span>
                                            @endif
                                        </div>
                                        <div class="product_details">
                                            <h3 class="product_name">{{ $product->name }}</h3>
                                            <div class="product_recipe">
                                                {!! $product->recipe !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product_sub_details">
                                        <div class="product_price">
                                            @if($rate == 1)
                                                {{ number_format((float)($product->price) / (float)($business->rate), 2, '.', ',') }} $
                                            @else
                                                @if($business->currency != "$")
                                                    @php
                                                        $formattedNumber = number_format((float)$product->price, 0, '.', ',');
                                                    @endphp
                                                    {{ $formattedNumber }} {{ $business->currency }}
                                                @else
                                                    {{ $product->price }} {{ $business->currency }}
                                                @endif
                                            @endif
                                            <span class="per_kg_label">{{ $product->perUnitLabel() }}</span>
                                        </div>
                                        @if($product->garnishes->isNotEmpty())
                                            <div class="garnish_btn" id="garnish-btn-{{ $product->id }}" onclick="toggleGarnish({{ $product->id }})">
                                                @if (app()->getLocale() == 'ar')
                                                    <svg class="arrow_icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M6.5 9.5l5 5l5-5"/></g></svg>
                                                    <span class=""> إضافات & أحجام</span>
                                                @else
                                                    <span class="">Garnish & Size</span>
                                                    <svg class="" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M6.5 9.5l5 5l5-5"/></g></svg>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    @if($product->isSoldByWeight())
                                        {{-- Weight products start at 1 kg; the customer can type any weight (the cart has -/+ by 0.1 kg) --}}
                                        <div class="weight_picker" id="weight-picker-{{ $product->id }}">
                                            <span class="weight_label">{{ app()->getLocale() == 'ar' ? 'الوزن' : 'Weight' }}</span>
                                            <input type="text" inputmode="decimal" class="weight_input" id="weight-input-{{ $product->id }}" value="1" placeholder="1.25" aria-label="{{ app()->getLocale() == 'ar' ? 'الوزن بالكيلو' : 'Weight in kg' }}" oninput="typeWeight({{ $product->id }}, this)">
                                            <span class="weight_unit">{{ app()->getLocale() == 'ar' ? 'كغ' : 'kg' }}</span>
                                        </div>
                                    @endif
                                    @if($product->garnishes->isNotEmpty())
                                        <div class="garnish_list" id="garnish-{{ $product->id }}">
                                            @foreach ($product->garnishes as $garnish)
                                                <div class="garnish_item">
                                                    <span class="garnish_name">{{ $garnish->name }}</span>
                                                    <span class="garnish_price">
                                                        @if($rate == 1)
                                                            {{ number_format((float)($garnish->price) / (float)($business->rate), 2, '.', ',') }} $
                                                        @else
                                                            @if($business->currency != "$")
                                                                @php
                                                                    $formattedNumber = number_format((float)$garnish->price, 0, '.', ',');
                                                                @endphp
                                                                {{ $formattedNumber }} {{ $business->currency }}
                                                            @else
                                                                {{ $garnish->price }} {{ $business->currency }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <svg class="add_to_cart_btn" id="add-to-cart-{{ $product->id }}" onclick="addToCart({{ $product->id }}, @js($product->name), @js((string) $product->price), @js($product->saleType()))" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32"><path fill="#fff" d="M28.778 5H29c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1c0 .415.256.772.617.923L26.34 6H5.2C3.44 6 2 7.432 2 9.253l.52 8.495c.15 2.517 2.52 3.84 4.65 4.009l14.832 1.169c-.028.476.303.928.802 1.045c.572.131 1.144-.193 1.282-.74l1.064-4.134c1.068.334 1.863 1.489 1.863 2.788V22c0 1.608-1.204 3-2.635 3H3c-.547 0-1 .382-1 .956S2.447 27 2.994 27H5.5a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3h18a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3h.919C26.943 27 29 24.756 29 22v-.115c0-2.268-1.424-4.18-3.351-4.728zm-7.162 11H20v-4h2.605zm1.236-5H20V8.007l1.95.002c.84 0 1.45.776 1.25 1.582zM19 8.006V11h-4.38V8zm-5.38-.007V11h-4.6V7.994zm-5.6-.006V11H4.111L4 9.193c0-.666.54-1.204 1.21-1.204zM4.173 12H8.02v4h-3.6zm.308 5H8.02v2.83l-.68-.053c-1.34-.11-2.74-.875-2.82-2.149zm4.539 2.91V17h4.6v3.272zm5.6.44V17H19v3.62q0 .039.006.076zm5.38.25V17h1.369l-.679 2.747a1.28 1.28 0 0 1-.69.853M14.62 12H19v4h-4.38zm-5.6 0h4.6v4h-4.6z" stroke-width="1" stroke="#fff"/></svg>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </main>    
            <!-- Dynamic Image Carousel Container -->
            <div id="imageCarouselContainer"></div>
            <div class="b_sm_fixed">
                <div class="b_sm_container">
                    <div class="footer_div" style="background-color: {{ $business->theme_color }};">
                        <div class="b_social_media">
                            <button class="cart_count_btn centerd_item" style="min-width: 60px; text-align: center; padding:10px 0px;"  onclick="showCart()" aria-label="Open shopping cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35px" height="35px" viewBox="0 0 15 15"><path fill="#fff" d="M.979.356L.02.644L3.128 11H15V4.5A2.5 2.5 0 0 0 12.5 2H1.472z"/><path fill="#fff" fill-rule="evenodd" d="M5.5 12a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3M5 13.5a.5.5 0 1 1 1 0a.5.5 0 0 1-1 0m7.5-1.5a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m-.5 1.5a.5.5 0 1 1 1 0a.5.5 0 0 1-1 0" clip-rule="evenodd"/></svg>
                                <span id="cart_count_number" aria-live="polite">0</span>
                            </button>
                            @if($business->facebook_url)
                            <a href="{{ $business->facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Visit us on Facebook">
                                <div style="min-width: 60px; text-align: center; padding:10px 0px;" class="centerd_item">
                                    <svg class="b_sm_icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 256 256"><path fill="#1877f2" d="M256 128C256 57.308 198.692 0 128 0S0 57.308 0 128c0 63.888 46.808 116.843 108 126.445V165H75.5v-37H108V99.8c0-32.08 19.11-49.8 48.348-49.8C170.352 50 185 52.5 185 52.5V84h-16.14C152.959 84 148 93.867 148 103.99V128h35.5l-5.675 37H148v89.445c61.192-9.602 108-62.556 108-126.445" stroke-width="6.5" stroke="#1877f2"/><path fill="#fff" d="m177.825 165l5.675-37H148v-24.01C148 93.866 152.959 84 168.86 84H185V52.5S170.352 50 156.347 50C127.11 50 108 67.72 108 99.8V128H75.5v37H108v89.445A129 129 0 0 0 128 256a129 129 0 0 0 20-1.555V165z" stroke-width="6.5" stroke="#fff"/></svg>
                                </div>
                            </a>
                            @endif
                            @if($business->instagram_url)
                                <a href="{{ $business->instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Visit us on Instagram">
                                    <div style="min-width: 60px; text-align: center; padding:10px 0px;" class="centerd_item">
                                        <svg class="b_sm_icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 256 256"><g fill="none"><rect width="256" height="256" fill="url(#SVGWRUqebek)" rx="60"/><rect width="256" height="256" fill="url(#SVGfkNpldMH)" rx="60"/><path fill="#fff" d="M128.009 28c-27.158 0-30.567.119-41.233.604c-10.646.488-17.913 2.173-24.271 4.646c-6.578 2.554-12.157 5.971-17.715 11.531c-5.563 5.559-8.98 11.138-11.542 17.713c-2.48 6.36-4.167 13.63-4.646 24.271c-.477 10.667-.602 14.077-.602 41.236s.12 30.557.604 41.223c.49 10.646 2.175 17.913 4.646 24.271c2.556 6.578 5.973 12.157 11.533 17.715c5.557 5.563 11.136 8.988 17.709 11.542c6.363 2.473 13.631 4.158 24.275 4.646c10.667.485 14.073.604 41.23.604c27.161 0 30.559-.119 41.225-.604c10.646-.488 17.921-2.173 24.284-4.646c6.575-2.554 12.146-5.979 17.702-11.542c5.563-5.558 8.979-11.137 11.542-17.712c2.458-6.361 4.146-13.63 4.646-24.272c.479-10.666.604-14.066.604-41.225s-.125-30.567-.604-41.234c-.5-10.646-2.188-17.912-4.646-24.27c-2.563-6.578-5.979-12.157-11.542-17.716c-5.562-5.562-11.125-8.979-17.708-11.53c-6.375-2.474-13.646-4.16-24.292-4.647c-10.667-.485-14.063-.604-41.23-.604zm-8.971 18.021c2.663-.004 5.634 0 8.971 0c26.701 0 29.865.096 40.409.575c9.75.446 15.042 2.075 18.567 3.444c4.667 1.812 7.994 3.979 11.492 7.48c3.5 3.5 5.666 6.833 7.483 11.5c1.369 3.52 3 8.812 3.444 18.562c.479 10.542.583 13.708.583 40.396s-.104 29.855-.583 40.396c-.446 9.75-2.075 15.042-3.444 18.563c-1.812 4.667-3.983 7.99-7.483 11.488c-3.5 3.5-6.823 5.666-11.492 7.479c-3.521 1.375-8.817 3-18.567 3.446c-10.542.479-13.708.583-40.409.583c-26.702 0-29.867-.104-40.408-.583c-9.75-.45-15.042-2.079-18.57-3.448c-4.666-1.813-8-3.979-11.5-7.479s-5.666-6.825-7.483-11.494c-1.369-3.521-3-8.813-3.444-18.563c-.479-10.542-.575-13.708-.575-40.413s.096-29.854.575-40.396c.446-9.75 2.075-15.042 3.444-18.567c1.813-4.667 3.983-8 7.484-11.5s6.833-5.667 11.5-7.483c3.525-1.375 8.819-3 18.569-3.448c9.225-.417 12.8-.542 31.437-.563zm62.351 16.604c-6.625 0-12 5.37-12 11.996c0 6.625 5.375 12 12 12s12-5.375 12-12s-5.375-12-12-12zm-53.38 14.021c-28.36 0-51.354 22.994-51.354 51.355s22.994 51.344 51.354 51.344c28.361 0 51.347-22.983 51.347-51.344c0-28.36-22.988-51.355-51.349-51.355zm0 18.021c18.409 0 33.334 14.923 33.334 33.334c0 18.409-14.925 33.334-33.334 33.334s-33.333-14.925-33.333-33.334c0-18.411 14.923-33.334 33.333-33.334" stroke-width="6.5" stroke="#fff"/><defs><radialGradient id="SVGWRUqebek" cx="0" cy="0" r="1" gradientTransform="matrix(0 -253.715 235.975 0 68 275.717)" gradientUnits="userSpaceOnUse"><stop stop-color="#fd5"/><stop offset=".1" stop-color="#fd5"/><stop offset=".5" stop-color="#ff543e"/><stop offset="1" stop-color="#c837ab"/></radialGradient><radialGradient id="SVGfkNpldMH" cx="0" cy="0" r="1" gradientTransform="matrix(22.25952 111.2061 -458.39518 91.75449 -42.881 18.441)" gradientUnits="userSpaceOnUse"><stop stop-color="#3771c8"/><stop offset=".128" stop-color="#3771c8"/><stop offset="1" stop-color="#60f" stop-opacity="0"/></radialGradient></defs></g></svg>
                                    </div>
                                </a>
                            @endif
                            @if($business->tikto_url)
                                <a href="{{ $business->tikto_url }}" target="_blank" rel="noopener noreferrer" aria-label="Visit us on TikTok">
                                    <div style="min-width: 60px; text-align: center; padding:10px 0px;" class="centerd_item">
                                        <svg class="b_sm_icon" xmlns="http://www.w3.org/2000/svg" width="26.49" height="30" viewBox="0 0 256 290"><path fill="#ff004f" d="M189.72 104.421c18.678 13.345 41.56 21.197 66.273 21.197v-47.53a67 67 0 0 1-13.918-1.456v37.413c-24.711 0-47.59-7.851-66.272-21.195v96.996c0 48.523-39.356 87.855-87.9 87.855c-18.113 0-34.949-5.473-48.934-14.86c15.962 16.313 38.222 26.432 62.848 26.432c48.548 0 87.905-39.332 87.905-87.857v-96.995zm17.17-47.952c-9.546-10.423-15.814-23.893-17.17-38.785v-6.113h-13.189c3.32 18.927 14.644 35.097 30.358 44.898M69.673 225.607a40 40 0 0 1-8.203-24.33c0-22.192 18.001-40.186 40.21-40.186a40.3 40.3 0 0 1 12.197 1.883v-48.593c-4.61-.631-9.262-.9-13.912-.801v37.822a40.3 40.3 0 0 0-12.203-1.882c-22.208 0-40.208 17.992-40.208 40.187c0 15.694 8.997 29.281 22.119 35.9" stroke-width="7.5" stroke="#ff004f"/><path d="M175.803 92.849c18.683 13.344 41.56 21.195 66.272 21.195V76.631c-13.794-2.937-26.005-10.141-35.186-20.162c-15.715-9.802-27.038-25.972-30.358-44.898h-34.643v189.843c-.079 22.132-18.049 40.052-40.21 40.052c-13.058 0-24.66-6.221-32.007-15.86c-13.12-6.618-22.118-20.206-22.118-35.898c0-22.193 18-40.187 40.208-40.187c4.255 0 8.356.662 12.203 1.882v-37.822c-47.692.985-86.047 39.933-86.047 87.834c0 23.912 9.551 45.589 25.053 61.428c13.985 9.385 30.82 14.86 48.934 14.86c48.545 0 87.9-39.335 87.9-87.857z"/><path fill="#00f2ea" d="M242.075 76.63V66.516a66.3 66.3 0 0 1-35.186-10.047a66.47 66.47 0 0 0 35.186 20.163M176.53 11.57a68 68 0 0 1-.728-5.457V0h-47.834v189.845c-.076 22.13-18.046 40.05-40.208 40.05a40.06 40.06 0 0 1-18.09-4.287c7.347 9.637 18.949 15.857 32.007 15.857c22.16 0 40.132-17.918 40.21-40.05V11.571zM99.966 113.58v-10.769a89 89 0 0 0-12.061-.818C39.355 101.993 0 141.327 0 189.845c0 30.419 15.467 57.227 38.971 72.996c-15.502-15.838-25.053-37.516-25.053-61.427c0-47.9 38.354-86.848 86.048-87.833" stroke-width="7.5" stroke="#00f2ea"/></svg>
                                    </div>
                                </a>
                            @endif
                            @if ($business->whatsapp)
                                <a href="https://wa.me/{{ $business->whatsapp }}" target="_blank" rel="noopener noreferrer" aria-label="Contact us on WhatsApp">
                                    <div style="min-width: 60px; text-align: center; padding:10px 0px;" class="centerd_item">
                                        <svg class="b_sm_icon" xmlns="http://www.w3.org/2000/svg" width="29.77" height="30" viewBox="0 0 256 258"><defs><linearGradient id="SVGBRLHCcSy" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#1faf38"/><stop offset="100%" stop-color="#60d669"/></linearGradient><linearGradient id="SVGHW6lecxh" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#f9f9f9"/><stop offset="100%" stop-color="#fff"/></linearGradient></defs><path fill="url(#SVGBRLHCcSy)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a123 123 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004"/><path fill="url(#SVGHW6lecxh)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416m40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513z"/><path fill="#fff" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561s11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716s-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64" stroke-width="6.5" stroke="#fff"/></svg>
                                    </div>
                                </a>
                            @endif
                        </div>
                        
                        
                        {{-- <svg class="" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#fff" d="M20.756 5.345A1 1 0 0 0 20 5H6.181l-.195-1.164A1 1 0 0 0 5 3H2.75a1 1 0 1 0 0 2h1.403l1.86 11.164l.045.124l.054.151l.12.179l.095.112l.193.13l.112.065a1 1 0 0 0 .367.075H18a1 1 0 1 0 0-2H7.847l-.166-1H19a1 1 0 0 0 .99-.858l1-7a1 1 0 0 0-.234-.797M18.847 7l-.285 2H15V7zM14 7v2h-3V7zm0 3v2h-3v-2zm-4-3v2H7l-.148.03L6.514 7zm-2.986 3H10v2H7.347zM15 12v-2h3.418l-.285 2z" stroke-width="0.5" stroke="#fff"/><circle cx="8.5" cy="19.5" r="1.5" fill="#fff" stroke-width="0.5" stroke="#fff"/><circle cx="17.5" cy="19.5" r="1.5" fill="#fff" stroke-width="0.5" stroke="#fff"/></svg>
                        <svg class="" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#fff" d="M20.756 5.345A1 1 0 0 0 20 5H6.181l-.195-1.164A1 1 0 0 0 5 3H2.75a1 1 0 1 0 0 2h1.403l1.86 11.164l.045.124l.054.151l.12.179l.095.112l.193.13l.112.065a1 1 0 0 0 .367.075H18a1 1 0 1 0 0-2H7.847l-.166-1H19a1 1 0 0 0 .99-.858l1-7a1 1 0 0 0-.234-.797M18.847 7l-.285 2H15V7zM14 7v2h-3V7zm0 3v2h-3v-2zm-4-3v2H7l-.148.03L6.514 7zm-2.986 3H10v2H7.347zM15 12v-2h3.418l-.285 2z" stroke-width="0.5" stroke="#fff"/><circle cx="8.5" cy="19.5" r="1.5" fill="#fff" stroke-width="0.5" stroke="#fff"/><circle cx="17.5" cy="19.5" r="1.5" fill="#fff" stroke-width="0.5" stroke="#fff"/></svg> --}}

                    </div>
                    
                </div>    
            </div>
            <footer>
                <div class="copy_right c" style="text-align: center; padding: 30px 0px;  font-size: 16px; padding-bottom: 100px; z-index: 1; position: relative;">
                    <span style="color: #444">&copy; {{ date('Y') }} <a href="https://www.algorexe.com" style="font-weight: bold; font-style: italic; color: var(--theme-color);">Algorexe</a></span>
                </div>
            </footer>
        </div>
        
        <!-- Cart Overlay -->
        <div class="cart_overlay" id="cart_overlay" onclick="closeCart(event)"></div>
        
        <!-- Cart Container -->
        <div class="cart_container" id="cart_container">
            <div class="cart_centerd">
                <div class="cart_header">
                    <h2>{{ app()->getLocale() == 'ar' ? 'سلتي' : 'My Cart' }}</h2>
                    <button class="cart_close_btn" onclick="closeCart()">&times;</button>
                </div>
                
                <div class="cart_items" id="cart_items"></div>
                
                <div class="cart_total" id="cart_total"></div>
                
                <button class="submit_btn" onclick="submitCart()">{{ app()->getLocale() == 'ar' ? 'تأكيد الطلب' : 'Confirm Order' }}</button>
            </div>
        </div>
        
        <!-- User Modal -->
        <div class="user_modal_overlay" id="user_modal_overlay" onclick="closeUserModal(event)"></div>
        
        <div class="user_modal" id="user_modal">
            <div class="user_modal_content">
                <div class="user_modal_header">
                    <h2>{{ app()->getLocale() == 'ar' ? 'بيانات العميل' : 'Customer Information' }}</h2>
                    <button class="user_modal_close_btn" onclick="closeUserModal()">&times;</button>
                </div>
                
                <form id="user_form" onsubmit="saveUserData(event)">
                    <div class="form_group">
                        <label class="l">{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Name' }}</label>
                        <input class="l" type="text" id="user_name" name="name" maxlength="100" pattern="^[a-zA-Z0-9\u0600-\u06FF ]+$" required placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل اسمك' : 'Enter your name' }}" oninvalid="setNameError()" onchange="this.setCustomValidity('')">
                    </div>
                    
                    <div class="form_group">
                        <label class="l">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone' }}</label>
                        <input class="l" type="tel" id="user_phone" name="phone" pattern="^[\d\u0660-\u0669]+$" required placeholder="{{ app()->getLocale() == 'ar' ? ' (961........)أدخل رقم الهاتف' : 'Enter your phone number (961xxxxxxxx)' }}" oninvalid="setPhoneError()" onchange="this.setCustomValidity('')">
                    </div>
                    
                    <div class="form_group">
                        <label class="l">{{ app()->getLocale() == 'ar' ? 'العنوان' : 'Address' }}</label>
                        <textarea class="l" id="user_address" name="address" required placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل عنوانك بالتفصيل' : 'Enter your detailed address' }}" oninvalid="setAddressError()" onchange="this.setCustomValidity('')"></textarea>
                    </div>
                    
                    <button type="submit" class="form_submit_btn">{{ app()->getLocale() == 'ar' ? 'حفظ ومتابعة' : 'Save & Continue' }}</button>
                </form>
            </div>
        </div>
        
        <!-- Offers Carousel Component -->
        @if($offers->isNotEmpty())
            <x-offers-carousel :offers="$offers" :themeColor="$business->theme_color" />
        @endif
<script>
    var local_cart = { b_slug: '', cart_list: [] };
    var cart_count = 0;
    const business_slug = '{{ $business->slug }}';
    const business_name = @js($business->name);
    const business_currency = '{{ $business->currency }}';
    const business_whatsapp = '{{ $business->whatsapp }}';
    const lang = '{{ app()->getLocale() }}';
    const storageBasePath = '{{ Storage::disk('public')->url('') }}';
    const business_rate = {{ $business->rate ?? 1 }};
    const rate = {{ $rate }};
    
    // Store product images data
    const productImagesData = {
        @foreach ($categories as $category)
            @foreach ($category->products as $product)
                @php
                    $images = [];
                    if($product->image_1) $images[] = $product->image_1;
                    if($product->image_2) $images[] = $product->image_2;
                    if($product->image_3) $images[] = $product->image_3;
                @endphp
                {{ $product->id }}: {!! json_encode($images) !!},
            @endforeach
        @endforeach
    };
    
    // Image Carousel Functions - Dynamic Loading
    const createCarouselHTML = (productId) => {
        const images = productImagesData[productId] || [];
        if (images.length === 0) return '';
        
        let slidesHTML = '';
        images.forEach((image, index) => {
            slidesHTML += `
                <div class="image-carousel-slide">
                    <img src="${storageBasePath}/${image}" alt="Product Image" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
            `;
        });
        
        return `
            <style>
                .image-carousel-overlay {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.9);
                    z-index: 9998;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                    justify-content: center;
                    align-items: center;
                }
                
                .image-carousel-overlay.show {
                    display: flex;
                    opacity: 1;
                }
                
                .image-carousel-container {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 90%;
                    max-width: 480px;
                    background: white;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
                    z-index: 9999;
                }
                
                .image-carousel-slides {
                    display: flex;
                    transition: transform 0.4s ease;
                    width: 100%;
                }
                
                .image-carousel-slide {
                    min-width: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 1rem;
                    background: white;
                    aspect-ratio: 1 / 1;
                }
                
                .image-carousel-slide img {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                    display: block;
                }
                
                .image-carousel-close {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: var(--theme-color);
                    color: white;
                    border: none;
                    width: 35px;
                    height: 35px;
                    border-radius: 50%;
                    font-size: 24px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 1000;
                    transition: background 0.2s ease;
                }
                
                .image-carousel-close:hover {
                    background: rgba(0, 0, 0, 0.9);
                }
                
                .image-carousel-nav {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    background: var(--theme-color);
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
                    z-index: 1000;
                }
                
                .image-carousel-nav:hover {
                    background: rgba(0, 0, 0, 0.9);
                }
                
                .image-carousel-prev {
                    left: 10px;
                }
                
                .image-carousel-next {
                    right: 10px;
                }
            </style>
            <div class="image-carousel-overlay" id="imageCarouselOverlay-${productId}" onclick="closeImageCarousel(event, ${productId})"></div>
            <div class="image-carousel-container" id="imageCarouselContainer-${productId}">
                <button class="image-carousel-close" onclick="closeImageCarousel(null, ${productId})">&times;</button>
                <div class="image-carousel-slides" id="imageCarouselSlides-${productId}">
                    ${slidesHTML}
                </div>
                <button class="image-carousel-nav image-carousel-prev" onclick="prevImageCarousel(${productId})">&lt;</button>
                <button class="image-carousel-nav image-carousel-next" onclick="nextImageCarousel(${productId})">&gt;</button>
            </div>
        `;
    };
    
    const openImageCarousel = (productId) => {
        const images = productImagesData[productId] || [];
        if (images.length === 0) return;
        
        // Create carousel if it doesn't exist
        let carouselOverlay = document.getElementById('imageCarouselOverlay-' + productId);
        if (!carouselOverlay) {
            const carouselHTML = createCarouselHTML(productId);
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = carouselHTML;
            document.body.appendChild(tempDiv);
            
            // Initialize state for this carousel
            window.imageCarouselStates = window.imageCarouselStates || {};
            window.imageCarouselStates['carousel_' + productId] = {
                currentIndex: 0,
                interval: null,
                totalImages: images.length
            };
            
            carouselOverlay = document.getElementById('imageCarouselOverlay-' + productId);
        }
        
        carouselOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
        startImageCarouselAutoPlay(productId);
    };
    
    const closeImageCarousel = (event, productId) => {
        if (event && event.target.id !== 'imageCarouselOverlay-' + productId) return;
        
        const carouselOverlay = document.getElementById('imageCarouselOverlay-' + productId);
        if (!carouselOverlay) return;
        
        stopImageCarouselAutoPlay(productId);
        carouselOverlay.classList.remove('show');
        document.body.style.overflow = 'auto';
        
        // Remove carousel from DOM after animation completes
        setTimeout(() => {
            const container = document.getElementById('imageCarouselContainer-' + productId);
            const overlay = document.getElementById('imageCarouselOverlay-' + productId);
            if (overlay && overlay.parentElement) overlay.parentElement.remove();
            if (container && container.parentElement) container.parentElement.remove();
            
            // Clean up state
            if (window.imageCarouselStates) {
                delete window.imageCarouselStates['carousel_' + productId];
            }
        }, 300);
    };
    
    const updateImageCarousel = (index, productId) => {
        const slidesContainer = document.getElementById('imageCarouselSlides-' + productId);
        if (!slidesContainer) return;
        const offset = -index * 100;
        slidesContainer.style.transform = `translateX(${offset}%)`;
    };
    
    const nextImageCarousel = (productId) => {
        const state = window.imageCarouselStates && window.imageCarouselStates['carousel_' + productId];
        if (!state) return;
        state.currentIndex = (state.currentIndex + 1) % state.totalImages;
        updateImageCarousel(state.currentIndex, productId);
        resetImageCarouselAutoPlay(productId);
    };
    
    const prevImageCarousel = (productId) => {
        const state = window.imageCarouselStates && window.imageCarouselStates['carousel_' + productId];
        if (!state) return;
        state.currentIndex = (state.currentIndex - 1 + state.totalImages) % state.totalImages;
        updateImageCarousel(state.currentIndex, productId);
        resetImageCarouselAutoPlay(productId);
    };
    
    const startImageCarouselAutoPlay = (productId) => {
        const state = window.imageCarouselStates && window.imageCarouselStates['carousel_' + productId];
        if (!state) return;
        state.interval = setInterval(() => {
            nextImageCarousel(productId);
        }, 2000);
    };
    
    const stopImageCarouselAutoPlay = (productId) => {
        const state = window.imageCarouselStates && window.imageCarouselStates['carousel_' + productId];
        if (!state || !state.interval) return;
        clearInterval(state.interval);
        state.interval = null;
    };
    
    const resetImageCarouselAutoPlay = (productId) => {
        stopImageCarouselAutoPlay(productId);
        startImageCarouselAutoPlay(productId);
    };
    
    // Cookie management functions
    const setCookie = (name, value, minutes = 30) => {
        const date = new Date();
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + encodeURIComponent(JSON.stringify(value)) + ";" + expires + ";path=/";
    };
    
    const getCookie = (name) => {
        const nameEQ = name + "=";
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i].trim();
            if (cookie.indexOf(nameEQ) === 0) {
                try {
                    return JSON.parse(decodeURIComponent(cookie.substring(nameEQ.length)));
                } catch (e) {
                    return null;
                }
            }
        }
        return null;
    };
    
    const removeCookie = (name) => {
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
    };
    
    const escapeHtml = (str) => String(str).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

    // ---- Weight (kg) support ----
    const kgLabel = lang == 'ar' ? 'كغ' : 'kg';
    // Unit names for lines sold by count
    const unitLabels = @js(collect(\App\Models\Product::UNIT_LABELS)->map(fn ($l) => $l[app()->getLocale() == 'ar' ? 'ar' : 'en']));
    const unitLabelAr = @js(collect(\App\Models\Product::UNIT_LABELS)->map(fn ($l) => $l['ar']));
    const WEIGHT_STEP = 0.1;
    const DEFAULT_WEIGHT = 1;
    const MAX_WEIGHT = 100;
    const roundWeight = (n) => Math.round(n * 100) / 100;
    // Accepts "1.25", "1,25", ".5" ... returns a weight rounded to 2 decimals, or null
    const parseWeight = (value) => {
        const str = String(value ?? '').trim().replace(/[٫,]/g, '.')
            .replace(/[٠-٩]/g, d => '٠١٢٣٤٥٦٧٨٩'.indexOf(d));
        if (!/^\d*\.?\d+$|^\d+\.$/.test(str)) return null;
        const n = roundWeight(parseFloat(str));
        return (n > 0 && n <= MAX_WEIGHT) ? n : null;
    };
    const formatWeight = (w) => roundWeight(parseFloat(w)).toString() + ' ' + kgLabel;
    const getSelectedWeight = (productId) => {
        const input = document.getElementById('weight-input-' + productId);
        return input ? parseWeight(input.value) : DEFAULT_WEIGHT;
    };
    const typeWeight = (productId, input) => {
        const w = parseWeight(input.value);
        input.classList.toggle('invalid', input.value.trim() !== '' && w === null);
    };
    // Number of "pieces" shown on the cart badge: a weight line counts as 1
    const countCart = () => local_cart.cart_list.reduce((total, item) => total + (item.item_unit === 'kg' ? 1 : item.item_count), 0);
    const refreshCartCount = () => {
        cart_count = countCart();
        setCookie('local_cart', local_cart);
        document.getElementById('cart_count_number').textContent = cart_count;
    };
    // Unit price of one cart line (price per kg x weight for weight items)
    const lineUnitPrice = (item) => {
        const base = parseFloat(item.item_price);
        return item.item_unit === 'kg' ? base * parseFloat(item.item_weight) : base;
    };
    const findItem = (key) => local_cart.cart_list.find(i => i.item_key === key);
    const updateCartButtonState = (productId) => {
        const btn = document.getElementById('add-to-cart-' + productId);
        if (!btn) return;
        if (local_cart.cart_list.some(i => i.item_id === productId)) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    };

    // Initialize cart on page load
    const initCart = () => {
        const savedCart = getCookie('local_cart');
        
        if (savedCart && savedCart.b_slug === business_slug && Array.isArray(savedCart.cart_list)) {
            // Cart exists and belongs to this business
            local_cart = savedCart;
            // Older carts had no line key: one line per product
            const merged = [];
            local_cart.cart_list.forEach(item => {
                if (!item.item_unit) item.item_unit = 'unit';
                if (item.item_unit === 'kg') {
                    // One line per weight product; its weight holds the whole amount
                    const total = roundWeight(parseFloat(item.item_weight || 1) * (item.item_count || 1));
                    item.item_key = item.item_id + '_kg';
                    const prev = merged.find(m => m.item_key === item.item_key);
                    if (prev) { prev.item_weight = roundWeight(prev.item_weight + total); return; }
                    item.item_weight = total;
                    item.item_count = 1;
                } else if (!item.item_key) {
                    item.item_key = String(item.item_id);
                }
                merged.push(item);
            });
            local_cart.cart_list = merged;
            cart_count = countCart();
            // add active to cart btns
            local_cart.cart_list.forEach(item => {
                const btn = document.getElementById('add-to-cart-' + item.item_id);
                if (btn) {
                    btn.classList.add('active');
                }
            });
        } else {
            // Cart doesn't exist or doesn't match - create new
            if (savedCart) {
                removeCookie('local_cart');
            }
            local_cart = {
                b_slug: business_slug,
                cart_list: []
            };
            cart_count = 0;
        }
        
        // Update UI
        document.getElementById('cart_count_number').textContent = cart_count;
    };
    
    // Add item to cart
    const addToCart = (productId, productName, productPrice, saleType = 'unit') => {
        const isWeight = saleType === 'weight';
        const weight = isWeight ? getSelectedWeight(productId) : null;
        if (isWeight && weight === null) {
            const input = document.getElementById('weight-input-' + productId);
            if (input) { input.classList.add('invalid'); input.focus(); }
            return;
        }
        const itemKey = isWeight ? productId + '_kg' : String(productId);
        const existingItem = findItem(itemKey);
        
        // Add animation to the button
        const btn = document.getElementById('add-to-cart-' + productId);
        btn.classList.add('added', 'active');
        setTimeout(() => {
            btn.classList.remove('added');
        }, 500);
        
        // Add animation to cart count button
        const cartCountBtn = document.querySelector('.cart_count_btn');
        cartCountBtn.classList.add('pulse');
        setTimeout(() => {
            cartCountBtn.classList.remove('pulse');
        }, 3000);
        
        if (existingItem && isWeight) {
            // Same product again: add the chosen weight to its line
            existingItem.item_weight = Math.min(MAX_WEIGHT, roundWeight(parseFloat(existingItem.item_weight) + weight));
        } else if (existingItem) {
            // Item exists, increment count
            existingItem.item_count++;
        } else {
            // Item doesn't exist, add it
            local_cart.cart_list.push({
                item_key: itemKey,
                item_id: productId,
                item_name: productName,
                item_price: productPrice,
                item_unit: isWeight ? 'kg' : (saleType === 'box' ? 'box' : 'unit'),
                item_weight: weight,
                item_count: 1,
                item_note: ""
            });

        }
        
        refreshCartCount();
    };
    
    // Show cart contents
    const showCart = () => {
        if (local_cart.cart_list.length === 0) {
            alert('{{ app()->getLocale() == "ar" ? "سلتك فارغة!" : "Your cart is empty!" }}');
            return;
        }
        document.body.style.overflow = 'hidden';
        document.getElementById('cart_overlay').classList.add('show');
        document.getElementById('cart_container').classList.add('show');
        renderCart();
    };
    
    // Close cart overlay
    const closeCart = (event) => {
        // If clicking on overlay background, close it
        if (event && event.target.id === 'cart_overlay') {
            document.getElementById('cart_overlay').classList.remove('show');
            document.getElementById('cart_container').classList.remove('show');
            document.body.style.overflow = 'auto';
        } else if (!event) {
            // If calling without event, just close it
            document.getElementById('cart_overlay').classList.remove('show');
            document.getElementById('cart_container').classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    };
    
    // Render cart items
    const renderCart = () => {
        const cartItemsDiv = document.getElementById('cart_items');
        const cartTotalDiv = document.getElementById('cart_total');
        
        cartItemsDiv.innerHTML = '';
        
        if (local_cart.cart_list.length === 0) {
            cartItemsDiv.innerHTML = '<p style="text-align: center; color: #999;">{{ app()->getLocale() == "ar" ? "السلة فارغة" : "Cart is empty" }}</p>';
            cartTotalDiv.innerHTML = '';
            return;
        }
        
        let totalPrice = 0;
        
        const formatPrice = (price) => {
            if (rate == 1) {
                const converted = (parseFloat(price) / business_rate).toFixed(2);
                return new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(converted);
            } else {
                return new Intl.NumberFormat('en-US', { minimumFractionDigits: 0 }).format(parseFloat(price));
            }
        };
        
        const getCurrency = () => {
            return rate == 1 ? '$' : business_currency;
        };
        
        local_cart.cart_list.forEach(item => {
            const unitPrice = lineUnitPrice(item);
            const itemPrice = rate == 1 ? (unitPrice / business_rate).toFixed(2) : unitPrice;
            const itemTotal = itemPrice * item.item_count;
            totalPrice += itemTotal;
            
            const cartItem = document.createElement('div');
            cartItem.className = 'cart_item';
            cartItem.innerHTML = `
                <div class="cart_item_header">
                    <div class="cart_item_info l">
                        <p class="cart_item_name">${escapeHtml(item.item_name)}</p>
                        ${item.item_unit === 'kg'
                            ? `<p class="cart_item_price">{{ app()->getLocale() == 'ar' ? 'السعر' : 'Price' }}:  ${formatWeight(item.item_weight)} * ${formatPrice(item.item_price)} ${getCurrency()} / ${kgLabel}</p>`
                            : `<p class="cart_item_price">{{ app()->getLocale() == 'ar' ? 'السعر' : 'Price' }}:  ${item.item_count} ${unitLabels[item.item_unit] || ''} * ${formatPrice(unitPrice)} ${getCurrency()}</p>`}
                        <div class="cart_item_total">{{ app()->getLocale() == 'ar' ? 'المجموع' : 'Total' }}: ${new Intl.NumberFormat('en-US', { minimumFractionDigits: rate == 1 ? 2 : 0, maximumFractionDigits: rate == 1 ? 2 : 0 }).format(itemTotal)} ${getCurrency()}</div>
                    </div>
                </div>
                <div class="cart_item_note l">
                    <input type="text" class="l" placeholder="{{ app()->getLocale() == 'ar' ? 'أضف ملاحظة' : 'Add a note' }}" value="${item.item_note || ''}" onchange="updateNote('${item.item_key}', this.value)">
                </div>
                <div class="cart_item_controls">
                    <button class="qty_btn" onclick="decreaseQty('${item.item_key}')">-</button>
                    ${item.item_unit === 'kg'
                        ? `<span class="qty_display weight_qty"><input type="text" inputmode="decimal" class="cart_weight_input" value="${roundWeight(parseFloat(item.item_weight))}" aria-label="{{ app()->getLocale() == 'ar' ? 'الوزن بالكيلو' : 'Weight in kg' }}" onchange="updateWeight('${item.item_key}', this.value)" onkeydown="if(event.key==='Enter'){this.blur();}"> ${kgLabel}</span>`
                        : `<span class="qty_display weight_qty">${item.item_count} <small>${unitLabels[item.item_unit] || ''}</small></span>`}
                    <button class="qty_btn" onclick="increaseQty('${item.item_key}')">+</button>
                </div>
            `;
            cartItemsDiv.appendChild(cartItem);
        });
        
        // Render total
        cartTotalDiv.innerHTML = `
            
            <div class="total_row final">
                <span>${new Intl.NumberFormat('en-US', { minimumFractionDigits: rate == 1 ? 2 : 0, maximumFractionDigits: rate == 1 ? 2 : 0 }).format(totalPrice)} ${getCurrency()}</span>
                <span>{{ app()->getLocale() == "ar" ? "الإجمالي النهائي" : "Final Total" }}</span>
            </div>
        `;
    };
    
    // Update note for item
    const updateNote = (itemKey, noteText) => {
        const item = findItem(itemKey);
        if (item) {
            item.item_note = noteText;
            setCookie('local_cart', local_cart);
        }
    };
    
    // Set the weight of a cart line from the typed value (e.g. 1.25)
    const updateWeight = (itemKey, value) => {
        const item = findItem(itemKey);
        if (!item) return;
        const w = parseWeight(value);
        if (w !== null) {
            item.item_weight = w;
            refreshCartCount();
        }
        renderCart();
    };

    const increaseQty = (itemKey) => {
        const item = findItem(itemKey);
        if (item) {
            if (item.item_unit === 'kg') {
                item.item_weight = Math.min(MAX_WEIGHT, roundWeight(parseFloat(item.item_weight) + WEIGHT_STEP));
            } else {
                item.item_count++;
            }
            refreshCartCount();
            renderCart();
        }
    };
    
    // Decrease quantity
    const decreaseQty = (itemKey) => {
        const item = findItem(itemKey);
        if (item) {
            if (item.item_unit === 'kg' && roundWeight(parseFloat(item.item_weight) - WEIGHT_STEP) > 0) {
                item.item_weight = roundWeight(parseFloat(item.item_weight) - WEIGHT_STEP);
            } else if (item.item_unit !== 'kg' && item.item_count > 1) {
                item.item_count--;
            } else {
                // Remove line if quantity becomes 0
                local_cart.cart_list = local_cart.cart_list.filter(i => i.item_key !== itemKey);
                updateCartButtonState(item.item_id);
            }
            refreshCartCount();
            renderCart();
        }
    };
    
    // Submit cart
    const submitCart = () => {
        if (local_cart.cart_list.length === 0) {
            alert('{{ app()->getLocale() == "ar" ? "السلة فارغة!" : "Your cart is empty!" }}');
            return;
        }
        
        // Check if user exists in localStorage
        const storedUser = localStorage.getItem('qr_algorexe_user');
        
        if (storedUser) {
            // User exists, parse and use it
            try {
                var user = JSON.parse(storedUser);
                console.log('User found:', user);
                console.log('Cart submitted:', local_cart);
                // TODO: Send cart and user data to backend
                var whatsappMessage = 'مرحبا ' + business_name + '\n\n';
                var totalPrice = 0;
                const getCurrency = () => rate == 1 ? '$' : business_currency;
                const formatCartPrice = (price) => {
                    if (rate == 1) {
                        return (parseFloat(price) / business_rate).toFixed(2);
                    }
                    return price;
                };
                for(var i=0; i<local_cart.cart_list.length; i++){
                    var item = local_cart.cart_list[i];
                    const itemPrice = formatCartPrice(lineUnitPrice(item));
                    if (item.item_unit === 'kg') {
                        whatsappMessage += item.item_name + '  وزن ' + formatWeight(item.item_weight) + '\n';
                    } else {
                        whatsappMessage += item.item_name + '  عدد ' + item.item_count + ' ' + (unitLabelAr[item.item_unit] || '') + '\n';
                    }
                    if(item.item_note){
                        whatsappMessage += '*ملاحظة: ' + item.item_note + '* \n\n';
                    }
                    else{
                        whatsappMessage += '\n';
                    }
                    totalPrice += item.item_count * itemPrice;
                }
                const displayCurrency = getCurrency();
                whatsappMessage += '\n الإجمالي بدون كلفة التوصيل: ' + totalPrice.toFixed(rate == 1 ? 2 : 0) + ' ' + displayCurrency + '\n\n';
                whatsappMessage += 'الاسم: ' + user.name + '\n';
                whatsappMessage += 'العنوان: ' + user.address + '\n';
                var whatsappUrl = 'https://wa.me/' + business_whatsapp + '?text=' + encodeURIComponent(whatsappMessage);
                window.open(whatsappUrl, '_blank');
            } catch (e) {
                console.error('Error parsing user data:', e);
                showUserModal();
            }
        } else {
            // User doesn't exist, show modal
            showUserModal();
        }
    };
    
    // Show user modal
    const showUserModal = () => {
        document.body.style.overflow = 'hidden';
        document.getElementById('user_modal_overlay').classList.add('show');
        document.getElementById('user_modal').classList.add('show');
    };
    
    // Close user modal
    const closeUserModal = (event) => {
        console.log('Closing user modal');
        if (event && event.target.id === 'user_modal_overlay') {
            document.getElementById('user_modal_overlay').classList.remove('show');
            document.getElementById('user_modal').classList.remove('show');
            document.body.style.overflow = 'auto';
        } else if (!event) {
            document.getElementById('user_modal_overlay').classList.remove('show');
            document.getElementById('user_modal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    };
    
    // Convert Arabic numerals to English numerals
    const convertArabicToEnglish = (str) => {
        const arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        let result = str;
        for (let i = 0; i < arabicNumbers.length; i++) {
            result = result.replace(new RegExp(arabicNumbers[i], 'g'), englishNumbers[i]);
        }
        return result;
    };
    
    // Validation error messages
    const setNameError = () => {
        const input = document.getElementById('user_name');
        if (!input.value.match(/^[a-zA-Z0-9\u0600-\u06FF ]*$/)) {
            const message = '{{ app()->getLocale() == "ar" ? "يُسمح فقط بالأحرف الإنجليزية والعربية والأرقام والمسافات" : "Only English letters, Arabic letters, numbers, and spaces are allowed" }}';
            input.setCustomValidity(message);
        } else {
            input.setCustomValidity('');
        }
    };
    
    const setPhoneError = () => {
        const input = document.getElementById('user_phone');
        if (!input.value.match(/^[\d\u0660-\u0669]*$/)) {
            const message = '{{ app()->getLocale() == "ar" ? "يُسمح فقط بالأرقام (0-9 أو ٠-٩)" : "Only numbers (0-9 or Arabic numerals) are allowed" }}';
            input.setCustomValidity(message);
        } else {
            input.setCustomValidity('');
        }
    };
    
    const setAddressError = () => {
        const input = document.getElementById('user_address');
        if (!input.value.match(/^[a-zA-Z0-9\u0600-\u06FF\s\-\\|]*$/)) {
            const message = '{{ app()->getLocale() == "ar" ? "يُسمح بالأحرف الإنجليزية والعربية والأرقام والمسافات والواصلة والشرطة المائلة والأنابيب" : "Letters, numbers, spaces, dash, backslash, and pipe allowed" }}';
            input.setCustomValidity(message);
        } else {
            input.setCustomValidity('');
        }
    };
    
    // Save user data
    const saveUserData = (event) => {
        event.preventDefault();
        
        const nameInput = document.getElementById('user_name');
        const phoneInput = document.getElementById('user_phone');
        const addressInput = document.getElementById('user_address');
        
        // Validate inputs
        setNameError();
        setPhoneError();
        setAddressError();
        
        // Check if any custom validity is set
        if (nameInput.validity.valid && phoneInput.validity.valid && addressInput.validity.valid) {
            // Additional address validation
            if (!addressInput.value.match(/^[a-zA-Z0-9\u0600-\u06FF\s\-\\|]+$/)) {
                setAddressError();
                nameInput.reportValidity();
                return;
            }
            
            const userData = {
                name: nameInput.value,
                phone: convertArabicToEnglish(phoneInput.value),
                address: addressInput.value
            };
            
            // Save to localStorage
            localStorage.setItem('qr_algorexe_user', JSON.stringify(userData));
            
            // Call API to save customer to database (non-blocking)
            fetch('/api/customers/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    name: userData.name,
                    phone: userData.phone,
                    address: userData.address
                })
            })
            .then(response => response.json())
            .then(data => {
            })
            .catch(error => {
                console.error('Error saving customer:', error);
            });
            
            console.log('User data saved:', userData);
            console.log('Cart submitted:', local_cart);
            
            // Close modal
            closeUserModal();
            submitCart(); // Call submitCart again to proceed with order submission now that we have user data
            // TODO: Send cart and user data to backend
        } else {
            // Show error message
            nameInput.reportValidity();
        }
    };

    // Initialize cart when page loads
    document.addEventListener('DOMContentLoaded', () => {
        initCart();
        
        // Also observe images with data-src attribute
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    });
let currentVisible = document.querySelector('.product_list_item.active');
let isAnimating = false;

const showCategory = (id) => {
    if (isAnimating) return;

    const clickedCategory = document.getElementById('cat-' + id);
    const newProductList = document.getElementById('products-cat-' + id);

    if (!clickedCategory || !newProductList) return;

    // If already active → stop
    if (clickedCategory.classList.contains('active')) return;

    isAnimating = true;

    // Update category active state
    document.querySelectorAll('.category_item').forEach(cat => {
        cat.classList.remove('active');
    });
    clickedCategory.classList.add('active');

    // If switching to a different list
    if (currentVisible && currentVisible !== newProductList) {
        currentVisible.classList.add('slide-up');

        setTimeout(() => {
            currentVisible.classList.remove('slide-up');
            currentVisible.classList.remove('active');

            newProductList.classList.add('active');
            newProductList.classList.add('slide-down');

            currentVisible = newProductList;

            setTimeout(() => {
                newProductList.classList.remove('slide-down');
                isAnimating = false;
            }, 300);

        }, 300);

    } else {
        // fallback (should rarely happen)
        currentVisible = newProductList;
        isAnimating = false;
    }
};
    showCategoryold = (id) => {
        // Get the clicked category element
        const clickedCategory = document.getElementById('cat-' + id);
        
        // Check if already active
        if (clickedCategory.classList.contains('active')) {
            return;
        }
        
        // Remove active class from all categories and add to clicked one
        document.querySelectorAll('.category_item').forEach(cat => {
            cat.classList.remove('active');
        });
        clickedCategory.classList.add('active');
        
        // Get current visible product list item
        const currentVisible = document.querySelector('.product_list_item[style*="display: block"], .product_list_item:not([style*="display: none"])');
        console.log(currentVisible)
        const newProductList = document.getElementById('products-cat-' + id);
        
        // Slide up current and slide down new
        if (currentVisible && currentVisible !== newProductList) {
            // Add slide-up animation to current
            currentVisible.classList.add('slide-up');
            
            // Remove slide-up class and hide after animation
            setTimeout(() => {
                currentVisible.classList.remove('slide-up');
                currentVisible.style.display = 'none';
                
                // Show and slide down new product list
                newProductList.style.display = 'block';
                newProductList.classList.add('slide-down');
                
                // Remove animation class after it completes
                setTimeout(() => {
                    newProductList.classList.remove('slide-down');
                }, 300);
            }, 300);
        } else if (!currentVisible) {
            // If no visible item, just show the new one with slide-down
            newProductList.style.display = 'block';
            newProductList.classList.add('slide-down');
            
            setTimeout(() => {
                newProductList.classList.remove('slide-down');
            }, 300);
        }
    }
    
    toggleGarnish = (productId) => {
        const button = document.getElementById('garnish-btn-' + productId);
        const garnishList = document.getElementById('garnish-' + productId);
        
        // If button already active, close it
        if (button.classList.contains('active')) {
            button.classList.remove('active');
            garnishList.classList.add('garnish-slide-up');
            
            setTimeout(() => {
                garnishList.classList.remove('garnish-slide-up');
                garnishList.classList.remove('active');
            }, 300);
        } else {
            // Close any other open garnish
            const allButtons = document.querySelectorAll('.garnish_btn');
            const allLists = document.querySelectorAll('.garnish_list');
            
            allButtons.forEach(btn => {
                if (btn.classList.contains('active')) {
                    btn.classList.remove('active');
                }
            });
            
            allLists.forEach(list => {
                if (list.classList.contains('active')) {
                    list.classList.add('garnish-slide-up');
                    
                    setTimeout(() => {
                        list.classList.remove('garnish-slide-up');
                        list.classList.remove('active');
                    }, 300);
                }
            });
            
            // Open the clicked garnish
            button.classList.add('active');
            garnishList.classList.add('active');
            garnishList.classList.add('garnish-slide-down');
            
            setTimeout(() => {
                garnishList.classList.remove('garnish-slide-down');
            }, 300);
        }
    }
    
    // Lazy load images with data-src attribute
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const fullSrc = img.getAttribute('data-src');
                
                if (fullSrc) {
                    // Create a new image to preload
                    const tempImg = new Image();
                    tempImg.onload = () => {
                        img.src = fullSrc;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    };
                    tempImg.src = fullSrc;
                }
            }
        });
    });
    
    // Scroll event to add/remove scrolled class to header
    let isScrolled = false;
    window.addEventListener('scroll', () => {
        const header = document.querySelector('.header');
        if (!header) return;
        
        if (window.scrollY > 50) {
            if (!isScrolled) {
                header.classList.add('scrolled');
                isScrolled = true;
            }
        } else {
            if (isScrolled) {
                header.classList.remove('scrolled');
                isScrolled = false;
            }
        }
    });
    

    
</script>
</body>

</html>