<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle" href="#">
                <i class="bi bi-search"></i>
            </a>
        </li><!-- End Search Icon -->

        <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0 dropdown-toggle" href="#"
                data-bs-toggle="dropdown">
                <div
                    style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; background-color: #ccc; display: flex; justify-content: center; align-items: center;">
                    <i class="bi bi-person-fill" style="font-size: 48px; color: white;"></i>
                </div>
                <span class="d-none d-md-block ps-2">{{ auth()->user()->name }}</span>
            </a><!-- End Profile Image Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6>{{ auth()->user()->name }}</h6>
                    <span>Admin</span>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile-page') }}">
                        <i class="bi bi-person"></i> <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i> <span>Sign Out</span>
                        </button>
                    </form>
                </li>
            </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

    </ul>
</nav><!-- End Icons Navigation -->

<!-- Bootstrap JS and Popper.js (Place before closing body tag) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
