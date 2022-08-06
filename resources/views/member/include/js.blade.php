<script src="{{ asset('public/assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<!-- bootstap bundle js -->
<script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
<!-- slimscroll js -->
<script src="{{ asset('public/assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
<!-- main js -->
<script src="{{ asset('public/assets/libs/js/main-js.js') }}"></script>
<!-- chart chartist js -->
{{-- <script src="{{ asset('public/assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script> --}}
<!-- sparkline js -->
<script src="{{ asset('public/assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
<!-- morris js -->
<script src="{{ asset('public/assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/charts/morris-bundle/morris.js') }}"></script>
<!-- chart c3 js -->
<script src="{{ asset('public/assets/vendor/charts/c3charts/c3.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
{{-- <script src="{{ asset('public/assets/vendor/charts/c3charts/C3chartjs.js') }}"></script> --}}
{{-- <script src="{{ asset('public/assets/libs/js/dashboard-ecommerce.js') }}"></script> --}}
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script type="text/javascript">
    var BASE_URL = '{{ route('homepage') }}';
    function notify_success(message) {
        let html_str = '<div class="alert alert-success text-center"><strong>'+ message +'</strong></div>';
        $('#alert_message,.alert_message').fadeIn();
        $('#alert_message,.alert_message').html(html_str).fadeOut(3000);
    }
    function notify_error(message = '') {
        if (message === '') {
            message = "Sorry, we have to face some technical issues please try again later."
        } 
        let html_str = '<div class="alert alert-danger text-center"><strong>'+ message +'</strong></div>';
        $('#alert_message,.alert_message').fadeIn();
        $('#alert_message,.alert_message').html(html_str).fadeOut(3000);
    }
    $.validator.addMethod("phoneUS", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([0-9]\d{2}\)|[0-9]\d{2})-?[0-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");
    
    $.validator.addMethod("pincode", function (pincode, element) {
        pincode = pincode.replace(/\s+/g, "");return pincode.match(/^[0-9]{6,6}$/);
    }, "Please specify a valid pincode");

    $.validator.addMethod('accountNumber', function (value) {
        return !(/^0{8}$/.test(value));
    }, 'Please enter a valid account.');

    $.validator.addMethod("customEmail", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
    }, "Please enter valid email address!");
</script>