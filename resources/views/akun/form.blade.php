@extends('layouts.template.app')
@section('title', 'Create Akun - Purchasing App')

@section('contents')
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">{{isset($akun) ? 'Edit Existing' : 'Add New'}} Akun</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('akuns.index')}}" class="text-muted">Akun</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">{{isset($akun) ? 'Edit' : 'Add'}} Akun</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data"
            action="{{ isset($akun) ? route('akuns.update', $akun['id']) : route('akuns.store') }}">
            @csrf
            @if(isset($akun))
            @method('PUT')
            @endif
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <small>* is required</small>
                </div>
                <div class="form-group">
                  <label for="name">Name *</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Add akun name" name="name" value="{{ isset($akun) ? $akun['name'] : old('name') }}"
                    autocomplete="off">
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <hr>
              <div class="">
                <a href="{{ route('akuns.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
                <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection