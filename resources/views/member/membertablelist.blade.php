@extends('layouts.master')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')

<div class="dashboard-wrapper">
    @include('member.include.banner')
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Members</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Member</a></li>
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
                    <h5 class="card-header">Members Data 
                        <a href="{{ route('addnewmember') }}" class="btn btn-primary text-white float-right btn-sm">Add new member</a>
                    </h5>
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table id="referrals_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>First name</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Member Code</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $onemember)
                                    <tr>
                                        <td>{{ $onemember->firstname }}</td>
                                        <td>{{ $onemember->lastname }}</td>
                                        <td>{{ $onemember->email }}</td>
                                        <td>{{ $onemember->contact }}</td>
                                        <td>{{ $onemember->member_code }}</td>
                                        <td style="width: 100px">
                                            @if(!empty($onemember->image) && $onemember->image != 'NA')
                                                <img src="{{ url(\Storage::url("app/".$onemember->image)) }}" alt="User Avatar" class="user-avatar-xxl">
                                            @else
                                                <img src="{{ url(\Storage::url("app/member_images/default.jpg")) }}" alt="User Avatar" class="user-avatar-xxl">
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('addnewmember',['member_id'=>$onemember->id]) }}">
                                                Edit
                                            </a>
                                            <button usermemebercode="{{ $onemember->member_code }}" class="btn btn-danger btn-sm" onclick="confirmation(this)" responseurl="{{ route('delete_member',['member_id'=>$onemember->id]) }}">Delete</button>
                                            <a target="_blank" href="{{ route('show_ledger_member',['member_id'=>$onemember->id]) }}" class="btn btn-warning btn-sm">View Ledger</a>
                                        </td>
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

        const confirmation = event => {
            if (confirm("Are you sure do u want to delete user : "+event.getAttribute('usermemebercode')+" ?")) {
                window.location.href = event.getAttribute('responseurl');
            }
        } 

        $(document).ready(() => DataTableObj.draw());
        var DataTableObj = $('#referrals_table').DataTable({
            "pageLength": 50,
            "responsive": true,
            "deferLoading": true,
            "search": {
                "search": $('#lavel_selector').val(),
            }
        }); 
    </script>
@endsection