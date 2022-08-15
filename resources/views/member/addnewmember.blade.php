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
                    <h2 class="pageheader-title">Members</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Member</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add new member</li>
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
                    <h5 class="card-header">Members form</h5>
                    <div class="card-body">
                        <div id="alert_message"></div>
                        <form id="add_new_member" action="{{ route('process_newmember') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label">First name:</label>
                                <input type="text" value="{{ !empty($post_mamber->firstname) ? $post_mamber->firstname : '' }}" name="firstname" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Last name:</label>
                                <input type="text" value="{{ !empty($post_mamber->lastname) ? $post_mamber->lastname : '' }}" name="lastname" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Email:</label>
                                <input type="email" value="{{ !empty($post_mamber->email) ? $post_mamber->email : '' }}" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Member Code:</label>
                                <input type="text" {{ !empty($post_mamber) ? 'readonly' : '' }} value="{{ !empty($post_mamber->member_code) ? $post_mamber->member_code : '' }}" name="member_code" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Proton Code:</label>
                                <input type="text" value="{{ !empty($post_mamber->password) ? $post_mamber->password : '' }}" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Contact:</label>
                                <input type="text" value="{{ !empty($post_mamber->contact) ? $post_mamber->contact : '' }}" name="contact" class="form-control">
                            </div>
                            @if(!empty($post_mamber))
                                <input type="hidden" value="{{ $post_mamber->id }}" name="member_id">
                            @endif
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
                member_code:{
                    required: true
                },
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

