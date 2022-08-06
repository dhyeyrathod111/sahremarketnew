@csrf
<div class="form-group">
    <input class="form-control form-control-lg" value="{{ $member->contact }}" id="roundpay_opt_contact" name="roundpay_opt_contact" required type="text" name="roundpay_opt_contact" autocomplete="off" readonly>
</div>
<div class="form-group">
    <input class="form-control form-control-lg" required type="text" id="roundpay_otp" name="roundpay_otp" placeholder="Enter OTP" autocomplete="off">
</div>
<button type="submit" class="btn btn-primary float-right">Submit</button>