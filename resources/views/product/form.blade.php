@extends('layouts.template.app')
@section('title', 'Create Products - Purchasing App')

@section('contents')
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">{{isset($product) ? 'Edit Existing' : 'Add New'}} Product</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('products.index')}}" class="text-muted">Product</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">{{isset($product) ? 'Edit' : 'Add'}} Product</li>
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
          <form method="POST" enctype="multipart/form-data"
            action="{{ isset($product) ? route('products.update', $product['id']) : route('products.store') }}">
            @csrf
            @if(isset($product))
            @method('PUT')
            @endif
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <small>* is required</small>
                </div>
                <div class="form-group">
                  <label for="code">Code *</label>
                  <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                    placeholder="Add product code" name="code" value="{{ isset($product) ? $product['code'] : old('code') }}"
                    autocomplete="off"
                    @if(isset($product)) readonly @endif>
                  @error('code')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="name">Name *</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Add product name" name="name" value="{{ isset($product) ? $product['name'] : old('name') }}"
                    autocomplete="off">
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="stock">Stock *</label>
                  <input type="text" class="form-control @error('stock') is-invalid @enderror" id="stock"
                    placeholder="Add Stock" name="stock" value="{{ isset($product) ? $product['stock'] : old('stock') }}"
                    autocomplete="off">
                  @error('stock')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="unit_price">Unit Price *</label>
                  <input type="number" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price"
                    placeholder="Add Product Price" name="unit_price" value="{{ isset($product) ? $product['unit_price'] : old('unit_price') }}"
                    autocomplete="off">
                  @error('unit_price')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="sku">SKU</label>
                  <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku"
                    placeholder="Add product SKU" name="sku" value="{{ isset($product) ? $product['sku'] : old('sku') }}"
                    autocomplete="off">
                  @error('sku')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                {{-- <div class="form-group d-flex flex-column">
                  <label>Photo</label>
                  <div class="d-flex flex-row">
                    @isset($product)
                      @if ($product->photo != null)
                      <div>
                        <h6>Current Photo</h6>
                        <img src="{{Storage::disk('public')->url($product->photo)}}" alt="{{$product['photo']}}" width="200" height="200">
                      </div>
                      @endif
                    @endisset  
                    <input type="file" class="ml-4 align-self-end" name="photo" accept=".png, .jpg, .jpeg"/>
                  </div>
                  @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div> --}}
                {{-- product variant --}}
                {{-- <div class="form-group">
                  <label for="variant">Variants</label>
                  <table class="w-100" id="variant_table">
                    <tr>
                      <th class="d-none">No</th>
                      <th class="d-none">ID</th>
                      <th class="w-50">Name</th>
                      <th>Unit Price</th>
                      <th></th>
                    </tr>
                    <tr>
                      <td class="d-none">1</td>
                      <td class="d-none">
                        <input 
                          type="text" 
                          class="form-control mb-1 @if(false) is-invalid @endif"
                          id="variant_id_0"
                          name="variants[0][id]"/>
                      </td>
                      <td>
                        <input 
                          type="text" 
                          class="form-control mb-1 @if(false) is-invalid @endif"
                          id="variant_name_0"
                          name="variants[0][name]" required />
                      </td>
                      <td>
                        <input class="form-control mb-1"
                          type="number"
                          step="0.01"
                          min="0"
                          id="unit_price_0"
                          name="variants[0][unit_price]"
                          />
                      </td>
                      <td>
                        <button class="btn btn-danger btn-rounded btn-sm btn-delete-row mb-1 ml-2" type="button">
                          Delete
                        </button>
                      </td>
                    </tr>
                  </table>
                  <button type="button" class="btn btn-success btn-rounded btn-add-row mt-2">Add Variant</button>
                </div> --}}
              </div>
              <hr>
              <div class="">
                <a href="{{ route('products.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
                <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  {{-- <script type="text/javascript">
    $(function () {
      function deleteRow(event) {
        if($("#variant_table tr").length === 2) {
          showAlert("", "The product must have at least 1 variant")
          return;
        }
        $(event.target).closest("tr").remove();
      }
      $(".btn-delete-row").on('click', deleteRow);
      function addProductRow(data = null) {
        let oldRow = $("#variant_table tr:last-child").first();
        let newRow = oldRow.clone();
        let curRowNum = newRow.find("td:first-child").html();
        newRow.find("td:first-child").html((parseInt(curRowNum) + 1));
        newRow.find("td:nth-child(2) input").attr("id", "variant_id_"+curRowNum)
          .attr("name", "variants["+curRowNum+"][id]")
          .val("");
        newRow.find("td:nth-child(3) input").attr("id", "variant_name_"+curRowNum)
          .attr("name", "variants["+curRowNum+"][name]")
          .val("");
        newRow.find("td:nth-child(3) input").attr("id", "variant_name_"+curRowNum)
          .attr("stock", "variants["+curRowNum+"][stock]")
          .val("");
        newRow.find("td:nth-child(4) input").attr("id", "unit_price_)"+curRowNum)
          .attr("name", "variants["+curRowNum+"][unit_price]")
          .val("");
        $("#variant_table").append(newRow);
        if(data !== null && data.name) {
          oldRow.find("td:nth-child(2) input").val(data.id);
          oldRow.find("td:nth-child(3) input").val(data.name);
          oldRow.find("td:nth-child(4) input").val(data.unit_price);
        }
        $(".btn-delete-row").prop("onclick", null).off("click");
        $(".btn-delete-row").on('click', deleteRow);
      }
      $(".btn-add-row").on('click', addProductRow);
      @if(isset($product))
        let variantData = null;
        @foreach($product->variants as $variant)
          variantData = {
            id: '{{ $variant->id }}',
            name: '{{$variant->name}}',
            unit_price: '{{$variant->unit_price}}',
          };
          addProductRow(variantData);
        @endforeach
        $("#variant_table tr:last-child td:last-child button").trigger("click");
      @elseif(old('variants'))
        let variantData = null;
        @foreach(old('variants') as $variant)
          variantData = {
            name: "{{ $variant['name'] ?? ""}}",
            unit_price: {{ $variant['unit_price'] ?? 0}}
          };
          @if(isset($variant['id']))
            @php
              $productObj = \App\ProductVariant::find($variant['id']);
            @endphp

            variantData.name = '{{ $productObj->name }}';
            variantData.unit_price = '{{ $productObj->unit_price }}';
            variantData.id = '{{ $productObj->id }}';
          @endif
          addProductRow(variantData);
        @endforeach

        $("#variant_table tr:last-child td:last-child button").trigger("click");
      @endif
    });
  </script> --}}
@endsection