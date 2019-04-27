@extends('layout.app')
@section('content')

<ol class="breadcrumb" >
  <li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
  <li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>


<div class="row">
	<div class="col-md-4 pull-left"><h4>All Accounts <br />
	<small>Record data of all user accounts in your web application.</small>
	</h4></div>
	
	<div class="col-md-4 pull-left">
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
		<a href="{{route('Backend.account.create')}}" class="btn btn default pull-right" style="border:1px solid green;color:green;">+ Add new</a>
	</div>
</div>

<div class="row">
<div class="col-md-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Record data</h3>
			</div>
			<hr>
			<div class="box-body">
				<table id="accounts_tbl" class="table accounts_tbl" width="100%">
					<thead>
						<tr>
							<th>AccountID</th>
							<th>Name</th>
							<th>Position</th>
							<th>Contact No.</th>
							<th>Gender</th>
							<th>Last Modified</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $index => $user)
						<tr>
							<td><small>{{"@".$user->username}}</small></td>
							<td>{{$user->name}}</td>
							<td>{{ucfirst($user->position)}}</td>
							<td>{{$user->contact}}</td>
							<td>{{ucfirst($user->gender)}}</td>
							<td>{{$user->updated_at}}</td>
							<td>
								<div class="input-group margin">
									<div class="input-group-btn">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
										<span class="fa fa-caret-down"></span></button>
										<ul class="dropdown-menu">
											<li><a class="" href="{{route('Backend.account.edit',[$user->id])}}">Edit</a></li>
											<li><a class="btn-delete" href="#" data-url="{{route('Backend.account.delete',[$user->id])}}">Delete</a></li>
										</ul>
									</div>
								</td>
							</tr>
						@endforeach					
							
						</tbody>
						<tfooter>
						<tr>
							<th>AccountID</th>
							<th>Name</th>
							<th >Position</th>
							<th>Contact No.</th>
							<th>Gender</th>
							<th>Last Modified</th>
							<th></th>
						</tr>
						</tfooter>
					</table>
				</div>
			</div>
			</div ><!--end of box-->
		</div>

</div>
@stop

<script src="ns/bower_components/jquery/dist/jquery.min.js"></script>
<script src="ns/sweetalert/dist/sweetalert2.all.js"></script>
<link rel="stylesheet" href="ns/sweetalert/dist/sweetalert2.min.css">

<script>
$(document).ready(function(){
	$(".accounts_tbl").DataTable({		
		"scrollX":true,
		"scrollY":true
	});


	$(".accounts_tbl").delegate('.btn-approve','click', function(){
		var url = $(this).data('url');

		Swal({
			title: 'Are you sure?',
	         text: 'This will be added to actual inventory',
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


	$(".accounts_tbl").delegate('.btn-delete','click', function(){
		var url = $(this).data('url');
		Swal({
			title: "Are you sure?",
			text: "You will not be able to undo this transaction?",
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
