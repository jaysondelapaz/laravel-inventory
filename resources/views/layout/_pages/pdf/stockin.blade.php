<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Stock In No. {{$header->code}}</title>

	<style>
		body{
			font-siza:12px;
		}
	</style>
</head>
<body>
	<table width="100%" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th>
				<div style="font-size:13px;">Encoder : <strong>{{$header->encoder ? $header->encoder->username: "Unknown"}}</strong> </div>
				<div style="font-size:13px;">
					@if($header->status !='draft')
					{{$header->status == 'posted' ? "Approved": "Cancelled"}} By : {{$header->admin ? $header->admin->username: "Unknown"}}
					@else
					<i style="font-size:12px;">Transaction On-going</i>
					@endif
				</div>
			</th>

			<th width="30%" style="border:1px solid #000;text-align:right;font-size:22px;padding:5px;"><strong>{{$header->code}}</strong></th>	
		</tr>

		<tr>
			<td></td>
		<td style="border:1px solid #000;text-align:right;font-size:12px;padding:5px;">({{strtoupper($header->status)}})</td>
		</tr>

		<tr>
			<td></td>
			<td style="text-align: right;font-size:10px;padding:5px;">Initial Date : {{$header->created_at}}</td>
		</tr>

		<tr>
			<td></td>
			<td style="text-align:right;font-size:10px;padding:5px;">Last Modified : {{$header->updated_at}}</td>
		</tr>
	</thead>
	</table>

	<hr>
	<p>Transaction details</p>

	<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr style="background-color:black;font-size:13px;color:white;border:">
				<th style="border-left:1px solid #000;padding:5px 8px;">Product</th>
				<th style="border-left:1px solid #fff;padding:5px 8px;">Supplier</th>
				<th width="10%" style="border-left:1px solid #fff;padding:5px 8px;text-align:center;">Qty</th>
				<th width="10%" style="border-left:1px solid #fff;padding:5px 8px;text-align:center;">Cost</th>
				<th width="15%" style="border-left:1px solid #fff;border-right:1px solid #000;padding:5px 8px;text-align:center;">Total Cost</th>
			</tr>
		</thead>

		<tbody>
			<?php $sum = 0; ?>
			@foreach($details as $index =>$detail)
			<tr style="font-size:13px;">
				<td style="border:1px solid #000;padding:7px 10px;">{{$detail->productname}}</td>
				<td style="border:1px solid #000;padding:7px 8px;"> {{$detail->suppliername}}</td>
				<td style="border:1px solid #000;padding:7px 8px;text-align:center;">{{$detail->qty}}</td>
				<td style="border:1px solid #000;padding:7px 8px;text-align:center;">{{Helper::Amount($detail->product ? $detail->product->price : "0.00")}}</td>
				<td style="border:1px solid #000;padding:5px 8px;text-align:center;">{{Helper::Amount($detail->product?$detail->product->price*$detail->qty : "0.00")}}</td>

				<?php $sum +=($detail->product? ($detail->product->price*$detail->qty) :0); ?>
			</tr>
			@endforeach
		</tbody>

		<tfoot>
			<tr style="background-color:black;font-size:13px;color:white;">
				<th style="padding:5px 8px;">Product</th>
				<th style="border-left:1px solid #fff;padding:5px 8px;">Supplier</th>
				<th width="10%" style="border-left:1px solid #fff;padding:5px 8px;text-align: center;">Qty</th>
				<th width="10%" style="border-left:1px solid #fff;padding:5px 8px;text-align: center;">Cost</th>
				<th width="15%" style="border-left:1px solid #fff;border-right:1px solid #000;padding:5px 8px;text-align: center;">Total Cost</th>
			</tr>
		</tfoot>
	</table>

	<br>
	<div style="font-size:13px;"> Summary of Transaction</div>
	<p style="font-size:13px;">Total Qty : <strong >{{$header->total_qty}}</strong></p>
	<p style="font-size:13px;">Overall Total : <strong>{{Helper::Amount($sum)}}</strong></p>
	<br />

	<p style="text-align:center;margin-top:40px;">End</p>
</body>
</html>