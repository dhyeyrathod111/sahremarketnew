@extends('layouts.master')

@section('pagecss')
    {{-- <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables/css/dataTables.bootstrap4.css') }}"> --}}
@endsection

@section('content')

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Stocks Assignment</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Stocks Assignment</a></li>
                                {{-- <li class="breadcrumb-item active" aria-current="page">Data Tables</li> --}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card col-md-10">
                    <h5 class="card-header">Stocks Assignment form</h5>
                    <div class="card-body">
                        <div id="alert_message"></div>
                        <form id="stock_assignment_form" action="{{ route('process_stock_assignment') }}"  method="POST" enctype="multipart/form-data" >
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label">File To Upload:</label>
                                <input type="file" name="master_data" class="form-control" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end basic table  -->
            <!-- ============================================================== -->
        </div>
        
    </div>
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    @include('member.include.footer')
    <!-- ============================================================== -->
    <!-- end footer -->
    <!-- ============================================================== -->
</div>

@endsection

@section('pagescript')
    <script type="text/javascript">
        $("#stock_assignment_form").validate({
            rules: {
                
            },
            submitHandler: function(form) {
                var form = $('#stock_assignment_form')[0];
                var form_data = new FormData(form);
                $('#preloader').fadeIn();
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    enctype: 'multipart/form-data',processData: false,contentType: false,cache: false,
                    data: form_data,
                    success: response => {
                        $('#preloader').fadeOut();
                        if (response.status == true) {
                            notify_success(response.message);
                            setTimeout(event => { 
                                window.location.href = response.redirect_url;
                            }, 2500);
                        } else {
                            notify_error(response.message);
                        }
                    },
                    error: response => {
                        $('#preloader').fadeOut();console.log(response);notify_error();
                    }
                });
            },
        });
    </script>
@endsection