@extends('layouts.master')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')

<div class="dashboard-wrapper">
    @include('member.include.banner')
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Stock</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Stock</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add new stock</li>
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
                    <h5 class="card-header">Stocks form</h5>
                    <div class="card-body">
                        <div id="alert_message"></div>
                        <form id="add_new_member" action="{{ route('process_stocks') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label">Name:</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Facevalue:</label>
                                <input type="number" name="facevalue" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Price:</label>
                                <input type="number" name="price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Quantity:</label>
                                <input type="number" name="quantity" class="form-control">
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
        $("#add_new_member").validate({
            rules: {
                // roundpay_otp:{
                //     pincode:true,
                // },
            },
            submitHandler: function(form) {
                var form_data = JSON.stringify($(form).serializeArray());
                $('#preloader').fadeIn();
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: JSON.parse(form_data),
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

