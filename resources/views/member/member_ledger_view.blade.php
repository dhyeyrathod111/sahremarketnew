@extends('layouts.master')


@section('content')

<div class="dashboard-wrapper">
    @include('member.include.banner')
    <div class="container-fluid dashboard-content pt-0">
        <div class="ecommerce-widget">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                    <div class="card">
                        <div class="card-body p-0">      
                            <div class="table-responsive">
                                <table id="stock_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="background: #fcdb68">Client code</th>
                                            <th style="background: #fcdb68">Proton code</th>
                                            <th style="background: #fcdb68">Opning Qty</th>
                                            <th style="background: #fcdb68">Ledger Size</th>
                                            <th style="background: #fcdb68">Opning Bal
                                                <a href="{{ route('show_ledger_member',[ 'download' => TRUE, "member_id" => $member->id]) }}" class="float-right btn btn-primary btn-sm p-1">Download</a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="background: #af9b20;color: white">{{ $member->member_code }}</th>
                                            <th style="background: #af9b20;color: white">{{ $member->password }}</th>
                                            <th style="background: #af9b20;color: white">{{ $member->opening_quantity }}</th>
                                            <th style="background: #af9b20;color: white">{{ $member->ledger_size }}</th>
                                            <th style="background: #af9b20;color: white">{{ $member->opning_balance }}</th>
                                        </tr>
                                        <tr>
                                            <th style="background: #011e58; color: white">Date</th>
                                            <th style="background: #011e58; color: white">Transaction Description</th>
                                            <th style="background: #011e58; color: white">Ledger Credit</th>
                                            <th style="background: #011e58; color: white">Ledger Debit</th>
                                            <th style="background: #011e58; color: white">Net Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ledgerdata as $oneledger)
                                        <tr>
                                        	<td>{{  date('d-m-Y', strtotime($oneledger->date))  }}</td>
                                        	<td>{{ $oneledger->name }}</td>
                                        	<td>{{ str_replace(" ", "", $oneledger->ledger_cr) }}</td>
                                        	<td>{{ str_replace(" ", "", $oneledger->ledger_dr) }}</td>
                                        	<td>{{ str_replace(" ", "", $oneledger->net_balance) }}</td>
                                        </tr>
                                        @endforeach
                                        @if(!empty($closing_balance))
                                        <tr class="headerfootercolor">
                                        	<td></td>
                                        	<td>Closing Balance : </td>
                                        	<td>{{ str_replace(" ", "", $closing_balance->ledger_cr) }}</td>
                                        	<td>{{ str_replace(" ", "", $closing_balance->ledger_dr) }}</td>
                                        	<td>{{ str_replace(" ", "", $closing_balance->net_balance) }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
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
