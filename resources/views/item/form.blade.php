@extends('layouts.app')
@section('title', 'Create Items - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title m-0">
            <h5>
            {{isset($item) ? 'Edit Existing' : 'Add New'}} Item
            </h5>
          </div>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data"
            action="{{ isset($item) ? route('items.update', $item['id']) : route('items.store') }}">
            @csrf
            @if(isset($item))
            @method('PUT')
            @endif
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name">Item name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Add item name" name="name" value="{{ isset($item) ? $item['name'] : old('name') }}"
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
                <a href="{{ route('items.index') }}" type="button" class="btn btn-secondary mr-2">Back</a>
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