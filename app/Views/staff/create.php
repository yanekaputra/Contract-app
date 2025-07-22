<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah Staff</h2>
    <a href="<?= BASE_URL ?>/staff" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/staff/store" method="POST" enctype="multipart/form-data">
            <h5 class="mb-3">Data Pribadi</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-control" name="gender" required>
                            <option value="">Pilih...</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="birth_place">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="birth_date">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Bergabung <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="join_date" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="address" rows="2"></textarea>
            </div>
            
            <div class="form-group">
                <label>Foto</label>
                <input type="file" class="form-control-file" name="photo" accept="image/*">
            </div>
            
            <hr>
            
            <h5 class="mb-3">Data Pekerjaan</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Posisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="position" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Department <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="department" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pendidikan Terakhir</label>
                        <select class="form-control" name="education_level">
                            <option value="">Pilih...</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Unit Penempatan</label>
                <select class="form-control" name="unit_id">
                    <option value="">Pilih Unit...</option>
                    <?php foreach ($units as $unit): ?>
                        <option value="<?= $unit['id'] ?>"><?= $unit['unit_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Dokumen Profesional</h5>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> STR dan SIP hanya untuk staff yang bekerja di pelayanan medis
            </div>
            
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="has_str" name="has_str">
                <label class="form-check-label" for="has_str">
                    Memiliki STR
                </label>
            </div>
            
            <div id="str_section" style="display: none;">
                <h6>Dokumen STR</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor STR</label>
                            <input type="text" class="form-control" name="str_number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Terbit STR</label>
                            <input type="date" class="form-control" name="str_issue_date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa STR</label>
                            <input type="date" class="form-control" name="str_expiry_date">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Upload File STR</label>
                    <input type="file" class="form-control-file" name="str_file" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text text-muted">Format: PDF, JPG, PNG (Max 5MB)</small>
                </div>
            </div>
            
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="has_sip" name="has_sip">
                <label class="form-check-label" for="has_sip">
                    Memiliki SIP
                </label>
            </div>
            
            <div id="sip_section" style="display: none;">
                <h6>Dokumen SIP</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor SIP</label>
                            <input type="text" class="form-control" name="sip_number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Terbit SIP</label>
                            <input type="date" class="form-control" name="sip_issue_date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa SIP</label>
                            <input type="date" class="form-control" name="sip_expiry_date">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Upload File SIP</label>
                    <input type="file" class="form-control-file" name="sip_file" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text text-muted">Format: PDF, JPG, PNG (Max 5MB)</small>
                </div>
            </div>
            
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
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
            $('#str_section input').attr('required', true);
        } else {
            $('#str_section').hide();
            $('#str_section input').attr('required', false);
        }
    });
    
    $('#has_sip').change(function() {
        if($(this).is(':checked')) {
            $('#sip_section').show();
            $('#sip_section input').attr('required', true);
        } else {
            $('#sip_section').hide();
            $('#sip_section input').attr('required', false);
        }
    });
});
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>