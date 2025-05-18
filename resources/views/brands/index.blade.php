@extends('layouts.app')

@section('title', 'All Brands - Drunkies')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Brands</li>
        </ol>
    </nav>

    <h1 class="mb-4">Our Beer Brands</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($brands as $brand)
        <div class="col">
            <div class="card h-100">
                @if($brand->image_url)
                    <img src="{{ asset($brand->image_url) }}" class="card-img-top p-3" alt="{{ $brand->name }} Logo">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $brand->name }}</h5>
                    <p class="card-text">{{ $brand->description }}</p>
                    <a href="{{ route('brands.show', $brand) }}" class="btn btn-primary">View Products</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection 