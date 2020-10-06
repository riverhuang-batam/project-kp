@extends('layouts.app')
@section('title', 'Detail Purchasing - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div class="card-title m-0">
            Detail Purchase
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <td>Purchase code</td>
              <td>{{ $purchase['purchase_code'] }}</td>
            </tr>
            <tr>
              <td>Date</td>
              <td>{{ $purchase['date'] }}</td>
            </tr>
            <tr>
              <td>Marking</td>
              <td>{{\App\Models\Order::getMarkingName($purchase['marking']) }}</td>
            </tr>
            <tr>
              <td>Item</td>
              <td>{{\App\Models\Order::getItemName($purchase['item'])}}</td>
            </tr>
            <tr>
              <td>Quantity</td>
              <td>{{ $purchase['quantity'] }}</td>
            </tr>
            <tr>
              <td>CTNS</td>
              <td>{{ $purchase['ctns'] }}</td>
            </tr>
            <tr>
              <td>Volume</td>
              <td>{{ $purchase['volume'] }}</td>
            </tr>
            <tr>
              <td>PL</td>
              <td>{{ $purchase['pl'] }}</td>
            </tr>
            <tr>
              <td>Resi</td>
              <td>{{ $purchase['resi'] }}</td>
            </tr>
            <tr>
              <td>Expected Date</td>
              <td>{{ $purchase['expected_date'] }}</td>
            </tr>
            <tr>
              <td>Status</td>
              <td>{{ \App\Helpers\OrderStatus::getString($purchase['status']) }}</td>
            </tr>
            <tr>
              <td>Remark</td>
              <td>{{ $purchase['remarks'] }}</td>
            </tr>
          </table>
          <a href="{{ route('purchases.index') }}" type="button" class="btn btn-secondary mr-2">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection