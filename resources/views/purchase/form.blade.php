@extends('layouts.template.app')
@section('title', 'Create Purchase - Purchasing App')

@section('contents')
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">{{isset($purchase) ? 'Edit Existing' : 'Add New'}} Purchase</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('purchases.index')}}" class="text-muted">Purchase</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">{{isset($purchase) ? 'Edit' : 'Add'}} Purchase</li>
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
         <form method="POST"
            action="{{ isset($purchase) ? route('purchases.update', $purchase['id']) : route('purchases.store') }}">
            @csrf
            @if(isset($purchase))
            @method('PUT')
            @endif
            <div class="card">
              <div class="card-header">
               <h4 class="page-title text-dark">Purchase</h4> 
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <h4 class="text-dark">Basic Information (Required)</h4>
                    <hr>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="code">Code</label>
                          <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ isset($pc) ? $pc : $purchase['code'] }}" autocomplete="off" readonly>
                          @error('code')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label for="order_date">Order Date</label>
                          <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ isset($purchase) ? $purchase['order_date'] : old('order_date') }}" required>
                          @error('order_date')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label for="grand_total">Grand total</label>
                          <input type="text" class="form-control @error('grand_total') is-invalid @enderror" id="grand_total" name="grand_total"
                          value="{{isset($purchase) ? $purchase['grand_total'] : (old('grand_total') ? old('grand_total') : 0) }}" readonly>
                          @error('grand_total')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>


                      </div>
                      <div class="col-6">

                        <div class="form-group">
                          <label for="supplier_id">Supplier</label>
                          <select id="supplier_id" name="supplier_id" class="form-control select2"></select>
                          @error('supplier_id')
                          <div class="invalid-feedback d-inline-block">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label for="remarks">Remarks</label>
                          <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ isset($purchase) ? $purchase['remarks'] : old('remarks') }}</textarea>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <hr>
                    <div class="d-flex align-items-center">
                      <a href="{{ route('purchases.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
                      <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card mt-4">
              <div class="card-header">
               <h4 class="page-title text-dark">Details</h4> 
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-4">
                    <!-- Button trigger modal -->
                    <button id="add-product" type="button" class="btn btn-primary btn-rounded mb-3" data-toggle="modal" data-target="#productModal">
                      + Add Product
                    </button>

                    <div id="productModal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Select Product</h4>
                              <button type="button" class="close" data-dismiss="modal"
                                  aria-hidden="true">×</button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                  <select id="product_id" name="product_id" class="form-control select2"></select>
                                  @error('product_id')
                                  <div class="invalid-feedback d-inline-block">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cancel</button>
                            <button id="update-detail" type="button" class="btn btn-primary btn-rounded">Update Detail</button>
                          </div>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    
                  </div>
                  <table class="table">
                    <thead>
                      <tr>
                        <td class="font-weight-bold">Product SKU</td>
                        <td class="font-weight-bold">Name</td>
                        <td class="font-weight-bold">Unit Price</td>
                        <td class="font-weight-bold">Quantity</td>
                        <td class="font-weight-bold">Sub Total</td>
                        <td class="font-weight-bold">Option</td>
                        <hr>
                      </tr>
                    </thead>
                    <tbody id="detail-product-table">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

  $(function(){

    let productRaw;

    function calculatePrice(){
      let grandTotal = $('#grand_total');

      let subTotal = $('.sub-total');
      let totalProductPrice = 0;
      for (var i = 0; i < subTotal.length; i++) {
        let subTotalPrice = subTotal[i].innerHTML;
        totalProductPrice += parseInt(subTotalPrice);   
      }

      grandTotal.val(totalProductPrice);
    }

    function drawTable(productRaw){
      console.log(productRaw);
      let refId = 'id' + (new Date()).getTime();
      let product = productRaw;
      let table = document.querySelector('#detail-product-table');
      let firstRow = document.createElement("tr");
      let nextRow = document.createElement("tr");
      let productSKU = document.createElement("td");
      let productName = document.createElement("td");
      let productPrice = document.createElement("td");
      let productQuantity = document.createElement("td");
      let productSubTotal = document.createElement("td");
      let inputQty = document.createElement('input');
      let inputName = document.createElement('input');
      let removeContainer = document.createElement('td')
      let remove = document.createElement('a');

      remove.className = "btn btn-danger btn-rounded btn-sm remove-product m-1 text-light";
      remove.innerHTML = "Remove this product";
      remove.dataset.ref = `${refId}`;
      removeContainer.appendChild(remove);
      productSKU.innerHTML = product.sku;
      inputName.type="hidden";
      inputName.className="form-control";
      inputName.name = `product_id[${product.id}]`;
      inputName.value = product.id;
      productName.innerHTML = product.name;
      productName.appendChild(inputName);
      productPrice.innerHTML = product.unit_price;
      productPrice.className = "unit-price";
      inputQty.type="number";
      inputQty.className="input-quanity form-control";
      inputQty.name = `quantity[${product.id}]`;
      inputQty.value = product.quantity ?? 0;
      inputQty.min = 0;
      productQuantity.appendChild(inputQty);
      productSubTotal.innerHTML = product.sub_total ?? 0;
      productSubTotal.className = "sub-total";
      firstRow.className = `${refId}`;
      firstRow.appendChild(productSKU);
      firstRow.appendChild(productName);
      firstRow.appendChild(productPrice);
      firstRow.appendChild(productQuantity);
      firstRow.appendChild(productSubTotal);
      firstRow.appendChild(removeContainer);
      table.appendChild(firstRow.cloneNode(true));
          
      let inputQuantity = $('.input-quanity');
      for (var i = 0; i < inputQuantity.length; i++) {
          inputQuantity[i].addEventListener('change', function(event){
          let unitPrice = $(this).parent().siblings('.unit-price').text().trim();
          let subTotal = $(this).parent().siblings('.sub-total');
          let result = +unitPrice * event.target.value;
          subTotal.text(result);
          calculatePrice();
        });
      }
      calculatePrice();
    }

    function getpurchaseDetails(id){
        let purchaseDetailURL = window.location.origin + "/purchases/details/";
        let pruductDetailURL = window.location.origin + "/product/details/";
        let purchaseDetails;
        let productList = [];
        let productRaw = [];

        // request purchase detail
        $.ajax({
          url: purchaseDetailURL + id,
          success: function(purchaseDetails){
            purchaseDetails = purchaseDetails;
            // productGrouping
            purchaseDetails.map(purchaseDetail => {
              if(!productList.includes(purchaseDetail.product_id)){
                productList.push(purchaseDetail.product_id);
              }
            });
            
            // create model
            productList.forEach(productId => {
              $.ajax({
                url: pruductDetailURL + productId,
                success: function(product){
                  let newProduct = {
                    id: product.id,
                    name: product.name,
                    sku: product.sku,
                    unit_price: product.unit_price,
                  }
                  let thisPurchaseDetail = purchaseDetails.filter(purchase => {
                    return purchase.product_id == productId;
                  });
                  console.log(thisPurchaseDetail);
                  thisPurchaseDetail.forEach(purchaseDetail => {
                    // let newProductDetail = {};
                    // newProduct.id = purchaseDetail.product_id,
                    newProduct.purchase_id = purchaseDetail.purchase_id,
                    newProduct.quantity = purchaseDetail.quantity,
                    newProduct.sub_total = purchaseDetail.sub_total
                  })

                  // draw table
                  drawTable(newProduct);
                },
                error: function(){
                  return;
                }
              });

            });
          },
          error: function(data){
            return;
          }
        });
    }

    calculatePrice();

    $('#transfer_fee').on('change', function(){
      calculatePrice();
    });

    $('#currency_rate').on('change', function(){
      calculatePrice();
    });

    $('#transport_cost').on('change', function(){
      calculatePrice();
    });

    $('#shipping_cost').on('change', function(){
      calculatePrice();
    });

    $('#productModal').on('show.bs.modal', function(){
      $("#product_id").empty().trigger('change')
    })

    $('body').on('click', '#update-detail', function () {
        let productId = $('#product_id').val();
        let productURL = window.location.origin + "/product/selected/" + productId;
        $('#productModal').modal('hide');
        $.ajax({
          url: productURL,
          success: function(product){
            drawTable(product); 
          }
        });
    });
    
    $('body').on('click', '.remove-product', function(){
      let ref = $(this).data('ref');
      let elements = $("."+ref);
      elements.remove();
      setTimeout(()=>{
        calculatePrice();
      }, 500)
    });

    $('#supplier_id').select2({
      placeholder: "Search for supplier...",
      minimumInputLength: 1,
      ajax: {
        url: "{{route('supplier-select')}}",
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

    $('#product_id').select2({
      placeholder: "Search for product...",
      minimumInputLength: 1,
      ajax: {
        url: "{{route('product-select')}}",
        dataType: 'json',
        delay: 250,
        data: function(params){
          return {
            q: $.trim(params.term)
          }
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true
      },
      dropdownParent: $('#productModal'),
      width: '100%',
      allowClear: true
    });

    @if(isset($purchase))
      @php
        $supplier = \App\Models\Supplier::find($purchase->supplier_id);
      @endphp
      let supplier = {
          id: '{{ $supplier->id }}',
          text: '{{$supplier->name }}'
      };
      let supplierOption = new Option(supplier.text, supplier.id, false, false);
      $('#supplier_id').append(supplierOption).trigger('change');
      let purchaseId = '{{$purchase->id}}';
      getpurchaseDetails(purchaseId);
    @endif

    @if(old('supplier_id'))
      @php
      $supplier = \App\Models\Supplier::find(old('supplier_id'));
      @endphp
      let supplier = {
          id: '{{ $supplier->id }}',
          text: '{{$supplier->name }}'
      };
      let supplierOption = new Option(supplier.text, supplier.id, false, false);
      $('#supplier_id').append(supplierOption).trigger('change');
    @endif

    @if(old('quantity'))
      let productIds = [];
      let validProductIds = [];
      let productDetails = [];
      let pruductDetailURL = window.location.origin + "/product/details/";

      @foreach(old('quantity') as $key => $value)
        // colecting data
        @php
          $product = \App\Models\Product::find($key);
        @endphp
        productIds.push(parseInt('{{$product->id}}'));
        productDetails.push({
          id: parseInt('{{$key}}'),
          quantity: parseInt('{{$value}}')
        });
      @endforeach
      
      // product grouping
      productIds.forEach(id => {
        if(!validProductIds.includes(id)){
          validProductIds.push(id);
        }
      });

      // creating model
      validProductIds.forEach(id => {
        $.ajax({
          url: pruductDetailURL + id,
          success: function(product){
            let newProduct = {
              id: product.id,
              name: product.name,
              sku: product.sku,
              photo: product.photo,
            };

            let newProductDetail = {
              id: product.id,
              name: product.name,
              unit_price: product.unit_price,
              sku: product.sku,
            }
            productDetails.forEach(productDetail => {
              if(productDetails.id == product.id){
                newProductDetail.quantity = productDetail.quantity;
                newProductDetail.sub_total = productDetail.quantity * product.unit_price;
              }
            })
            // productDetails.push(newProductDetail);
            newProduct = {
              ...newProductDetail,
            };

            // draw table
            drawTable(newProduct);
          },
          error: function(){
            return;
          }
        });
      })
      calculatePrice();
    @endif
})
</script>
@endsection