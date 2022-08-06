<!DOCTYPE html>
<html lang="en">
    <head>
        @include('website/include/metatitle')

        @include('website/include/css')
    </head>
    <body class="body-wrapper" data-spy="scroll" data-target=".privacy-nav">

        @include('website/include/navigationmenu')

        @yield('content')

        @include('website/include/footer')
        <!-- To Top -->
        <div class="scroll-top-to">
            <i class="ti-angle-up"></i>
        </div>
        <!-- JAVASCRIPTS -->
        @include('website/include/js')
    </body>
</html>