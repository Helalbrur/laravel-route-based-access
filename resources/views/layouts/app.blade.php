<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Laravel Stater {{ !empty($title) ?  '-' : '' }} {{ @$title }}</title>
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
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <<script>
        var sessionData = {!! json_encode([
        'data_arr' => session('laravel_stater.data_arr', []),
        'mandatory_field' => session('laravel_stater.mandatory_field', []),
        'mandatory_message' => session('laravel_stater.mandatory_message', []),
        ]) !!};
        //console.log(sessionData);
        </script>

        @yield('script_before')
</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
    <div id="boxes">
        <div id="dialog" class="window">
            <div id="msg" class="msg_header">
            </div>
            <div style="width:400;padding:20px; height:150px; vertical-align:middle">
                <img src="{{asset('images/Loading2.gif')}}" width="30" height="30" clear="all" style="vertical-align:middle;" /> <span id="msg_text" style="font-size:14px; color:#F00"> </span>
            </div>
        </div>
        <div id="mask"></div>
    </div>
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
                    
                    <div id="messagebox_main" class="row col-md-8 msgbox d-flex justify-content-center text-center" style="color: red; font-weight: bold; font-size: 15px;"></div>
                    <!-- start page title -->
                    @yield('content_header')
                    <!-- end page title -->
                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row g-0"> <!-- Added g-0 to remove gap -->
                        
                        <div class="col-sm-12 text-center">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © 
                            <span class="d-inline-block text-start">Designed & Developed by Sait</span>
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
                    <svg fill="#000000" viewBox="0 0 24 24" id="cross-circle" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <circle id="primary" cx="12" cy="12" r="10" style="fill: #ff0000;"></circle>
                            <path id="secondary" d="M13.41,12l2.3-2.29a1,1,0,0,0-1.42-1.42L12,10.59,9.71,8.29A1,1,0,0,0,8.29,9.71L10.59,12l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z" style="fill: #ffffff;"></path>
                        </g>
                    </svg>
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
    <script src="{{asset('js/select2.min.js')}}"></script>

    <script>
        

        // $(document).ready(function() {
        //     $('.select2').select2();
        // });
        $(document).ready(function() {
            $(".must_entry_caption").each(function(index) {
                var ht = " <font color='red'>" + $(this).html() + "</font>";
                $(this).html(ht);
                $(this).attr('title', 'Must Entry Field.');
            });
            $('.select2, select[id^="cbo"]').select2();
        });

        // $(document).on('DOMNodeInserted', function() {
        //     $('.select2, select[id^="cbo_"]').select2();
        // });

    </script>
    <!-- REQUIRED SCRIPTS -->
    @yield('script')
</body>

</html>