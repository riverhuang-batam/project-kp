@extends('layouts.app')
@section('title', 'Detail Purchasing - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div class="m-0 text-center">
           <h4>Detail Purchase</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <div class="card-title m-0">
                    Descriptions
                  </div>
                </div>
                <div class="card-body">
                <div>
                  <h6>Purchase Code:</h6>
                  <p>{{$purchase->purchase_code}}</p>
                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div>
                    <h6>Date:</h6>
                    <p>{{$purchase->date}}</p>
                  </div>
                  <div>
                    <h6>Expected date:</h6>
                    <p>{{$purchase->expected_date}}</p>
                  </div>
                </div>
                <div class="d-flex justify-content-between mb-4">
                <div>
                  <h6>Marking:</h6>
                  <p>{{$purchase->marking}}</p>
                </div>
                <div>
                  <h6>Item:</h6>
                  <p>{{\App\Models\Purchase::getItemName($purchase->item_id)}}</p>
                </div>
                <div>
                  <h6>Status:</h6>
                  <p>{{\App\Helpers\OrderStatus::getString($purchase->status) }}</p>
                </div>
                </div>
                <div class="d-flex justify-content-between mb-4">
                <div>
                  <h6>Quantity:</h6>
                  <p>{{$purchase->quantity}}</p>
                </div>
                <div>
                  <h6>Volume:</h6>
                  <p>{{$purchase->volume}}</p>
                </div>
                <div>
                  <h6>CTNS:</h6>
                  <p>{{$purchase->ctns}}</p>
                </div>
              </div>
              <div class="d-flex justify-content-between mb-4">
                <div>
                  <h6>PL:</h6>
                  <p>{{$purchase->pl}}</p>
                </div>
                <div>
                  <h6>Resi:</h6>
                  <p>{{$purchase->resi}}</p>
                </div>
              </div>
                <div>
                  <h6>Remarks:</h6>
                  <p>{{$purchase->remarks}}</p>
                </div>
              </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title m-0">
                  Detail Payment
                </div>
              </div>
              <div class="card-body">
                <ul class="list-group">
                @if(count($payments) < 1)
                <li class="list-group-item">
                  No Attachment
                </li>
                @endif
                @foreach ($payments as $payment)
                <li class="list-group-item">
                  <h6>Payment type:</h6>
                  <p>{{\App\Helpers\PaymentType::getString($payment->type) }}</p>
                  <h6>Attachment:</h6>
                  @if($payment->file_name != null)
                  <a role="button" class="badge badge-primary text-light mr-3" id="download" data-id={{$payment->id}}>Download</a>
                  <span>{{$payment->file_name}}</span>
                  @else
                  <p>No attachment</p>
                  @endif
                </li>
                @endforeach
                </ul>
              </div>
            </div>
            </div>
          </div>
          
          <a href="{{ route('purchases.index') }}" type="button" class="btn btn-secondary mr-2">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
  $(function () {
        $('body').on('click', '#download', function () {
            let data_id = $(this).data("id");
            let url = window.location.origin + "/payments/download/" + data_id;
            $(location).attr('href', url);
        });
    });
</script>
@endsection