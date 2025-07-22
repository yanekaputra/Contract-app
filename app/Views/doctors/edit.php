<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Dokter</h2>
    <a href="<?= BASE_URL ?>/doctors" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/doctors/update/<?= $employee['id'] ?>" method="POST" enctype="multipart/form-data">
            <h5 class="mb-3">Data Pribadi</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" class="form-control" value="<?= $employee['employee_code'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($employee['full_name']) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-control" name="gender" required>
                            <option value="L" <?= $employee['gender'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= $employee['gender'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="birth_place" value="<?= htmlspecialchars($employee['birth_place']) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="birth_date" value="<?= $employee['birth_date'] ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Unit Saat Ini</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($currentPlacement['unit_name'] ?? 'Belum ditempatkan') ?>" readonly>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($employee['email']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($employee['phone']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="address" rows="2"><?= htmlspecialchars($employee['address']) ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Foto</label>
                <?php if ($employee['photo']): ?>
                    <div class="mb-2">
                        <img src="<?= BASE_URL ?>/uploads/photo/<?= $employee['photo'] ?>" class="img-thumbnail" style="max-height: 100px;">
                        <small class="form-text text-muted">Foto saat ini</small>
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control-file" name="photo" accept="image/*">
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Data Profesional</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Spesialisasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="specialization" value="<?= htmlspecialchars($doctor['specialization']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sub Spesialisasi</label>
                        <input type="text" class="form-control" name="sub_specialization" value="<?= htmlspecialchars($doctor['sub_specialization']) ?>">
                    </div>
                </div>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Dokumen STR</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nomor STR <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="str_number" value="<?= htmlspecialchars($doctor['str_number']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Terbit STR</label>
                        <input type="date" class="form-control" name="str_issue_date" value="<?= $doctor['str_issue_date'] ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Kadaluarsa STR <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="str_expiry_date" value="<?= $doctor['str_expiry_date'] ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Upload File STR</label>
                <?php if ($doctor['str_file']): ?>
                    <div class="mb-2">
                        <a href="<?= BASE_URL ?>/uploads/str/<?= $doctor['str_file'] ?>" target="_blank" class="btn btn-sm btn-info">
                            <i class="bi bi-file-pdf"></i> Lihat STR Saat Ini
                        </a>
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control-file" name="str_file" accept=".pdf,.jpg,.jpeg,.png">
                <small class="form-text text-muted">Format: PDF, JPG, PNG (Max 5MB). Biarkan kosong jika tidak ingin mengubah</small>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Dokumen SIP</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nomor SIP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="sip_number" value="<?= htmlspecialchars($doctor['sip_number']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Terbit SIP</label>
                        <input type="date" class="form-control" name="sip_issue_date" value="<?= $doctor['sip_issue_date'] ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Kadaluarsa SIP <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="sip_expiry_date" value="<?= $doctor['sip_expiry_date'] ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Upload File SIP</label>
                <?php if ($doctor['sip_file']): ?>
                    <div class="mb-2">
                        <a href="<?= BASE_URL ?>/uploads/sip/<?= $doctor['sip_file'] ?>" target="_blank" class="btn btn-sm btn-info">
                            <i class="bi bi-file-pdf"></i> Lihat SIP Saat Ini
                        </a>
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control-file" name="sip_file" accept=".pdf,.jpg,.jpeg,.png">
                <small class="form-text text-muted">Format: PDF, JPG, PNG (Max 5MB). Biarkan kosong jika tidak ingin mengubah</small>
            </div>
            
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="<?= BASE_URL ?>/doctors" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>