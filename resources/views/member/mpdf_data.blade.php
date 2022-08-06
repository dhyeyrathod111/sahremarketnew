<!DOCTYPE html>
<html>
<head>
	<title></title>
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
	{{-- <table style="border: none;width: 100%">
		<tr style="border: none;text-align: center;">
			<td style="border: none;padding: 5px">Name : Dhyey Rathd</td>
			<td style="border: none;padding: 5px">Name : Dhyey Rathd</td>
			<td style="border: none;padding: 5px">Name : Dhyey Rathd</td>
		</tr>
		<tr style="border: none;text-align: center;">
			<td style="border: none;padding: 5px">Name : Dhyey Rathd</td>
			<td style="border: none;padding: 5px">Name : Dhyey Rathd</td>
		</tr>
	</table> --}}
	<table style="autosize:2.4;">
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
</body>
</html>