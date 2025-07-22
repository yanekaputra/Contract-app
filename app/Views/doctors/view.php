<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Detail Dokter</h2>
    <div>
        <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
        <a href="<?= BASE_URL ?>/doctors/edit/<?= $employee['id'] ?>" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/doctors" class="btn btn-secondary">
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
                        <td><strong>Spesialisasi:</strong></td>
                        <td><?= htmlspecialchars($doctor['specialization']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>TTL:</strong></td>
                        <td>
                            <?= htmlspecialchars($employee['birth_place']) ?>, 
                            <?= date('d/m/Y', strtotime($employee['birth_date'])) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin:</strong></td>
                        <td><?= $employee['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
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
        <!-- STR Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Surat Tanda Registrasi (STR)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nomor STR:</strong> <?= htmlspecialchars($doctor['str_number']) ?></p>
                        <p><strong>Tanggal Terbit:</strong> 
                            <?= $doctor['str_issue_date'] ? date('d/m/Y', strtotime($doctor['str_issue_date'])) : '-' ?>
                        </p>
                        <p><strong>Tanggal Kadaluarsa:</strong> 
                            <?= date('d/m/Y', strtotime($doctor['str_expiry_date'])) ?>
                        </p>
                        <?php
                        require_once dirname(__DIR__) . '/../Helpers/DateHelper.php';
                        $strDays = DateHelper::getDaysRemaining($doctor['str_expiry_date']);
                        ?>
                        <p><strong>Status:</strong> <?= DateHelper::getStatusBadge($strDays) ?></p>
                    </div>
                    <div class="col-md-6">
                        <?php if ($doctor['str_file']): ?>
                            <a href="<?= BASE_URL ?>/uploads/str/<?= $doctor['str_file'] ?>" 
                               class="btn btn-info" target="_blank">
                                <i class="bi bi-file-pdf"></i> Lihat Dokumen STR
                            </a>
                        <?php else: ?>
                            <p class="text-muted">Dokumen STR belum diupload</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- SIP Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Surat Izin Praktik (SIP)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nomor SIP:</strong> <?= htmlspecialchars($doctor['sip_number']) ?></p>
                        <p><strong>Tanggal Terbit:</strong> 
                            <?= $doctor['sip_issue_date'] ? date('d/m/Y', strtotime($doctor['sip_issue_date'])) : '-' ?>
                        </p>
                        <p><strong>Tanggal Kadaluarsa:</strong> 
                            <?= date('d/m/Y', strtotime($doctor['sip_expiry_date'])) ?>
                        </p>
                        <?php $sipDays = DateHelper::getDaysRemaining($doctor['sip_expiry_date']); ?>
                        <p><strong>Status:</strong> <?= DateHelper::getStatusBadge($sipDays) ?></p>
                    </div>
                    <div class="col-md-6">
                        <?php if ($doctor['sip_file']): ?>
                            <a href="<?= BASE_URL ?>/uploads/sip/<?= $doctor['sip_file'] ?>" 
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