@extends('layouts.admin')

@section('content')

<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slide</h3>
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
                    <a href="slider.html">
                        <div class="text-tiny">Slide</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">New Slide</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.slide_update', $slide->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Tagline -->
                <fieldset class="name">
                    <div class="body-title">Tagline <span class="tf-color-1">*</span></div>
                    <input
                        class="flex-grow"
                        type="text"
                        placeholder="Tagline"
                        name="tagline"
                        value="{{ old('tagline', $slide->tagline) }}"
                        aria-required="true"
                    >
                    @error('tagline')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </fieldset>

                <!-- Title -->
                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input
                        class="flex-grow"
                        type="text"
                        placeholder="Title"
                        name="title"
                        value="{{ old('title', $slide->title) }}"
                        aria-required="true"
                    >
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </fieldset>

                <!-- Subtitle -->
                <fieldset class="name">
                    <div class="body-title">Subtitle <span class="tf-color-1">*</span></div>
                    <input
                        class="flex-grow"
                        type="text"
                        placeholder="Subtitle"
                        name="subtitle"
                        value="{{ old('subtitle', $slide->subtitle) }}"
                        aria-required="true"
                    >
                    @error('subtitle')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </fieldset>

                <!-- Link -->
                <fieldset class="name">
                    <div class="body-title">Link <span class="tf-color-1">*</span></div>
                    <input
                        class="flex-grow"
                        type="url"
                        placeholder="Link"
                        name="link"
                        value="{{ old('link', $slide->link) }}"
                        aria-required="true"
                    >
                    @error('link')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </fieldset>

                <!-- Image Upload -->
                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <!-- Display existing image -->
                        @if($slide->image)
                            <div class="item" id="imgpreview" style="margin-bottom: 20px;">
                                <img id="imgPreview" class="effect8" src="{{ asset('uploads/slides/' . $slide->image) }}" alt="Current Image" style="max-width: 100%; height: auto;">
                            </div>
                        @endif
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
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </fieldset>

                <!-- Status -->
                <fieldset class="category">
                    <div class="body-title">Status</div>
                    <div class="select flex-grow">
                        <select name="status">
                            <option value="">Select</option>
                            <option value="1" @if(old('status', $slide->status) == "1") selected @endif>Active</option>
                            <option value="0" @if(old('status', $slide->status) == "0") selected @endif>Inactive</option>
                        </select>
                    </div>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
        <!-- /new-category -->
    </div>
    <!-- /main-content-wrap -->
</div>
<script>
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
</script>
@endsection
