@extends('layouts.template.app')
@section('title', 'Data Purchasing - Purchasing App')

@section('contents')
<div class="page-wrapper">
  <div id="delete-alert" class="alert alert-success d-none">
    Data have been removed
   </div>
   <div id="not-delete-alert" class="alert alert-danger d-none">
    Can not delete completed order
   </div>
   <div id="duplicate-alert" class="alert alert-success d-none">
    Data was successfully duplicated
   </div>
   <div id="update-status-alert" class="alert alert-success d-none">
    Status successfully updated
   </div>
   <div id="not-update-status-alert" class="alert alert-danger d-none">
    Can not update completed order
   </div>
  @if(session('status'))
  <div id="alert" class="alert alert-success">
    {{ session('status') }}
  </div>
  @endif
  @if(session('error'))
  <div id="alert" class="alert alert-danger">
    {{ session('error') }}
  </div>
  @endif
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title text-center">
            Purchase List
          </div>
        </div>
        <div class="card-header">
          <div class="nav-item my-1 float-right">
            <a href="{{ route('purchases.create') }}" type="button" class="btn btn-primary">
              + Add New Record
            </a>
          </div>
          <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item ml-2 mr-1 my-1 border rounded" role="presentation" onclick="datatable(1)">
            <a class="nav-link active" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="true">(<span id="waiting-badge" >{{count(\App\Models\Purchase::where('status', 1)->get())}}</span>) Waiting</a>
            </li>
            <li class="nav-item mx-1 my-1 border rounded" role="presentation" onclick="datatable(2)">
              <a class="nav-link " id="pills-shippingWH-tab" data-toggle="pill" href="#pills-shippingWH" role="tab" aria-controls="pills-shippingWH" aria-selected="false">(<span id="warehouse-badge" >{{count(\App\Models\Purchase::where('status', 2)->get())}}</span>) Shipping to Warehouse</a>
            </li>
            <li class="nav-item mx-1 my-1 border rounded" role="presentation" onclick="datatable(3)">
              <a class="nav-link" id="pills-shippingID-tab" data-toggle="pill" href="#pills-shippingID" role="tab" aria-controls="pills-shippingID" aria-selected="false">(<span id="indonesia-badge" >{{count(\App\Models\Purchase::where('status', 3)->get())}}</span>) Shipping to Indonesia</a>
            </li>
            <li class="nav-item mx-1 my-1 border rounded" role="presentation" onclick="datatable(4)">
              <a class="nav-link" id="pills-arrived-tab" data-toggle="pill" href="#pills-arrived" role="tab" aria-controls="pills-arrived" aria-selected="false">(<span id="arrived-badge" >{{count(\App\Models\Purchase::where('status', 4)->get())}}</span>) Arrived</a>
            </li>
            <li class="nav-item mx-1 my-1 border rounded" role="presentation" onclick="datatable(5)">
              <a class="nav-link" id="pills-completed-tab" data-toggle="pill" href="#pills-completed" role="tab" aria-controls="pills-completed" aria-selected="false">(<span id="completed-badge" >{{count(\App\Models\Purchase::where('status', 5)->get())}}</span>) Completed</a>
            </li>
          </ul>
        </div>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered yajra-datatable w-100">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Purchase code</th>
                      <th>Date</th>
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
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function () {
   
        let alert = $('#alert').length;
        if (alert > 0) {
            setTimeout(() => {
                $('#alert').remove();
            }, 3000);
        }
        // data table
        datatable(1);

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

        $('body').on('click', '#delete',async function () {
            let data_id = $(this).data("id");
            let confirmation = await showDialog("Are you sure?","You want to delete this data!","warning");
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
                      if(data.error){
                        var element = document.getElementById("not-delete-alert");
                        element.classList.remove("d-none");
                        setTimeout(()=>{
                          element.classList.add("d-none");
                        }, 3000);
                        return;
                      }
                      var table =  $(".yajra-datatable").DataTable();
                      table.ajax.reload();
                      var element = document.getElementById("delete-alert");
                      element.classList.remove("d-none");
                      setTimeout(()=>{
                        element.classList.add("d-none");
                      }, 3000);
                      $.ajax({
                        url: window.location.origin + "/purchases-counter",
                        success: function(data){
                          updateBadge(data);
                        }
                      });
                    },
                    error: function (data) {
                        $(location).attr('href', window.location.origin + "/purchases");
                    }
                });
            }
        });

        $('body').on('click', '#duplicate', async function () {
            let data_id = $(this).data('id');
            let confirmation = await showDialog("Please confirm!","Do you want to duplicate this data?","question");
            if(confirmation){
              let url = "purchases/duplicate/" + data_id;
              $.ajax({
                url: url,
                success: function(data){
                  var table =  $(".yajra-datatable").DataTable();
                  table.ajax.reload();
                  var element = document.getElementById("duplicate-alert");
                      element.classList.remove("d-none");
                      setTimeout(()=>{
                        element.classList.add("d-none");
                      }, 3000);
                  $.ajax({
                    url: window.location.origin + "/purchases-counter",
                    success: function(data){
                      updateBadge(data);
                    }
                  });
                },
                error: function(data){
                  $(location).attr('href', window.location.origin + "/purchases");
                }
              })
            }
        });

        $('body').on('click', '.update-status', function () {
            let id = $(this).data("id");
            let status = $(this).data("status");

            let url = window.location.origin + "/purchases-status";
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                  if(data.error){
                    var element = document.getElementById("not-update-status-alert");
                      element.classList.remove("d-none");
                      setTimeout(()=>{
                        element.classList.add("d-none");
                      }, 3000);
                    return;
                  }
                  var table =  $(".yajra-datatable").DataTable();
                  table.ajax.reload();
                  var element = document.getElementById("update-status-alert");
                      element.classList.remove("d-none");
                      setTimeout(()=>{
                        element.classList.add("d-none");
                      }, 3000);
                  $.ajax({
                    url: window.location.origin + "/purchases-counter",
                    success: function(data){
                      updateBadge(data);
                    }
                  });
                },
                error: function (data) {
                    $(location).attr('href', window.location.origin + "/purchases");
                }
            });
        });
  });

  function updateBadge(data){
    let waiting = $('#waiting-badge');
    let warehouse = $('#warehouse-badge');
    let indonesia = $('#indonesia-badge');
    let arrived = $('#arrived-badge');
    let completed = $('#completed-badge');

    waiting.text(data.waiting);
    warehouse.text(data.warehouse);
    indonesia.text(data.indonesia);
    arrived.text(data.arrived);
    completed.text(data.completed);
  }

  function datatable(status) {
    $table = $('.yajra-datatable').DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      ajax: `{{ url('purchase-list/${status}') }}`,
      columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex'
          },
          {
              data: 'code',
              name: 'code'
          },
          {
              data: 'order_date',
              name: 'order_date'
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
  }
</script>
@endsection