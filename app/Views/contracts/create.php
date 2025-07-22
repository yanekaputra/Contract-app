<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah Kontrak</h2>
    <a href="<?= BASE_URL ?>/contracts" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/contracts/store" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Kontrak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="contract_number" 
                               value="<?= $contractNumber ?>" readonly required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Karyawan <span class="text-danger">*</span></label>
                        <?php if ($employee): ?>
                            <input type="hidden" name="employee_id" value="<?= $employee['id'] ?>">
                            <input type="text" class="form-control" 
                                   value="<?= $employee['employee_code'] ?> - <?= $employee['full_name'] ?>" 
                                   readonly>
                        <?php else: ?>
                            <select class="form-control" name="employee_id" required>
                                <option value="">Pilih Karyawan...</option>
                                <?php foreach ($employees as $emp): ?>
                                    <option value="<?= $emp['id'] ?>">
                                        <?= $emp['employee_code'] ?> - <?= $emp['full_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipe Kontrak <span class="text-danger">*</span></label>
                        <select class="form-control" name="contract_type" required>
                            <option value="">Pilih Tipe...</option>
                            <option value="permanent">Tetap</option>
                            <option value="contract">Kontrak</option>
                            <option value="internship">Magang</option>
                            <option value="honorary">Honorer</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Berakhir</label>
                        <input type="date" class="form-control" name="end_date">
                        <small class="form-text text-muted">Kosongkan untuk kontrak tetap</small>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Informasi Gaji</label>
                <textarea class="form-control" name="salary_info" rows="2" 
                          placeholder="Informasi gaji dan tunjangan (opsional)"></textarea>
            </div>
            
            <div class="form-group">
                <label>Upload File Kontrak</label>
                <input type="file" class="form-control-file" name="contract_file" accept=".pdf,.doc,.docx">
                <small class="form-text text-muted">Format: PDF, DOC, DOCX (Max 5MB)</small>
            </div>
            
            <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control" name="notes" rows="3"></textarea>
            </div>
            
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="<?= BASE_URL ?>/contracts" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>