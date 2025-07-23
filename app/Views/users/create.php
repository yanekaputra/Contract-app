<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah User</h2>
    <a href="<?= BASE_URL ?>/users" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/users/store" method="POST" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required 
                               pattern="[a-zA-Z0-9_]{3,20}" 
                               title="Username harus 3-20 karakter, hanya huruf, angka, dan underscore">
                        <div class="invalid-feedback">
                            Username harus 3-20 karakter, hanya huruf, angka, dan underscore
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                        <div class="invalid-feedback">
                            Email harus valid
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="full_name" required>
                        <div class="invalid-feedback">
                            Nama lengkap wajib diisi
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role <span class="text-danger">*</span></label>
                        <select class="form-control" name="role" required>
                            <option value="">Pilih Role...</option>
                            <option value="admin">Admin</option>
                            <option value="hr">HR</option>
                            <option value="viewer">Viewer</option>
                        </select>
                        <div class="invalid-feedback">
                            Role wajib dipilih
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required 
                               minlength="6" id="password">
                        <div class="invalid-feedback">
                            Password minimal 6 karakter
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="confirm_password" required 
                               minlength="6" id="confirm_password">
                        <div class="invalid-feedback">
                            Password tidak cocok
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="<?= BASE_URL ?>/users" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    if (this.value !== document.getElementById('password').value) {
        this.setCustomValidity('Password tidak cocok');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>