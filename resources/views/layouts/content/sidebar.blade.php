<div class="nk-aside" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">
    <div class="nk-sidebar-menu" data-simplebar>
        <!-- Menu -->
        <ul class="nk-menu">
            <li class="nk-menu-heading">
                <h6 class="overline-title">Menu</h6>
            </li>
            <li class="nk-menu-item">
                <a href="{{ route('dashboard') }}" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                    <span class="nk-menu-text">Dashboard</span>
                </a>
            </li>
            <li class="nk-menu-item">
                <a href="{{ route('record.index') }}" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                    <span class="nk-menu-text">Records</span>
                </a>
            </li>

            <li class="nk-menu-item">
                <a href="{{ route('notice.index') }}" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon ni ni-bell"></em></span>
                    <span class="nk-menu-text">Notification</span>
                </a>
            </li>

            <li class="nk-menu-item">
                <a href="{{ route('account.edit', $person->uuid) }}" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon ni ni-user-circle"></em></span>
                    <span class="nk-menu-text">Profile</span>
                </a>
            </li>

            @if($person->hasAccess('admin'))
                <li class="nk-menu-heading">
                    <h6 class="overline-title">Administration</h6>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('process.index') }}" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-send-alt"></em></span>
                        <span class="nk-menu-text">Processes</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('measure.index') }}" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-list-check"></em></span>
                        <span class="nk-menu-text">Measure</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('product.index') }}" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-box"></em></span>
                        <span class="nk-menu-text">Product</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('group.index') }}" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                        <span class="nk-menu-text">Department</span>
                    </a>
                </li>
            @endif

            @if($person->hasAccess('admin'))
                <li class="nk-menu-heading">
                    <h6 class="overline-title">Settings</h6>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('account.index') }}" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
                        <span class="nk-menu-text">Users</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('role.index') }}" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-shield-alert"></em></span>
                        <span class="nk-menu-text">User Role</span>
                    </a>
                </li>
            @endif
        </ul>
        <!-- Menu -->

    </div><!-- .nk-sidebar-menu -->
    <div class="nk-aside-close">
        <a href="#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
    </div><!-- .nk-aside-close -->
</div><!-- .nk-aside -->