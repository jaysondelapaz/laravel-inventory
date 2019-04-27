@extends('layout.app')
@section('content')

<ol class="breadcrumb" >
  <li><a href="{{route('Backend.index')}}" style="color:red;">Home</a></li>
  <li class="active">{{ucfirst(Helper::Currentdirectory())}}  </li>
</ol>

<div class="row">


</div><!--End of row-->
@stop
