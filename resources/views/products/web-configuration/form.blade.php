<!-- Product Basic Information -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Basic Information</h4>

        <div class="row">
            <div class="col-md-4 mb-2">
                <x-form-input name="name" value="{{ $product->name ?? '' }}" label="Product Name"
                    placeholder="Enter Product Name" required="true" />
            </div>
            <div class="col-md-2 mb-2">
                <x-form-input name="price" type="number" step="0.01" value="{{ $product->price ?? '' }}"
                    label="Price" placeholder="Enter Price" required="true" />
            </div>
            <div class="col-md-2 mb-2">
                <x-form-input name="sale_price" type="number" step="0.01" value="{{ $product->sale_price ?? '' }}"
                    label="Sale Price" placeholder="Enter Sale Price" />
            </div>
            <div class="col-md-2 mb-2">
                <x-form-input name="sale_start" class="sale-date-picker"
                    value="{{ isset($product->sale_start) && $product->sale_start ? \Carbon\Carbon::parse($product->sale_start)->format('d-m-Y') : '' }}"
                    label="Sale Start at" placeholder="Sale Start at" />
            </div>
            <div class="col-md-2 mb-2">
                <x-form-input name="sale_end" class="sale-date-picker"
                    value="{{ isset($product->sale_end) && $product->sale_end ? \Carbon\Carbon::parse($product->sale_end)->format('d-m-Y') : '' }}"
                    label="Sale End at" placeholder="Sale End at" />
            </div>

            <div class="col-md-4 mb-2">
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" @class(['form-control', 'is-invalid' => $errors->has('tags')]) multiple>
                    <option value="" disabled>Select tag</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags', $product->tags->pluck('tag_id')->toArray())))>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Product Specification -->
<div class="card">
    <div class="card-body" id="product-specification">
        <h4 class="card-title">Specifications</h4>
        <div class="row" id="specification-container">
            @foreach (old('specifications', $product->webSpecification) as $specificationIndex => $specification)
                <div class="col-md-6 specification-item mb-3" id="spec-0">
                    <div class="row">
                        <div class="col-md-5">
                            <x-form-input name="specifications[{{ $specificationIndex }}][key]"
                                value="{{ $specification->key ?? $specification['key'] }}" label="Key"
                                placeholder="Key" class="form-control" required="true" />
                        </div>

                        <div class="col-md-5">
                            <x-form-input name="specifications[{{ $specificationIndex }}][value]"
                                value="{{ $specification->value ?? $specification['value'] }}" label="Value"
                                placeholder="Value" class="form-control" required="true" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger delete-specification mt-4" data-spec-id="spec-0"><i
                                    class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button id="add-specification" class="btn btn-secondary mt-3">Add Specification</button>
    </div>
</div>

<!-- Product Description & Summary -->
<div class="card">
    <div class="card-body">
        <div>
            <h4 class="card-title">Summary</h4>
            <textarea name="summary" id="summary" class="editor" rows="2">{{ $product->webInfo->summary ?? '' }}</textarea>
        </div>
        <div class="mt-3">
            <h4 class="card-title">Description</h4>
            <textarea name="description" id="description" class="editor" rows="2">{{ $product->webInfo->description ?? '' }}</textarea>
        </div>
    </div>
</div>

<!-- Sizes & prices -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Sizes & Prices</h4>

                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->sizes as $index => $size)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $size->sizeDetail->size }}</td>
                                <td><input type="text" name="sizes[{{ $size->id }}][web_price]"
                                        class="form-control" value="{{ $size->web_price }}"></td>
                                <td><input type="text" name="sizes[{{ $size->id }}][web_sale_price]"
                                        class="form-control" value="{{ $size->web_sale_price }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h4 class="card-title">Colors</h4>

                <input type="hidden" name="removed_color_images">

                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Color Name</th>
                            <th>Swatch</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->colors as $index => $color)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $color->colorDetail->name }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <div class="color-swatch-container">
                                        <div class="avatar-sm" @style(['background: '.$color->colorDetail->ui_color_code, 'background-image: url('.asset($color->swatch_image_path).')'])>
                                            <div class="overlay">
                                                <i class="mdi mdi-camera-outline"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="file" name="color_images[{{ $color->id }}]" accept="image/*" class="color_image_picker d-none">

                                    <button type="button" data-input="removed_color_images" data-id="{{ $color->id }}" @class(['btn btn-text remove-image', 'd-none'=> !$color->swatch_image_path])>Remove Image</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Status & Visibility -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Status & Visibility</h4>
        <div class="row">
            <div class="col-md-4">
                <select name="visibilty" id="visibilty" class="form-control">
                    <option value="0" @selected(($product->webInfo->status ?? '') === '0')>Inactive</option>
                    <option value="1" @selected(($product->webInfo->status ?? '') === '1')>Active</option>
                    <option value="2" @selected(($product->webInfo->status ?? '') === '2')>Hide When Out Of Stock</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2 align-items-center">
                <div class="small-toggle-button">
                    <input type="checkbox" name="split_with_colors" id="splitWithColors" switch="success"
                        data-on="On" data-off="Off" @checked($product->is_splitted_with_colors === '1') />
                    <label class="mb-0" for="splitWithColors" data-on-label="On" data-off-label="Off"></label>
                </div>
                <label for="splitWithColors">Split With Colors</label>
            </div>
        </div>
    </div>
</div>

<!-- Product Images -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Images</h4>

        <div class="row">
            <div class="col-md-4">
                <label for="colorForImages">Select Color</label>
                <select name="color" id="colorForImages" class="form-control">
                    <option value="">Select Color</option>

                    @foreach ($product->colors as $color)
                        <option value="{{ $color->id }}"> {{ $color->colorDetail->name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="colorForImages">Choose Images</label>
                <input type="file" class="form-control" id="productImages" name="images[]" accept="image/*"
                    multiple="multiple" />
            </div>
        </div>
        <div id="imagePreview" class="row mt-2 image-preview"></div>

        <div class="container">
            <div class="row image-preview">
                @foreach ($product->webImage as $index => $image)
                    <div class="col-6 col-sm-2 mb-2">
                        <div class="preview-image-container">
                            <img src="{{ asset($image->path) }}" alt="Product Images" class="img-fluid">
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-source="image"
                                data-endpoint="{{ route('product.destroy.image', $image->id) }}"><i
                                    class="fa fa-trash"></i></button>

                            <div class="alt-container"><input type="text" value="{{ $image->alt }}"
                                    name="saved_image_alt[{{ $image->id }}]" class="form-control"
                                    placeholder="Alt text"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- SEO -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">SEO</h4>
        <div class="row">
            <div class="col-sm-10 mb-2">
                <x-form-input name="heading" label="Heading" required="true"
                    value="{{ $product->webInfo->heading ?? '' }}" placeholder="Heading" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="mb-2">
                    <x-form-input name="meta_title" label="Meta title" required="true"
                        value="{{ $product->webInfo->meta_title ?? '' }}" placeholder="Meta title" />
                </div>
                <div class="mb-2">
                    <x-form-input name="meta_keywords" label="Meta Keywords"
                        value="{{ $product->webInfo->meta_keywords ?? '' }}" placeholder="Meta Keywords"
                        required="true" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" class="form-control" id="meta_description" rows="5"
                        placeholder="Meta Description">{{ $product->webInfo->meta_description ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
