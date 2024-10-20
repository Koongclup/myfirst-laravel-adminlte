<nav class="main-header navbar navbar-expand navbar-{{ Auth::user()->mode }} navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto font-weight-bold">
        <!-- Dark/Light Mode Toggle -->
        <li class="nav-item">
            <a id="mode-toggle" class="nav-link" href="#" role="button" title="Toggle Dark/Light Mode">
                <i class="fas fa-adjust"></i>
            </a>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button">
                <i class="fas fa-user-circle mx-1"></i> {{ Auth::user()->name }} <!-- Display the authenticated user's name -->
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <!-- Profile Link -->
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mx-1"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <!-- Logout Link -->
                <a href="#" id="logout-btn" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mx-1"></i> Log out
                </a>
            </div>
        </li>
    </ul>

    <!-- Logout Form (hidden) -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
</nav>


<!-- SweetAlert Script for Logout Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   

    // Logout confirmation
    document.getElementById('logout-btn').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent immediate logout

        // SweetAlert confirmation popup
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the hidden logout form if confirmed
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
