<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

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
	<img class="img-fluid w-100" src="{{ asset('public/assets/images/banner_pdf_file.png') }}">

    <table style="border: none;width: 100%">
        <tr style="border: none;text-align: center; background: #ffd966">
            <td style="border: none;padding: 5px">Client Code</td>
            <td style="border: none;padding: 5px">Proton Code</td>
            <td style="border: none;padding: 5px">Opening Qty</td>
            <td style="border: none;padding: 5px">Ledger Size</td>
            <td style="border: none;padding: 5px">Opening Bal</td>
        </tr>
        <tr style="border: none;text-align: center;background: #ae9a24">
            <td style="border: none;padding: 5px">{{ $member->member_code }}</td>
            <td style="border: none;padding: 5px">{{ $member->password }}</td>
            <td style="border: none;padding: 5px"></td>
            <td style="border: none;padding: 5px"></td>
            <td style="border: none;padding: 5px"></td>

        </tr>
    </table>
    
	<table class="table">
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
                <!-- <th>time</th> -->
                <!-- <th>brokrage</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($transection as $onetransection)
            <tr>
                <td>{{ date('d-m-Y', strtotime($onetransection->date)) }}</td>
                <td>{{ $onetransection->trade_id }}</td>
                <td>{{ $onetransection->position }}</td>
                <td>{{ round($onetransection->stock_entry,2) }}</td>
                <td>{{ round($onetransection->stock_exit,2) }}</td>
                <td>{{ round($onetransection->net_exit,2) }}</td>
                <td>{{ $onetransection->amount }}</td>
                <td>{{ $onetransection->opening_balance }}</td>
                <td>{{ $onetransection->closing_balance }}</td>
                <!-- <td>{{ $onetransection->time }}</td> -->
                <!-- <td>{{ strpos($onetransection->brokrage,"₹") ? $onetransection->brokrage : round($onetransection->brokrage,2)  }}</td> -->
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
            </tr>
            @endif
        </tbody>
    </table>
    
    <hr style="height: 5px;border-width:0;color:white;background-color:white">

    <table style="border: 2px solid black;width: 100%;">
        <tr style="border: none;">
            <td style="border: none;padding: 5px">*Merely Individual Entity Being Acknowleged as Valid Ledger Client</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;padding: 5px">*Long term Debits shall be levy Anually Intrest @18%</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;padding: 5px">*Proton Code is Higly Classified, Company shall not responsible for misuses from client side</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;padding: 5px">*Any Error in Ledger should be notify within Seven Uk Working Days</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;padding: 5px">*Computer generated bill/Ledger carries no signature</td>
        </tr>
    </table>

</body>
</html>