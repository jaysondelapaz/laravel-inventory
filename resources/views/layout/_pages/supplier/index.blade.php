@extends('layout.app')
@section('content')
	<ol class="breadcrumb">
		<li> <a href="{{route('Backend.index')}}">Home</a></li>
		<li class="active"> {{ucfirst(Helper::Currentdirectory())}}</li>
	</ol>

	<div class="row">
			
		<div class="col-md-4 pull-left"><h4>Supplier <br />
		<small>Record data of all suppliers in your web application</small>
		</h4>
		</div>
		 <div class="col-md-4 pull-left">
	     	 @if(session()->has('msg'))
		      <div class="alert alert-success alert-dismissible">
		      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    	  <i class="icon fa fa-check"></i> {{session()->get('msg')}}
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
			<a href="{{route('Backend.supplier.create')}}" class="btn btn default pull-right" style="border:1px solid green;color:green;">+ Add new</a>
  		</div>

  		<div class="col-md-12">
  		<div class="box">	
			<div class="box-header">
				<h3 class="box-title">All Records</h3>

			</div>
			<hr>

			<div class="box-body">
				<table id="product_tbl" class="table">

					<thead>
						<tr>
							
							<th>Supplier Name</th>
							<th>Status</th>
							<th>Last Modified</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
						@foreach($suppliers as  $Supplier_list)
						<tr>
							
							<td><div>{{$Supplier_list->name}}</div><small>{{$Supplier_list->address}}</small></td>
							<td>
								<small class="label bg-{{$Supplier_list->status == "active" ? 'green' : 'red'}}">{{$Supplier_list->status}}
								</small>
							</td>
							<td>{{$Supplier_list->updated_at}}</td>
							<td>
								<div class="input-group">
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                            <span class="fa fa-caret-down"></span></button>
                          <ul class="dropdown-menu">
                            <li><a href="{{route('Backend.supplier.edit',[$Supplier_list->id])}}">Edit</a></li>
                            <li><a href="#" class="btn-delete" data-url="{{route('Backend.supplier.destroy',$Supplier_list->id)}}">Delete</a></li>
                            {{-- <li><a href="{{route('Backend.supplier.destroy',$Supplier_list->id)}}">Delete</a></li> --}}
                          </ul>
                        </div>
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfooter>
							<tr>
							
							<th>Supplier Name</th>
							<th>Status</th>
							<th>Last Modified</th>
							<th></th>
						</tr>
					</tfooter>
				</table>

			</div>
  		</div>
  	</div ><!--end of box-->
	</div>


@stop
<script src="{{asset('ns/dist/js/jquery1.js')}}"></script>
<script src="ns/sweetalert/dist/sweetalert2.all.js"></script>
<link rel="stylesheet" href="ns/sweetalert/dist/sweetalert2.min.css">
<script>
$(document).ready(function(){

    $('#product_tbl').DataTable({
      // 'paging'      : true,
      // 'lengthChange': true,
      // 'searching'   : true,
      // 'ordering'    : true,
      // 'info'        : true,
      // 'autoWidth'   : true
    });


    $('#product_tbl').delegate('.btn-delete','click', function(){
      var url =$(this).data('url');
     
          Swal({
                title: 'Are you sure?',
                text: "You won't be able to recover this record!",
                type: 'warning',
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonColor: '#00a65a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  Swal(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'    
                  )
                   window.location.href= url;
                }
               })
    });

  });
</script>