@extends('layouts.master')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Stocks</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Stocks</a></li>
                                {{-- <li class="breadcrumb-item active" aria-current="page">Data Tables</li> --}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Stock Data 
                        <a href="{{ route('stock_assignment') }}" class="btn btn-primary text-white float-right btn-sm">Add New Stock</a>
                    </h5>
                    <div class="card-header">
                        <form method="GET" action="{{ route('stock_list_route') }}" id="filter_form">
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
                                    <a class="btn btn-primary" href="{{ route('stock_list_route') }}">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table id="stock_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>id</th>
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
                                        <th>Member Code</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $onetransection)
                                    <tr>
                                        <td>{{ $onetransection->id }}</td>
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
                                        <td>{{ $onetransection->brokrage  }}</td>
                                        <td>{{ $onetransection->member_code }}</td>
                                        <td><a class="btn btn-primary btn-sm" href="{{ route('update_single_stock',['stock_id' => Crypt::encryptString($onetransection->id) ]) }}"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                    @endforeach
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
            <!-- ============================================================== -->
            <!-- end basic table  -->
            <!-- ============================================================== -->
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
    {{-- <script src=" {{ asset('public/assets/vendor/datatables/js/data-table.js') }}"></script> --}}
    <script type="text/javascript">
        // var DataTableObj = $('#stock_table').DataTable({
        //     // "pageLength": 50,
        //     // "columnDefs": [
        //     //     { "width": "50%", "targets": 0 }
        //     //   ]
        // }); 
    </script>
@endsection