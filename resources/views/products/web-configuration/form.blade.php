@extends('layouts.app')

@section('title', 'Product Web Configuration')
@section('header-button')
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-2 d-flex gap-1">
                                <h5 class="card-title">Article Code: </h5>
                                <p class="card-text"> {{ $product->article_code }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Product Description</h4>

                            <div class="dropzone" id="product-dropzone">
                                <div class="fallback">
                                    <input name="file" type="file" multiple="multiple">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                    </div>
                                    <h4>Drop files here or click to upload.</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product Description</h4>
                            <textarea name="editor" id="editor" class="editor" rows="2"></textarea>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">SEO</h4>
                           {{--  <p class="card-title-desc">Fill all information below</p> --}}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="metatitle">Meta title</label>
                                        <input id="metatitle" name="productname" type="text" class="form-control"
                                            placeholder="Metatitle">
                                    </div>
                                    <div class="mb-3">
                                        <label for="metakeywords">Meta Keywords</label>
                                        <input id="metakeywords" name="manufacturername" type="text" class="form-control"
                                            placeholder="Meta Keywords">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="metadescription">Meta Description</label>
                                        <textarea class="form-control" id="metadescription" rows="5" placeholder="Meta Description"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save
                                    Changes</button>
                                <button type="submit" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-include-plugins :plugins="['contentEditor', 'dropzone']"></x-include-plugins>


        @push('scripts')
            <script>
                // Initialize Dropzone without form tag
                const dropzone = new Dropzone("#product-dropzone", {
                    url: "{{ route('product.uploadImages', $product->id) }}", // The URL to send the file to
                    paramName: "file", // The name that will be used to transfer the file
                    maxFilesize: 10, // Maximum filesize in MB
                    acceptedFiles: "image/*", // Only accept image files
                    addRemoveLinks: true,
                    dictDefaultMessage: "Drop files here or click to upload.",
                    dictRemoveFile: "Remove",
                    init: function() {
                        this.on("success", function(file, response) {
                            console.log(response); // Handle the server response here
                        });
                        this.on("error", function(file, response) {
                            console.log(response); // Handle the error here
                        });
                    }
                });
            </script>
        @endpush
    @endsection
