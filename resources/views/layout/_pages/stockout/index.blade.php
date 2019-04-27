@extends('layout.app')
@section('content')

<ol class="breadcrumb" >
	<li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
	<li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>

<div class="row">
	<div class="col-md-5 pull-left" style="margin-bottom:10px;"><h4>All Stock Out <br />
	<small>Record data of all stock out of your products in your web application.</small>
	</h4>
	</div>
	<div class="col-md-3 pull-left">
		@if(session()->has('msg_error'))
		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon fa fa-ban"></i> {{session()->get('msg_error')}}
		</div>
		@endif
		@if(session()->has('success_msg'))
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon fa fa-check"></i> {{session()->get('success_msg')}}
		</div>
		@endif
	</div>
	<div class="col-md-4 pull-right">
		<a href="{{route('Backend.stockout.create')}}" class="btn btn default pull-right" style="border:1px solid green;color:green;">+ Add new</a>
	</div>
</div> <!--end of row-->

<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Record Data</h3>
			</div>
			<hr>
			<div class="box-body">
				<table id="stockout_tbl" class="table stockout_tbl" width="100%">
					<thead>
						<tr>
							<th>Transaction Code</th>
							<th>Total Qty</th>
							<th >Status</th>
							<th>Encoder</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($stockouts as $index => $stockout)
						<tr>
							<td>{{$stockout->code}}</td>
							<td>{{$stockout->total_qty}}</td>
							<td>{{$stockout->status}}</td>
							<td>
								<div>
									<small>Encoded By : <i><strong>{{$stockout->encoder ? $stockout->encoder->username : "unknown"}}</strong></i></small>
								</div>
								@if($stockout->status != "draft")
									<div>
										<small>{{$stockout->status == 'posted' ? "Approved" : "Cancelled"}} By : 
										<i><strong> {{$stockout->admin ? $stockout->admin->username : "Unknown"}}</strong></i>
										</small>
									</div>
								@endif
							</td>
							<td>
								<div class="input-group margin">
									<div class="input-group-btn">

										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
										<span class="fa fa-caret-down"></span></button>
										<ul class="dropdown-menu">
											<li><a class="" href="{{route('Backend.stockout.edit',[$stockout->id])}}">View details</a></li>
											<li><a class="dropdown-item" href="{{route('Backend.stockout.pdf',[$stockout->id])}}" target="_blank">View PDF</a></li>
										@if($stockout->status == 'draft')	
											<li><a class="dropdown-item btn-approve" href="#" data-url="{{route('Backend.stockout.approve',[$stockout->id])}}">Approve and Post</a></li>
											<li><a class="dropdown-item btn-void" href="#" data-url="{{route('Backend.stockout.destroy',[$stockout->id])}}">Void transaction</a></li>
										@endif
											
											{{-- <li><a href="{{route('Backend.supplier.destroy',$Supplier_list->id)}}">Delete</a></li> --}}
										</ul>
									</div>
							</td>
						</tr>
						@endforeach
					</tbody>

					<tfoot>
						<tr>
							<th>Transaction Code</th>
							<th>Total Qty</th>
							<th >Status</th>
							<th>Encoder</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div><!--End of box body-->
		</div><!--End of box-->		
	</div> <!--End of col-md-12 -->
</div> <!--End of row-->
@stop


<script src="ns/bower_components/jquery/dist/jquery.min.js"></script>
<script src="ns/sweetalert/dist/sweetalert2.all.js"></script>
<link rel="stylesheet" href="ns/sweetalert/dist/sweetalert2.min.css">

<script>
$(document).ready(function(){
	$(".stockout_tbl").DataTable({		
		"scrollX":true,
		"scrollY":true
	});


	$(".stockout_tbl").delegate('.btn-approve','click', function(){
     var url = $(this).data('url');

     Swal({
         title: 'Are you sure?',
         text: 'This will be remove to actual inventory',
         type: 'warning',
         showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonColor: '#00a65a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Approve and Post'
              }).then((result) => {
                if (result.value) {
                  Swal(
                    'Success',
                    'Product added to actual inventory.',
                    'success'    
                  )
                   window.location.href= url;
                }
              })
  });

	$(".stockout_tbl").delegate('.btn-void','click', function(){
    var url = $(this).data('url');
    Swal({
      title: "Are you sure?",
      text: "You will no be able to undo this transaction?",
      type: "warning",
      showCancelButton: true,
      allowOutsideClick: false,
                  confirmButtonColor: '#00a65a',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, void it!'
    }).then((result)=>{
      if(result.value){
        Swal(
          'Success',
          'Transaction has been cancelled',
          'success'
          )
        window.location.href=url;
      }
    })
  });

});	
</script>