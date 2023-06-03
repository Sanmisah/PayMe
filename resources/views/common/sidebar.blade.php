<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
        <i class="fa fa-money"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Pay Me</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
    Masters
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fas fa-file-alt"></i>
            <span>Masters</span>
        </a>
        <div id="taTpDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Masters:</h6>
                <a class="collapse-item" href="{{ route('areas.index') }}">Area</a>
                <a class="collapse-item" href="{{ route('accounts.index') }}">Account</a>
                @hasrole('Admin')
                <a class="collapse-item" href="{{ route('agents.index') }}">Agents</a>
                @endhasrole
            </div>
        </div>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
    Transactions
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transactionDropDown"
            aria-expanded="true" aria-controls="transactionDropDown">
            <i class="fas fa-file-alt"></i>
            <span>Transactions</span>
        </a>
        <div id="transactionDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Transactions:</h6>
                <a class="collapse-item" href="{{ route('loans.index') }}">Loans</a>
                <a class="collapse-item" href="{{ route('loan_repayments.index') }}">Loan Repayments</a>
            </div>
        </div>
    </li>
     <!-- Heading -->
     <div class="sidebar-heading">
    Reports
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reportDropDown"
            aria-expanded="true" aria-controls="reportDropDown">
            <i class="fas fa-file-alt"></i>
            <span>Reports</span>
        </a>
        <div id="reportDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('report.loan') }}">Loan Repayments Report</a>
                <a class="collapse-item" href="{{ route('collections') }}">Collection Report</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    @hasrole('Admin')
    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#aTpDropDown"
            aria-expanded="true" aria-controls="aTpDropDown">
            <i class="fas fa-user-alt"></i>
            <span>Admin Section</span>
        </a>
        <div id="aTpDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management:</h6>
                <a class="collapse-item" href="{{ route('users.index') }}">List</a>
                <a class="collapse-item" href="{{ route('users.create') }}">Add New</a>
                <h6 class="collapse-header">Role & Permissions</h6>
                <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
            </div>
        </div>
    </li>

         

       

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
