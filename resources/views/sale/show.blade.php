@extends('layouts.template.app')
@section('title', 'Detail Purchasing - Purchasing App')

@section('contents')
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Sale Detail</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('purchases.index')}}" class="text-muted">Sale</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Detail</li>
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
          <div class="row">
                  <div class="col-12">
                    <h4>Basic Information (Required)</h4>
                    <hr>
                    <div class="row">
                      <div class="col-6">
                        <div>
                          <h6>Sale Code:</h6>
                          <p>{{$sale->code}}</p>
                        </div>
                        <div>
                          <h6>Order Date:</h6>
                          <p>{{$sale->order_date}}</p>
                        </div>
                        <div>
                          <h6>Grand total (RMB):</h6>
                          <p>{{$sale->grand_total}}</p>
                        </div>
                      </div>
                      <div class="col-6">
                        <div>
                          <h6>Fullname:</h6>
                          <p>{{$sale->fullname}}</p>
                        </div>
                        <div>
                          <h6>Address:</h6>
                          <p>{{$sale->address}}</p>
                        </div>
                        <div>
                          <h6>Remark:</h6>
                          <p>{{$sale->remarks}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
            
            <div class="col-md-12">
              <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <div class="card-title m-0">
                    Sale Items
                  </div>
                </div>
                <div class="card-body">
                  @foreach($productList as $product)
                  <div class="card mb-3">
                    <div class="card-header">
                      <h5>{{$product->name}} <small> - {{$product->sku}}</small> </h5>
                    </div>
                    <div class="card-body">
                      <div class="d-flex flex-row justify-content-around">
                        <div class="mr-4">
                          @if($product->photo != null)
                          <img src="{{Storage::disk('public')->url($product->photo)}}" alt="" width="150" height="150">
                          @endif
                          @if($product->photo == null)
                            <p>No Photo Available</p>
                          @endif
                        </div>
                        <div>
                          <strong>Varint items:</strong>
                          <ul class="list-group list-group-flush">
                          @foreach ($product->variants as $variant)
                            @if($variant->quantity != 0)
                              <li class="list-group-item">
                                <p>{{\App\Models\Purchase::getProductVariantName($variant->product_variant_id)}} - {{$variant->quantity}} pcs - {{$variant->sub_total}} RMB</p>
                              </li>
                            @endif
                          @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            {{-- <div class="col-md-6">
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
                  <h6>Payment amount:</h6>
                  <p>{{$payment->amount}}</p>
                  <h6>Attachment:</h6>
                  @if($payment->file_name != null)
                  <a role="button" type="button" class="badge badge-primary text-light mr-3" id="download" data-id={{$payment->id}}>Download</a>
                  <span>{{$payment->file_name}}</span>
                  @else
                  <p>No attachment</p>
                  @endif
                </li>
                @endforeach
                </ul>
              </div>
            </div> --}}
            </div>
          </div>
          
          <a href="{{ route('sales.index') }}" type="button" class="btn w-25 btn-secondary btn-rounded mr-2">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
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