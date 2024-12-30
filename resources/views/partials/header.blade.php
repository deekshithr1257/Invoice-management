<div class="nav-header">
    <div class="brand-logo">
        <a href="{{ url('/') }}"> <!-- Adjust URL as needed -->
            <b class="logo-abbr">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Abbreviated">
            </b>
            <span class="logo-compact">
                <img src="{{ asset('images/logo-compact.jpg') }}" alt="Compact Logo">
            </span>
            <span class="brand-title">
                <img src="{{ asset('images/logo-text.jpg') }}" alt="Brand Title">
            </span>
        </a>
    </div>
</div>
<div class="header">    
    <div class="header-content clearfix">
        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>
        <!-- <div class="header-left">
            <div class="input-group icons">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1">
                        <i class="mdi mdi-magnify"></i>
                    </span>
                </div>
                <input type="search" class="form-control" placeholder="Search Dashboard" aria-label="Search Dashboard">
                <div class="drop-down animated flipInX d-md-none">
                    <form action="#">
                        <input type="text" class="form-control" placeholder="Search">
                    </form>
                </div>
            </div>
        </div> -->
        <div class="header-right">
            <ul class="clearfix">
                <!-- <li class="icons dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown">
                        <i class="mdi mdi-email-outline"></i>
                        <span class="badge badge-pill gradient-1">3</span>
                    </a>
                    <div class="drop-down animated fadeIn dropdown-menu">
                        <div class="dropdown-content-heading d-flex justify-content-between">
                            <span class="">3 New Messages</span>
                            <a href="javascript:void()" class="d-inline-block">
                                <span class="badge badge-pill gradient-1">3</span>
                            </a>
                        </div>
                        <div class="dropdown-content-body">
                            <ul>
                                <li class="notification-unread">
                                    <a href="javascript:void()">
                                        <img class="float-left mr-3 avatar-img" src="{{ asset('images/avatar/1.jpg') }}" alt="">
                                        <div class="notification-content">
                                            <div class="notification-heading">Saiful Islam</div>
                                            <div class="notification-timestamp">08 Hours ago</div>
                                            <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-unread">
                                    <a href="javascript:void()">
                                        <img class="float-left mr-3 avatar-img" src="{{ asset('images/avatar/2.jpg') }}" alt="">
                                        <div class="notification-content">
                                            <div class="notification-heading">Adam Smith</div>
                                            <div class="notification-timestamp">08 Hours ago</div>
                                            <div class="notification-text">Can you do me a favour?</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void()">
                                        <img class="float-left mr-3 avatar-img" src="{{ asset('images/avatar/3.jpg') }}" alt="">
                                        <div class="notification-content">
                                            <div class="notification-heading">Barak Obama</div>
                                            <div class="notification-timestamp">08 Hours ago</div>
                                            <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void()">
                                        <img class="float-left mr-3 avatar-img" src="{{ asset('images/avatar/4.jpg') }}" alt="">
                                        <div class="notification-content">
                                            <div class="notification-heading">Hilari Clinton</div>
                                            <div class="notification-timestamp">08 Hours ago</div>
                                            <div class="notification-text">Hello</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="icons dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown">
                        <i class="mdi mdi-bell-outline"></i>
                        <span class="badge badge-pill gradient-2">3</span>
                    </a>
                    <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                        <div class="dropdown-content-heading d-flex justify-content-between">
                            <span class="">2 New Notifications</span>
                            <a href="javascript:void()" class="d-inline-block">
                                <span class="badge badge-pill gradient-2">5</span>
                            </a>
                        </div>
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="javascript:void()">
                                        <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                        <div class="notification-content">
                                            <h6 class="notification-heading">Events near you</h6>
                                            <span class="notification-text">Within next 5 days</span> 
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void()">
                                        <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                        <div class="notification-content">
                                            <h6 class="notification-heading">Event Started</h6>
                                            <span class="notification-text">One hour ago</span> 
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void()">
                                        <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                        <div class="notification-content">
                                            <h6 class="notification-heading">Event Ended Successfully</h6>
                                            <span class="notification-text">One hour ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void()">
                                        <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                        <div class="notification-content">
                                            <h6 class="notification-heading">Events to Join</h6>
                                            <span class="notification-text">After two days</span> 
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li> -->
                <li class="icons dropdown d-md-flex">
                            <form method="POST" action="{{ route('admin.set.store') }}" class="form-inline">
                                @csrf
                                @if($stores->isEmpty())
                                    <select name="store_id" class="header-select" disabled>
                                        <option value="" selected>Please create your</option>
                                    </select>
                                @else
                                    <select name="store_id" class="header-select" onchange="this.form.submit()">
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}" {{ session('selected_store_id') == $store->id ? 'selected' : '' }}>
                                                {{ $store->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </form>
                    <!-- <a href="javascript:void(0)" class="log-user" data-toggle="dropdown">
                        <i class="fas fa-store f-s-14" aria-hidden="true"></i><span>All</span>
                    </a>
                    <div class="drop-down dropdown-language animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="javascript:void()">All</a></li>
                                @foreach($stores as $store)
                                    <li><a href="javascript:void()">{{ $store->name }}</a></li>
                                @endforeach
                            </ul>
                            
                        </div>
                    </div> -->
                </li> 
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{ asset('images/user/1.png') }}" height="40" width="40" alt="">
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="{{ url('app-profile') }}"><i class="icon-user"></i> <span>Profile</span></a>
                                </li>
                                <li>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                                        <i class="icon-key"></i> 
                                        <span class="nav-text">{{ trans('global.logout') }}</span>
                                    </a>
                                </li>

                                <!-- Logout Form (hidden) -->
                                <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>