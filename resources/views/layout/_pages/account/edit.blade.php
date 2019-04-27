@extends('layout.app')
@section('content')

<ol class="breadcrumb" >
  <li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
  <li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>

<div class="row">
   <div class="col-md-2 pull-left"  ><h4>Update Account</h4></div>

  <div class="col-md-4 pull-left">

    @if(session()->has('msg'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-check"></i> {{session()->get('msg')}}
    </div>
    @endif

  </div> <!--end of col-md 4-->

   <div class="col-md-6">
      <a class="btn btn default pull-right" style="color:green;border:1px solid green;" href="{{route('Backend.account.index')}}">All Records</a>
    </div>
  </div> <!-- end of row-->

  <div class="row">

   

    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Employee Details</h3>
        </div >
        <!-- /.box-header -->
        <!-- form start -->
        
     
        <form class="form-horizontal" method="post" action="{{route('Backend.account.update',[$user->id])}}" style="margin-top:20px;">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
              <label for="supplier" class="col-sm-2 control-label">Employee Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{old('name',$user->name)}}">
                @if($errors->has('name'))
                  <small class="text-danger"> {{$errors->first('name')}} </small> 
                @endif
              </div>
             </div>

            <div class="form-group">
              <label for="gender" class="col-sm-2 control-label">Gender</label>
              <div class="col-sm-10">
          {{Form::select('gender',$gender,old('gender',$user->gender),['class' =>"form-control",'gender'=>"gender"])}}
              </div>
            </div> 
      
      <div class="form-group">
          <label for="position" class="col-sm-2 control-label">Job Position</label>
        <div class="col-sm-10"> 
          {{Form::select('position',$positions,old('position',$user->position),['class' => "form-control",'id' => "position"])}}
          {{-- {!!Form::select('position',$positions,old('position',$user->position),['class' => "form-control",'id' => "position"])!!}
 --}}
          @if($errors->has('position'))
            <small class="text-danger">{{$errors->first('position')}}</small>
          @endif
        </div>
      </div>



          <div class="form-group">
            <label for="username" class="col-sm-2 control-label">username</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="username" id="username" value="{{old('username',$user->username)}}">
                @if($errors->has('username'))
                <small class="text-danger text-muted">{{$errors->first('username')}}</small>
              @endif
              </div>
          </div>


            <div class="form-group">
              <label for="Contact No" class="col-sm-2 control-label">Contact No</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Contact No." name="contact" id="contact" value="{{old('contact',$user->contact)}}">
                 @if($errors->has('contact'))
                <small class="text-danger text-muted">{{$errors->first('contact')}}</small>
              @endif
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="col-sm-2 control-label">password</label>
              <div class="col-sm-10">
                <input type="password" placeholder="User password" class="form-control" name="password" id="password">
                 @if($errors->has('password'))
                <small class="text-danger text-muted">{{$errors->first('password')}}</small>
              @endif
              </div>
            </div>

            <div class="form-group">
              <label for="confirmpassword" class="col-sm-2 control-label">Confirm password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" placeholder="Confirm password" name="password_confirmation" id="password" >
              </div>
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">    
            <button type="submit" class="btn btn-success" style="width:100px;margin-right:20px;">
            <i class="fa fa-check"></i> Save
            </button>
             <a href="{{route('Backend.account.index')}}" class="btn btn-default"><i class="fa fa-remove"></i> Cancel</a>
          </div>
          <!-- /.box-footer -->
        </form>
      </div>
      <!-- /.box -->
    </div>

</div><!--End of row-->
@stop