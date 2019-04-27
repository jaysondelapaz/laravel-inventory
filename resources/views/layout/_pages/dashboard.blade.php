@extends('layout.app')
@section('content')

<div class="row">
 <section class="content-header" style="margin-bottom: 1em;">
      <h4>
        Dashboard and Statistics <br />
        <small>Quick Overview of Inventory</small>
      </h4>
  </section>
</div> 


<div class="row">

        <div class="col-lg-4 col-xs-6 col-sm-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$total_in_stocks}}</h3>

              <p>Overall Total Stocks</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('Backend.inventory.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$total_stockins}}</h3>

              <p>Total Stock in Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('Backend.stockin.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      
        <div class="col-lg-4 col-md-4  col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$total_stockout}}</h3>

              <p>Total Stock out Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{route('Backend.stockout.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
</div>
  <!-- /.row -->

<div class="row">
  <div class="col-md-8">
    
    <!-- BAR CHART -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Monthly Recap Report</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body chart-responsive">
        <div class="chart" id="bar-chart" style="height: 300px;"></div>
      </div>
     

    <div class="box-footer">
      <div class="row">
                <div class="col-sm-4 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-aqua"><i class="fa fa-caret-up"></i> {{$total_in_stocks}}</span>
                    <h5 class="description-header"></h5>
                    <span class="description-text">CURRENT STOCKS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
               
                <div class="col-sm-4 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> {{$total_stockin}}</span>
                    <h5 class="description-header"></h5>
                    <span class="description-text">TOTAL STOCK IN</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> {{$total_stock_out}}</span>
                    <h5 class="description-header"></h5>
                    <span class="description-text">TOTAL STOCK OUT</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
    </div> <!--end of box-footer-->

    </div>
    <!-- /.box -->

    
  </div> <!--End of col md 8-->
  <!-- /.col (RIGHT) -->
  <div class="col-md-4">
    <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recently Added Products</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


              <ul class="products-list product-list-in-box">
                @if($Products->count() > 0)
                @foreach($Products as $index => $products)
                  <li class="item">
                  <div class="product-img">
                    <img src="ns/dist/img/product.png" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">{{$products->productname}}
                      <span class="label label-warning pull-right">Php {{Helper::Amount($products->price)}}</span></a>
                    
                    <span class="product-description">
                          ({{$products->name}})
                        </span>
                  </div>
                </li>
                <!-- /.item -->
                @endforeach
                @else
            
                <div style="text-align:center;color:orange;">No products added yet.</div>                
                @endif

              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="{{route('Backend.product.index')}}" class="uppercase">View All Products</a>
            </div>
            <!-- /.box-footer -->
  </div><!--end of col-md 4-->
</div>
<!-- /.row -->
@stop
<!-- jQuery 3 -->
<script src="ns/bower_components/jquery/dist/jquery.min.js"></script>
  <script>
  var array_1 = <?php echo json_encode($january, JSON_PRETTY_PRINT); ?>;
  var array_2 = <?php echo json_encode($february, JSON_PRETTY_PRINT); ?>;
  var array_3 = <?php echo json_encode($march, JSON_PRETTY_PRINT); ?>;
  var array_4 = <?php echo json_encode($april, JSON_PRETTY_PRINT); ?>;
  var array_5 = <?php echo json_encode($may, JSON_PRETTY_PRINT); ?>;
  var array_6 = <?php echo json_encode($june, JSON_PRETTY_PRINT); ?>;
  var array_7 = <?php echo json_encode($july, JSON_PRETTY_PRINT); ?>;
  var array_8 = <?php echo json_encode($august, JSON_PRETTY_PRINT); ?>;
  var array_9 = <?php echo json_encode($september, JSON_PRETTY_PRINT); ?>;
  var array_10 = <?php echo json_encode($october, JSON_PRETTY_PRINT); ?>;
  var array_11 = <?php echo json_encode($november, JSON_PRETTY_PRINT); ?>;
  var array_12 = <?php echo json_encode($december, JSON_PRETTY_PRINT); ?>;
  
  $(function () {
    //"use strict";
   //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
        {y: 'January',  a: array_1.a, b: array_1.b, c: array_1.c},
        {y: 'February', a: array_2.a, b: array_2.b, c: array_2.c},
        {y: 'March',    a: array_3.a, b: array_3.b, c: array_3.c},
        {y: 'April',    a: array_4.a, b: array_4.b, c: array_4.c},
        {y: 'May',      a: array_5.a, b: array_5.b, c: array_5.c},
        {y: 'June',     a: array_6.a, b: array_6.b, c: array_6.c},
        {y: 'July',     a: array_7.a, b: array_7.b, c: array_7.c},
        {y: 'August',   a: array_8.a, b: array_8.b, c: array_8.c},
        {y: 'September',a: array_9.a, b: array_9.b, c: array_9.c},
        {y: 'October',  a: array_10.a, b: array_10.b, c: array_10.c},
        {y: 'November', a: array_11.a, b: array_11.b, c: array_11.c},
        {y: 'December', a: array_12.a, b: array_12.b, c: array_12.c}
      ],
      barColors: ['#00c0ef','#00a65a', '#dd4b39'],
      xkey: 'y',
      ykeys: ['a', 'b','c'],
      labels: ['CurrentStocks', 'StockIn','StockOut'],
      hideHover: 'auto'
    });
  });
</script>
