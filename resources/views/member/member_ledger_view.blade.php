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
                            Ledger
                        </h3>
                        <div class="card-body">      
                            <div class="table-responsive">
                                <table id="stock_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Ledger Credit</th>
                                            <th>Ledger Debit</th>
                                            <th>Net Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ledgerdata as $oneledger)
                                        <tr>
                                        	<td>{{ $oneledger->date }}</td>
                                        	<td>{{ $oneledger->name }}</td>
                                        	<td>{{ $oneledger->ledger_cr }}</td>
                                        	<td>{{ $oneledger->ledger_dr }}</td>
                                        	<td>{{ $oneledger->net_balance }}</td>
                                        </tr>
                                        @endforeach
                                        @if(!empty($closing_balance))
                                        <tr class="headerfootercolor">
                                        	<td></td>
                                        	<td>Closing Balance : </td>
                                        	<td>{{ $closing_balance->ledger_cr }}</td>
                                        	<td>{{ $closing_balance->ledger_dr }}</td>
                                        	<td>{{ $closing_balance->net_balance }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
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
