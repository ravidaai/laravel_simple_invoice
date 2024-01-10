<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Invoice</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<base href="{{ asset('/') }}">
	<link rel="stylesheet" href="assets/admin/invoice/style.css">
	<style>
	</style>
</head>

<body>
	<div class="header">
		@foreach(optional($info->company)->branches as $key => $branch)
		<address class="address-{{ ++$key }}">
			<p>{{ optional($info->company)->name }}</p>
			<p>{{ $branch->address_one }} </p>
			<p>{{ optional($branch->city)->name }} {{ $branch->postal_code }} </p>
			<p>{{ optional($branch->country)->name }} </p>
		</address>
		@endforeach
		<span><img alt="" width="85" height="91" src="{{ asset('uploads/companies/'.optional($info->company)->logo) }}"></span>
	</div>
	<h5>
		Tax Registration Number {{ optional($info->company)->tax_number }}
	</h5>
	<div class="article">
		<address>
			<p>
				{{ optional($info->contact)->display_name }}
			</p>
			<p>
				{{ optional(optional($info->contact)->country)->name }}
			</p>
		</address>
		<table class="meta">
			<tr>
				<th><span>Invoice #</span></th>
				<td><span>CR-{{ $info->number }}</span></td>
			</tr>
			<tr>
				<th><span>Invoice Date</span></th>
				<td><span>{{ date("M d, Y",strtotime($info->invoice_date)) }}</span></td>
			</tr>
			<tr class="table-footer">
				<th><span>Balance Due</span></th>
				<td><span id="prefix"></span><span>{{ $info->total }}</span></td>
			</tr>
		</table>
		<table class="inventory">
			<thead>
				<tr>
					<th><span>Item</span></th>
					<th><span>Description</span></th>
					<th><span>Unit Cost</span></th>
					<th><span>Quantity</span></th>
					<th><span>Line Total</span></th>
				</tr>
			</thead>
			<tbody>
			@foreach($info->items as $row)
				<tr>
					<td><span>{{ optional($row->item)->name }}</span></td>
					<td><span>{{ $row->description }}</span></td>
					<td><span></span><span>{{ $row->price }}</span></td>
					<td><span>{{ $row->quantity }}</span></td>
					<td><span>{{ $row->total }}</span></td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<hr class="middle">
		<table class="balance">
			<tr>
				<th><span>Total Before Taxes</span></th>
				<td><span>{{ $info->subtotal - $info->tax }}</span></td>
				<td><span>{{ optional($info->currency)->sign }}</span></td>
			</tr>
			<tr>
				<th><span>Discount</span></th>
				<td><span>{{ $info->discount }}</span></td>
				<td><span>{{ optional($info->currency)->sign }}</span></td>
			</tr>
			<tr>
				<th><span>VAT ({{ $info->tax_percentage }}%)</span></th>
				<td><span>{{ $info->tax }}</span></td>
				<td><span>{{ optional($info->currency)->sign }}</span></td>
			</tr>
			<tr>
				<th><span>Amount Paid</span></th>
				<td><span>{{ optional($info->payments)->sum('amount') }}</span></td>
				<td><span>{{ optional($info->currency)->sign }}</span></td>
			</tr>
			<tr class="table-footer">
				<th><span>Balance Due</span></th>
				<td><span>{{ $info->total }}</span></td>
				<td><span>{{ optional($info->currency)->sign }}</span></td>
			</tr>
		</table>
	</div>
	<div>
		<div class="notes-block">
			<div class="terms-block">
				<p>Terms</p>
				{!! $info->terms !!}
			</div>
			<div class="bank-block">
				<table class="payment-table">
					@foreach(optional($info->company)->payments as $payment)
					<tr>
						<td>
							Payment
						</td>
						<td>
							{{ $payment->address }}
						</td>
					</tr>

					<tr>
						<td>
							Company Name
						</td>
						<td>
							{{ optional($info->company)->name }}
						</td>
					</tr>
					<tr>
						<td>
							Bank Name
						</td>
						<td>
							{{ $payment->name }}
						</td>
					</tr>
					<tr>
						<td>
							Iban
						</td>
						<td>
							{{ $payment->iban }}
						</td>
					</tr>
					<tr>
						<td>
							Swift Code
						</td>
						<td>
							{{ $payment->swift_code }}
						</td>
					</tr>
					<tr>
						<td colspan="2">
							&nbsp;
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	<hr class="bottom">
</body>

</html>