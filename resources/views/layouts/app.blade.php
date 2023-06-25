<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel Starter</title>


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
	


   @yield('script_before')
  <!-- jQuery -->
<script src="{{asset('jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>
<script src="{{asset('modal_window/modal_window.js')}}"></script>
<script src="{{asset('js/tablefilter.js')}}"></script>
<script src="{{asset('js/function.js')}}"></script>
<script src="{{asset('js/multi_select.js')}}"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('layouts.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{date('Y')}} <a href="https://sait.com">Sait</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@yield('script')
<script>
  function  showNotification(message,type='success',second = 5)
  {
    Swal.fire({
      icon: type, // Set the icon to 'success'
      title: message,
      toast: true,
      position: 'top-end', // Display the toast at the top-right position
      showConfirmButton: false,
      timer: second * 1000,
      willOpen: () => {
        console.log('Modal will open'); // Perform actions before the modal opens
      },
      didOpen: () => {
        console.log('Modal is open'); // Perform actions after the modal opens
      },
      willClose: () => {
        //error();
      },
      didClose: () => {
        console.log('Modal is closed'); // Perform actions after the modal closes
      }
    });
  }
var operation_success_msg=new Array (22);
operation_success_msg[0]="Data is Saved Successfully";
operation_success_msg[1]="Data is Updated Successfully";
operation_success_msg[2]="Data is Deleted Successfully";
operation_success_msg[3]="Report is Generated Successfully";
operation_success_msg[4]="List View is Populated Successfully";

operation_success_msg[5]="Data is not Saved Successfully";
operation_success_msg[6]="Data is not Updated Successfully";
operation_success_msg[7]="Data is not Deleted Successfully";
operation_success_msg[8]="Report is not Generated Successfully";
operation_success_msg[9]="List View is not Populated Successfully";
operation_success_msg[10]="Invalid Operation";
operation_success_msg[11]="Duplicate Data Found, Please check again.";
operation_success_msg[12]="Old Password not Matching, Please check again.";
operation_success_msg[13]="Delete restricted, This Information is used in another Table.";
operation_success_msg[14]="Update restricted, This Information is used in another Table.";
operation_success_msg[15]="Database is Busy, Please wait...";
operation_success_msg[16]="This Information is already Approved. So You can't change it.";
operation_success_msg[17]="Issue Qnty Exceeds Stock Qnty.";
operation_success_msg[18]="Data is Populated Successfully";
operation_success_msg[19]="Data is Approved Successfully";
operation_success_msg[20]="Data is Un-Approved Successfully";
operation_success_msg[21]="Data is not Approved Successfully";
operation_success_msg[22]="Data is not Un-Approved Successfully";
operation_success_msg[23]="Overlapping Not Allowed, Please Check agian";
operation_success_msg[24]="Image Add is Required, Please Save The Image First.";
operation_success_msg[25]="Total input quantity over the total cut quantity not allowed.";
operation_success_msg[26]="Total output quantity over the total sewing input quantity not allowed.";
operation_success_msg[27]="Total iron quantity over the total sewing output quantity not allowed.";
operation_success_msg[28]="Total finishing quantity over the total iron quantity not allowed.";
operation_success_msg[29]="Total inspection quantity over the total finishing quantity not allowed.";
operation_success_msg[30]="Total garments quantity over the total inspection quantity not allowed.";
operation_success_msg[31]="Entry quantity can not exceed balance or total quantity.";
operation_success_msg[32]="Data is  Acknowledged Successfully";
operation_success_msg[33]="Data is Un-Acknowledged Successfully";
operation_success_msg[34]="Data is Not Acknowledged Successfully";
operation_success_msg[35]="Data is Not Un-Acknowledged Successfully";
operation_success_msg[36]="Copy Successfully";
</script>
</body>
</html>
