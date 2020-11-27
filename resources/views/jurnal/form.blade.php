@extends('layouts.template.app')
@section('title', 'Create Jurnal - Purchasing App')

@section('contents')
<div class="page-wrapper">
	<div class="page-breadcrumb">
		<div class="row">
				<div class="col-7 align-self-center">
					<h4 class="page-title text-truncate text-dark font-weight-medium mb-1">{{isset($jurnal) ? 'Edit Existing' : 'Add New'}} Jurnal</h4>
						<div class="d-flex align-items-center">
								<nav aria-label="breadcrumb">
										<ol class="breadcrumb m-0 p-0">
												<li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
												<li class="breadcrumb-item"><a href="{{route('jurnals.index')}}" class="text-muted">Jurnal</a></li>
												<li class="breadcrumb-item text-muted active" aria-current="page">{{isset($jurnal) ? 'Edit' : 'Add'}} Jurnal</li>
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
						action="{{ isset($jurnal) ? route('jurnals.update', $jurnal['id']) : route('jurnals.store') }}">
						@csrf
						@if(isset($jurnal))
						@method('PUT')
						@endif
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<div class="card">
							<div class="card-header">
							 <h4 class="page-title text-dark">Jurnal</h4> 
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<h4 class="text-dark">Basic Information (Required)</h4>
										<hr>
										<div class="row">
											<div class="col-6">
												<div class="form-group">
													<label for="transaction_no">Transaction No</label>
													<input type="number" class="form-control @error('transaction_no') is-invalid @enderror" id="transaction_no" name="transaction_no" value="{{ isset($jurnal) ? $jurnal['transaction_no'] : old('transaction_no') }}" autocomplete="off">
													@error('transaction_no')
													<div class="invalid-feedback">
														{{ $message }}
													</div>
													@enderror
												</div>
											</div>
											<div class="col-6">
												<div class="form-group">
													<label for="transaction_date">Transaction Date</label>
													<input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date" name="transaction_date" value="{{ isset($jurnal) ? $jurnal['transaction_date'] : old('transaction_date') }}" required>
													@error('transaction_date')
													<div class="invalid-feedback">
														{{ $message }}
													</div>
													@enderror
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card mt-4">
							<div class="card-header d-flex flex-row justify-content-between align-items-center">
							 <h4 class="page-title text-dark">Details</h4>
							 <button type="button" class="btn btn-warning btn-add-row mt-2">Add Row</button>
							</div>
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
												<select class="form-control border-0 akun-select2 select2 @if(false) is-invalid @endif"
													id="akun_id_0"
													name="akuns[0][akun_id]">
												</select>
											</td>
											<td>
												<select class="form-control border-0 detail-select2 select2 @if(false) is-invalid @endif"
													id="description_0"
													name="akuns[0][description]">
												</select>
											</td>
											<td>
												<input class="form-control debit"
													type="number"
													min="0"
													value="0"
													id="debit_0"
													name="akuns[0][debit]"
													onchange="calculatePrice()"
													/>
											</td>
											<td>
												<input class="form-control credit"
													type="number"
													min="0"
													value="0"
													id="credit_0"
													name="akuns[0][credit]"
													onchange="calculatePrice()"
													/>
											</td>
											<td>
												<button class="btn btn-sm btn-clean btn-icon btn-delete-row"
													type="button"
													title="Delete">
													<p class="m-0 font-weight-bold">-</p>
												</button>
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
										<input type="text" class="form-control @error('total_debit') is-invalid @enderror" id="total_debit" name="total_debit"
										value="{{isset($jurnal) ? $jurnal['total_debit'] : (old('total_debit') ? old('total_debit') : 0) }}" readonly>
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
										<input type="text" class="form-control @error('total_credit') is-invalid @enderror" id="total_credit" name="total_credit"
										value="{{isset($jurnal) ? $jurnal['total_credit'] : (old('total_credit') ? old('total_credit') : 0) }}" readonly>
										@error('total_credit')
										<div class="invalid-feedback">
											{{ $message }}
										</div>
										@enderror
									</div>
								</div>
							</div>
							<hr>
							<div class="d-flex align-items-center">
								<a href="{{ route('purchases.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
								<button type="submit" class="btn btn-primary btn-rounded">Submit</button>
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
		function deleteRow(event) {
			if($("#product_table tr").length === 2) {
				alert("You cannot delete the last row!");
				return;
			}
			$(event.target).closest("tr").remove();
			calculatePrice();
		}
		
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
			let newSelect2Detail = newRow.find("select.detail-select2");
			newSelect2Detail.attr("id", "description_"+curRowNum)
				.attr("name", "akuns["+curRowNum+"][description]")
				.removeClass("select2-hidden-accessible")
				.attr("data-select2-id", null)
				.attr("tabindex", null)
				.attr("aria-hidden", null)
				.empty()
				.clone();
			newRow.find("td:nth-child(2)").first().html(newSelect2);
			newRow.find("td:nth-child(3)").html(newSelect2Detail);
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

				newSelect2Detail.select2({
					placeholder: "Search for Detail",
					ajax: {
						url: "{{ route('purchase-select') }}",
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
					escapeMarkup: function(markup) {
						return markup;
					},
					minimumInputLength: 1,
					templateResult: formatDetail,
					templateSelection: formatDetailSelection,
					tags: true,
					createTag: function(params) {
						if(params.term == parseInt(params.term)) {
							return null;
						}
						return {
							id: params.term,
							text: params.term,
						};
					},
				});
			
			if(data !== null && data.name && data.id) {
				oldRow.find("select.select2").append(
						new Option(
							data.name,
							data.id,
							false,
							false,
						)
					)
				.trigger('change');
				// newRow.find("td:nth-child(4)").append("# "+data);
				// console.log("have data, will need to update rows", data);
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
			$(".btn-delete-row").prop("onclick", null).off("click");
			$(".btn-delete-row").on('click', deleteRow);
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

		$("#description_0").select2({
			placeholder: "Search for Detail",
			ajax: {
				url: "{{ route('purchase-select') }}",
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
			escapeMarkup: function(markup) {
				return markup;
			},
			minimumInputLength: 1,
			templateResult: formatDetail,
			templateSelection: formatDetailSelection,
			tags: true,
			createTag: function(params) {
				if(params.term == parseInt(params.term)) {
					return null;
				}
				return {
					id: params.term,
					text: params.term,
				};
			},
		});

		$(".btn-delete-row").on('click', deleteRow);
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