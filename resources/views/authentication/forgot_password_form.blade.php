@extends('layouts.master')

@section('content')

<div class="splash-container">
    <div class="card ">
        <div class="card-header text-center"><a href="{{ route('login') }}"><img class="logo-img" src="{{ asset('public/assets/images/logo.png') }}" alt="logo"></a><span class="splash-description">Please enter your user information.</span></div>
        <div class="card-body">
            <div id="alert_message"></div>
            @if(session()->has('message'))
                <div class="alert {{session('alert') ?? 'alert-info'}} text-center">
                    {{ session('message') }}
                </div>
             @endif
            <form method="POST" id="forgotpasswordform" action="{{ route('forgot_password_process') }}">
                @csrf
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="email" placeholder="Email ID" autocomplete="off" required="">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            </form>
        </div>
        <div class="card-footer bg-white p-0  ">
            <div class="card-footer-item card-footer-item-bordered">
                <a href="{{ route('registration') }}" class="footer-link">Create An Account</a></div>
            <div class="card-footer-item card-footer-item-bordered">
                <a href="{{ route('login') }}" class="footer-link">Login</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#forgotpasswordform").validate({
                rules: {
                    
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
                                // setTimeout(()=>window.location.href = response.redirect_url,3000);
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
        });
    </script>
@endsection