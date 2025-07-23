<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Ganti Password</h2>
    <a href="<?= BASE_URL ?>/dashboard" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="<?= BASE_URL ?>/change-password" method="POST" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label>Password Lama <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="current_password" required>
                        <div class="invalid-feedback">
                            Password lama wajib diisi
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="new_password" required 
                               minlength="6" id="new_password">
                        <div class="invalid-feedback">
                            Password baru minimal 6 karakter
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="confirm_password" required 
                               minlength="6" id="confirm_password">
                        <div class="invalid-feedback">
                            Password tidak cocok
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Ganti Password
                        </button>
                        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    if (this.value !== document.getElementById('new_password').value) {
        this.setCustomValidity('Password tidak cocok');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>