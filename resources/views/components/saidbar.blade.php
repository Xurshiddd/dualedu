<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <div class="user-img-div">
                    <p style="font-size: larger; font-weight: 900; color: white; display: flex; justify-content: center; align-items: center">
                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                    </p>
                </div>
            </li>
            <li>
                <a class="active-menu" href="{{ route('dashboard') }}"><i class="fa fa-dashboard "></i>Dashboard</a>
            </li>
            @if(auth()->user()->hasRole('Admin'))
            <li>
                <a href="#"><i class="fa fa-lock" aria-hidden="true"></i>Ruxsatlar<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('roles.index')}}">Role</a>
                    </li>
                    <li>
                        <a href="{{ route('permissions.index') }}">Permission</a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                </ul>
            </li>
            @endif
            @can('moderator')
            <li>
                <a href="#"><i class="fa-solid fa-code-pull-request"></i>Moderator<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('students.index') }}">Talabalar</a>
                    </li>
                    <li>
                        <a href="{{ route('groups.index') }}">Guruh</a>
                    </li>
                    <li>
                        <a href="{{ route('addresses.index') }}">Manzil</a>
                    </li>
                    <li>
                        <a href="{{ route('practics.index') }}">Amaliyot davri</a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('inspector')
            <li>
                <a href="{{ route('inspectors.index') }}"><i class="fa-solid fa-briefcase"></i>Tekshiruv</a>
            </li>
            @endcan
        </ul>
    </div>
</nav>
