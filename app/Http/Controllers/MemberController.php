<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    protected $data ;protected $response = array();protected $wallet;

    public function __construct()
    {
        $this->data = [];$this->response = [];
    }
    public function index(Request $request)
    {
        if (!$request->session()->has('member_id')) return redirect()->route('login');
        $this->data['members'] = \App\Member::where('is_admin',0)->get();
        return view('member.membertablelist',$this->data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!empty($request->member_id) && $request->member_id != '') {
            $this->data['post_mamber'] = \App\Member::find($request->member_id);   
        } else {
            $this->data['post_mamber'] = NULL;
        }
        return view('member.addnewmember',$this->data);
    }
    public function process_newmember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'contact' => ['required'],
            'member_code' => ['required'],
        ]);    
        if ($validator->fails()) {
            $this->response['status'] = FALSE;
            $this->response['message'] = implode("<br />",$validator->messages()->all());
        } else {
            if (!empty($request->member_id) && $request->member_id != '') {
                $newmember = \App\Member::find($request->member_id);
            } else {
                $newmember = new \App\Member;
                if (\App\Member::where('member_code',$request->member_code)->count() > 0) {
                    $this->response['status'] = FALSE;
                    $this->response['message'] = 'This member code is already in use';
                    return response($this->response, 200)->header('Content-Type', 'application/json');exit();
                }
            }
            $member_image = $request->file('member_image');
            if (!empty($member_image) && $member_image != NULL) {
                $newmember->image = $member_image->store("/member_images");
            }
            $newmember->firstname = $request->firstname;
            $newmember->lastname = $request->lastname;
            $newmember->email = $request->email;
            $newmember->member_code = $request->member_code;
            $newmember->password = $request->password;
            $newmember->contact = $request->contact;
            $newmember->remember_token = strtoupper(\Str::random(20));
            if ($newmember->save()) {
                $this->response['status'] = TRUE;
                $this->response['message'] = 'Data Update successfully.';
                $this->response['redirect_url'] = route('memberlist');
            } else {
                $this->response['status'] = FALSE;
                $this->response['message'] = "Sorry, we have to face some technical issues please try again later.";
            }
        }
        return response($this->response, 200)->header('Content-Type', 'application/json');
    }
    public function member_stocks_foradmin(Request $request)
    {
        $member = \App\Member::find($request->member_id);
        if (empty($member)) return redirect()->route('memberlist');
        if (!empty($request->filter) && $request->filter == 1) {
            $start_date = \Carbon\Carbon::parse($request->start_date)->toDateTimeString();
            $end_date = \Carbon\Carbon::parse($request->end_date)->toDateTimeString();
            $stockAssignment = \App\StockAssignment::where('member_code',$member->member_code)->whereBetween('date',[$start_date,$end_date])->get();
        } else {
            $stockAssignment = \App\StockAssignment::where('member_code',$member->member_code)->get();
        }
        $this->data['transactions'] = $stockAssignment;
        $this->data['member'] = $member;
        return view('member.member_stocks_foradmin',$this->data);
    }
}
