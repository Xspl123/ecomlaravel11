@extends('layouts.admin')

@section('content')
<style>
    .img-preview {
        max-width: 100px;
        max-height: 100px;
        margin: 10px;
    }
</style>
<!-- main-content-wrap -->
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Product</h3>
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
                    <div class="text-tiny">Edit Product</div>
                </li>
            </ul>
        </div>
        <!-- form-edit-product -->
        <form class="tf-section-2 form-edit-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update', $product->id) }}">
            @csrf
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name" id="ProductName" tabindex="0" value="{{ old('name', $product->name) }}" aria-required="true" required>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" id="ProductSlug" tabindex="0" value="{{ old('slug', $product->slug) }}" aria-required="true" required readonly>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product slug.</div>
                </fieldset>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="category_id" required>
                                <option value="">Choose category</option>
                                @foreach($categories as $id => $name)
                                <option value="{{ $id }}" @if($id == old('category_id', $product->category_id)) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="brand_id" required>
                                <option value="">Choose Brand</option>
                                @foreach($brands as $id => $name)
                                <option value="{{ $id }}" @if($id == old('brand_id', $product->brand_id)) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true" required>{{ old('short_description', $product->short_description) }}</textarea>
                    <div class="text-tiny">Do not exceed 255 characters when entering the short description.</div>
                </fieldset>

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required>{{ old('description', $product->description) }}</textarea>
                    <div class="text-tiny">Do not exceed 255 characters when entering the description.</div>
                </fieldset>
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" @if(!$product->image) style="display:none;" @endif>
                            <img id="imgPreview" class="effect8" src="{{ $product->image ? asset('uploads/products/thumbnails/'.$product->image) : '' }}" alt="Image Preview" style="max-width: 100%; height: auto;">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                            </label>
                        </div>
                    </div>
                    <div id="galleryPreview" class="gallery-preview">
                        @if($product->gallery_images)
                            @foreach(json_decode($product->gallery_images) as $galleryImage)
                                <img src="{{ asset('uploads/products/gallery/'.$galleryImage) }}" class="img-preview" alt="Gallery Image Preview">
                            @endforeach
                        @endif
                    </div>
                </fieldset>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price" tabindex="0" value="{{ old('regular_price', $product->regular_price) }}" aria-required="true" required>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price" tabindex="0" value="{{ old('sale_price', $product->sale_price) }}" aria-required="true" required>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0" value="{{ old('SKU', $product->SKU) }}" aria-required="true" required>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity" tabindex="0" value="{{ old('quantity', $product->quantity) }}" aria-required="true" required>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select name="stock_status">
                                <option value="instock" @if(old('stock_status', $product->stock_status) == 'instock') selected @endif>In Stock</option>
                                <option value="outofstock" @if(old('stock_status', $product->stock_status) == 'outofstock') selected @endif>Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select name="featured">
                                <option value="0" @if(old('featured', $product->featured) == '0') selected @endif>No</option>
                                <option value="1" @if(old('featured', $product->featured) == '1') selected @endif>Yes</option>
                            </select>
                        </div>
                    </fieldset>
                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update product</button>
                </div>
            </div>
        </form>
        <!-- /form-edit-product -->
    </div>
    <!-- /main-content-wrap -->
</div>
<!-- /main-content-wrap -->

<script>
    // Generate slug from product name
    document.getElementById('ProductName').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        document.getElementById('ProductSlug').value = slug;
    });

    // Preview single image
    document.getElementById('myFile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const imgPreview = document.getElementById('imgPreview');
        const imgPreviewContainer = document.getElementById('imgpreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreviewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            imgPreviewContainer.style.display = 'none';
        }
    });

    // Preview multiple gallery images
    document.getElementById('gFile').addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('galleryPreview');

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Ensure it's an image
            if (!file.type.startsWith('image/')){
                continue;
            }

            const img = document.createElement('img');
            img.classList.add('img-preview');
            img.file = file;

            previewContainer.appendChild(img);

            const reader = new FileReader();
            reader.onload = (function(aImg) {
                return function(e) {
                    aImg.src = e.target.result;
                };
            })(img);

            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
