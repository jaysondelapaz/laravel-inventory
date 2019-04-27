@extends('layout.app')

@section('content')
<ol class="breadcrumb" >
	<li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
	<li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>
<div class="row">
<div class="col-md-4 pull-left"><h4>Transaction Details</h4>  <p class="text-muted mb-0">Details of the stock in</p></div>

<div class="col-md-4 pull-left">
          <!-- Allert message for StockInRequest Validation-->  
         @if(count($errors)>0)
            @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <i class="icon fa fa-ban"></i>   {{$error}}
            </div>
            @endforeach
         @endif

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
    
 </div> <!--end of col-md-4 -->
  		<div class="col-md-4 pull-left">
			<a href="{{route('Backend.stockin.index')}}" class="btn btn default pull-right" style="border:1px solid green;color:green;">+ All Transactions</a>
  		</div>
</div><!--End of row-->	

<div class="row">
	<div class="col-md-3">
		<div class="box box-primary">
			<div class="box-header with-border">
              <h3 class="box-title">Transaction Header</h3>
            </div>
         

            <div class="box-body">
            	<div class="form-group row">
            	   <label class="col-md-4 label-control" for="code">Code</label>
                   <span class="col-md-8" >{{$header->code}}</span>
            	</div>

            	<div class="form-group row">
                    <label class="col-md-4 label-controls" for="Encoder">Encoder</label>
                   <span class="col-md-8">{{$header->encoder->username}}</span>
                </div>

            	<div class="form-group row">
            		 <label class="col-md-4 label-control" for="Qty">Qty</label>
                   <span class="col-md-8">{{$header->total_qty}}</span>
            	</div>

            	<div class="form-group row">
            		 <label  class="col-md-4 pull-left" for="code">Status</label>
                   <span class="col-md-8">{{$header->status}}</span>
            	</div>

            	<hr>
              @if($header->status == 'draft' AND in_array(Auth::user()->position,['manager','administrator']))
            	<a href="#" class="btn btn-default pull-left btn-void" data-url="{{route('Backend.stockin.destroy',[$header->id])}}"><i class="icon fa fa-ban"></i> Void</a>
            	<a href="#" class="btn btn-success pull-right btn-approve" data-url="{{route('Backend.stockin.Approve',[$header->id])}}">Approve</a>
              @endif
              
              
              <a href="{{route('Backend.stockin.index')}}" class="btn btn-flat" style="margin-top:5px;color:green;">
                <i class="fa fa-long-arrow-left"></i>Return to all records
              </a>

        	</div>
		</div>
	</div> <!--end of col-md-3 -->

@if($header->status == 'draft')
<div class="col-md-8 col-md-offset-1">
  <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Stock In Form </h3>
        </div>

        <div class="box-body">

          <form class="form" method="post" action="{{route('Backend.stockin.Add-Product',[$header->id])}}">
            {{csrf_field()}}
            <div class="col-md-5">
              <div class="form-group">
                {{-- {{Form::select('product_id',$products,old('product_id'),['class'=>"form-control",'id'=>"product_id"])}} --}}

                {!!Form::select('product_id',$products,old('product_id'),['class' => "form-control",'id' => "product_id"])!!}
                
              </div>
            </div> <!--end of col-md-4-->
                  
            <div class="col-md-3 col-md-offset-1">
                <div class="form-group">
                  <input type="text" class="form-control" name="qty" placeholder="No. of Qty" value="{{old('qty')}}">
                </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <button type="submit" class="btn btn-success">Add Product</button>
              </div>
            </div>
          </form>
        </div> <!--end of box body-->
    

  </div><!--end of box primary-->
</div><!--end col-md-8-->
@endif

 <div class='col-md-8 col-md-offset-1'>
   <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Transaction Details </h3>
        </div>
        <div class="box-body">

       
          <table class="table stockin_tbl" id="stockin_tbl">
            <thead>
            <tr>
              <th>Product</th>
              <th>Supplier</th>
              <th>Qty</th>
              <th></th>
            </tr>
           </thead>
           
           <tbody>
            @foreach($details as $index => $detail)
             <tr>
               <td>{{$detail->productname}}</td>
              <td>{{$detail->suppliername}}</td>
              <td>{{$detail->qty}}</td>
              <td>
                <div class="input-group">
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                            <span class="fa fa-caret-down"></span></button>
                          <ul class="dropdown-menu">
                            <li><a class="btn_remove" href="#" data-url="{{route('Backend.stockin.remove_product',[$header->id,$detail->id])}}">Remove Product</a></li>
                          </ul>
                        </div>
                </div><!--end of input group-->  
              </td>
             </tr>
            @endforeach 
           </tbody> 

           <tfoot>
             <tr>
               <th>Product</th>
               <th>Supplier</th>
               <th>Qty</th>
             </tr>
           </tfoot>
          </table>
      
      </div><!--end of box body-->  
    </div><!--end of box-primary -->  
    </div> <!--end of col-md-8 -->    

</div><!--end of row-->
@stop

<script src="{{asset('ns/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('ns/sweetalert/dist/sweetalert2.all.js')}}"></script>
<link rel="stylesheet" href="{{asset('ns/sweetalert/dist/sweetalert2.min.css')}}">

<script>
$(document).ready(function(){
  $(".stockin_tbl").DataTable({

  });

  $(".btn-approve").on("click", function(){
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

  $(".btn-void").on('click', function(){
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

  $(".stockin_tbl").delegate('.btn_remove','click', function(){
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
