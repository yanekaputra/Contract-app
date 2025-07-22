<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Dokter</h2>
    <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
    <a href="<?= BASE_URL ?>/doctors/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Dokter
    </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Spesialisasi</th>
                        <th>No. STR</th>
                        <th>Status STR</th>
                        <th>No. SIP</th>
                        <th>Status SIP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doctors as $doctor): ?>
                        <tr>
                            <td><?= htmlspecialchars($doctor['employee_code']) ?></td>
                            <td><?= htmlspecialchars($doctor['full_name']) ?></td>
                            <td><?= htmlspecialchars($doctor['specialization']) ?></td>
                            <td><?= htmlspecialchars($doctor['str_number']) ?></td>
                            <td>
                                <?php
                                require_once dirname(__DIR__) . '/../Helpers/DateHelper.php';
                                echo DateHelper::getStatusBadge($doctor['str_days_remaining']);
                                ?>
                            </td>
                            <td><?= htmlspecialchars($doctor['sip_number']) ?></td>
                            <td>
                                <?php echo DateHelper::getStatusBadge($doctor['sip_days_remaining']); ?>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>/doctors/view/<?= $doctor['employee_id'] ?>" 
                                   class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
                                <a href="<?= BASE_URL ?>/doctors/edit/<?= $doctor['employee_id'] ?>" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/contracts/create/<?= $doctor['employee_id'] ?>" 
                                   class="btn btn-sm btn-success" title="Tambah Kontrak">
                                    <i class="bi bi-file-plus"></i>
                                </a>
                                <?php endif; ?>
                                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <button onclick="confirmDelete(<?= $doctor['employee_id'] ?>)" 
                                        class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data dokter ini?')) {
        window.location.href = '<?= BASE_URL ?>/doctors/delete/' + id;
    }
}
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>