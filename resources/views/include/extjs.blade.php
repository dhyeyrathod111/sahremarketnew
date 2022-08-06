<script src="{{ asset('public/') }}/assets/js/vendor/modernizr-3.5.0.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/popper.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/bootstrap.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/jquery.slicknav.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/owl.carousel.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/slick.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/wow.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/animated.headline.js"></script>
<script src="{{ asset('public/') }}/assets/js/jquery.magnific-popup.js"></script>
<script src="{{ asset('public/') }}/assets/js/gijgo.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/jquery.nice-select.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/jquery.sticky.js"></script>
<script src="{{ asset('public/') }}/assets/js/jquery.counterup.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/waypoints.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/jquery.countdown.min.js"></script>
{{-- <script src="{{ asset('public/') }}/assets/js/contact.js"></script> --}}
{{-- <script src="{{ asset('public/') }}/assets/js/jquery.form.js"></script> --}}
<script src="{{ asset('public/') }}/assets/js/jquery.validate.min.js"></script>
{{-- <script src="{{ asset('public/') }}/assets/js/mail-script.js"></script> --}}
<script src="{{ asset('public/') }}/assets/js/jquery.ajaxchimp.min.js"></script>
<script src="{{ asset('public/') }}/assets/js/plugins.js"></script>
<script src="{{ asset('public/') }}/assets/js/main.js"></script>
<script type="text/javascript">
	$.validator.addMethod("phoneUS", function (phone_number, element) {
	    phone_number = phone_number.replace(/\s+/g, "");
	    return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([0-9]\d{2}\)|[0-9]\d{2})-?[0-9]\d{2}-?\d{4}$/);
	}, "Please specify a valid phone number");
	function notify_success(message) {
        let html_str = '<div class="alert alert-success text-center"><strong>'+ message +'</strong></div>';
        $('#alert_message').fadeIn();
        $('#alert_message').html(html_str).fadeOut(3000);
    }
    function notify_error(message = '') {
        if (message === '') {
            message = "Sorry, we have to face some technical issues please try again later."
        } 
        let html_str = '<div class="alert alert-danger text-center"><strong>'+ message +'</strong></div>';
        $('#alert_message').fadeIn();
        $('#alert_message').html(html_str).fadeOut(3000);
    }
</script>