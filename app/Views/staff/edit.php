<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Staff</h2>
    <a href="<?= BASE_URL ?>/staff" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/staff/update/<?= $employee['id'] ?>" method="POST" enctype="multipart/form-data">
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
            
            <h5 class="mb-3">Data Pekerjaan</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Posisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="position" value="<?= htmlspecialchars($staff['position']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Department <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="department" value="<?= htmlspecialchars($staff['department']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pendidikan Terakhir</label>
                        <select class="form-control" name="education_level">
                            <option value="">Pilih...</option>
                            <option value="SMA/SMK" <?= $staff['education_level'] == 'SMA/SMK' ? 'selected' : '' ?>>SMA/SMK</option>
                            <option value="D3" <?= $staff['education_level'] == 'D3' ? 'selected' : '' ?>>D3</option>
                            <option value="D4" <?= $staff['education_level'] == 'D4' ? 'selected' : '' ?>>D4</option>
                            <option value="S1" <?= $staff['education_level'] == 'S1' ? 'selected' : '' ?>>S1</option>
                            <option value="S2" <?= $staff['education_level'] == 'S2' ? 'selected' : '' ?>>S2</option>
                            <option value="S3" <?= $staff['education_level'] == 'S3' ? 'selected' : '' ?>>S3</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Dokumen Profesional</h5>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> STR dan SIP hanya untuk staff yang bekerja di pelayanan medis
            </div>
            
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="has_str" name="has_str" <?= $staff['has_str'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="has_str">
                    Memiliki STR
                </label>
            </div>
            
            <div id="str_section" style="<?= $staff['has_str'] ? '' : 'display: none;' ?>">
                <h6>Dokumen STR</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor STR</label>
                            <input type="text" class="form-control" name="str_number" value="<?= htmlspecialchars($staff['str_number']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Terbit STR</label>
                            <input type="date" class="form-control" name="str_issue_date" value="<?= $staff['str_issue_date'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa STR</label>
                            <input type="date" class="form-control" name="str_expiry_date" value="<?= $staff['str_expiry_date'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Upload File STR</label>
                    <?php if ($staff['str_file']): ?>
                        <div class="mb-2">
                            <a href="<?= BASE_URL ?>/uploads/str/<?= $staff['str_file'] ?>" target="_blank" class="btn btn-sm btn-info">
                                <i class="bi bi-file-pdf"></i> Lihat STR Saat Ini
                            </a>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control-file" name="str_file" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text text-muted">Format: PDF, JPG, PNG (Max 5MB)</small>
                </div>
            </div>
            
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="has_sip" name="has_sip" <?= $staff['has_sip'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="has_sip">
                    Memiliki SIP
                </label>
            </div>
            
            <div id="sip_section" style="<?= $staff['has_sip'] ? '' : 'display: none;' ?>">
                <h6>Dokumen SIP</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor SIP</label>
                            <input type="text" class="form-control" name="sip_number" value="<?= htmlspecialchars($staff['sip_number']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Terbit SIP</label>
                            <input type="date" class="form-control" name="sip_issue_date" value="<?= $staff['sip_issue_date'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa SIP</label>
                            <input type="date" class="form-control" name="sip_expiry_date" value="<?= $staff['sip_expiry_date'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Upload File SIP</label>
                    <?php if ($staff['sip_file']): ?>
                        <div class="mb-2">
                            <a href="<?= BASE_URL ?>/uploads/sip/<?= $staff['sip_file'] ?>" target="_blank" class="btn btn-sm btn-info">
                                <i class="bi bi-file-pdf"></i> Lihat SIP Saat Ini
                            </a>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control-file" name="sip_file" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text text-muted">Format: PDF, JPG, PNG (Max 5MB)</small>
                </div>
            </div>
            
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="<?= BASE_URL ?>/staff" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#has_str').change(function() {
        if($(this).is(':checked')) {
            $('#str_section').show();
        } else {
            $('#str_section').hide();
        }
    });
    
    $('#has_sip').change(function() {
        if($(this).is(':checked')) {
            $('#sip_section').show();
        } else {
            $('#sip_section').hide();
        }
    });
});
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>