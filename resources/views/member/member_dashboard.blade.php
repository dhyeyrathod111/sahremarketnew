@extends('layouts.master')


@section('content')

<div class="dashboard-wrapper">
    @include('member.include.banner')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            
            <!-- ============================================================== -->
            <!-- end pageheader  -->
            <!-- ============================================================== -->
            <div class="ecommerce-widget">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card influencer-profile-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="text-center">
                                            @if($member->image != "NA")
                                                <img src="{{ url(\Storage::url("app/".$member->image)) }}" alt="User Avatar" class="rounded-circle user-avatar-xxl">
                                            @else
                                                <img src="{{ url(\Storage::url("app/member_images/default.jpg")) }}" alt="User Avatar" class="rounded-circle user-avatar-xxl">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                        <div class="user-avatar-info">
                                            <div class="m-b-20">
                                                <div class="user-avatar-name">
                                                    <h2 class="mb-1">{{ $member->firstname }} {{ $member->lastname }}</h2>
                                                </div>
                                                <div class="rating-star  d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <p class="d-inline-block text-dark">14 Reviews </p>
                                                </div>
                                            </div>  
                                            <div class="user-avatar-address">
                                                <p class="border-bottom pb-3">
                                                    <span class="d-xl-inline-block d-block mb-2"><b>Member Code:</b> {{ $member->member_code }}</span>
                                                    <!-- <span class="mb-2 ml-xl-4 d-xl-inline-block d-block"><b>Joined date:</b> 21/05/2022</span> -->
                                                    <span class="mb-2 ml-xl-4 d-xl-inline-block d-block"><b>Email:</b> {{ $member->email }}</span>
                                                </p>
                                                <div class="mt-3">
                                                    <a href="#" class="badge badge-light mr-1">Fitness</a> <a href="#" class="badge badge-light mr-1">Life Style</a> <a href="#" class="badge badge-light">Gym</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
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
