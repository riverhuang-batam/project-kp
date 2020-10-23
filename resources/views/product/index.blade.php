@extends('layouts.template.app')
@section('title', 'Data Products - Purchasing App')

@section('contents')
<div class="page-wrapper">
  <div id="delete-alert" class="alert alert-success d-none">
    Data have been removed
   </div>
  @if(session('status'))
  <div id="alert" class="alert alert-success">
    {{ session('status') }}
  </div>
  @endif
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Product List</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Product</li>
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
          <div class="mb-4">
            <a href="{{ route('products.create') }}" type="button" class="btn btn-primary btn-rounded">
              + Add New Record</a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered yajra-datatable table-striped no-wrap">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Code</th>
                  <th>Name</th>
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
<script type="text/javascript">
  $(function () {
        let alert = $('#alert').length;
        if (alert > 0) {
            setTimeout(() => {
                $('#alert').remove();
            }, 3000);
        }
        $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product-list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('body').on('click', '#edit', function () {
            let data_id = $(this).data('id');
            let url = "products/" + data_id + "/edit";
            $(location).attr('href', url);
        });

        $('body').on('click', '#delete', async function () {
            let data_id = $(this).data("id");
            let confirmation = await showDialog("Are you sure?","You want to delete this data!","warning");
            if (confirmation) {
              
                let url = window.location.origin + "/products/" + data_id;
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
                        $(location).attr('href', window.location.origin + "/products");
                    }
                });
            }
        });
    });

</script>
@endsection