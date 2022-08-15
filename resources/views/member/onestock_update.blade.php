<?php
// dd($onestock);
?>
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
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Stock Assignment</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Stock Update</li>
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
                    <h5 class="card-header">Members form</h5>
                    <div class="card-body">
                        <div id="alert_message"></div>
                        <form id="add_new_stock" action="{{ route('update_single_stock_process') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Date:</label>
                                        <input type="text" value="{{ $onestock->date }}" name="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Trade Id:</label>
                                        <input type="text" value="{{ $onestock->trade_id }}" name="trade_id" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Position:</label>
                                        <input type="text" value="{{ $onestock->position }}" name="position" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Stock Entry:</label>
                                        <input type="text" value="{{ $onestock->stock_entry }}" name="stock_entry" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Amount:</label>
                                        <input type="text" value="{{ $onestock->amount }}" name="amount" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Opening Balance:</label>
                                        <input type="text" value="{{ $onestock->amount }}" name="amount" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Closing Balance:</label>
                                        <input type="text" value="{{ $onestock->closing_balance }}" name="closing_balance" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Time:</label>
                                        <input type="text" value="{{ $onestock->time }}" name="time" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Brokrage:</label>
                                        <input type="text" value="{{ $onestock->brokrage }}" name="brokrage" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $onestock->id }}" name="stock_id">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
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
    <script type="text/javascript">
        $("#add_new_stock").validate({
            rules: {
                
            },
            submitHandler: function(form) {
                var form_data = JSON.stringify($(form).serializeArray());
                $('#preloader').fadeIn();
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: JSON.parse(form_data),
                    success: response => {
                        $('#preloader').fadeOut();
                        if (response.status == true) {
                            notify_success(response.message);
                            setTimeout(event => { 
                                window.location.href = response.redirect_url;
                            }, 2500);
                        } else {
                            notify_error(response.message);
                        }
                    },
                    error: response => {
                        $('#preloader').fadeOut();console.log(response);notify_error();
                    }
                });
            },
        });
    </script>
@endsection

