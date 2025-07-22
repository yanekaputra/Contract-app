<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Detail Kontrak</h2>
    <div>
        <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
        <a href="<?= BASE_URL ?>/contracts/edit/<?= $contract['id'] ?>" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/contracts" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Kontrak</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>Nomor Kontrak:</strong></td>
                        <td><?= htmlspecialchars($contract['contract_number']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tipe Kontrak:</strong></td>
                        <td>
                            <?php
                            $types = [
                                'permanent' => 'Tetap',
                                'contract' => 'Kontrak',
                                'internship' => 'Magang',
                                'honorary' => 'Honorer'
                            ];
                            echo $types[$contract['contract_type']] ?? $contract['contract_type'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Mulai:</strong></td>
                        <td><?= date('d F Y', strtotime($contract['start_date'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Berakhir:</strong></td>
                        <td>
                            <?php if ($contract['end_date']): ?>
                                <?= date('d F Y', strtotime($contract['end_date'])) ?>
                                <?php
                                require_once dirname(__DIR__) . '/../Helpers/DateHelper.php';
                                $days = DateHelper::getDaysRemaining($contract['end_date']);
                                if ($days >= 0) {
                                    echo " <small class='text-muted'>(" . $days . " hari lagi)</small>";
                                }
                                ?>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada batas waktu (Kontrak Tetap)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <?php
                            $statusBadges = [
                                'active' => 'success',
                                'expired' => 'danger',
                                'terminated' => 'warning',
                                'renewed' => 'info'
                            ];
                            $statusLabels = [
                                'active' => 'Aktif',
                                'expired' => 'Kadaluarsa',
                                'terminated' => 'Dihentikan',
                                'renewed' => 'Diperpanjang'
                            ];
                            $badge = $statusBadges[$contract['status']] ?? 'secondary';
                            $label = $statusLabels[$contract['status']] ?? $contract['status'];
                            ?>
                            <span class="badge badge-<?= $badge ?>"><?= $label ?></span>
                        </td>
                    </tr>
                    <?php if ($contract['salary_info']): ?>
                    <tr>
                        <td><strong>Informasi Gaji:</strong></td>
                        <td><?= nl2br(htmlspecialchars($contract['salary_info'])) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($contract['notes']): ?>
                    <tr>
                        <td><strong>Catatan:</strong></td>
                        <td><?= nl2br(htmlspecialchars($contract['notes'])) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Dokumen Kontrak:</strong></td>
                        <td>
                            <?php if ($contract['contract_file']): ?>
                                <a href="<?= BASE_URL ?>/uploads/contract/<?= $contract['contract_file'] ?>" 
                                   class="btn btn-info" target="_blank">
                                    <i class="bi bi-file-pdf"></i> Lihat Dokumen Kontrak
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Dokumen belum diupload</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Karyawan</h5>
            </div>
            <div class="card-body">
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
                        <td><strong>Tipe:</strong></td>
                        <td><?= $employee['employee_type'] == 'doctor' ? 'Dokter' : 'Staff' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Posisi:</strong></td>
                        <td><?= htmlspecialchars($employee['position_info']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Unit:</strong></td>
                        <td><?= htmlspecialchars($employee['current_unit'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= htmlspecialchars($employee['email']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td><?= htmlspecialchars($employee['phone']) ?></td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="<?= BASE_URL ?>/<?= $employee['employee_type'] == 'doctor' ? 'doctors' : 'staff' ?>/view/<?= $employee['id'] ?>" 
                       class="btn btn-sm btn-info btn-block">
                        <i class="bi bi-person"></i> Lihat Profil Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
