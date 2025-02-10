@extends('layouts.app')

@section('title', 'Edit Web Configration')
@section('header-button')
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
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
                            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('products.web-configuration.form')

                                <button type="button" class="btn btn-secondary me-2" id="add-variant-btn">Add new variant</button>
                                <button class="btn btn-primary">Save</button>
                            </form>    
                            
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection