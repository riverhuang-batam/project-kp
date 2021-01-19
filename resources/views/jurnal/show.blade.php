@extends('layouts.template.app')
@section('title', 'Detail Journal')

@section('contents')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Detail Journal</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('jurnals.index')}}"
                                    class="text-muted">Journal</a></li>
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
                            <h4>Information</h4>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div>
                                        <h6>Jurnals Number:</h6>
                                        <p>{{$jurnal->transaction_no}}</p>
                                    </div>
                                    <div>
                                        <h6>Date:</h6>
                                        <p>{{$jurnal->transaction_date}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card mt-4">
                   
                    <div class="card-body">
                        <div class="form-group">
                            <table class="w-100" id="product_table">
                                <tr>
                                    <th class="d-none">No</th>
                                    <th class="w-25">Akun</th>
                                    <th class="w-25">Details</th>
                                    <th class="w-25">Debit</th>
                                    <th class="w-25">Credit</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td class="d-none">1</td>
                                    <td>
                                        <select disabled
                                            class="form-control border-0 akun-select2 select2 @if(false) is-invalid @endif"
                                            id="akun_id_0" name="akuns[0][akun_id]">
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control description" type="text" id="description_0"
                                            name="akuns[0][description]" readonly/>
                                    </td>
                                    <td>
                                        <input class="form-control debit" type="number" min="0" value="0" id="debit_0"
                                            name="akuns[0][debit]" onchange="calculatePrice()" readonly/>
                                    </td>
                                    <td>
                                        <input class="form-control credit" type="number" min="0" value="0" id="credit_0"
                                            name="akuns[0][credit]" onchange="calculatePrice()"readonly />
                                    </td>
                                   
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="total_debit">Total Debit</label>
                                <input type="text" class="form-control @error('total_debit') is-invalid @enderror"
                                    id="total_debit" name="total_debit"
                                    value="{{isset($jurnal) ? $jurnal['total_debit'] : (old('total_debit') ? old('total_debit') : 0) }}"
                                    readonly>
                                @error('total_debit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="total_credit">Total Credit</label>
                                <input type="text" class="form-control @error('total_credit') is-invalid @enderror"
                                    id="total_credit" name="total_credit"
                                    value="{{isset($jurnal) ? $jurnal['total_credit'] : (old('total_credit') ? old('total_credit') : 0) }}"
                                    readonly>
                                @error('total_credit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <a href="{{ route('jurnals.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
		function calculatePrice(){
			let totalDebit = $('#total_debit');
			let totalCredit = $('#total_credit');
			let debit = $('.debit');
			let calculatedDebit = 0;
			for (var i = 0; i < debit.length; i++) {
				let debitTotal = debit[i].value;
				calculatedDebit += parseInt(debitTotal);   
			}
			let credit = $('.credit');
			let calculatedCredit = 0;
			for (var i = 0; i < credit.length; i++) {
				let creditTotal = credit[i].value;
				calculatedCredit += parseInt(creditTotal);   
			}
			totalDebit.val(calculatedDebit);
			totalCredit.val(calculatedCredit)
		}
	$(function(){
		
		function addProductRow(data = null) {
			let oldRow = $("#product_table tr:last-child").first();
			let newRow = oldRow.clone();
			let curRowNum = newRow.find("td:first-child").html();
			newRow.find("td:first-child").html((parseInt(curRowNum) + 1));
			let newSelect2 = newRow.find("select.akun-select2");
			newSelect2.attr("id", "akun_id_"+curRowNum)
				.attr("name", "akuns["+curRowNum+"][akun_id]")
				.removeClass("select2-hidden-accessible")
				.attr("data-select2-id", null)
				.attr("tabindex", null)
				.attr("aria-hidden", null)
				.empty()
				.clone();
			newRow.find("td:nth-child(2)").first().html(newSelect2);
			newRow.find("td:nth-child(3) input").attr("id", "description_"+curRowNum)
        		.attr("name", "akuns["+curRowNum+"][description]")
				.val();
			newRow.find("td:nth-child(4) input").attr("id", "debit_"+curRowNum)
				.attr("name", "akuns["+curRowNum+"][debit]")
				.val(0);
			newRow.find("td:nth-child(5) input").attr("id", "credit_"+curRowNum)
				.attr("name", "akuns["+curRowNum+"][credit]")
				.val(0);
			$("#product_table").append(newRow);
				newSelect2.select2({
					placeholder: "Search for Akun",
					ajax: {
						url: "{{ route('akun-select') }}",
						dataType: 'json',
						delay: 250,
						data: function(params) {
							return {
								q: params.term,
							};
						},
						processResults: function(data) {
							return {
								results: data
							};
						},
						cache: true
					},
					minimumInputLength: 1,
				});
			
			if(data !== null && data.akun !== null) {
				oldRow.find("select.select2").append(
						new Option(
							data.akun.name,
							data.akun.id,
							false,
							false,
						)
					)
				.trigger('change');
			}
			if(data !== null && data.description) {
				oldRow.find("td:nth-child(3) input").val(data.description);
			}
			if(data !== null && data.debit) {
				oldRow.find("td:nth-child(4) input").val(data.debit);
			}
			if(data !== null && data.credit) {
				oldRow.find("td:nth-child(5) input").val(data.credit);
			}
			calculatePrice();
		}
		$(".btn-add-row").on('click', addProductRow);
		$("#akun_id_0").select2({
			placeholder: "Search for Akun",
			ajax: {
				url: "{{ route('akun-select') }}",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						q: params.term,
					};
				},
				processResults: function(data) {
					return {
						results: data
					};
				},
				cache: true
			},
			minimumInputLength: 1,
		});
		function formatDetail(data) {
			if (data.loading) {
				return data.text;
			}
			let markup = "<div class='select2-result-repository clearfix'>";
					markup += "<div class='select2-result-repository__meta'>";
					markup += "<div class='select2-result-repository__title'>" + data.text + "</div>";
					markup += "</div></div>";
			return markup;
		}
		
		function formatDetailSelection(data) {
			if(data.text) {
				return data.text;
			} else {
				return data.text;
			}
		}
		@if(isset($jurnal))
			let jurnalDetail = null;
			let akun = null;
			@foreach($jurnal->jurnalDetail as $detail)
				@php
					$akun = App\Models\Akun::find($detail->akun_id);
				@endphp
				akun = {
					id: '{{ $akun->id }}',
					name: '{{ $akun->name }}'
				};
				console.log(akun,"===========================");
				jurnalDetails = {
					detail_id: '{{$detail->id}}',
					akun: akun,
					description: '{{$detail->description}}',
					debit: '{{$detail->debit}}',
					credit: '{{$detail->credit}}',
				};
				addProductRow(jurnalDetails);
			@endforeach
            deletelastRow();
		@endif
		$("#product_table tr:last-child td:last-child button").trigger("click");
        function deletelastRow(event) {
			$('#product_table tr:last').remove();
		}
		@if(isset($data))
		let productData = null;
			@foreach($data->product as $product)
				productData = {
					name: '{{ $product->name }}',
					id: '{{ $product->id }}',
					discount_type: {{$product->pivot->discount_type}},
					discount_value: {{$product->pivot->discount_value}},
				};
				addProductRow(productData);
			@endforeach
		$("#product_table tr:last-child td:last-child button").trigger("click");
		@elseif(old('akuns'))
			let data = null;
			@foreach(old('akuns') as $akun)
				data = {
					description: '{{ $akun['description'] ?? ""}}',
					debit: {{ $akun['debit'] ?? 0}},
					credit: {{ $akun['credit'] ?? 0}},
				};
					@if(isset($akun['akun_id']))
						@php
							$productObj = \App\Models\Akun::find($akun['akun_id']);
							$name = "(" .$productObj->code. ") ". $productObj->name;
						@endphp
						data.name = "{{ $name }}";
						data.id = '{{ $productObj->id }}';
					@endif
				addProductRow(data);
			@endforeach
		$("#product_table tr:last-child td:last-child button").trigger("click");
		@endif
		
	})
</script>
@endsection