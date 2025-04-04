<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Popup</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('modal_window/modal_window.css')}}">
  
  {{-- common style --}}
  <link rel="stylesheet" href="{{asset('css/style_common.css')}}">

  {{-- filtergrid style --}}
   <link rel="stylesheet" href="{{asset('css/filtergrid.css')}}">

  <link href="{{asset('sweetalert2/sweetalert2.css')}}" rel="stylesheet" type="text/css" />
  <script src="{{asset('sweetalert2/sweetalert2.all.js')}}" type="text/javascript"></script>
  <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/flatpickr.min.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <div id="boxes">
      <div id="dialog" class="window">
          <div id="msg" class="msg_header">
          </div>
          <div style="width:400;padding:20px; height:150px; vertical-align:middle">
              <img src="{{asset('images/loading.gif')}}" width="20" height="20" clear="all" style="vertical-align:middle;" /> &nbsp; &nbsp;<span id="msg_text" style="font-size:14px; color:#ffffff"> </span>
          </div>
      </div>
      <div id="mask"></div>
  </div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @yield('content_header')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->




</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>
<script src="{{asset('modal_window/modal_window.js')}}"></script>
<script src="{{asset('js/tablefilter.js')}}"></script>
<script src="{{asset('js/function.js')}}"></script>

<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/flatpickr.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.select2, select[id^="cbo"]').select2();
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d",
            enableTime: false
        });
    });

    // $(document).on('DOMNodeInserted', function() {
    //     $('.select2, select[id^="cbo_"]').select2();
    // });
</script>
@yield('script')
</body>
</html>
