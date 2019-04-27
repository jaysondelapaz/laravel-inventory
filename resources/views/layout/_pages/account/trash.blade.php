@extends('layout.app')
@section('content')

<ol class="breadcrumb" >
  <li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
  <li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>

<div class="row">
	<div class="col-md-4 pull-left" style="margin-bottom:10px;"><h4>Trash</h4>
    <span>Record of all deleted users data in your web application.</span>
  </div>

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
  
      <a href="{{route('Backend.account.index')}}" class="btn btn default pull-right" style="border:1px solid green;color:green;">All active users</a>
  </div>


</div><!--end of row-->

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
              <table id="account_tbl" class="table table-striped account_tbl" width="100%">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Deleted On</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  
                  @foreach($trashed as $index => $trash)
                  <tr>
                    <td>{{$trash->id}}</td>
                    <td>{{$trash->name}}</td>
               		  <td>{{$trash->position}}</td>
                    <td><div>{{$trash->deleted_at}} </div>
                    	<small>Deleted by: (<i> <strong>{{$trash->encoder ? $trash->encoder->name : "Unknown"}}</strong></i>)</small>
                    </td>
                    <td>    
                      <div class="input-group">
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                            <span class="fa fa-caret-down"></span></button>
                          <ul class="dropdown-menu">
                            <li><a class="btn-restore" href="#" data-url="{{route('Backend.account.restore',[$trash->id])}}">restore</a></li>
                           

                          </ul>
                        </div>
                      </div><!--end of input group-->  
                    </td>
                  </tr>             
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Deleted On</th>
                  <th></th>
                </tr>
                </tfoot>
              </table>
            </div><!--end of table responsive-->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

</div><!--End of row-->
@stop
<script src="{{asset('ns/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('ns/sweetalert/dist/sweetalert2.all.js')}}"></script>
<link rel="stylesheet" href="{{asset('ns/sweetalert/dist/sweetalert2.min.css')}}">

<script>
$(document).ready(function(){

    $('.account_tbl').DataTable({
     "scrollX":true,
     "scrollY":true
    });

   

    $('.account_tbl').delegate('.btn-restore','click', function(){
      var url =$(this).data('url');
     
          Swal({
                title: 'Are you sure?',
                text: "You want to recover this record!",
                type: 'warning',
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonColor: '#00a65a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
              }).then((result) => {
                if (result.value) {
                  Swal(
                    'Success!',
                    'Your file has been restored.',
                    'success'    
                  )
                   window.location.href= url;
                }
              })
  
    });
});    

</script>    