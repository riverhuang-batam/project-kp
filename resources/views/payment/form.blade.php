@extends('layouts.app')
@section('title', 'Create Payment - Purchasing App')

@section('content')
@if(session('payment'))
  <?php
    $payment = session('payment')
  ?>
@endif
<div class="container">
  @if(session('error'))
  <div id="alert" class="alert alert-danger">
    {{ session('error') }}
  </div>
  @endif
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title m-0">
            <h5>
           {{isset($payment) ? 'Edit Existing' : 'Add New'}} Payment
            </h5>
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
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="purchase_id">Purchase code</label>
                    <select id="purchase_id" name="purchase_id" class="form-control select2"></select>
                    @error('purchase_id')
                    <div class="invalid-feedback d-inline-block">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-4">
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
              <div class="col-md-4">
                <div class="form-group">
                  <label for="amount">Amount (S$)</label>
                <input type="number" class="form-control" name="amount" value="{{isset($payment) ? $payment->amount : 0}}" required/>
                    @error('amount')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-12">
                @if(isset($payment))
                <div class="mb-4 form-group">
                  <input class="attachment-option" name="attachment_option" type="radio" value="change" required/><span>  Change attachement</span>
                  <div></div>
                  <input class="attachment-option" name="attachment_option" type="radio" value="remove"/><span>  Remove attachement</span>
                </div>
                <div id="current-attachment">
                  <p>Current attachement: {{$payment->file_name}}</p>
                </div>
                @endif
              <div id="input-attachment"  class="form-group {{isset($payment) ? "d-none" : ""}}">
                  <label for="file_name">Attachment</label>
                  <div></div>
                <input type="file" name="file_name"/>
                <input type="hidden" name="current_file" value="{{isset($payment) ? $payment->file_name : ""}}"/> 
                </div>
              </div>
            </div>
            <hr>
            <div class="btn-group">
              @if(!isset($purchase_code))
              <a href="{{ route('payments.index') }}" type="button" class="btn btn-secondary mr-2">Back</a>
              @endif 
              @if(isset($purchase_code))
              <a href="{{ route('purchases.index') }}" type="button" class="btn btn-secondary mr-2">Back to Purchase</a> 
              @endif
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
    let alert = $('#alert').length;
    if (alert > 0) {
        setTimeout(() => {
            $('#alert').remove();
        }, 3000);
    }

    $('body').on('click','.attachment-option',function(){
        let isInputHide = $('#input-attachment').hasClass("d-none");
        let isInputShow = $('#input-attachment').hasClass("d-block");
        let isAttachmentHide = $('#current-attachment').hasClass('d-none');
        switch($(this).val()){
          case 'change':
            if(isInputHide){
              $('#input-attachment').removeClass('d-none');
              $('#input-attachment').addClass('d-block');
            }
            if(isAttachmentHide){
              $('#current-attachment').removeClass('d-none');
              $('#current-attachment').addClass('d-block')
            }
            break;
          case 'remove':
            if(!isInputHide){
              $('#input-attachment').removeClass('d-block');
              $('#input-attachment').addClass('d-none');
            }
            if(!isAttachmentHide){
              $('#current-attachment').removeClass('d-block');
              $('#current-attachment').addClass('d-none')
            }
            break;
        }
    });

    $('#purchase_id').select2({
      placeholder: "Search for purchase order...",
      minimumInputLength: 1,
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "{{route('purchase-select')}}",
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
        $purchase = \App\Models\Purchase::find($payment['purchase_id']);
      @endphp
      let order = {
          id: '{{ $purchase->id }}',
          text: '{{ $purchase->purchase_code }}'
      };
      
      let orderOption = new Option(order.text, order.id, false, false);
      $('#purchase_id').append(orderOption).trigger('change');
    @endif

    @if(isset($purchase_code))
      @php
        $purchase = \App\Models\Purchase::find($purchase_code['id']);
      @endphp
        let order = {
            id: '{{ $purchase->id }}',
            text: '{{ $purchase->code }}'
        };
        
        let orderOption = new Option(order.text, order.id, false, false);
        $('#purchase_id').append(orderOption).trigger('change');
    @endif

    @if(old('purchase_id'))
      @php
        $purchase = \App\Models\Purchase::find($payment['purchase_id']);
      @endphp
      let order = {
          id: '{{ $purchase->id }}',
          text: '{{ $purchase->purchase_code }}'
      };
      let orderOption = new Option(order.text, order.id, false, false);
      $('#purchase_id').append(orderOption).trigger('change');
    @endif
})
</script>
@endsection