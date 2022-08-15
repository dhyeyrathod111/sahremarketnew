<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            {{-- <a class="d-xl-none d-lg-none" href="#">Dashboard</a> --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>

                    @if(request()->session()->get('is_admin') == 1)
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('member/dashboard')) ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fa fa-fw fa-user-circle"></i>SGX Trade Ledger <span class="badge badge-success">6</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('member/memberlist') || request()->is('member/addnewmember')) ? 'active' : '' }}" href="{{ route('memberlist') }}" ><i class="fas fa-hands-helping"></i>Members</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('member/stock*')) ? 'active' : '' }}" href="{{ route('stock_list_route') }}" ><i class="fas fa-hands-helping"></i>Stock Assignment</a>
                        </li>
                    @else;
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('member/member_dashboard')) ? 'active' : '' }}" href="{{ route('member_dashboard') }}" ><i class="fas fa-hands-helping"></i>Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('member/member_tradereport')) ? 'active' : '' }}" href="{{ route('member_tradereport') }}" ><i class="fas fa-hands-helping"></i>SGX Trade Ledger</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('member/show_ledger_member')) ? 'active' : '' }}" href="{{ route('show_ledger_member') }}" ><i class="fas fa-hands-helping"></i>Ledger</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('member/help_center')) ? 'active' : '' }}" href="{{ route('help_center') }}" ><i class="fas fa-hands-helping"></i>Help center</a>
                        </li>

                    @endif




                    
                   
                        
                   

                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="btn btn-primary btn-block">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>