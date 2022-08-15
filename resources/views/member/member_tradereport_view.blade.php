@extends('layouts.master')


@section('content')

<div class="dashboard-wrapper">
    @include('member.include.banner')
    <div class="container-fluid dashboard-content ">
        <div class="ecommerce-widget">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h3 class="card-header">
                            Welcome {{ $member->firstname." ".$member->lastname }} ({{ $member->member_code }})
                            <a href="{{ route('download_excel',[
                                'start_date' => request()->start_date,
                                'end_date' => request()->end_date,
                                'filter' => request()->filter
                            ]) }}" class="btn btn-primary float-right">Download PDF</a>
                        </h3>
                        <div class="card-header">
                            <form method="GET" action="{{ route('dashboard') }}" id="filter_form">
                                <div class="form-row">
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                        <label>From Date:</label>
                                        <input type="date" name="start_date" value="{{ request()->start_date }}" class="form-control">
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                        <label>To Date:</label>
                                        <input name="end_date" type="date" value="{{ request()->end_date }}" class="form-control">
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <input type="hidden" value="1" name="filter">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <a class="btn btn-primary" href="{{ route('dashboard') }}">Reset</a>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">      
                            <div class="table-responsive">
                                <table id="stock_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>date</th>
                                            <th>trade id</th>
                                            <th>position</th>
                                            <th>entry</th>
                                            <th>exit</th>
                                            <th>net exit</th>
                                            <th>amount</th>
                                            <th>opening balance</th>
                                            <th>closing balance</th>
                                            <th>time</th>
                                            <th>brokrage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $onetransection)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($onetransection->date)) }}</td>
                                            <td>{{ $onetransection->trade_id }}</td>
                                            <td>{{ $onetransection->position }}</td>
                                            <td>{{ round($onetransection->stock_entry , 2) }}</td>
                                            <td>{{ round($onetransection->stock_exit , 2) }}</td>
                                            <td>{{ round($onetransection->net_exit , 2) }}</td>
                                            <td>{{ $onetransection->amount }}</td>
                                            <td>{{ $onetransection->opening_balance }}</td>
                                            <td>{{ $onetransection->closing_balance }}</td>
                                            <td>{{ $onetransection->time }}</td>
                                            <td>{{ strpos($onetransection->brokrage,"₹") ? $onetransection->brokrage : round($onetransection->brokrage,2)  }}</td>
                                        </tr>
                                        @endforeach
                                        @if(!empty($calculation))
                                        <tr>
                                            <td> </td>
                                            <td> Total  </td>
                                            <td> </td>
                                            <td> {{ $calculation->stock_entry }} </td>
                                            <td> {{ $calculation->stock_exit }} </td>
                                            <td> {{ $calculation->net_exit }} </td>
                                            <td> {{ $calculation->amount }} </td>
                                            <td> {{ $calculation->opening_balance }} </td>
                                            <td> {{ $calculation->closing_balance }} </td>
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
                                    {{ $transactions->links() }}  
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
