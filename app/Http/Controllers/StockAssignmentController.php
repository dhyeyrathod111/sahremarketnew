<?php

namespace App\Http\Controllers;

use App\StockAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StockAssignmentController extends Controller
{
    protected $data ;protected $response ;protected $memberwallet;protected $transection;
    protected $ledgercontroller;

    public function __construct()
    {
        $this->data = [];$this->response = [];$this->pagination_limit = 50;
        $this->membreledger = new \App\Http\Controllers\MemberledgerController;
        $this->dashboard = new \App\Http\Controllers\DashboardController;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->session()->has('member_id')) return redirect()->route('login');
        $this->data['members'] = \App\Member::where('is_admin',0)->get();
        return view('member.stockAssignment',$this->data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_excel_forbackup($getFile)
    {
        $folder_name = date('d_m_Y', time());
        $filestore = new \App\UploadedFiles;$filestore->file_path = $getFile->store("/".$folder_name."/");
        $filestore->save();
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'member_id' => ['required'],
            // 'master_data' => ['required','file','mimes:xls,xlsx,xlsm'],
        ]);
        if ($validator->fails()) {
            $this->response['status'] = FALSE;
            $this->response['message'] = implode("<br />",$validator->messages()->all());
        } else {
            try {$success_upload = [];$error_upload = [];\App\StockAssignment::query()->truncate();\App\Memberledger::query()->truncate();
                $the_file = $request->file('master_data');$this->store_excel_forbackup($the_file);
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                foreach ($spreadsheet->getSheetNames() as $key => $oneSpreadsheet) :
                    if ($oneSpreadsheet != 'Report') {
                        $getActiveSheet = $spreadsheet->getSheet($key);
                        $import_response = $this->import_active_sheet($getActiveSheet, $request->member_id, $oneSpreadsheet);
                        $create_ledger = $this->membreledger->create_memberledger($getActiveSheet, $request->member_id, $oneSpreadsheet);
                        if ($import_response == TRUE) {
                            array_push($success_upload,$oneSpreadsheet);
                        } else {
                            array_push($error_upload,$oneSpreadsheet);
                        }
                    }
                endforeach;
                if (count($success_upload) == $spreadsheet->getSheetCount() && count($error_upload) == 0) {
                    $this->response['status'] = TRUE;$this->response['message'] = "Excel has been Uploded successfully.";
                    $this->response['redirect_url'] = route('stock_list_route');
                } else {
                    $this->response['status'] = FALSE;
                    $this->response['message'] = implode(",",$error_upload)." Excels are not properly Uploded.";
                }
            } catch (\Exception $exception) {
                $this->response['status'] = FALSE;$this->response['message'] = $exception->getMessage();
            }
        }
        return response($this->response, 200)->header('Content-Type', 'application/json');
    }
    private function import_active_sheet($activeSheet, $member_id, $member_code)
    {
        $spreadsheet_array = $activeSheet->toArray();
        unset($spreadsheet_array[0]);unset($spreadsheet_array[1]);unset($spreadsheet_array[2]);unset($spreadsheet_array[3]);
        $member = \App\Member::where('member_code',$member_code)->first();
        $member->opening_quantity = $activeSheet->getCell('C2')->getFormattedValue();$member->ledger_size = $activeSheet->getCell('D2')->getFormattedValue();
        $member->opning_balance = $activeSheet->getCell('E2')->getFormattedValue();$member->save();
        if (!empty($member)) {
            $member_id = $member->id;
        } else {
            $member_id = NULL;
        }
        $error_stack = [];$excelKeyStart = 5;
        foreach ($spreadsheet_array as $key  => $oneColumn) :
            if (!empty($oneColumn[0]) && !empty($oneColumn[1])) :
                $newtransection = new \App\StockAssignment;
                $newtransection->member_id = $member_id;
                $d_exp = explode("/", trim( $activeSheet->getCell('A'.$excelKeyStart)->getFormattedValue() ));
                if (!empty($d_exp[2])) {
                    $finalDateString = $d_exp[2]."-".$d_exp[1]."-".$d_exp[0];$finalDateString = date('Y-m-d', strtotime($finalDateString));
                } else {
                    $finalDateString = NULL;
                }
                $newtransection->date = $finalDateString;
                $newtransection->trade_id = $activeSheet->getCell('B'.$excelKeyStart)->getFormattedValue();
                $newtransection->position = $activeSheet->getCell('C'.$excelKeyStart)->getFormattedValue();
                $newtransection->quantity = $activeSheet->getCell('D'.$excelKeyStart)->getFormattedValue();
                $newtransection->stock_entry = $activeSheet->getCell('E'.$excelKeyStart)->getFormattedValue();
                $newtransection->stock_exit = $activeSheet->getCell('F'.$excelKeyStart)->getFormattedValue();
                $newtransection->net_exit = $activeSheet->getCell('G'.$excelKeyStart)->getFormattedValue();
                $newtransection->amount = $activeSheet->getCell('H'.$excelKeyStart)->getFormattedValue();
                $newtransection->opening_balance = $activeSheet->getCell('I'.$excelKeyStart)->getFormattedValue();
                $newtransection->closing_balance = $activeSheet->getCell('J'.$excelKeyStart)->getFormattedValue();
                $newtransection->time = $activeSheet->getCell('K'.$excelKeyStart)->getFormattedValue();
                $newtransection->brokrage = $activeSheet->getCell('L'.$excelKeyStart)->getFormattedValue();
                $newtransection->member_code = $member_code;
                $trade_id = $activeSheet->getCell('B'.$excelKeyStart)->getFormattedValue();
                try {
                    $newtransection->save();
                    \Log::info('Transaction Created For Trade ID : '.$trade_id);
                } catch (\Exception $exception) {
                    array_push($error_stack, $trade_id);
                    \Log::error('Transaction Error : '.$exception->getMessage());
                }
                $excelKeyStart++;
            endif;
        endforeach;
        if (count($error_stack) > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function stack_list(Request $request)
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
        return view('member.stocktablelist',$this->data);
    }
    public function download_excel_admin(Request $request)
    {
        $mpdf = new \Mpdf\Mpdf();
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
        if (!empty($request->is_brokerage) && $request->is_brokerage != '') {
            $html = $html = view('member.mpdf_brokerage_data',[
                'is_brokerage' => $request->is_brokerage,
                'transection'=> $stockAssignment,
                'calculation' => $this->dashboard->calculated_stack($stockAssignment,1) 
            ])->render();
        } else {
            $html = view('member.mpdf_data',[
                'transection'=> $stockAssignment,
                'calculation' => $this->dashboard->calculated_stack($stockAssignment,1) 
            ])->render();
        }
        // echo $html;
        $fileName = "master_export_".date('d-m-Y', time());
        $mpdf->WriteHTML($html);$mpdf->Output($fileName.".pdf",'D');
    }
    public function update_single_stock(Request $request)
    {
        try {
            $stock_id = filter_var(Crypt::decryptString($request->stock_id), FILTER_VALIDATE_INT);
            if (!empty($stock_id)) {
                $this->data['onestock'] = \App\StockAssignment::find($stock_id);
                return view('member.onestock_update',$this->data);
            } else {
                return redirect()->route('stock_list_route');    
            }
        } catch (\Exception $e) {
            return redirect()->route('stock_list_route');
        }
    }
    public function update_single_stock_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required'],
            'trade_id' => ['required'],
            'position' => ['required'],
            'stock_entry' => ['required'],
            'amount' => ['required'],
            'closing_balance' => ['required'],
            'time' => ['required'],
            'brokrage' => ['required'],
        ]);
        if ($validator->fails()) {
            $this->response['status'] = FALSE;
            $this->response['message'] = implode("<br />",$validator->messages()->all());
        } else {
            \Log::info('Transaction ID has been updated : '.$request->trade_id." BY user ID :".$request->session()->get('member_id'));
            \Log::info('Transaction Data : '.json_encode($request->all()));
            $newtransection = \App\StockAssignment::find($request->stock_id);
            $newtransection->date = $request->date;
            $newtransection->trade_id = $request->trade_id;
            $newtransection->position = $request->position;
            $newtransection->stock_entry = $request->stock_entry;
            $newtransection->amount = $request->amount;
            $newtransection->closing_balance = $request->closing_balance;
            $newtransection->time = $request->time;
            $newtransection->brokrage = $request->brokrage;
            if ($newtransection->save()) {
                $this->response['status'] = TRUE;
                $this->response['message'] = 'Data Update successfully.';
                $this->response['redirect_url'] = route('stock_list_route');
            } else {
                $this->response['status'] = TRUE;
                $this->response['message'] = "Sorry, we have to face some technical issues please try again later.";
            }
        }
        return response($this->response, 200)->header('Content-Type', 'application/json');
    }
}
