<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
      <li class="nav-item">
      <router-link to="/dashboard" class="nav-link">
        <i class="nav-icon fa fa-th text-primary"></i>
        <p>Dashboard</p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/profile" class="nav-link">
        <i class="nav-icon fa fa-user text-success"></i>
        <p>Profile</p>
      </router-link>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-cogs text-info"></i>
        <p>
          Setting
          <i class="right fa fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        @can('isAdmin')
        <li class="nav-item ml-4">
          <router-link to="/users" class="nav-link">
            <i class="fas fa-users nav-icon"></i>
            <p>Users</p>
          </router-link>
        </li>        
        <li class="nav-item ml-4">
          <router-link to="/company" class="nav-link">
            <i class="fas fa-building nav-icon"></i>
            <p>Teacher</p>
          </router-link>
        </li>
        <li class="nav-item ml-4">
          <router-link to="/jobs" class="nav-link">
            <i class="fas fa-briefcase nav-icon"></i>
            <p>Parent</p>
          </router-link>
        </li>
        <li class="nav-item ml-4">
          <router-link to="/jobs" class="nav-link">
            <i class="fas fa-briefcase nav-icon"></i>
            <p>Student</p>
          </router-link>
        </li>
        <li class="nav-item ml-4">
          <router-link to="/reports" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>Reports</p>
          </router-link>
        </li>
        @endcan
      </ul>
    </li>
    {{-- System --}}
    @can('isAdmin')
    <li class="nav-item">
      <router-link to="/token" class="nav-link">
        <i class="nav-icon fa fa-lock text-warning"></i>
        <p>Token</p>
      </router-link>
    </li>
    @endcan
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        <i class="nav-icon fa fa-power-off text-danger"></i>
        <p>{{ __('Logout') }}</p>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
    </li>
  </ul>