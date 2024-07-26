@extends('layouts.admin')

@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Brand infomation</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="#">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="#">
                        <div class="text-tiny">Brands</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">New Brand</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
    <form class="form-new-product form-style-1" action="{{ route('admin.brands_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset class="name">
            <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
            <input class="flex-grow" type="text" placeholder="Brand name" name="name" tabindex="0" value="" aria-required="true" required="" id="brandName">
        </fieldset>
        <fieldset class="name">
            <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
            <input class="flex-grow" type="text" placeholder="Brand Slug" name="slug" tabindex="0" value="" aria-required="true" required="" id="brandSlug">
        </fieldset>
         <fieldset>
            <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
            <div class="upload-image flex-grow">
                <!-- Existing Image Preview -->
                @if(isset($brand) && $brand->image)
                    <div class="item" id="imgpreview" style="display:block;">
                        <img src="{{ asset('uploads/brands/' . $brand->image) }}" id="previewImage" class="effect8" alt="{{ $brand->name }}">
                    </div>
                @else
                    <div class="item" id="imgpreview" style="display:none;">
                        <img src="" id="previewImage" class="effect8" alt="">
                    </div>
                @endif
                <!-- File Upload Section -->
                <div id="upload-file" class="item up-load">
                    <label class="uploadfile" for="myFile">
                        <span class="icon">
                            <i class="icon-upload-cloud"></i>
                        </span>
                        <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                        <input type="file" id="myFile" name="image" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>
            </div>
        </fieldset>

        <div class="bot">
            <div></div>
            <button class="tf-button w208" type="submit">Save</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('brandName').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        document.getElementById('brandSlug').value = slug;
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('previewImage');
            output.src = reader.result;
            document.getElementById('imgpreview').style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


<script>
    document.getElementById('brandName').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        document.getElementById('brandSlug').value = slug;
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('previewImage');
            output.src = reader.result;
            document.getElementById('imgpreview').style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


<script>
    document.getElementById('brandName').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        document.getElementById('brandSlug').value = slug;
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('previewImage');
            output.src = reader.result;
            document.getElementById('imgpreview').style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

    </div>
</div>


@endsection
