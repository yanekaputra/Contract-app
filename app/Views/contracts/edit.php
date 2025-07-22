<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Kontrak</h2>
    <a href="<?= BASE_URL ?>/contracts" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/contracts/update/<?= $contract['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Kontrak</label>
                        <input type="text" class="form-control" value="<?= $contract['contract_number'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Karyawan</label>
                        <input type="text" class="form-control" 
                               value="<?= $employee['employee_code'] ?> - <?= $employee['full_name'] ?>" readonly>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipe Kontrak <span class="text-danger">*</span></label>
                        <select class="form-control" name="contract_type" required>
                            <option value="permanent" <?= $contract['contract_type'] == 'permanent' ? 'selected' : '' ?>>Tetap</option>
                            <option value="contract" <?= $contract['contract_type'] == 'contract' ? 'selected' : '' ?>>Kontrak</option>
                            <option value="internship" <?= $contract['contract_type'] == 'internship' ? 'selected' : '' ?>>Magang</option>
                            <option value="honorary" <?= $contract['contract_type'] == 'honorary' ? 'selected' : '' ?>>Honorer</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" value="<?= $contract['start_date'] ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Berakhir</label>
                        <input type="date" class="form-control" name="end_date" value="<?= $contract['end_date'] ?>">
                        <small class="form-text text-muted">Kosongkan untuk kontrak tetap</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="status" required>
                            <option value="active" <?= $contract['status'] == 'active' ? 'selected' : '' ?>>Aktif</option>
                            <option value="expired" <?= $contract['status'] == 'expired' ? 'selected' : '' ?>>Kadaluarsa</option>
                            <option value="terminated" <?= $contract['status'] == 'terminated' ? 'selected' : '' ?>>Dihentikan</option>
                            <option value="renewed" <?= $contract['status'] == 'renewed' ? 'selected' : '' ?>>Diperpanjang</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Informasi Gaji</label>
                <textarea class="form-control" name="salary_info" rows="2"><?= htmlspecialchars($contract['salary_info']) ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Upload File Kontrak</label>
                <?php if ($contract['contract_file']): ?>
                    <div class="mb-2">
                        <a href="<?= BASE_URL ?>/uploads/contract/<?= $contract['contract_file'] ?>" target="_blank" class="btn btn-sm btn-info">
                            <i class="bi bi-file-pdf"></i> Lihat Kontrak Saat Ini
                        </a>
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control-file" name="contract_file" accept=".pdf,.doc,.docx">
                <small class="form-text text-muted">Format: PDF, DOC, DOCX (Max 5MB). Biarkan kosong jika tidak ingin mengubah</small>
            </div>
            
            <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control" name="notes" rows="3"><?= htmlspecialchars($contract['notes']) ?></textarea>
            </div>
            
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="<?= BASE_URL ?>/contracts" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>