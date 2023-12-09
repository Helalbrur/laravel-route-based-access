<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>{{ @$title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="{{ asset('skote/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('skote/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('skote/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        {{-- common style --}}
        <link rel="stylesheet" href="{{asset('css/style_common.css')}}">

        {{-- filtergrid style --}}
        <link rel="stylesheet" href="{{asset('css/filtergrid.css')}}">

        <link href="{{asset('sweetalert2/sweetalert2.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{asset('modal_window/modal_window.css')}}">
        <script src="{{asset('sweetalert2/sweetalert2.all.js')}}" type="text/javascript"></script>
        <!-- App js -->
        <script src="{{ asset('skote/assets/js/plugin.js') }}"></script>
        {{-- custom style --}}
        <link rel="stylesheet" href="{{asset('skote/assets/css/custom.css')}}">
        @yield('script_before')
    </head>

    <body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

          @include('layouts.navbar')
           

            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.left')
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                         <!-- start page title -->
                        {{-- @yield('content_header') --}}
                        <!-- end page title -->
                        @yield('content')
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © 
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by ..........
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="{{URL::asset('skote/assets/images/layouts/layout-1.jpg') }}" class="img-thumbnail" alt="layout images">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="{{URL::asset('skote/assets/images/layouts/layout-2.jpg') }}" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="{{URL::asset('skote/assets/images/layouts/layout-3.jpg') }}" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="{{URL::asset('skote/assets/images/layouts/layout-4.jpg') }}" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                        <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                    </div>

            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('skote/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('skote/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('skote/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('skote/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('skote/assets/libs/node-waves/waves.min.js') }}"></script>

        <script src="{{ asset('skote/assets/js/app.js') }}"></script>
        <script src="{{asset('modal_window/modal_window.js')}}"></script>
        <script src="{{asset('js/tablefilter.js')}}"></script>
        <script src="{{asset('js/function.js')}}"></script>
        <script src="{{asset('js/multi_select.js')}}"></script>

        <script>
          $(".must_entry_caption").each(function( index ) {
            var ht=" <font color='red'>"+$(this).html()+"</font>";
            $(this).html(ht);
            $(this).attr('title','Must Entry Field.');
          });
        
        </script>
        <!-- REQUIRED SCRIPTS -->
        @yield('script')
    </body>
</html>
