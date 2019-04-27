@extends('layout.app')
@section('content')
<ol class="breadcrumb" >
	<li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
	<li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>


<div class="row">
	<div class="col-md-4 pull-left" style="margin-bottom:10px;">
    <h4>All Products <br />
    <small>Record data of all products in your web application.</small>
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
  
      <a href="{{route('Backend.product.create')}}" class="btn btn default pull-right" style="border:1px solid green;color:green;">+ Add new</a>
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
              <table id="product_tbl" class="table table-striped product_tbl" width="100%">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Product Name</th>
                  <th>Cost</th>
                  <th>Status</th>
                  <th>Last Modified</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  
                  @foreach($All_products as $index => $ProductList)
                  <tr>
                    <td>{{$ProductList->id}}</td>
                    <td>
                      <div>{{$ProductList->productname}}</div>
                       <small style="font-style:italic;">({{$ProductList->fromsupplier ? $ProductList->fromsupplier->name:"-"}})</small>
                    </td>

                    <td>{{$ProductList->price}}</td>
                    <td><small class="label tag bg-{{$ProductList->status == "active" ? "green" : "red"}}">{{$ProductList->status}}</small></td>
                    <td>{{$ProductList->updated_at}}</td>
                    <td>    
                      <div class="input-group">
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                            <span class="fa fa-caret-down"></span></button>
                          <ul class="dropdown-menu">
                            <li><a href="{{route('Backend.product.edit',[$ProductList->id])}}">Edit</a></li>
                            <li><a class="btn-delete" data-url="{{route('Backend.product.destroy',[$ProductList->id])}}" href="#">Delete</a></li>

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
                  <th>Product Name</th>
                  <th>Cost</th>
                  <th>Status</th>
                  <th>Last Modified</th>
                  <th></th>
                </tr>
                </tr>
                </tfoot>
              </table>
            </div><!--end of table responsive-->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	</div>
</div>
@stop
{{-- <script src="{{asset('ns/dist/js/jquery1.js')}}"></script> --}}
<script src="ns/bower_components/jquery/dist/jquery.min.js"></script>
<script src="ns/sweetalert/dist/sweetalert2.all.js"></script>
<link rel="stylesheet" href="ns/sweetalert/dist/sweetalert2.min.css">
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.all.min.js"></script> --}}


<script>
$(document).ready(function(){

    $('.product_tbl').DataTable({
     "scrollX":true,
    "scrollY":true
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