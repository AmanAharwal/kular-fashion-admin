@extends('layouts.app')

@section('title', 'Products')
@section('header-button')
    {{-- <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" id="importForm" class="d-inline">
        @csrf
        <input type="file" name="file" id="fileInput" accept=".csv" required style="display: none;" onchange="document.getElementById('importForm').submit();">
        <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click();">
            <i class="fas fa-file-import"></i> Import Products
        </button>
    </form>

    <a href="{{ route('products.export') }}" class="btn btn-primary">
        <i class="bx bx-download"></i> Download Product Configuration File
    </a> --}}

    @if (Auth::user()->can('create products'))
        <a href="{{ route('products.create') }}" id="add-product-link" class="btn btn-primary">
            <i class="bx bx-plus fs-16"></i> Add New Product
        </a>
    @endif
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-3 mb-2">
                                    <label for="brandFilter">Brand Name:</label>
                                    <select id="brandFilter" class="form-control select2">
                                        <option value="">All Brands</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-3 mb-2">
                                    <label for="typeFilter">Product Type:</label>
                                    <select id="typeFilter" class="form-control select2">
                                        <option value="">All Products Type</option>
                                        @foreach ($productTypes as $productType)
                           
                                            <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <table id="product-table" class="table table-bordered dt-responsive nowrap w-100 table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Article Code</th>
                                        <th>Manufacture Code</th>
                                        <th>Department</th>
                                        <th>Product Type</th>
                                        <th>Brand</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-include-plugins :plugins="['dataTable', 'update-status', 'select2']"></x-include-plugins>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#brandFilter, #typeFilter').select2({
                width: '100%',
            });

            var table = $('#product-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get.products') }}",
                    data: function(d) {
                        d.page = Math.floor(d.start / d.length) + 1;
                        d.brand_id = $('#brandFilter').val();
                        d.product_type_id = $('#typeFilter').val();
                        console.log(d.product_type_id);
                    }
                },
                columns: [{
                        title: "Article Code",
                        data: 'article_code'
                    },
                    {
                        title: "Manufacture Code",
                        data: 'manufacture_code'
                    },
                    {
                        title: "Department",
                        data: 'department.name'
                    },
                    {
                        title: "Brand",
                        data: 'brand.name'
                    },
                    {
                        title: "Product Type",
                        data: 'product_type.name'
                    },
                    {
                        title: "Actions",
                        data: null,
                        render: function(data, type, row) {
                            var actions = '<div class="action-buttons">';
                            @can('view products')
                                actions +=
                                    `<a href="{{ route('products.show', ':id') }}" class="btn btn-secondary btn-sm py-0 px-1">`
                                    .replace(/:id/g, row.id);
                                actions += `<i class="fas fa-eye"></i>`;
                                actions += `</a>`;
                            @endcan

                            @can('edit products')
                                actions +=
                                    `<a href="{{ route('products.edit', ':id') }}" class="btn btn-primary btn-sm edit py-0 px-1">`
                                    .replace(/:id/g, row.id);
                                actions += `<i class="fas fa-pencil-alt"></i>`;
                                actions += `</a>`;
                            @endcan
                            @can('delete products')
                                actions +=
                                    `<button data-source="product" data-endpoint="{{ route('products.destroy', ':id') }}" class="delete-btn btn btn-danger btn-sm py-0 px-1"> <i class="fas fa-trash-alt"></i> </button>`
                                    .replace(/:id/g, row.id);
                            @endcan

                            return actions;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                drawCallback: function(settings) {
                    let api = this.api();
                    $('#product-table th, #product-table td').addClass('p-1');

                    let rows = api.rows({
                        page: 'current'
                    }).data().length;

                    let searchValue = $('#custom-search-input').val();
                    if (rows === 0 && searchValue) {
                        $('#add-product-link').attr('href',
                            `{{ route('products.create') }}?mfg_code=${searchValue}`)
                    } else {
                        $('#add-product-link').attr('href', `{{ route('products.create') }}`)
                    }
                }
            });
            $('#brandFilter, #typeFilter').on('change', function() {
                table.ajax.reload();
            });

            $('#product-table_filter').prepend(
                `<input type="text" id="custom-search-input" class="form-control" placeholder="Search Products">`
                );

            $('#custom-search-input').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>

    @push('styles')
        <style>
            #product-table_filter label {
                display: none;
            }
        </style>
    @endpush
@endsection
