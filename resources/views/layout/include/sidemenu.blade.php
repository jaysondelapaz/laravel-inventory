<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        {{--  <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image"> --}}
      </div>
      {{-- <center class="treeview"><i class="fa fa-circle text-success"></i> Online </center> --}}
       <center><a href="#"><i class="fa fa-circle text-success"></i> Online</a></center>
      {{--  <div class="pull-left info">
        <p>Alexander Pierce</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div> --}}
    </div>
    <!-- search form -->
    {{-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form> --}}
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      
      <center><li class="header"><a href="#"><strong>MASTERFILE</strong></a></li></center>
      
      <li {{ (Helper::is_active('dashboard')) ? "class=active treeview" : "class="}}>
        <a href="{{route('Backend.index')}}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      
      <li {{ (Helper::is_active('product')) ? "class=active treeview" : "class=treeview"}}>
        <a href="#">
          <i class="fa fa-barcode"></i>
          <span>Products</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li ><a href="{{route('Backend.product.index')}}"><i class="fa fa-circle-o"></i> All Products</a></li>
          <li><a href="{{route('Backend.product.create')}}"><i class="fa fa-circle-o"></i> Add New Product</a></li>
           {{-- <li><a href="{{route('Backend.product.trash')}}"><i class="fa fa-circle-o"></i> Trash</a></li> --}}
          {{Helper::trash(Auth::user()->position,'product')}}
          {{-- @if(Helper::trash(Auth::user()->position) === true)
            <li><a href="{{route('Backend.product.trash')}}"><i class="fa fa-circle-o"></i> Trash</a></li>
          @endif --}}
        </ul>
      </li>

       <li {{ (Helper::is_active('supplier')) ? "class=active treeview" : "class=treeview"}}>
        <a href="#">
          <i class="fa  fa-file-text-o"></i>
          <span>Supplier</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li ><a href="{{route('Backend.supplier.index')}}"><i class="fa fa-circle-o"></i> All Records</a></li>
          <li><a href="{{route('Backend.supplier.create')}}"><i class="fa fa-circle-o"></i> Add New Supplier</a></li> {{Helper::trash(Auth::user()->position,'supplier')}}
        </ul>
      </li>

  <center><li class="header"><a href="#"><strong>TRANSACTIONS</strong></a></li></center>


      <li {{ (Helper::is_active('inventory')) ? "class=active treeview" : "class="}}>
        <a href="{{route('Backend.inventory.index')}}">
          <i class="fa fa-home"></i> <span>Physical Inventory</span>
        </a>
      </li>


      <li class="treeview">
        <a href="#">
          <i class="fa  fa-area-chart"></i> <span>Stock In</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('Backend.stockin.index')}}"><i class="fa fa-circle-o"></i> All Transactions</a></li>
          <li><a href="{{route('Backend.stockin.create')}}"><i class="fa fa-circle-o"></i> Add new Stock in</a></li>
           {{Helper::trash(Auth::user()->position,'stockin')}}
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa  fa-area-chart"></i> <span>Stock Out</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('Backend.stockout.index')}}"><i class="fa fa-circle-o"></i> All Transactions</a></li>
          <li><a href="{{route('Backend.stockout.create')}}"><i class="fa fa-circle-o"></i> Add new Stock out</a></li> {{Helper::trash(Auth::user()->position,'stockout')}}
        </ul>
      </li>
      
       <center><li class="header"><a href="#"><strong>SYSTEM SETTINGS</strong></a></li></center>

       <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i> <span>Account Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('Backend.account.index')}}"> <i class="fa fa-circle-o"></i>All Accounts</a></li>
           <li><a href="{{route('Backend.account.create')}}"> <i class="fa fa-circle-o"></i>Add new Account</a></li>
            {{Helper::trash(Auth::user()->position,'account')}}
        </ul>
       </li>

      <li class="treeview" style="margin-top:20px;">
        <center><a href="{{route('Backend.logout')}}" ><i class="fa fa-power-off"></i> Sign out</a></center>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>