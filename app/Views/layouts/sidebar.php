<nav class="sidebar bg-light">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/dashboard">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'doctors') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/doctors">
                    <i class="bi bi-person-badge"></i> Data Dokter
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'staff') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/staff">
                    <i class="bi bi-people"></i> Data Staff
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'contracts') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/contracts">
                    <i class="bi bi-file-text"></i> Kontrak
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'placements') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/placements">
                    <i class="bi bi-building"></i> Penempatan Unit
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'notifications') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/notifications">
                    <i class="bi bi-bell"></i> Notifikasi
                    <?php if (isset($unreadCount) && $unreadCount > 0): ?>
                        <span class="badge badge-danger"><?= $unreadCount ?></span>
                    <?php endif; ?>
                </a>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <i class="bi bi-file-earmark-text"></i> Laporan
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= BASE_URL ?>/reports/expired-documents">
                        Dokumen Kadaluarsa
                    </a>
                    <a class="dropdown-item" href="<?= BASE_URL ?>/reports/employee-distribution">
                        Distribusi Karyawan
                    </a>
                </div>
            </li>
            
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/users">
                    <i class="bi bi-person-gear"></i> Manajemen User
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>