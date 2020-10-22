@extends('layouts.template.app')
@section('title', 'Create Supplier - Purchasing App')

@section('contents')
<div class="page-wrapper">
  <div class="row justify-content-center">
    <div class="col-md-8">
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
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    placeholder="Add phone number" name="phone" value="{{ isset($supplier) ? $supplier['phone'] : old('phone') }}"
                    autocomplete="off">
                  @error('phone')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea class="form-control" id="address" name="address" rows="3">{{ isset($supplier) ? $supplier['address'] : old('address') }}</textarea>
                </div>
                <div class="form-group">
                  <label for="remark">Remark</label>
                  <textarea class="form-control" id="remark" name="remark" rows="3">{{ isset($supplier) ? $supplier['remark'] : old('remark') }}</textarea>
                </div>
              </div>
              <hr>
              <div>
                <a href="{{ route('suppliers.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
                <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
