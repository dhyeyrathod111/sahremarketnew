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
    </style>
</head>
<body>
	<img style="width: 100%;height: 120px" src="{{ asset('public/assets/images/banner_pdf_file.png') }}">
    <table style="border: none;width: 100%">
        @if(!empty($member))
            <tr style="border: none;text-align: center; background: #ffd966">
                <td style="border: none;padding: 5px">Client Code</td>
                <td style="border: none;padding: 5px">Proton Code</td>
                <td style="border: none;padding: 5px">Opening Quantity</td>
                <td style="border: none;padding: 5px">Ledger Size</td>
                <td style="border: none;padding: 5px">Opening Balance</td>
            </tr>
            <tr style="border: none;text-align: center;background: #ae9a24">
                <td style="border: none;padding: 5px;background: #af9b20;color: white">{{ $member->member_code }}</td>
                <td style="border: none;padding: 5px;background: #af9b20;color: white">{{ $member->password }}</td>
                <td style="border: none;padding: 5px;background: #af9b20;color: white">{{ $member->opening_quantity }}</td>
                <td style="border: none;padding: 5px;background: #af9b20;color: white">{{ $member->ledger_size }}</td>
                <td style="border: none;padding: 5px;background: #af9b20;color: white">{{ $member->opning_balance }}</td>
            </tr>
        @endif
    </table>
    
	<table class="table m-0">
        <thead>
            <tr>
                <th style="background: #011e58; color: white">Date</th>
                <th style="background: #011e58; color: white">Trade id</th>
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
            @foreach($transection as $onetransection)
            <tr>
                <td>{{ date('d-m-Y', strtotime($onetransection->date)) }}</td>
                <td>{{ $onetransection->trade_id }}</td>
                <td>{{ $onetransection->position }}</td>
                <td>{{ $onetransection->quantity }}</td>
                <td>{{ round($onetransection->stock_entry,2) }}</td>
                <td>{{ round($onetransection->stock_exit,2) }}</td>
                <td>{{ round($onetransection->net_exit,2) }}</td>
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
                <td> </td>
                <td> </td>
                <td> </td>
                <td> {{ round($calculation->net_exit,2) }} </td>
                <td> {{ "₹".round($calculation->amount,2) }} </td>
                <td> </td>
                <td> </td>
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