<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Profil Saya</h2>
    <a href="<?= BASE_URL ?>/change-password" class="btn btn-warning">
        <i class="bi bi-key"></i> Ganti Password
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <td width="200"><strong>Username:</strong></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
            </tr>
            <tr>
                <td><strong>Nama Lengkap:</strong></td>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <tr>
                <td><strong>Role:</strong></td>
                <td>
                    <span class="badge badge-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'hr' ? 'warning' : 'info') ?>">
                        <?= ucfirst($user['role']) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    <?php if ($user['is_active']): ?>
                        <span class="badge badge-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Nonaktif</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><strong>Terakhir Login:</strong></td>
                <td><?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : '-' ?></td>
            </tr>
            <tr>
                <td><strong>Terdaftar Sejak:</strong></td>
                <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
            </tr>
        </table>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>