@csrf
<div class="form-group">
    <input class="form-control form-control-lg" value="{{ $otpStack->contact_number }}" id="opt_contact" required type="text" name="opt_contact" autocomplete="off" readonly>
</div>
<div class="form-group">
    <input class="form-control form-control-lg" required type="text" id="otp" name="otp" placeholder="Enter OTP" autocomplete="off">
</div>
<input type="hidden" value="{{ $otpStack->id }}" name="otp_id">
<button type="button" class="btn btn-secondary">Resend OTP</button>
<button type="submit" class="btn btn-primary float-right">Submit</button>