@extends('layouts.master')

@section('content')

<div class="dashboard-wrapper">
    <div class="influence-profile">
        <div class="container-fluid dashboard-content">
            <!-- ============================================================== -->
            <!-- pageheader -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Help Center</h2>
                        {{-- <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p> --}}
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Help Center</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0">How may i help you ?</h4>
                                </div>
                                <div class="card-body">
                                    <div id="alert_message"></div>
                                    <form id="help_center_form" action="{{ route('help_center_process') }}" class="needs-validation">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <input type="text" autocomplete="off" name="subject" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <div class="form-group">
                                                    <label>Message</label>
                                                    <textarea name="message" autocomplete="off" class="form-control" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end pricing - two  -->
            <!-- ============================================================== -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end content -->
    <!-- ============================================================== -->
    @include('member.include.footer')
    <!-- ============================================================== -->
    <!-- end footer -->
    <!-- ============================================================== -->
</div>
@endsection
@section('pagescript')
<script type="text/javascript">
    $("#help_center_form").validate({
        rules: {
            subject:{
                required:true
            },
            message:{
                required:true
            }
        },
        submitHandler: function(form) {
            var form_data = JSON.stringify($(form).serializeArray());
            $('#preloader').fadeIn();
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: JSON.parse(form_data),
                success: response => {
                    console.log(response);$('#preloader').fadeOut();
                    if (response.status == true) {
                        notify_success(response.message);
                        setTimeout(()=>window.location.href = response.redirect_url,2000);
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