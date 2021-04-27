<div class="nk-header nk-header-fixed is-light">
    <div class="container-lg wide-xl">
        <div class="nk-header-wrap">
            <div class="nk-header-brand">
                <a href="{{ route('dashboard') }}" class="logo-link">
                    <img class="logo-light logo-img" src="{{ url('img/logo.png') }}" >
                    <img class="logo-dark logo-img" src="{{ url('img/logo.png') }}" >
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                                <div class="user-name dropdown-indicator d-none d-sm-block">{{ $person->first_name }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <span>{{ $person->first_name[0] }}</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{ $person->first_name }}</span>
                                        <span class="sub-text">{{ $person->email }}</span>
                                    </div>
                                    <!--
                                    <div class="user-action">
                                        <a class="btn btn-icon mr-n2" href="#"><em class="icon ni ni-setting"></em></a>
                                    </div>
                                    -->
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="#"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    <li><a href="#"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                    <li><a href="#"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <em class="icon ni ni-signout"></em><span>Sign out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li><!-- .dropdown -->
                    <li class="dropdown notification-dropdown">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon mr-lg-n1" data-toggle="dropdown">
                            <div class="{{ $notices->count()>0?'icon-status icon-status-info':'' }}"><em class="icon ni ni-bell"></em></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">Notifications</span>
                            </div>
                            <div class="dropdown-body">
                                <div class="nk-notification">
                                    @forelse($notices as $notice)
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <a href="{{ route('open.notice', $notice->uuid) }}">
                                                    <em class="icon icon-circle bg-warning-dim ni ni-alert"></em>
                                                </a>
                                            </div>
                                            <div class="nk-notification-content">
                                                <a href="{{ route('open.notice', $notice->uuid) }}">
                                                    <div class="nk-notification-text">{{ $notice->title }}</div>
                                                </a>
                                                <div class="nk-notification-time">{{ $notice->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>

                                    @empty
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">Nothing to show</div>
                                            </div>
                                        </div>
                                    @endforelse

                                </div><!-- .nk-notification -->
                            </div><!-- .nk-dropdown-body -->
                            <div class="dropdown-foot center">
                                <a href="{{ route('notice.index',['type'=>'all']) }}">View More</a>
                            </div>
                        </div>
                    </li><!-- .dropdown -->
                    <li class="d-lg-none">
                        <a href="#" class="toggle nk-quick-nav-icon mr-n1" data-target="sideNav"><em class="icon ni ni-menu"></em></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>