<!DOCTYPE html>
<html lang="en">

  @include('layout.include.header')

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('layout.include.nav')
  @include('layout.include.sidemenu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">    

   

   
    <section class="content">
     @yield('content')
    </section>
   
  </div>  <!-- /.content-wrapper -->
 

  @include('layout.include.footer')
  @include('layout.include.themesettings')
  
</div><!-- ./wrapper -->
  
  @include('layout.include.scripts')
</body>
</html>
