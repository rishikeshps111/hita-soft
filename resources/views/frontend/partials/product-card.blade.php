@php
    $productImage = !empty($product->featured_product_img)
        ? asset($product_path . '/' . $product->featured_product_img)
        : asset($noimage_path . '/' . ($noimage->product_no_image ?? 'no-img.jpg'));
    $productPrice = $product->original_price;
    $productDescription = $product->short_description ?: strip_tags($product->product_desc);
    $productFeature = $product->product_feature_text ?: $product->features;
@endphp

<div class="purchase-container">
    <div class="purchase-image">
        {{-- <a href="{{ route('view_products', ['id' => $product->id]) }}"> --}}
            <img src="{{ $productImage }}" alt="{{ $product->product_title }}">
        {{-- </a> --}}
        <div class="purchase-tags">
            <span>{{ $product->onhand_qty > 0 ? $product->onhand_qty . ' Left' : 'Out of Stock' }}</span>
        </div>
    </div>
    <div class="purchase-info">
        <h6>
            <a href="{{ route('view_products', ['id' => $product->id]) }}">{{ $product->product_title }}</a>
        </h6>
        <h5>₹ {{ number_format((float) $productPrice, 2) }}</h5>
        @if($productDescription)
            <p>{{ \Illuminate\Support\Str::limit($productDescription, 110) }}</p>
        @endif
        <ul>
            @if($product->product_capacity)
                <li><i class="fas fa-cogs"></i>Capacity: {{ $product->product_capacity }}</li>
            @endif
            @if($product->product_type)
                <li><i class="fas fa-cog"></i>Type: {{ $product->product_type }}</li>
            @endif
            @if($product->product_power)
                <li><i class="fas fa-bolt"></i>Power: {{ $product->product_power }}</li>
            @endif
            @if($product->product_size)
                <li><i class="fas fa-ruler-combined"></i>Size: {{ $product->product_size }}</li>
            @endif
            @if($productFeature)
                <li><i class="fas fa-shield-alt"></i>{{ $productFeature }}</li>
            @endif
        </ul>
        <a href="{{ route('view_products', ['id' => $product->id]) }}" class="view-details">View Details</a>
    </div>
</div>
