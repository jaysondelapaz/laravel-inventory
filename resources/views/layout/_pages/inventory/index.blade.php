@extends('layout.app')
@section('content')
<ol class="breadcrumb" >
	<li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
	<li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>

<div class="row">
	<div class="col-md-4 pull-left">
		<h4>All product stocks <br />
			<small>Record data of all product stocks in your web application.</small>	
	</h4></div>

  <div class="col-md-4 pull-left">
      @if(session()->has('success_msg'))
      <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-check"></i> {{session()->get('success_msg')}}
    </div>
    @endif

    @if(session()->has('error_msg'))
      <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-ban"></i>   {{session()->get('error_msg')}}
    </div>
    @endif
  </div>

  <div class="col-md-4 pull-right">
  
      <a href="{{route('Backend.inventory.pdf')}}" target="_blank" class="btn btn default pull-right" style="border:1px solid green;color:green;"><i class="fa fa-print"></i> Print Inventory</a>
  </div>
</div> <!--end of row-->

<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Record Data</h3>
			</div>
			<!-- /.box-header -->
			<hr>
			<div class="box-body">
				<div class="table-responsive">
					<table id="inventory_tbl" class="table table-striped" width="100%">
						<thead>
							<tr>
								<th>Product</th>
								<th>Supplier</th>
								<th>QTY</th>
								
							</tr>
						</thead>

						<tbody>
							@foreach($stocks as $index => $stock)
							<tr>
								<td>{{$stock->productname}}</td>
								<td>{{$stock->suppliername}}</td>
								<td>
									@if($stock->qty < 10)
									<strong style="color:red">{{$stock->qty}}</strong>
									<small><i>({{$stock->updated_at->diffForHumans()}})</i></small>
									@else
									<strong>{{$stock->qty}}</strong>
									<small><i>({{$stock->updated_at->diffForHumans()}})</i></small>
									@endif
								</td>	
							</tr>
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<th>Product</th>
								<th>Supplier</th>
								<th>QTY</th>
								
							</tr>
						</tfoot>
					</table>
				</div><!--end of table responsive-->
				
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</div>

@stop
<script src="ns/bower_components/jquery/dist/jquery.min.js"></script>
<script src="ns/sweetalert/dist/sweetalert2.all.js"></script>
<link rel="stylesheet" href="ns/sweetalert/dist/sweetalert2.min.css">

<script>
$(document).ready(function(){
    $('#inventory_tbl').DataTable({
     "scrollX":true,
    "scrollY":true
     
    });
});
</script>