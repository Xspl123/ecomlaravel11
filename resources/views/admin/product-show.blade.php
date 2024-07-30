@extends('layouts.admin')

@section('content')
<style>
    .gallery-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Space between images */
        justify-content: flex-start; /* Align images to the start of the container */
    }

    .img-preview {
        width: 100px; /* Set width of each image */
        height: 100px; /* Set height of each image */
        object-fit: cover; /* Ensure images cover the area without distortion */
        border-radius: 5px; /* Optional: Add rounded corners to the images */
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Product Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Product Details</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="product-detail">
                <div class="product-image">
                    <img src="{{ asset('/uploads/products/thumbnails/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px;">
                </div>
                <div class="product-info">
                    <h4>{{ $product->name }}</h4>
                    <p><strong>Slug:</strong> {{ $product->slug }}</p>
                    <p><strong>Category:</strong> {{ $product->category->name }}</p>
                    <p><strong>Brand:</strong> {{ $product->brand->name }}</p>
                    <p><strong>Short Description:</strong> {{ $product->short_description }}</p>
                    <p><strong>Description:</strong> {{ $product->description }}</p>
                    <p><strong>Regular Price:</strong> {{ $product->regular_price }}</p>
                    <p><strong>Sale Price:</strong> {{ $product->sale_price }}</p>
                    <p><strong>SKU:</strong> {{ $product->SKU }}</p>
                    <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
                    <p><strong>Stock Status:</strong> {{ ucfirst($product->stock_status) }}</p>
                    <p><strong>Featured:</strong> {{ $product->featured ? 'Yes' : 'No' }}</p>
                </div>
            </div>
            <div class="product-gallery">
                <h4>Gallery Images</h4>
                <div class="gallery-images">
                    @if ($product->gallery_images)
                    @foreach (json_decode($product->gallery_images) as $galleryImage)
                    <img src="{{ asset('/uploads/products/' . $galleryImage) }}" alt="Gallery Image" class="img-preview">
                    @endforeach
                    @else
                    <p>No gallery images</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
