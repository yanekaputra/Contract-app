<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Kontrak</h2>
    <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
    <a href="<?= BASE_URL ?>/contracts/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Kontrak
    </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>No. Kontrak</th>
                        <th>Nama Karyawan</th>
                        <th>Tipe</th>
                        <th>Mulai</th>
                        <th>Berakhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require_once dirname(__DIR__) . '/../Models/Employee.php';
                    $employeeModel = new Employee();
                    
                    foreach ($contracts as $contract): 
                        $employee = $employeeModel->findById($contract['employee_id']);
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($contract['contract_number']) ?></td>
                            <td><?= htmlspecialchars($employee['full_name']) ?></td>
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
                            <td><?= date('d/m/Y', strtotime($contract['start_date'])) ?></td>
                            <td>
                                <?= $contract['end_date'] ? date('d/m/Y', strtotime($contract['end_date'])) : '-' ?>
                            </td>
                            <td>
                                <?php
                                $statusBadges = [
                                    'active' => 'success',
                                    'expired' => 'danger',
                                    'terminated' => 'warning',
                                    'renewed' => 'info'
                                ];
                                $badge = $statusBadges[$contract['status']] ?? 'secondary';
                                ?>
                                <span class="badge badge-<?= $badge ?>">
                                    <?= ucfirst($contract['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>/contracts/view/<?= $contract['id'] ?>" 
                                   class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
                                <a href="<?= BASE_URL ?>/contracts/edit/<?= $contract['id'] ?>" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>