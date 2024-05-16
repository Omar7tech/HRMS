<div class="sidebar close">
    <div class="logo-details">
        <i class="bi bi-people"></i>

        <span class="logo_name">Hrms</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/home">
                <i class='home-icon bx bx-home'></i>
                <span class="link_name">Home</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/home">Home</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='user-icon bx bx-user'></i>
                    <span class="link_name">Employees</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Employees</a></li>
                <li><a href="{{ route('employee.index') }}">Employees</a></li>
                <li><a href="{{ route('trainee.index') }}">Trainees</a></li>
                <li><a href="{{ route('employee.create') }}">Add Employee/Trainee</a></li>
                <li><a href="{{ route('employees.statistics') }}">Statistics</a></li>
                <li><a href="{{ route('employees.terminated') }}">Terminated Employees</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='user-icon bx bx-cog'></i>

                    <span class="link_name">Settings</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Settings</a></li>
                <li><a href="{{ route('positions.index') }}">Positions</a></li>
                <li><a href="{{ route('vacations.index') }}">Vacations</a></li>
                <li><a href="{{ route('schedules.index') }}">Schedules</a></li>
                <li><a href="{{ route('uuid.index') }}">UUID</a></li>
                <li><a href="{{ route('about') }}">About</a></li>

                {{--                 <li><a href="{{ route('employee.create') }}">Add Employee</a></li>
 --}}
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-book-alt'></i>
                    <span class="link_name">Storage</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Storage</a></li>
                <li><a href="{{ route("trained.index") }}">trained</a></li>
                <li><a href="{{ route("online.jobs") }}">Online jobs</a></li>

            </ul>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <!--<img src="image/profile.jpg" alt="profileImg">-->
                </div>
                <div class="name-job">
                    <div class="profile_name">{{ Auth::user()->username }}</div>
                    <div class="job">{{ Auth::user()->first_name }}</div>
                </div>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" style="background: none ; border-style: none"><i
                            class='bx bx-log-out'></i></button>
                </form>
            </div>
        </li>
    </ul>
</div>
