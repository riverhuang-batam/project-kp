@extends('layouts.app')
@section('title', 'Create Payment - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title m-0">
           {{isset($payment) ? 'Edit Existing' : 'Add New'}} Payment
          </div>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data" 
            action="{{ isset($payment) ? route('payments.update', $payment['id']) : route('payments.store') }}">
            @csrf
            @if(isset($payment))
            @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="order_id">Purchase code</label>
                    <select id="order_id" name="order_id" class="form-control select2"></select>
                    @error('order_id')
                    <div class="invalid-feedback d-inline-block">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="type">Payment type</label>
                    <select class="custom-select @error('type') is-invalid @enderror" id="type" name="type">
                      <option value="">Select type</option>
                      <option value="1" {{isset($payment) && $payment['type'] == 1 || old('type') == 1 ? 'selected="selected"' : ""}}>Stock</option>
                      <option value="2" {{isset($payment) && $payment['type'] == 2 || old('type') == 2 ? 'selected="selected"' : ""}}>Shipping</option>
                    </select>
                    @error('type')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="file_name">Attachment</label>
                  <input type="file" name="file_name"/>
                </div>
              </div>
            </div>
            <hr>
            <div class="btn-group">
              <a href="{{ route('payments.index') }}" type="button" class="btn btn-secondary mr-2">Back</a> 
              <button type="submit" class="btn btn-primary">Submit</button>
            </>
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
    $('#order_id').select2({
      placeholder: "Search for purchase order...",
      minimumInputLength: 1,
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "{{route('order-select')}}",
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

    @if(isset($payment))
      @php
        $order = \App\Models\Order::find($payment['order_id']);
      @endphp
      let order = {
          id: '{{ $order->id }}',
          text: '{{ $order->purchase_code }}'
      };
      
      let orderOption = new Option(order.text, order.id, false, false);
      $('#order_id').append(orderOption).trigger('change');
    @endif

    @if(old('order_id'))
      @php
        $order = \App\Models\Order::find($payment['order_id']);
      @endphp
      let order = {
          id: '{{ $order->id }}',
          text: '{{ $order->purchase_code }}'
      };
      let orderOption = new Option(order.text, order.id, false, false);
      $('#order_id').append(orderOption).trigger('change');
    @endif
})
</script>
@endsection