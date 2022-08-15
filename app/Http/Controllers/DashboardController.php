<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MemberConfirmation;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    protected $data ;

    public function __construct()
    {
        $this->data = [];
    }
    public function index(Request $request)
    {
        if (!$request->session()->has('member_id')) return redirect()->route('login');
        $member = \App\Member::find($request->session()->get('member_id'));
        $this->data['member'] = $member;
        if ($member->is_admin == 1) {
            $this->data['member_counter'] = \App\Member::where('is_admin',0)->count();
            return view('member.admin_dashboard',$this->data);
        } else {
            if ($member->is_admin != 1) return redirect()->route('member_dashboard');
        }
    }
    public function member_dashboard(Request $request)
    {
        $this->data['member'] = \App\Member::find($request->session()->get('member_id'));
        return view('member.member_dashboard',$this->data);
    }
    public function logoutmember(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
    public function help_center(Request $request)
    {
        $this->data['member'] = \App\Member::find($request->session()->get('member_id'));
        return view('member/help_center_view',$this->data);
    }
    public function help_center_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required'],
            'message' => ['required']
        ]);
        if ($validator->fails()) {
            $this->response['status'] = FALSE;
            $this->response['message'] = implode("<br />",$validator->messages()->all());
        } else {
            $help_center = new \App\help_center;
            $help_center->member_id = $request->session()->get('member_id');
            $help_center->subject = $request->subject;$help_center->message = $request->message;
            if ($help_center->save()) {
                $this->response['status'] = TRUE;
                $this->response['message'] = "Your complain has been submited.";
                $this->response['redirect_url'] = route('help_center');
            } else {
                $this->response['status'] = FALSE;
                $this->response['message'] = "Something went wrong";
            }
        }
        return response($this->response, 200)->header('Content-Type','application/json');
    }
    public function download_excel(Request $request)
    {
        if (!$request->session()->has('member_id')) return redirect()->route('login');
        $mpdf = new \Mpdf\Mpdf();
        if (!empty($request->member_id) && $request->member_id != '') {
            $member = \App\Member::find($request->member_id);
        } else {
            $member = \App\Member::find($request->session()->get('member_id'));
        }
        if (!empty($request->filter) && $request->filter == 1) {
            $start_date = \Carbon\Carbon::parse($request->start_date)->toDateTimeString();
            $end_date = \Carbon\Carbon::parse($request->end_date)->toDateTimeString();
            $stockAssignment = \App\StockAssignment::where('member_code',$member->member_code)->whereBetween('date',[$start_date,$end_date])->get();
            if (!empty($stockAssignment)) {
                $calculation = $this->calculated_stack($stockAssignment);
            }
        } else {
            $stockAssignment = \App\StockAssignment::where('member_code',$member->member_code)->get();
        }
        $html = view('member.mpdf_data',[
            'member' => $member,
            'transection'=>$stockAssignment,
            'calculation' => !empty($calculation) ? $calculation : NULL 
        ])->render();
        $mpdf->WriteHTML($html);$mpdf->Output($member->member_code.".pdf",'D');
    }
    public function calculated_stack($stockdata)
    {
        $stock_entry = 0;$stock_exit = 0;$net_exit = 0;$amount = 0;$opening_balance = 0;$closing_balance = 0;
        foreach ($stockdata as $key => $onestack) :
            $stock_entry = $stock_entry + $onestack->stock_entry;
            $stock_exit = $stock_exit + $onestack->stock_exit;
            $net_exit = $net_exit + $onestack->net_exit;
            $amount = $amount + $this->clean_number($onestack->amount);
            $opening_balance = $opening_balance + $this->clean_number($onestack->opening_balance);
            $closing_balance = $closing_balance + $this->clean_number($onestack->closing_balance);
        endforeach;
        return json_decode(json_encode([
            'stock_entry' => $stock_entry,
            'stock_exit' => $stock_exit,
            'net_exit' => $net_exit,
            'amount' => $amount,
            'opening_balance' => $opening_balance,
            'closing_balance' => $closing_balance,
        ]));
    }
    public function clean_number($number_string)
    {
        $number_string = str_replace('₹', '', $number_string);
        $number_string = str_replace(',', '', $number_string);
        $number_string = trim($number_string);
        return floatval($number_string);
    }
    public function member_tradereport(Request $request)
    {
        $member = \App\Member::find($request->session()->get('member_id'));
        $this->data['member'] = $member;
        if (!empty($request->filter) && $request->filter == 1) {
            $start_date = \Carbon\Carbon::parse($request->start_date)->toDateTimeString();
            $end_date = \Carbon\Carbon::parse($request->end_date)->toDateTimeString();
            $stockAssignment = \App\StockAssignment::where('member_code',$member->member_code)->whereBetween('date',[$start_date,$end_date])->paginate(
                $perPage = 10000, $columns = ['*'], $pageName = 'pagination'
            );
            if (!empty($stockAssignment)) {
                $this->data['calculation'] = $this->calculated_stack($stockAssignment);
            }
        } else {
            $stockAssignment = \App\StockAssignment::where('member_code',$member->member_code)->paginate(
                $perPage = config('app.pagination_limit'), $columns = ['*'], $pageName = 'pagination'
            );
        }
        $this->data['transactions'] = $stockAssignment;
        return view('member.member_tradereport_view',$this->data);
    }
}
