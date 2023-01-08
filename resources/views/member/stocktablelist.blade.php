@extends('layouts.master')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')

<div class="dashboard-wrapper">
    @include('member.include.banner')
    <div class="container-fluid  dashboard-content">
        
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                <div class="card">
                    <h5 class="card-header">Stock Data 
                        {{-- <a href="{{ route('stock_assignment') }}" class="btn btn-primary text-white float-right btn-sm">Add New Stock</a> --}}
                    </h5>
                    <div class="card-header">
                        <form method="GET" action="{{ route('stock_list_route') }}" id="filter_form">
                            <div class="form-row">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 mb-2">
                                    <label>From Date:</label>
                                    <input type="text" placeholder="DD-MM-YYYY" name="start_date" value="{{ request()->start_date }}" class="form-control">
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 mb-2">
                                    <label>To Date:</label>
                                    <input type="text" placeholder="DD-MM-YYYY" name="end_date" value="{{ request()->end_date }}" class="form-control">
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 mb-2">
                                    <label>Members:</label>
                                    <select name="member_select[]" class="form-control" multiple="multiple">
                                        <option value="">--- Select Member ---</option>
                                        @foreach($members as $memeber)
                                            @if(!empty(request()->member_select))
                                                <option {{ in_array($memeber->member_code, request()->member_select) ? 'selected' : '' }} value="{{ $memeber->member_code }}" >{{ $memeber->member_code }} ({{ $memeber->firstname." ".$memeber->lastname }})</option>
                                            @else 
                                                <option value="{{ $memeber->member_code }}" >{{ $memeber->member_code }} ({{ $memeber->firstname." ".$memeber->lastname }})</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 fillterbuttonallignment">
                                    <input type="hidden" value="1" name="filter">
                                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                                    <a class="btn btn-primary btn-sm" href="{{ route('stock_list_route') }}">Reset</a>
                                    <a href="{{ route('download_excel_admin',[
                                            'start_date' => request()->start_date,
                                            'end_date' => request()->end_date,
                                            'member_select' => request()->member_select,
                                            'filter' => request()->filter
                                        ]) }}" class="btn btn-primary btn-sm float-right">Download PDF</a>  
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="stock_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <!-- <th>id</th> -->
                                        <th style="background: #011e58; color: white">date</th>
                                        <th style="background: #011e58; color: white">trade id</th>
                                        <th style="background: #011e58; color: white">position</th>
                                        <th style="background: #011e58; color: white">quantity</th>
                                        <th style="background: #011e58; color: white">entry</th>
                                        <th style="background: #011e58; color: white">exit</th>
                                        <th style="background: #011e58; color: white">net exit</th>
                                        <th style="background: #011e58; color: white">amount</th>
                                        <th style="background: #011e58; color: white">opening balance</th>
                                        <th style="background: #011e58; color: white">closing balance</th>
                                        <th style="background: #011e58; color: white">time</th>
                                        <th style="background: #011e58; color: white">brokrage</th>
                                        <th style="background: #011e58; color: white">Member Code</th>
                                        <th style="background: #011e58; color: white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $onetransection)
                                    <tr>
                                        <!-- <td>{{ $onetransection->id }}</td> -->
                                        <td style="width: 100%">{{ date('d-m-Y', strtotime($onetransection->date)) }}</td>
                                        <td>{{ $onetransection->trade_id }}</td>
                                        <td>{{ $onetransection->position }}</td>
                                        <td>{{ $onetransection->quantity }}</td>
                                        <td>{{ round($onetransection->stock_entry,2) }}</td>
                                        <td>{{ round($onetransection->stock_exit,2) }}</td>
                                        <td>{{ round($onetransection->net_exit,2) }}</td>
                                        <td>{{ $onetransection->amount }}</td>
                                        <td>{{ $onetransection->opening_balance }}</td>
                                        <td>{{ $onetransection->closing_balance }}</td>
                                        <td>{{ $onetransection->time }}</td>
                                        <td>{{ "₹".round($onetransection->brokrage,2)  }}</td>
                                        <td>{{ $onetransection->member_code }}</td>
                                        <td><a class="btn btn-primary btn-sm" href="{{ route('update_single_stock',['stock_id' => Crypt::encryptString($onetransection->id) ]) }}"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                    @endforeach
                                    @if(!empty($calculation))
                                        <tr style="background: yellowgreen !important">
                                            <td> </td>
                                            <td> Total </td>
                                            <td> </td>
                                            <td> {{ $calculation->quantity }} </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> {{ round($calculation->net_exit,2) }} </td>
                                            <td> {{ "₹".round($calculation->amount, 2) }} </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> {{ "₹".round($calculation->brokrage, 2) }} </td>
                                            <td> </td>
                                            <td> </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                @if(empty(request()->filter))
                                    {{ $transactions->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end basic table  -->
            <!-- ============================================================== -->
        </div>
        
    </div>
    @include('member.include.footer')
</div>

@endsection

@section('pagescript')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src=" {{ asset('public/assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection