<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <!-- Bootstrap CSS -->
    @include('member.include.css')

    @yield('pagecss')
    
    <title>Stockmarket</title>
</head>

<body>
    <div class="preloader" id="preloader" style="display: none;">
        <div class="cssload-loader">
            <div class="cssload-inner cssload-one"></div>
            <div class="cssload-inner cssload-two"></div>
            <div class="cssload-inner cssload-three"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        {{-- {{ dd(session()->has('member_id')) }} --}}
        @if(session()->has('member_id'))
            @include('member.include.header')
        @endif
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        @if(session()->has('member_id'))
            @include('member.include.sidebar')
        @endif
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->

    @yield('popup_modal')


    @include('member.include.js')

    @yield('pagescript')
</body>
 
</html>