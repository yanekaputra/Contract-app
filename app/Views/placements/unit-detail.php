<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Detail Unit: <?= htmlspecialchars($unit['unit_name']) ?></h2>
    <a href="<?= BASE_URL ?>/placements" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <p><strong>Kode Unit:</strong> <?= htmlspecialchars($unit['unit_code']) ?></p>
            </div>
            <div class="col-md-4">
                <p><strong>Tipe Unit:</strong> <?= ucfirst($unit['unit_type']) ?></p>
            </div>
            <div class="col-md-4">
                <p><strong>Total Karyawan:</strong> <?= count($employees) ?></p>
            </div>
        </div>
        <?php if ($unit['description']): ?>
            <p><strong>Deskripsi:</strong> <?= htmlspecialchars($unit['description']) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Karyawan</h5>
    </div>
    <div class="card-body">
        <?php if (empty($employees)): ?>
            <p class="text-muted">Belum ada karyawan di unit ini</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Posisi</th>
                            <th>Tanggal Mulai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $emp): ?>
                            <tr>
                                <td><?= htmlspecialchars($emp['employee_code']) ?></td>
                                <td><?= htmlspecialchars($emp['full_name']) ?></td>
                                <td>
                                    <span class="badge badge-<?= $emp['employee_type'] == 'doctor' ? 'primary' : 'info' ?>">
                                        <?= $emp['employee_type'] == 'doctor' ? 'Dokter' : 'Staff' ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($emp['position_info']) ?></td>
                                <td><?= date('d/m/Y', strtotime($emp['start_date'])) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/<?= $emp['employee_type'] == 'doctor' ? 'doctors' : 'staff' ?>/view/<?= $emp['employee_id'] ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>