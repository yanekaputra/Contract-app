<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= BASE_URL ?>/dashboard">
            <i class="bi bi-hospital"></i> RS Contract System
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/dashboard">Dashboard</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge badge-danger notification-count" style="display: none;">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="width: 300px;">
                        <h6 class="dropdown-header">Notifikasi</h6>
                        <div id="notification-list" class="px-2">
                            <p class="text-muted text-center py-2">Loading...</p>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center" href="<?= BASE_URL ?>/notifications">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <?= $_SESSION['user_name'] ?? 'User' ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?= BASE_URL ?>/profile">
                            <i class="bi bi-person"></i> Profile
                        </a>
                        <a class="dropdown-item" href="<?= BASE_URL ?>/change-password">
                            <i class="bi bi-key"></i> Ganti Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= BASE_URL ?>/logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>