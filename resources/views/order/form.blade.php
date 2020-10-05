@extends('layouts.app')
@section('title', 'Create Order - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title m-0">
           {{isset($data) ? 'Edit Existing' : 'Add New'}} Order
          </div>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data" 
            action="{{ isset($data) ? route('orders.update', $data['id']) : route('orders.store') }}">
            @csrf
            @if(isset($data))
            @method('PUT')
            @endif
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="purchase_code">Purchase Code</label>
                  <input type="text" class="form-control @error('purchase_code') is-invalid @enderror" id="purchase_code" name="purchase_code" value="{{ isset($pc) ? $pc : $data['purchase_code'] }}" autocomplete="off" readonly>
                  @error('purchase_code')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="date">Date</label>
                  <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" placeholder="Add Date" name="date" value="{{ isset($data) ? $data['date'] : old('date') }}" autocomplete="off">
                  @error('date')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="expected_date">Expected Date</label>
                  <input type="date" class="form-control @error('expected_date') is-invalid @enderror" id="expected_date" placeholder="Expected Date"
                    name="expected_date" value="{{ isset($data) ? $data['expected_date'] : old('expected_date') }}" autocomplete="off">
                  @error('expected_date')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="marking">Marking</label>
                  <select id="marking" name="marking" class="form-control select2"></select>
                  @error('marking')
                  <div class="invalid-feedback d-inline-block">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="items">Item</label>
                  <select id="items" name="items" class="form-control"></select>
                  @error('items')
                  <div class="invalid-feedback d-inline-block">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="qty">Quantity</label>
                  <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" placeholder="Quantity"
                    name="qty" value="{{ isset($data) ? $data['qty'] : old('qty') }}" autocomplete="off">
                  @error('qty')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="volume">Volume</label>
                  <input type="number" class="form-control @error('volume') is-invalid @enderror" id="volume" placeholder="Volume"
                    name="volume" value="{{ isset($data) ? $data['volume'] : old('volume') }}" step="0.01" autocomplete="off">
                  @error('volume')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ctns">CTNS</label>
                  <input type="number" class="form-control @error('ctns') is-invalid @enderror" id="ctns" placeholder="CTNS"
                    name="ctns" value="{{ isset($data) ? $data['ctns'] : old('ctns') }}" autocomplete="off">
                  @error('ctns')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="pl">PL</label>
                  <input type="text" class="form-control @error('pl') is-invalid @enderror" id="pl" placeholder="PL"
                    name="pl" value="{{ isset($data) ? $data['PL'] : old('pl') }}" autocomplete="off">
                  @error('pl')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="resi">Resi</label>
                  <input type="text" class="form-control @error('resi') is-invalid @enderror" id="resi" placeholder="Resi"
                    name="resi" value="{{ isset($data) ? $data['resi'] : old('resi') }}" autocomplete="off">
                  @error('resi')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="custom-select @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="">Select Status</option>
                    <option value="1" {{isset($data) && $data['status'] == 1 || old('status') == 1 ? 'selected="selected"' : ""}}>Waiting</option>
                    <option value="2" {{isset($data) && $data['status'] == 2 || old('status') == 2 ? 'selected="selected"' : ""}}>Shipping to Warehouse</option>
                    <option value="3" {{isset($data) && $data['status'] == 3 || old('status') == 3 ? 'selected="selected"' : ""}}>Shipping to Indonesia</option>
                    <option value="4" {{isset($data) && $data['status'] == 4 || old('status') == 4 ? 'selected="selected"' : ""}}>Arrived</option>
                    <option value="5" {{isset($data) && $data['status'] == 5 || old('status') == 5 ? 'selected="selected"' : ""}}>Completed</option>
                  </select>
                  @error('status')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mb-4">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks" rows="6">{{ isset($data) ? $data['remarks'] : old('remarks') }}</textarea>
              </div>
            </div>
            <hr>
            <div class="btn-group">
              <a href="{{ route('orders.index') }}" type="button" class="btn btn-secondary mr-2">Back</a> 
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">    
  $(function(){
    $('#marking').select2({
      placeholder: "Search for marking...",
      minimumInputLength: 1,
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "{{route('marking-select')}}",
        dataType: 'json',
        delay: 250,
        data: function(params){
          return {
            q: $.trim(params.term)
          }
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
      }
    });

    $('#items').select2({
      placeholder: "Search for item...",
      minimumInputLength: 1,
      ajax: {
        url: "{{route('item-select')}}",
        dataType: 'json',
        delay: 250,
        data: function(params){
          return {
            q: $.trim(params.term)
          }
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
      }
    });

    @if(isset($data))
      @php
        $marking = \App\Models\Marking::find($data['marking']);
        $item = \App\Models\Item::find($data['items']);
      @endphp
      let marking = {
          id: '{{ $marking->id }}',
          text: '{{ $marking->name }}'
      };
      let item = {
          id: '{{ $item->id }}',
          text: '{{ $item->name }}'
      };
      let markingOption = new Option(marking.text, marking.id, false, false);
      let itemOption = new Option(item.text, item.id, false, false);
      $('#marking').append(markingOption).trigger('change');
      $('#items').append(itemOption).trigger('change');
    @endif

    @if(old('marking'))
      @php
        $marking = \App\Models\Marking::find(old('marking'));
      @endphp
      let marking = {
          id: '{{ $marking->id }}',
          text: '{{ $marking->name }}'
      };
      let markingOption = new Option(marking.text, marking.id, false, false);
      $('#marking').append(markingOption).trigger('change');
    @endif

    @if(old('items'))
      @php
        $item = \App\Models\Item::find(old('items'));
      @endphp
      let item = {
          id: '{{ $item->id }}',
          text: '{{ $item->name }}'
      };
      let itemOption = new Option(item.text, item.id, false, false);
      $('#items').append(itemOption).trigger('change');
    @endif
})
</script>
@endsection