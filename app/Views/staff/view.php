<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Detail Staff</h2>
    <div>
        <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
        <a href="<?= BASE_URL ?>/staff/edit/<?= $employee['id'] ?>" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/staff" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Personal Information -->
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pribadi</h5>
            </div>
            <div class="card-body">
                <?php if ($employee['photo']): ?>
                    <div class="text-center mb-3">
                        <img src="<?= BASE_URL ?>/uploads/photo/<?= $employee['photo'] ?>" 
                             class="img-thumbnail" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
                
                <table class="table table-sm">
                    <tr>
                        <td><strong>NIP:</strong></td>
                        <td><?= htmlspecialchars($employee['employee_code']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td><?= htmlspecialchars($employee['full_name']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Posisi:</strong></td>
                        <td><?= htmlspecialchars($staff['position']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Department:</strong></td>
                        <td><?= htmlspecialchars($staff['department']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>TTL:</strong></td>
                        <td>
                            <?= htmlspecialchars($employee['birth_place']) ?>, 
                            <?= $employee['birth_date'] ? date('d/m/Y', strtotime($employee['birth_date'])) : '-' ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin:</strong></td>
                        <td><?= $employee['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Pendidikan:</strong></td>
                        <td><?= htmlspecialchars($staff['education_level'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= htmlspecialchars($employee['email']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td><?= htmlspecialchars($employee['phone']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Unit:</strong></td>
                        <td><?= htmlspecialchars($employee['current_unit'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Professional Documents -->
    <div class="col-md-8">
        <?php if ($staff['has_str']): ?>
        <!-- STR Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Surat Tanda Registrasi (STR)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nomor STR:</strong> <?= htmlspecialchars($staff['str_number']) ?></p>
                        <p><strong>Tanggal Terbit:</strong> 
                            <?= $staff['str_issue_date'] ? date('d/m/Y', strtotime($staff['str_issue_date'])) : '-' ?>
                        </p>
                        <p><strong>Tanggal Kadaluarsa:</strong> 
                            <?= $staff['sip_expiry_date'] ? date('d/m/Y', strtotime($staff['sip_expiry_date'])) : '-' ?>
                        </p>
                        <?php if ($staff['sip_expiry_date']): ?>
                            <?php $sipDays = DateHelper::getDaysRemaining($staff['sip_expiry_date']); ?>
                            <p><strong>Status:</strong> <?= DateHelper::getStatusBadge($sipDays) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <?php if ($staff['sip_file']): ?>
                            <a href="<?= BASE_URL ?>/uploads/sip/<?= $staff['sip_file'] ?>" 
                               class="btn btn-info" target="_blank">
                                <i class="bi bi-file-pdf"></i> Lihat Dokumen SIP
                            </a>
                        <?php else: ?>
                            <p class="text-muted">Dokumen SIP belum diupload</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Contracts -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat Kontrak</h5>
                <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
                <a href="<?= BASE_URL ?>/contracts/create/<?= $employee['id'] ?>" class="btn btn-sm btn-success">
                    <i class="bi bi-plus"></i> Tambah Kontrak
                </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (empty($contracts)): ?>
                    <p class="text-muted">Belum ada kontrak</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>No. Kontrak</th>
                                    <th>Tipe</th>
                                    <th>Mulai</th>
                                    <th>Berakhir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contracts as $contract): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($contract['contract_number']) ?></td>
                                        <td><?= ucfirst($contract['contract_type']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($contract['start_date'])) ?></td>
                                        <td>
                                            <?= $contract['end_date'] ? date('d/m/Y', strtotime($contract['end_date'])) : '-' ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $contract['status'] == 'active' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($contract['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/contracts/view/<?= $contract['id'] ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
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
        
        <!-- Placement History -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Penempatan</h5>
            </div>
            <div class="card-body">
                <?php if (empty($placementHistory)): ?>
                    <p class="text-muted">Belum ada riwayat penempatan</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($placementHistory as $placement): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($placement['unit_name']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($placement['start_date'])) ?></td>
                                        <td>
                                            <?= $placement['end_date'] ? date('d/m/Y', strtotime($placement['end_date'])) : '-' ?>
                                        </td>
                                        <td><?= htmlspecialchars($placement['placement_reason'] ?? '-') ?></td>
                                        <td>
                                            <?php if ($placement['is_current']): ?>
                                                <span class="badge badge-success">Saat Ini</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Selesai</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>