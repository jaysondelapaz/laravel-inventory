<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Physical Inventory as of Today {{Helper::date_format(Carbon::now()->toDayDateTimeString())}}</title>
	<style>
		body{
			font-siza:12px;
		}
	</style>

</head>
<body>

	<table width="100%" cellpadding="0" cellspacing="0">
	<thead><tr>
			<th>
				<div style="font-size:13px;">Generated By : <strong>{{Auth::user()->name}}</strong> </div>
			</th>

			<th width="30%" style="border:1px solid #000;text-align:right;font-size:22px;padding:5px;"><strong>
			PHYSICAL INVENTORY</strong>
			</th>	
		</tr>

		<tr>
			<th></th>
			<td width="30%" style="border:1px solid #000;text-align: right;font-size:12px;padding:5px;">({{strtoupper("UPDATED")}})</td>
		</tr>

		<tr>
			<th></th>
			<th widht="30%" style="color:#333;font-size:10px;padding:5px;text-align:right;">Generation date : {{Helper::date_format(Carbon::now(),"Y-m-d h:i:s")}} </th>
		</tr>
		</thead>
	</table>

	
<hr>
<p>Physical Inventory Details</p>
	<table width="100%" cellspacing="0" cellpadding="0">
		<thead>
			<tr  style="background-color:black;font-size:13px;color:white;border:">
				<th style="border-left:1px solid #000;padding:5px 8px;">Product</th>
				<th style="border-left:1px solid #fff;padding:5px 8px;">Supplier</th>
				<th width="10%" style="border-left:1px solid #fff;padding:5px 8px;text-align:center;">Qty</th>
				<th width="10%" style="border-left:1px solid #fff;padding:5px 8px;text-align:center;">Cost</th>
				<th width="15%" style="border-left:1px solid #fff;border-right:1px solid #000;padding:5px 8px;text-align:center;">Total Cost</th>
			</tr>
		</thead>

		<tbody>
			<?php 
			$sum = 0; 
			$sum_qty = 0;
			?>
			@foreach($stocks as $index => $stock)
			<tr style="font-size:13px;">
				<td style="border:1px solid #000;padding:7px 10px;">{{$stock->productname}}</td>
				<td style="border:1px solid #000;padding:7px 8px;">{{$stock->suppliername}}</td>
				<td style="border:1px solid #000;padding:7px 8px;text-align:center;">{{$stock->qty}}</td>
				<td style="border:1px solid #000;padding:7px 8px;text-align:center;">{{Helper::Amount($stock->product ? $stock->product->price : "0")}}</td>
				<td style="border:1px solid #000;padding:5px 8px;text-align:center;">{{Helper::Amount($stock->product ? $stock->product->price * $stock->qty : 0)}}
				</td>
				<?php $sum +=($stock->product ? $stock->qty*$stock->product->price : 0); $sum_qty +=$stock->qty ?>
			</tr>
			@endforeach
		</tbody>

		<tfoot>
			<tr  style="background-color:black;font-size:13px;color:white;border:">
				<th style="border-left:1px solid #000;padding:5px 8px;">Product</th>
				<th style="border-left:1px solid #fff;padding:5px 8px;">Supplier</th>
				<th width="10%" style="border-left:1px solid #fff;padding:5px 8px;text-align:center;">Qty</th>
				<th width="10%" style="border-left:1px solid #fff;padding:5px 8px;text-align:center;">Cost</th>
				<th width="15%" style="border-left:1px solid #fff;border-right:1px solid #000;padding:5px 8px;text-align:center;">Total Cost</th>
			</tr>
		</tfoot>
	</table>
	<br />
	<div style="font-size:13px;">Total Inventory as of {{Helper::date_format(Carbon::now()->toDayDateTimeString())}} </div>
	<p style="font-size:13px;">Total Qty : <strong> {{$sum_qty}} </strong>
	<p style="font-size:13px;">Overall Total : <strong> {{Helper::Amount($sum)}} </strong></p>
	<br />

	<center>End</center>
	
</body>
</html>