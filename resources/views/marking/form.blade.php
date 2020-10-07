@extends('layouts.app')
@section('title', 'Create Marking - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title m-0">
            <h5>
            {{isset($marking) ? 'Edit Existing' : 'Add New'}} Marking
            </h5>
          </div>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data"
            action="{{ isset($marking) ? route('markings.update', $marking['id']) : route('markings.store') }}">
            @csrf
            @if(isset($marking))
            @method('PUT')
            @endif
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name">Marking name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Add marking name" name="name" value="{{ isset($marking) ? $marking['name'] : old('name') }}"
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
                <a href="{{ route('markings.index') }}" type="button" class="btn btn-secondary mr-2">Back</a>
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