@extends('layouts.admin')

@section('content')
<div class="wg-box">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form class="form-new-product form-style-1" action="{{ route('admin.brands_update', $brand->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset class="name">
            <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
            <input class="flex-grow" type="text" placeholder="Brand name" name="name" tabindex="0" value="{{ old('name', $brand->name) }}" aria-required="true" required="" id="brandName">
        </fieldset>
        <fieldset class="name">
            <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
            <input class="flex-grow" type="text" placeholder="Brand Slug" name="slug" tabindex="0" value="{{ old('slug', $brand->slug) }}" aria-required="true" required="" id="brandSlug">
        </fieldset>
        <fieldset>
            <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
            <div class="upload-image flex-grow">
                <div class="item" id="imgpreview" style="display:{{ $brand->image ? 'block' : 'none' }}">
                    <img src="{{ $brand->image ? asset('uploads/brands/' . $brand->image) : '' }}" id="previewImage" class="effect8" alt="">
                </div>
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
@endsection
