<?php

namespace App\Http\Controllers;

use App\Memberledger;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MemberledgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->data = [];$this->response = [];$this->pagination_limit = 50;
        $this->dashboard = new \App\Http\Controllers\DashboardController;
    }
    public function index()
    {
        //
    }
    public function create_memberledger($activeSheet, $member_id, $oneSpreadsheet)
    {   
        $getHighestRow = $activeSheet->getHighestRow();
        $member = \App\Member::where('member_code',$oneSpreadsheet)->first();
        if (!empty($member)) :
            for ($i=1; $i < $getHighestRow; $i++) : 
                $ledgerdate = trim($activeSheet->getCell('N'.$i)->getFormattedValue());
                if (!empty($ledgerdate) && str_contains($ledgerdate,'/')) :
                    $ledgerdate = explode("/", trim( $activeSheet->getCell('N'.$i)->getFormattedValue() ));
                    if (!empty($ledgerdate[2])) {
                        $finalDateString = $ledgerdate[2]."-".$ledgerdate[0]."-".$ledgerdate[1];$finalDateString = date('Y-m-d', strtotime($finalDateString));
                    } else {
                        $finalDateString = NULL;
                    }
                    $memberledger = new Memberledger;
                    $memberledger->member_id = $member->id;
                    $memberledger->date = $finalDateString;
                    $memberledger->name = $activeSheet->getCell('O'.$i)->getFormattedValue();
                    $memberledger->ledger_cr = $activeSheet->getCell('P'.$i)->getFormattedValue();
                    $memberledger->ledger_dr = $activeSheet->getCell('Q'.$i)->getFormattedValue();
                    $memberledger->net_balance = $activeSheet->getCell('R'.$i)->getFormattedValue();
                    $memberledger->is_closing_balance = 0;
                    $memberledger->save();
                endif;
                $closing_balance_row = trim($activeSheet->getCell('O'.$i)->getFormattedValue());
                if (str_contains($closing_balance_row,'Closing Balance') || str_contains($closing_balance_row,'closing balance')) {
                    $memberledger = new Memberledger;
                    $memberledger->member_id = $member->id;
                    $memberledger->ledger_cr = $activeSheet->getCell('P'.$i)->getFormattedValue();
                    $memberledger->ledger_dr = $activeSheet->getCell('Q'.$i)->getFormattedValue();
                    $memberledger->net_balance = $activeSheet->getCell('R'.$i)->getFormattedValue();
                    $memberledger->is_closing_balance = 1;
                    $memberledger->save();
                }
            endfor;
        endif;
    }
    public function show_ledger_member(Request $request)
    {
        if (!empty($request->member_id)) {
            $member = \App\Member::find($request->member_id);
        } else {
            $member = \App\Member::find($request->session()->get('member_id'));
        }
        $this->data['member'] = $member;
        $this->data['ledgerdata'] = \App\Memberledger::where(['member_id' => $member->id,'is_closing_balance' => 0])->get();
        $this->data['closing_balance'] = \App\Memberledger::where(['member_id' => $member->id,'is_closing_balance' => 1])->first();
        return view('member.member_ledger_view',$this->data);
    }
    public function brokerage_calculation(Request $request)
    {
        if (!empty($request->filter) && $request->filter == 1) {
            $stockAssignment = \App\StockAssignment::where('is_active',1);
            if (!empty($request->member_select) && $request->member_select != '') {
                $stockAssignment->whereIn('member_code',$request->member_select);
            } 
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start_date = Carbon::parse($request->start_date)->toDateTimeString();
                $end_date = Carbon::parse($request->end_date)->toDateTimeString();
                $stockAssignment->whereBetween('date',[$start_date,$end_date]);
            }
            $stockAssignment = $stockAssignment->get();
            $this->data['calculation'] = $this->dashboard->calculated_stack($stockAssignment,1);
        } else {
            $stockAssignment = \App\StockAssignment::paginate(
                $perPage = $this->pagination_limit, $columns = ['*'], $pageName = 'pagination'
            );
        }
        $this->data['transactions'] = $stockAssignment;
        $this->data['members'] = \App\Member::where('is_admin',0)->get();
        return view('member.brokerage_calculation_view',$this->data);   
    }
}
