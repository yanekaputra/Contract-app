<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah Dokter</h2>
    <a href="<?= BASE_URL ?>/doctors" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/doctors/store" method="POST" enctype="multipart/form-data">
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
            
            <h5 class="mb-3">Data Profesional</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Spesialisasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="specialization" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sub Spesialisasi</label>
                        <input type="text" class="form-control" name="sub_specialization">
                    </div>
                </div>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Dokumen STR</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nomor STR <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="str_number" required>
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
                        <label>Tanggal Kadaluarsa STR <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="str_expiry_date" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Upload File STR</label>
                <input type="file" class="form-control-file" name="str_file" accept=".pdf,.jpg,.jpeg,.png">
                <small class="form-text text-muted">Format: PDF, JPG, PNG (Max 5MB)</small>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Dokumen SIP</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nomor SIP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="sip_number" required>
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
                        <label>Tanggal Kadaluarsa SIP <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="sip_expiry_date" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Upload File SIP</label>
                <input type="file" class="form-control-file" name="sip_file" accept=".pdf,.jpg,.jpeg,.png">
                <small class="form-text text-muted">Format: PDF, JPG, PNG (Max 5MB)</small>
            </div>
            
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="<?= BASE_URL ?>/doctors" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>