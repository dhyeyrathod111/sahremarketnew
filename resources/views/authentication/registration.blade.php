@extends('layouts.master')

@section('content')

<div class="splash-container">
    <div class="card ">
        <div class="card-header text-center"><a href="{{ route('registration') }}"><img class="logo-img" src="{{ asset('public/assets/images/logo.png') }}" alt="logo"></a><span class="splash-description">Please enter your user information.</span></div>
        <div class="card-body">
            <div id="alert_message"></div>
            <form id="genrate_otp" method="POST" action="{{ route('genrate_otp') }}">
                @csrf
                <div class="form-group">
                    <input class="form-control form-control-lg" required type="text" name="firstname" placeholder="First name" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="lastname" placeholder="Last name" autocomplete="off" required="">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="email" placeholder="Email ID" autocomplete="off" required="">
                </div>
                <div class="form-group">
                    <input autocomplete="off" class="form-control form-control-lg" name="password" id="password" type="password" placeholder="Password" required="">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="number" id="contact" name="contact" placeholder="Contact Number" autocomplete="off" required="">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="reference_id" placeholder="Reference ID" autocomplete="off" {{ request()->segment(3) ? 'readonly' : '' }} value="{{ request()->segment(3) }}" required="">
                </div>
                <div class="from-group">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox">
                        <span class="custom-control-label"><a href="{{ route('termsandconditions') }}">Agree to terms and conditions</a></span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Sign up</button>
            </form>
        </div>
        <div class="card-footer bg-white p-0  ">
            <div class="card-footer-item card-footer-item-bordered">
                <a href="{{ route('login') }}" class="footer-link">Login</a></div>
            <div class="card-footer-item card-footer-item-bordered">
                <a href="{{ route('forgot_password_form') }}" class="footer-link">Forgot Password</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('popup_modal')
    <div class="modal fade" id="otp_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enter OTP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert_message"></div>
                    <form id="otp_from" method="POST" action="{{ route('registration_process') }}">
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('pagescript')
    <script type="text/javascript">

        $("#otp_from").validate({
            rules: {
                
            },
            submitHandler: function(form) {
                var form_data = $('#genrate_otp').serializeArray();
                form_data.push({
                    name:"otp",value:$('#otp').val()
                });
                $('#preloader').fadeIn();
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data:form_data,
                    success: response => {
                        if (response.status == true) { 
                            notify_success(response.message);
                            $('#preloader').fadeOut();$('#otp_modal').modal('hide');
                            setTimeout(()=>window.location.href = response.redirect_url,200);
                        } else {
                            notify_error(response.message);
                            $('#preloader').fadeOut();$('#otp_modal').modal('hide');
                        }
                    },
                    error: response => {
                        $('#preloader').fadeOut();console.log(response);notify_error();
                    }
                });
                
            },
        });

        $("#genrate_otp").validate({
            rules: {
                email:{
                    customEmail:true
                },
                contact:{
                    phoneUS:true
                }
            },
            submitHandler: function(form) {
                var form_data =  JSON.stringify($(form).serializeArray());
                $('#preloader').fadeIn();
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: JSON.parse(form_data),
                    success: response => {
                        if (response.status == true) {
                            $('#preloader').fadeOut();$('#otp_from').html(response.otp_form_html_str);$('#otp_modal').modal('show');
                        } else {
                            notify_error(response.message);
                        }
                        $('#preloader').fadeOut();
                    },
                    error: response => {
                        $('#preloader').fadeOut();console.log(response);notify_error();
                    }
                });
            },
        });
    </script>
@endsection