@extends('layouts.app')
@section('title', 'Create Purchase - Purchasing App')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title m-0">
            <h5>
           {{isset($purchase) ? 'Edit Existing' : 'Add New'}} Order
            </h5>
          </div>
        </div>
        <div class="card-body">
         <form method="POST"
            action="{{ isset($purchase) ? route('purchases.update', $purchase['id']) : route('purchases.store') }}">
            @csrf
            @if(isset($purchase))
            @method('PUT')
            @endif
            <div class="card">
              <div class="card-header">
                Purchase
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-4">
                    <h6>Basic Information (Required)</h6>
                    <hr>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group input-group-sm">
                          <label for="code">Code</label>
                          <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ isset($pc) ? $pc : $purchase['code'] }}" autocomplete="off" readonly>
                          @error('code')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group input-group-sm">
                          <label for="order_date">Order Date</label>
                          <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ isset($purchase) ? $purchase['order_date'] : old('order_date') }}" required>
                          @error('order_date')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group input-group-sm">
                          <label for="product_total">Product total (RMB)</label>
                          <input type="text" class="form-control @error('product_total') is-invalid @enderror" id="product_total" name="product_total"
                          value="{{isset($purchase) ? $purchase['product_total'] : (old('product_total') ? old('product_total') : 0) }}" readonly>
                          @error('product_total')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group input-group-sm">
                          <label for="grand_total">Grand total (RMB)</label>
                          <input type="text" class="form-control @error('grand_total') is-invalid @enderror" id="grand_total" name="grand_total"
                          value="{{isset($purchase) ? $purchase['grand_total'] : (old('grand_total') ? old('grand_total') : 0) }}" readonly>
                          @error('grand_total')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group input-group-sm">
                          <label for="grand_total_rp">Grand total (RP)</label>
                          <input type="text" class="form-control @error('grand_total_rp') is-invalid @enderror" id="grand_total_rp" name="grand_total_rp"   value="{{isset($purchase) ? $purchase['grand_total_rp'] : (old('grand_total_rp') ? old('grand_total_rp') : 0) }}" readonly>
                          @error('grand_total_rp')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                      </div>
                      <div class="col-6">
                        <div class="form-group input-group-sm">
                          <label for="status">Status</label>
                          <select class="custom-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">Select Status</option>
                            <option value="1" {{isset($purchase) && $purchase['status'] == 1 || old('status') == 1 ? 'selected="selected"' : ""}}>Waiting</option>
                            <option value="2" {{isset($purchase) && $purchase['status'] == 2 || old('status') == 2 ? 'selected="selected"' : ""}}>Shipping to Warehouse</option>
                            <option value="3" {{isset($purchase) && $purchase['status'] == 3 || old('status') == 3 ? 'selected="selected"' : ""}}>Shipping to Indonesia</option>
                            <option value="4" {{isset($purchase) && $purchase['status'] == 4 || old('status') == 4 ? 'selected="selected"' : ""}}>Arrived</option>
                            <option value="5" {{isset($purchase) && $purchase['status'] == 5 || old('status') == 5 ? 'selected="selected"' : ""}}>Completed</option>
                          </select>
                          @error('status')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group input-group-sm">
                          <label for="supplier_id">Supplier</label>
                          <select id="supplier_id" name="supplier_id" class="form-control select2"></select>
                          @error('supplier_id')
                          <div class="invalid-feedback d-inline-block">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group input-group-sm">
                          <label for="transfer_fee">Transfer Fee (RMB)</label>
                          <input type="number" class="form-control @error('transfer_fee') is-invalid @enderror" id="transfer_fee" name="transfer_fee" 
                          value="{{isset($purchase) ? $purchase['transfer_fee'] : (old('transfer_fee') ? old('transfer_fee') : 0) }}">
                          @error('transfer_fee')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group input-group-sm">
                          <label for="currency_rate">Currency Rate</label>
                          <input type="number" class="form-control @error('currency_rate') is-invalid @enderror" id="currency_rate" name="currency_rate"
                          value="{{isset($purchase) ? $purchase['currency_rate'] : (old('currency_rate') ? old('currency_rate') : 0) }}">
                          @error('currency_rate')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <h6>
                      Transport Information (Optional)
                    </h6>
                      <hr>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group input-group-sm">
                            <label for="transport_company">Transport Company</label>
                            <input type="text" class="form-control @error('transport_company') is-invalid @enderror" id="transport_company" name="transport_company"
                              value="{{isset($purchase) ? $purchase['transport_company'] : old('transport_company') }}">
                            @error('transport_company')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>

                          <div class="form-group input-group-sm">
                            <label for="transport_cost">Transport Cost (RMB)</label>
                            <input type="number" class="form-control @error('transport_cost') is-invalid @enderror" id="transport_cost" name="transport_cost"
                            value="{{isset($purchase) ? $purchase['transport_cost'] : (old('transport_cost') ? old('transport_cost') : 0) }}">
                            @error('transport_cost')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group input-group-sm">
                            <label for="tracking_number">Tracking No</label>
                            <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" id="tracking_number" name="tracking_number"
                            value="{{isset($purchase) ? $purchase['tracking_number'] : old('tracking_number') }}">
                            @error('tracking_number')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>

                          <div class="form-group input-group-sm">
                            <label for="total_piece_ctn">Total Pieces CTN</label>
                            <input type="number" class="form-control @error('total_piece_ctn') is-invalid @enderror" id="total_piece_ctn" name="total_piece_ctn" value="{{isset($purchase) ? $purchase['total_piece_ctn'] : (old('total_piece_ctn') ? old('total_piece_ctn') : 0) }}">
                            @error('total_piece_ctn')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-12">
                          <label for="remarks">Remarks</label>
                          <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ isset($purchase) ? $purchase['remarks'] : old('remarks') }}</textarea>
                        </div>
                      </div>
                    
                  </div>
                  <div class="col-4">
                    <h6>
                      Shipping Information (Optional)
                    </h6>
                      <hr>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group input-group-sm">
                            <label for="container_number">Container No</label>
                            <input type="text" class="form-control @error('container_number') is-invalid @enderror" id="container_number" name="container_number" value="{{isset($purchase) ? $purchase['container_number'] : old('container_number') }}">
                            @error('container_number')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group input-group-sm">
                            <label for="load_date">Load Date</label>
                            <input type="date" class="form-control @error('load_date') is-invalid @enderror" id="load_date" name="load_date" value="{{ isset($purchase) ? $purchase['load_date'] : old('load_date') }}">
                            @error('load_date')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>

                          <div class="form-group input-group-sm">
                            <label for="cubication">Cubication</label>
                            <input type="number" class="form-control @error('cubication') is-invalid @enderror" id="cubication" name="cubication"
                            value="{{isset($purchase) ? $purchase['cubication'] : (old('cubication') ? old('cubication') : 0) }}">
                            @error('cubication')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>


                        </div>
                        <div class="col-6">
                          <div class="form-group input-group-sm">
                            <label for="estimated_unload_date">Estimated Unload</label>
                            <input type="date" class="form-control @error('estimated_unload_date') is-invalid @enderror" id="estimated_unload_date" name="estimated_unload_date" value="{{ isset($purchase) ? $purchase['estimated_unload_date'] : old('estimated_unload_date') }}">
                            @error('estimated_unload_date')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>

                          <div class="form-group input-group-sm">
                            <label for="shipping_cost">Shippinig Costs (RP)</label>
                            <input type="number" class="form-control @error('shipping_cost') is-invalid @enderror" id="shipping_cost" name="shipping_cost"
                            value="{{isset($purchase) ? $purchase['shipping_cost'] : (old('shipping_cost') ? old('shipping_cost') : 0) }}">
                            @error('shipping_cost')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-12">
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                      <button type="submit" class="btn btn-primary btn-sm">Save</button>
                      <a href="{{ route('purchases.index') }}" type="button" class="text-none"><< Back</a> 
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card mt-4">
              <div class="card-header">
                Details
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-4">
                    <!-- Button trigger modal -->
                    <button id="add-product" type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#productModal">
                      + Add Product
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header  bg-primary text-light">
                            <h5 class="modal-title" id="exampleModalLabel">Select Product</h5>
                            <button type="button" class="text-light bg-danger " data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="false">&times;</span>
                            </button>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button id="update-detail" type="button" class="btn btn-primary">Update Detail</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <table class="table">
                    <thead>
                      <tr>
                        <td class="font-weight-bold">Product SKU</td>
                        <td class="font-weight-bold">Photo</td>
                        <td class="font-weight-bold">Name</td>
                        <td class="font-weight-bold">Unit Price (RMB)</td>
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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">

  $(function(){

    let productRaw;

    function calculatePrice(){
      let productTotal = $('#product_total');
      let grandTotal = $('#grand_total');
      let grandTotalRP = $('#grand_total_rp');
      let transferFee = $('#transfer_fee').val();
      let currencyRate = $('#currency_rate').val();
      let shippingCost = $('#shipping_cost').val();
      let transportCost = $('#transport_cost').val();

      let subTotal = $('.sub-total');
      let totalProductPrice = 0;
      for (var i = 0; i < subTotal.length; i++) {
        let subTotalPrice = subTotal[i].innerHTML;
        totalProductPrice += parseInt(subTotalPrice);   
      }

      let grandTotalPrice = totalProductPrice + parseInt(transferFee) + parseInt(shippingCost) + parseInt(transportCost);
      let grandTotalRPPrice = grandTotalPrice * currencyRate

      productTotal.val(totalProductPrice);
      grandTotal.val(grandTotalPrice);
      grandTotalRP.val(grandTotalRPPrice);
    }

    function drawTable(productRaw){
      let refId = 'id' + (new Date()).getTime();
            let product = productRaw;
            let table = document.querySelector('#detail-product-table');
            let firstRow = document.createElement("tr");
            let nextRow = document.createElement("tr");
            let productSKU = document.createElement("td");
            let productPhoto = document.createElement("td");
            let productImage = document.createElement("img");
            let variantData = document.createElement("tr");
            let variantName = document.createElement("td");
            let variantUnitPrice = document.createElement("td");
            let variantQuantity = document.createElement("td");
            let variantSubTotal = document.createElement("td");
            let input = document.createElement('input');
            let removeContainer = document.createElement('td')
            let remove = document.createElement('a');
            let imageURL = (product.photo ? window.location.origin+"/storage/"+product.photo : "");

            remove.className = "btn btn-primary btn-sm remove-product m-1 text-light";
            remove.innerHTML = "Remove this product";
            remove.dataset.ref = `${refId}`;
            removeContainer.appendChild(remove);
            removeContainer.rowSpan = product.variants.length;
            productImage.src = imageURL;
            productImage.alt = product.name;
            productImage.width = 100;
            productImage.height = 100;

            product.variants.map((data, index) => {
              if(index === 0){
                productSKU.innerHTML = product.sku;
                productSKU.rowSpan = product.variants.length;
                if(product.photo != null){
                  productPhoto.appendChild(productImage);
                }else{
                  productPhoto.innerHTML = product.name;
                }
                productPhoto.rowSpan = product.variants.length;
                variantName.innerHTML = data.name;
                variantUnitPrice.innerHTML = data.unit_price;
                variantUnitPrice.className = "unit-price";
                input.type="number";
                input.className="border border-secondary rounded-lg input-quanity input-group-sm";
                input.name = `quantity[${data.id}]`;
                input.value = data.quantity ?? 0;
                input.min = 0;
                variantQuantity.appendChild(input);
                variantSubTotal.innerHTML = data.sub_total ?? 0;
                variantSubTotal.className = "sub-total";
                firstRow.className = `${refId}`;
                firstRow.appendChild(productSKU);
                firstRow.appendChild(productPhoto);
                firstRow.appendChild(variantName);
                firstRow.appendChild(variantUnitPrice);
                firstRow.appendChild(variantQuantity);
                firstRow.appendChild(variantSubTotal);
                firstRow.appendChild(removeContainer);
                table.appendChild(firstRow.cloneNode(true));
              }else{
                variantName.innerHTML = data.name;
                variantUnitPrice.innerHTML = data.unit_price;
                variantUnitPrice.className = "unit-price";
                input.type="number";
                input.className="border border-secondary rounded-lg input-quanity input-group-sm";
                input.name = `quantity[${data.id}]`;
                input.value = data.quantity ?? 0;
                input.min = 0;
                variantQuantity.appendChild(input);
                variantSubTotal.innerHTML = data.sub_total ?? 0;
                variantSubTotal.className = "sub-total";
                nextRow.className = `${refId}`;
                nextRow.appendChild(variantName);
                nextRow.appendChild(variantUnitPrice);
                nextRow.appendChild(variantQuantity);
                nextRow.appendChild(variantSubTotal);
                table.appendChild(nextRow.cloneNode(true));
              }
            });
          
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
                  let variants = [];
                  let productVariants = [];
                  let newProduct = {
                    name: product.name,
                    sku: product.sku,
                    photo: product.photo
                  }
                  product.variants.forEach(variant => {
                    let newProductVariant = {
                      variant_id: variant.id,
                      name: variant.name,
                      unit_price: variant.unit_price
                    }
                    productVariants.push(newProductVariant);
                  })
                  let thisPurchaseDetail = purchaseDetails.filter(purchase => {
                    return purchase.product_id == productId;
                  });
                  thisPurchaseDetail.forEach(purchaseDetail => {
                    let newVariant = {};
                    productVariants.map(variant =>{
                      if(variant.variant_id == purchaseDetail.product_variant_id){
                        newVariant.name = variant.name,
                        newVariant.unit_price = variant.unit_price
                      }
                    });
                    newVariant.id = purchaseDetail.product_variant_id,
                    newVariant.purchase_id = purchaseDetail.purchase_id,
                    newVariant.quantity = purchaseDetail.quantity,
                    newVariant.sub_total = purchaseDetail.sub_total
                    variants.push(newVariant);
                  })
                  newProduct.variants = variants;

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
      let oldVariants = [];
      let pruductDetailURL = window.location.origin + "/product/details/";

      @foreach(old('quantity') as $key => $value)
        // colecting data
        @php
          $variant = \App\Models\ProductVariant::find($key);
          // dd($variant);
        @endphp
        productIds.push(parseInt('{{$variant->product_id}}'));
        oldVariants.push({
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
            let variants = [];
            let productVariants = [];
            let newProduct = {
              name: product.name,
              sku: product.sku,
              photo: product.photo
            };

            product.variants.forEach(variant => {
              let newProductVariant = {
                id: variant.id,
                name: variant.name,
                unit_price: variant.unit_price
              }
              oldVariants.forEach(oldVariant => {
                if(oldVariant.id == variant.id){
                  newProductVariant.quantity = oldVariant.quantity;
                  newProductVariant.sub_total = oldVariant.quantity * variant.unit_price;
                }
              })
              productVariants.push(newProductVariant);
            });
          
            newProduct.variants = productVariants;

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