<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    protected $data = array();protected $response = array();

    public function index(Request $request)
    {
        if ($request->session()->has('member_id')) return redirect()->route('dashboard');
        return view('authentication.login');
    }
    
    public function loginprocess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_code' => ['required'],
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            $this->response['status'] = FALSE;
            $this->response['message'] = implode("<br />",$validator->messages()->all());
        } else {
            $member = \App\Member::where('member_code',$request->member_code)->first();
            if (!empty($member)) {
                if (trim($request->password) == $member->password) {
                    $request->session()->put('member_id',$member->id);
                    $request->session()->put('member_email',$member->email);
                    $request->session()->put('member_code',$member->member_code);
                    $request->session()->put('is_admin',$member->is_admin);
                    $this->response['status'] = TRUE;$this->response['message'] = "Login success..!!!";
                    $this->response['redirect_url'] = route('dashboard');
                } else {
                    $this->response['status'] = FALSE;
                    $this->response['message'] = "Member code and password is not match.";
                }
            } else {
                $this->response['status'] = FALSE;
                $this->response['message'] = "Member code does not exsist.";
            }
        }
        return response($this->response, 200)->header('Content-Type', 'application/json');
    }
    public function confirmation(Request $request)
    {
        $member = \App\Member::find($request->segment(3));
        if (!empty($member)) {
            if ($member->is_veryfied == 0) {
                $this->meghdoot->updateMember($request,['is_veryfied'=>TRUE],$member->id);
                return redirect(route('login'))->with(['message' => 'Your confirmation process has been completed.', 'alert' => 'alert-success']);
            } else {
                return redirect(route('login'))->with(['message' => 'You are already confirm.', 'alert' => 'alert-success']);
            }
        } else {
            return redirect()->route('login');   
        }
    }
    public function forgot_password_form(Request $request)
    {
        return view('authentication.forgot_password_form');
    }
    public function forgot_password_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required','email'],
        ]);
        if ($validator->fails()) {
            $this->response['status'] = FALSE;
            $this->response['message'] = implode("<br />",$validator->messages()->all());
        } else {
            $member = \App\Member::where('email',$request->email)->first();
            if (!empty($member)) {
                $forgot_password_token = strtoupper(\Str::random(8));
                try {
                    $this->meghdoot->updateMember($request,['forgot_password_token'=>$forgot_password_token],$member->id);
                    $this->data['member'] = $member;
                    $this->data['password_reset_token'] = $forgot_password_token;
                    $this->data['password_reset_link'] = route('password_reset_form');
                    \Mail::to($member->email)->send(new ForgotPassword($this->data));
                    $this->response['status'] = TRUE;
                    $this->response['message'] = "Link has been send to your inbox.";
                } catch (Exception $exception) {
                    $this->response['status'] = FALSE;
                    $this->response['message'] = $exception->getMessage();
                }
            } else {
                $this->response['status'] = FALSE;
                $this->response['message'] = "Email id does not exsist.";
            }
        }
        return response($this->response, 200)->header('Content-Type', 'application/json');
    }
    public function password_reset_form(Request $request)
    {
        return view('authentication.password_reset_form');
    }
    public function password_reset_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verification_token' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required'],
        ]);
        if ($validator->fails()) {
            $this->response['status'] = FALSE;
            $this->response['message'] = implode("<br />",$validator->messages()->all());
        } else {
            $member = \App\Member::where('forgot_password_token',$request->verification_token)->first();
            if (!empty($member)) {
                try {
                    $updateMemberStack = ['forgot_password_token'=>NULL,'password' => $request->password];
                    $this->meghdoot->updateMember($request,$updateMemberStack,$member->id);
                    $this->response['status'] = TRUE;  
                    $this->response['message'] = "Password has been updated.";
                } catch (Exception $exception) {
                    $this->response['status'] = FALSE;
                    $this->response['message'] = $exception->getMessage();
                }
            } else {
                $this->response['status'] = FALSE;
                $this->response['message'] = "Token is not valid.";
            }
        }
        return response($this->response, 200)->header('Content-Type', 'application/json');
    }
}
