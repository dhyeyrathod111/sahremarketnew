<?php

namespace App\Http\Controllers;

use App\Memberledger;
use Illuminate\Http\Request;

class MemberledgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function create_memberledger($activeSheet, $member_id, $oneSpreadsheet)
    {   
        $getHighestRow = $activeSheet->getHighestRow();
        $member = \App\Member::where('member_code',$oneSpreadsheet)->first();
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
    }
    public function show_ledger_member(Request $request)
    {
        $member = $member = \App\Member::find($request->session()->get('member_id'));
        $this->data['member'] = $member;
        $this->data['ledgerdata'] = \App\Memberledger::where(['member_id' => $member->id,'is_closing_balance' => 0])->get();
        $this->data['closing_balance'] = \App\Memberledger::where(['member_id' => $member->id,'is_closing_balance' => 1])->first();
        return view('member.member_ledger_view',$this->data);
    }
}
