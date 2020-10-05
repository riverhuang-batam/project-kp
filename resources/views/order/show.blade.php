@extends('layouts.app')
@section('title', 'Detail Order - Purchasing App')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div class="card-title m-0">
            Detail Order
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <td>Purchase code</td>
              <td>{{ $data['purchase_code'] }}</td>
            </tr>
            <tr>
              <td>Date</td>
              <td>{{ $data['date'] }}</td>
            </tr>
            <tr>
              <td>Marking</td>
              <td>{{\App\Models\Order::getMarkingName($data['marking']) }}</td>
            </tr>
            <tr>
              <td>Item</td>
              <td>{{\App\Models\Order::getItemName($data['items'])}}</td>
            </tr>
            <tr>
              <td>Quantity</td>
              <td>{{ $data['qty'] }}</td>
            </tr>
            <tr>
              <td>CTNS</td>
              <td>{{ $data['ctns'] }}</td>
            </tr>
            <tr>
              <td>Volume</td>
              <td>{{ $data['volume'] }}</td>
            </tr>
            <tr>
              <td>PL</td>
              <td>{{ $data['PL'] }}</td>
            </tr>
            <tr>
              <td>Resi</td>
              <td>{{ $data['resi'] }}</td>
            </tr>
            <tr>
              <td>Expected Date</td>
              <td>{{ $data['expected_date'] }}</td>
            </tr>
            <tr>
              <td>Status</td>
              <td>{{ \App\Helpers\OrderStatus::getString($data['status']) }}</td>
            </tr>
            <tr>
              <td>Remark</td>
              <td>{{ $data['remarks'] }}</td>
            </tr>
          </table>
          <a href="{{ route('orders.index') }}" type="button" class="btn btn-secondary mr-2">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection