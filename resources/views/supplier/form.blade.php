@extends('layouts.app')
@section('title', 'Create Supplier - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title m-0">
            <h5>
            {{isset($supplier) ? 'Edit Existing' : 'Add New'}} Supplier
            </h5>
          </div>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data"
            action="{{ isset($supplier) ? route('suppliers.update', $supplier['id']) : route('suppliers.store') }}">
            @csrf
            @if(isset($supplier))
            @method('PUT')
            @endif
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <small>* is required</small>
                </div>
                <div class="form-group">
                  <label for="code">Supplier Code *</label>
                  <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                    placeholder="Add supplier code" name="code" value="{{ isset($supplier) ? $supplier['code'] : old('code') }}"
                    autocomplete="off">
                  @error('code')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="name">Supplier Name *</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Add supplier name" name="name" value="{{ isset($supplier) ? $supplier['name'] : old('name') }}"
                    autocomplete="off">
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <hr>
              <div class="btn-group">
                <a href="{{ route('suppliers.index') }}" type="button" class="btn btn-secondary mr-2">Back</a>
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