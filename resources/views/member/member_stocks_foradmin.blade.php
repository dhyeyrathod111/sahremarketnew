@extends('layouts.master')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            {{-- <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"> Welcome {{ $member->firstname." ".$member->lastname }} ({{ $member->member_code }}) 
                            @if(session()->has('message'))
                                <div class="alert {{session('alert') ?? 'alert-info'}} text-center">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- ============================================================== -->
            <!-- end pageheader  -->
            <!-- ============================================================== -->
            <div class="ecommerce-widget">
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- basic table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h3 class="card-header">
                                {{ $member->member_code }}

                                <a href="{{ route('download_excel',[
                                    'start_date' => request()->start_date,
                                    'end_date' => request()->end_date,
                                    'filter' => request()->filter
                                    'member_id' => request()->member_id
                                ]) }}" class="btn btn-primary float-right">Download PDF</a>
                            </h3>

                            <div class="card-header">
                                <form method="GET" action="{{ route('member_stocks_foradmin') }}" id="filter_form">
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
                                            <input type="hidden" value="{{ $member->id }}" name="member_id">
                                            <button class="btn btn-primary" type="submit">Submit form</button>
                                            <a class="btn btn-primary" href="{{ route('member_stocks_foradmin',['member_id'=>$member->id]) }}">Reset</a>
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
                                                <td>{{ $onetransection->date }}</td>
                                                <td>{{ $onetransection->trade_id }}</td>
                                                <td>{{ $onetransection->position }}</td>
                                                <td>{{ $onetransection->stock_entry }}</td>
                                                <td>{{ $onetransection->stock_exit }}</td>
                                                <td>{{ $onetransection->net_exit }}</td>
                                                <td>{{ $onetransection->amount }}</td>
                                                <td>{{ $onetransection->opening_balance }}</td>
                                                <td>{{ $onetransection->closing_balance }}</td>
                                                <td>{{ $onetransection->time }}</td>
                                                <td>{{ $onetransection->brokrage }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end basic table  -->
                    <!-- ============================================================== -->
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    @include('member.include.footer')
    <!-- ============================================================== -->
    <!-- end footer -->
    <!-- ============================================================== -->
</div>

@endsection

@section('pagescript')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src=" {{ asset('public/assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        // $(document).ready(() => DataTableObj.draw());
        var DataTableObj = $('#stock_table').DataTable({
            "pageLength": 50,
        }); 
    </script>
@endsection