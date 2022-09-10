@extends('layouts.master')


@section('content')

<div class="dashboard-wrapper">
    @include('member.include.banner')
    <div class="container-fluid dashboard-content pt-0">
        <div class="ecommerce-widget">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                    <div class="card">
                        <div class="card-header">
                            <form method="GET" action="{{ route('member_tradereport') }}" id="filter_form">
                                <div class="form-row">
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                        <label>From Date:</label>
                                        <input type="text" placeholder="DD-MM-YYYY" name="start_date" value="{{ request()->start_date }}" class="form-control">
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                        <label>To Date:</label>
                                        <input type="text" placeholder="DD-MM-YYYY" name="end_date" value="{{ request()->end_date }}" class="form-control">
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 fillterbuttonallignment">
                                        <input type="hidden" value="1" name="filter">
                                        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                                        <a class="btn btn-primary btn-sm" href="{{ route('member_tradereport') }}">Reset</a>
                                        <a href="{{ route('download_excel',[
                                            'start_date' => request()->start_date,
                                            'end_date' => request()->end_date,
                                            'filter' => request()->filter
                                        ]) }}" class="btn btn-primary btn-sm float-right">Download PDF</a>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body p-0">      
                            <div class="table-responsive">
                                <table id="stock_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="background: #fcdb68"></th>
                                            <th style="background: #fcdb68">Client Code</th>
                                            <th style="background: #fcdb68">Proton Code</th>
                                            <th style="background: #fcdb68">Opning Quantity</th>
                                            <th style="background: #fcdb68">Ledger Size</th>
                                            <th style="background: #fcdb68">Opning Balance</th>
                                            <th style="background: #fcdb68">Start Date</th>
                                            <th style="background: #fcdb68">End Date</th>
                                            <th style="background: #fcdb68"></th>
                                            <th style="background: #fcdb68"></th>
                                        </tr>
                                        <tr>
                                            <th style="background: #af9b20;color: white"></th>
                                            <th style="background: #af9b20;color: white">{{ $member->member_code }}</th>
                                            <th style="background: #af9b20;color: white">{{ $member->password }}</th>
                                            <th style="background: #af9b20;color: white">{{ $member->opening_quantity }}</th>
                                            <th style="background: #af9b20;color: white">{{ $member->ledger_size }}</th>
                                            <th style="background: #af9b20;color: white">{{ $member->opning_balance }}</th>
                                            <th style="background: #af9b20;color: white">{{ 
                                                !empty($filter_dates) ? date('d-m-Y', strtotime($filter_dates['start_date'])) : ''
                                            }}</th>
                                            <th style="background: #af9b20;color: white">{{ 
                                                !empty($filter_dates) ? date('d-m-Y', strtotime($filter_dates['end_date'])) : ''
                                            }}</th>
                                            <th style="background: #af9b20"></th>
                                            <th style="background: #af9b20"></th>
                                        </tr>
                                        <tr>
                                            <th style="background: #011e58; color: white">Date</th>
                                            <th style="background: #011e58; color: white">Trade Id</th>
                                            <th style="background: #011e58; color: white">Position</th>
                                            <th style="background: #011e58; color: white">Quantity</th>
                                            <th style="background: #011e58; color: white">Entry</th>
                                            <th style="background: #011e58; color: white">Exit</th>
                                            <th style="background: #011e58; color: white">Net Exit</th>
                                            <th style="background: #011e58; color: white">Amount</th>
                                            <th style="background: #011e58; color: white">Opening Balance</th>
                                            <th style="background: #011e58; color: white">Closing Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $onetransection)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($onetransection->date)) }}</td>
                                            <td>{{ $onetransection->trade_id }}</td>
                                            <td>{{ $onetransection->position }}</td>
                                            <td>{{ $onetransection->quantity }}</td>
                                            <td>{{ round($onetransection->stock_entry , 2) }}</td>
                                            <td>{{ round($onetransection->stock_exit , 2) }}</td>
                                            <td>{{ round($onetransection->net_exit , 2) }}</td>
                                            <td>{{ $onetransection->amount }}</td>
                                            <td>{{ $onetransection->opening_balance }}</td>
                                            <td>{{ $onetransection->closing_balance }}</td>
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
                                            <td> {{ round($calculation->net_exit, 2) }} </td>
                                            <td> {{ round($calculation->amount,2) }} </td>
                                            <td> </td>
                                            <td> </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="{{ !empty($calculation) ? '' : 'card-footer' }}">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ $transactions->links() }}      
                                </div>
                            </div>
                        </div>
                        <hr class="style-eight" />
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <p class="m-0" style="color: #011e58">*Merely Individual Entity Being Acknowleged as Valid Ledger Client</p>
                                    <p class="m-0" style="color: #011e58">*Long term Debits shall be levy Anually Intrest @18%</p>
                                    <p class="m-0" style="color: #011e58">*Proton Code is Higly Classified, Company shall not responsible for misuses from client side</p>
                                    <p class="m-0" style="color: #011e58">*Any Error in Ledger should be notify within Seven Uk Working Days</p>
                                    <p class="m-0" style="color: #011e58">*Computer generated bill/Ledger carries no signature</p>      
                                </div>
                                <div class="col-md-2">
                                    <p class="m-0" style="color: #011e58">Brown Finance Uk Limited</p>
                                    <p class="m-0">&nbsp;</p>
                                    <p class="m-0">&nbsp;</p>
                                    <p class="m-0">&nbsp;</p>
                                    <p class="m-0" style="color: #011e58">signature/seal</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('member.include.footer')
</div>
@endsection
