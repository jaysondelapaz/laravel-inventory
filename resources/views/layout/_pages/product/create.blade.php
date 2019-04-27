 @extends('layout.app')
@section('content')

{{--  <span>{{ucfirst(Helper::Currentdirectory())}}</span> <br /> --}}
<ol class="breadcrumb" >
  <li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
  <li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>

<div class="row"  >
  <div class="col-md-2 pull-left"  ><h4>Add new product</h4></div>

  <div class="col-md-4 pull-left">
    
    @if(count($errors)>0)
    
    @foreach($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-ban"></i>   {{$error}}
    </div>
    @endforeach    
    @endif

    @if(session()->has('msg'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-check"></i> {{session()->get('msg')}}
    </div>
    @endif

  </div> <!--end of col-md 4-->

   <div class="col-md-6">
      <a class="btn btn default pull-right" style="color:green;border:1px solid green;" href="{{route('Backend.product.index')}}">All Products</a>
    </div>
  </div> <!-- end of row-->

  <div class="row">

   

    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Product Details</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        
     
        <form class="form-horizontal" method="post" action="{{route('Backend.product.store')}}" style="margin-top:20px;">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
              <label for="supplier" class="col-sm-2 control-label">Supplier</label>
              <div class="col-sm-10">
              {{Form::select('supplier_id',$supplier,('supplier_id'), ['class'=>"form-control",'id'=>"supplier_id"])}}
              </div>
            </div>

            <div class="form-group">
              <label for="productname" class="col-sm-2 control-label">ProductName</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="productname" id="productname" placeholder="ProductName">
              </div>
            </div>
            <div class="form-group">
              <label for="productcost" class="col-sm-2 control-label">Product Cost</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" name="price" id="price" placeholder="0.00">
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success" style="width:100px;margin-right:20px;">
            <i class="fa fa-check"></i> Save
            </button>

            <a href="{{route('Backend.product.index')}}" class="btn btn-default"> <i class="fa fa-remove"></i>Cancel</a>
            
          </div>
          <!-- /.box-footer -->
        </form>
      </div>
      <!-- /.box -->
    </div>
  </div>
  @stop