@extends('layouts.app')
@section('title', 'Data Payment - Purchasing App')

@section('content')
<div class="container">
  <div id="delete-alert" class="alert alert-success d-none">
    Data have been removed
   </div>
   @if(session('error'))
    <div id="alert" class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif
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
              Data Payment
            </div>
            <div class="card-title ml-2">
              <a href="{{ route('payments.create') }}" type="button" class="btn btn-primary">+
                Add New Record</a>
            </div>
          </div>
          <div>
            <a href="{{ route('purchases.index') }}" type="button" class="btn btn-secondary">
              Back to Purchase</a> </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered yajra-datatable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Purchase code</th>
                  <th>Type</th>
                  <th>Attachment</th>
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

        let error = $('#error').length;
        if (error > 0) {
            setTimeout(() => {
                $('#error').remove();
            }, 3000);
        }
        $table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('payment-list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'purchase_code',
                    name: 'purchase_code'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'attachment',
                    name: 'attachment'
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
            let url = "payments/" + data_id;
            $(location).attr('href', url);
        });

        $('body').on('click', '#edit', function () {
            let data_id = $(this).data('id');
            let url = "payments/" + data_id + "/edit";
            $(location).attr('href', url);
        });

        $('body').on('click', '#delete', function () {
            let data_id = $(this).data("id");
            let confirmation = confirm("Are you sure want to delete the data?");
            if (confirmation) {
                let url = window.location.origin + "/payments/" + data_id;
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
                        $(location).attr('href', window.location.origin + "/payments");
                    }
                });
            }
        });

        $('body').on('click', '#download', function () {
            let data_id = $(this).data("id");
            let url = "payments/download/" + data_id;
            $(location).attr('href', url);
        });
    });

</script>
@endsection