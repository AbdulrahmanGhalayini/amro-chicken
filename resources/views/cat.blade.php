<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        @foreach( $categories as $cat )
            <ul>
                <li><strong>{{ $cat->name_ar }}</strong></li>
                @if($cat->image)
                <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name_ar }}" style="max-width: 200px; max-height: 200px;">
                @else
                <img src="{{ asset('storage/' . $business->profile_photo) }}" alt="{{ $cat->name_ar }}" style="max-width: 200px; max-height: 200px;">
                @endif
                @foreach( $cat->products as $product )
                    <li style="margin-left: 20px;">
                        <p>{{ $product->name_ar }}</p>
                        <p>{{ $product->recipe_ar }}</p>
                        <p>{{ $product->price }}</p>
                        @if($product->image_1)
                <img src="{{ asset('storage/' . $product->image_1) }}" alt="{{ $product->name_ar }}" style="width: 40px; height: 40px; border-radius: 50%;">
                @else
                <img src="{{ asset('storage/' . $business->profile_photo) }}" alt="{{ $product->name_ar }}" style="width: 40px; height: 40px; border-radius: 50%;">
                @endif
                        @if($product->garnishes->count() > 0)
                            <ul style="margin-left: 20px; font-style: italic; color: red;">
                                @foreach( $product->garnishes as $garnish )
                                    <li>{{ $garnish->name_ar }} ({{ $garnish->price }} {{ $business->currency }} )</li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endforeach
    </body>
</html>
