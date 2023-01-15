<!DOCTYPE html>
<html>
<head>

	<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th,
    td {
        padding: 20px;
    }
    .headerfootercolor {
        background: yellowgreen !important;
        color: black !important;
    }
    </style>
</head>
<body>
	<img style="width: 100%;height: 120px" src="{{ asset('public/assets/images/banner_pdf_file.png') }}">
    
    <table style="width: 100%">
        <thead>
            <tr>
                <th style="background: #fcdb68">Client code</th>
                <th style="background: #fcdb68">Proton code</th>
                <th style="background: #fcdb68">Opning Qty</th>
                <th style="background: #fcdb68">Ledger Size</th>
                <th style="background: #fcdb68">Opning Bal</th>
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


    <table style="border: 1px solid black;width: 100%;">
        <tr style="border: none;">
            <td style="border: none;padding: 0px;font-size: 7px;">*Merely Individual Entity Being Acknowleged as Valid Ledger Client</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;padding: 0px;font-size: 7px;">*Long term Debits shall be levy Anually Intrest @18%</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;padding: 0px;font-size: 7px;">*Proton Code is Higly Classified, Company shall not responsible for misuses from client side</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;padding: 0px;font-size: 7px;">*Any Error in Ledger should be notify within Seven Uk Working Days</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;padding: 0px;font-size: 7px;">*Computer generated bill/Ledger carries no signature</td>
        </tr>
    </table>
    

</body>
</html>