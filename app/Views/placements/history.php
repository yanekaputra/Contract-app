<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Riwayat Penempatan</h2>
    <a href="<?= BASE_URL ?>/placements" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <input type="text" class="form-control" id="searchPlacement" placeholder="Cari berdasarkan nama atau NIP...">
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Dari Unit</th>
                        <th>Ke Unit</th>
                        <th>Alasan</th>
                        <th>SK</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Get all placement history
                    require_once dirname(__DIR__) . '/../Models/Placement.php';
                    require_once dirname(__DIR__) . '/../Models/Employee.php';
                    require_once dirname(__DIR__) . '/../Models/Unit.php';
                    
                    $placementModel = new Placement();
                    $employeeModel = new Employee();
                    $unitModel = new Unit();
                    
                    $allPlacements = $placementModel->findAll([], 'created_at DESC', 100);
                    
                    foreach ($allPlacements as $placement):
                        $employee = $employeeModel->findById($placement['employee_id']);
                        $unit = $unitModel->findById($placement['unit_id']);
                    ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($placement['start_date'])) ?></td>
                            <td><?= htmlspecialchars($employee['employee_code']) ?></td>
                            <td><?= htmlspecialchars($employee['full_name']) ?></td>
                            <td>-</td>
                            <td><?= htmlspecialchars($unit['unit_name']) ?></td>
                            <td><?= htmlspecialchars($placement['placement_reason'] ?? '-') ?></td>
                            <td>
                                <?php if ($placement['sk_file']): ?>
                                    <a href="<?= BASE_URL ?>/uploads/placement/<?= $placement['sk_file'] ?>" 
                                       target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-file-pdf"></i>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($placement['is_current']): ?>
                                    <span class="badge badge-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Selesai</span>
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
$(document).ready(function() {
    $('#searchPlacement').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>