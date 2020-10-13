@extends('layouts.app')
@section('title', 'Create Products - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title m-0">
            <h5>
            {{isset($product) ? 'Edit Existing' : 'Add New'}} Product
            </h5>
          </div>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data"
            action="{{ isset($product) ? route('products.update', $product['id']) : route('products.store') }}">
            @csrf
            @if(isset($product))
            @method('PUT')
            @endif
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="code">Code *</label>
                  <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                    placeholder="Add product code" name="code" value="{{ isset($product) ? $product['code'] : old('code') }}"
                    autocomplete="off">
                  @error('code')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="name">Name *</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Add product name" name="name" value="{{ isset($product) ? $product['name'] : old('name') }}"
                    autocomplete="off">
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="sku">SKU</label>
                  <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku"
                    placeholder="Add product SKU" name="sku" value="{{ isset($product) ? $product['sku'] : old('sku') }}"
                    autocomplete="off">
                  @error('sku')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group d-flex flex-column">
                  <label>Photo</label>
                  @isset($product)
                    <img src="{{Storage::disk('public')->url($product->photo)}}" alt="{{$product['photo']}}" width="200" height="200">
                  @endisset
                  <input type="file" name="photo" accept=".png, .jpg, .jpeg"/>
                  @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <hr>
              <div class="btn-group">
                <a href="{{ route('products.index') }}" type="button" class="btn btn-secondary mr-2">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
@endsection