@extends('layouts.app')
@section('title', 'Data Purchasing - Purchasing App')

@section('content')
<div class="container-fluid">
  <div id="delete-alert" class="alert alert-success d-none">
    Data have been removed
   </div>
  @if(session('status'))
  <div id="alert" class="alert alert-success">
    {{ session('status') }}
  </div>
  @endif
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <div class="card-title mr-2">
              Data Purchasing
            </div>
            <div class="card-title ml-2">
              <a href="{{ route('purchases.create') }}" type="button" class="btn btn-primary">+
                Add New Record</a>
            </div>
          </div>
          <div class="d-flex">
            <div class="card-title mr-2">
              <a href="{{ route('payments.index') }}" type="button" class="btn btn-primary text-light">
                Manage Payment</a>
            </div>
            <div class="card-title mr-2 ml-2">
              <a href="{{ route('markings.index') }}" type="button" class="btn btn-info text-light">
                Manage Marking</a>
            </div>
            <div class="card-title ml-2">
              <a href="{{ route('items.index') }}" type="button" class="btn btn-info text-light">
                Manage Item</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered yajra-datatable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Purchase code</th>
                  <th>Date</th>
                  <th>Marking</th>
                  <th>Item</th>
                  <th>Quantity</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(function () {
        let alert = $('#alert').length;
        if (alert > 0) {
            setTimeout(() => {
                $('#alert').remove();
            }, 3000);
        }
        $table = $('.yajra-datatable').DataTable({
            rowCallback: function( row, data, index ) {
              if ( data['item'] === null || data['marking'] === null ) {
                $(row).hide();
              }
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('purchase-list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'purchase_code',
                    name: 'purchase_code'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'marking',
                    name: 'marking'
                },
                {
                    data: 'item',
                    name: 'item'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('body').on('click', '#show-detail', function () {
            let data_id = $(this).data('id');
            let url = "purchases/" + data_id;
            $(location).attr('href', url);
        });

        $('body').on('click', '#edit', function () {
            let data_id = $(this).data('id');
            let url = "purchases/" + data_id + "/edit";
            $(location).attr('href', url);
        });

        $('body').on('click', '#payment', function () {
            let data_id = $(this).data('id');
            let url = "payments/add-payment/" + data_id;
            $(location).attr('href', url);
        });

        $('body').on('click', '#delete', function () {
            let data_id = $(this).data("id");
            let confirmation = confirm("Are you sure want to delete the data?");
            if (confirmation) {
                let url = window.location.origin + "/purchases/" + data_id;
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: data_id
                    },
                    success: function (data) {
                      var table =  $(".yajra-datatable").DataTable();
                      table.ajax.reload();
                      var element = document.getElementById("delete-alert");
                      element.classList.remove("d-none");
                      setTimeout(()=>{
                        element.classList.add("d-none");
                      }, 3000);
                    },
                    error: function (data) {
                        $(location).attr('href', window.location.origin + "/purchases");
                    }
                });
            }
        });

        $('body').on('click', '#duplicate', function () {
            let data_id = $(this).data('id');
            let confirmation = confirm("Are you sure want to duplicate this order?");
            if(confirmation){
              let url = "purchases/duplicate/" + data_id;
              $.ajax({
                url: url,
                success: function(data){
                  var table =  $(".yajra-datatable").DataTable();
                  table.ajax.reload();
                  // $(location).attr('href', window.location.origin + "/purchases");
                },
                error: function(data){
                  $(location).attr('href', window.location.origin + "/purchases");
                }
              })
            }
        });
    });

</script>
@endsection