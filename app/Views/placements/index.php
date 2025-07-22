<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Penempatan Unit</h2>
    <?php if (in_array($_SESSION['user_role'], ['admin', 'hr'])): ?>
    <button class="btn btn-primary" data-toggle="modal" data-target="#assignModal">
        <i class="bi bi-plus-circle"></i> Assign Karyawan
    </button>
    <?php endif; ?>
</div>

<div class="row">
    <?php foreach ($units as $unit): ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($unit['unit_name']) ?></h5>
                    <p class="card-text">
                        <strong>Kode:</strong> <?= htmlspecialchars($unit['unit_code']) ?><br>
                        <strong>Tipe:</strong> <?= ucfirst($unit['unit_type']) ?><br>
                        <strong>Jumlah Karyawan:</strong> <?= $unit['employee_count'] ?>
                    </p>
                    <a href="<?= BASE_URL ?>/placements/unit/<?= $unit['id'] ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= BASE_URL ?>/placements/assign" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Karyawan ke Unit</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Karyawan <span class="text-danger">*</span></label>
                        <select class="form-control" name="employee_id" required>
                            <option value="">Pilih Karyawan...</option>
                            <?php 
                            require_once dirname(__DIR__) . '/../Models/Employee.php';
                            $employeeModel = new Employee();
                            $employees = $employeeModel->findAll(['is_active' => 1], 'full_name ASC');
                            foreach ($employees as $emp): 
                            ?>
                                <option value="<?= $emp['id'] ?>">
                                    <?= $emp['employee_code'] ?> - <?= $emp['full_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Unit Tujuan <span class="text-danger">*</span></label>
                        <select class="form-control" name="unit_id" required>
                            <option value="">Pilih Unit...</option>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?= $unit['id'] ?>"><?= $unit['unit_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Alasan Penempatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="placement_reason" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Nomor SK</label>
                        <input type="text" class="form-control" name="sk_number">
                    </div>
                    
                    <div class="form-group">
                        <label>Upload SK</label>
                        <input type="file" class="form-control-file" name="sk_file" accept=".pdf">
                    </div>
                    
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>