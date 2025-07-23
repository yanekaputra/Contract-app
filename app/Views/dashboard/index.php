<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard</h2>
    <button class="btn btn-primary" onclick="checkExpiryDates()">
        <i class="bi bi-arrow-clockwise"></i> Refresh Data
    </button>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Karyawan</h6>
                        <h2 class="mb-0"><?= $total_employees ?></h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Dokter</h6>
                        <h2 class="mb-0"><?= $total_doctors ?></h2>
                    </div>
                    <i class="bi bi-person-badge" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Staff</h6>
                        <h2 class="mb-0"><?= $total_staff ?></h2>
                    </div>
                    <i class="bi bi-person" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Dokumen Akan Expired</h6>
                        <h2 class="mb-0"><?= $expiring_documents ?></h2>
                    </div>
                    <i class="bi bi-exclamation-triangle" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Expiry Alerts -->
<div id="expiry-alerts"></div>

<div class="row">
    <!-- Recent Notifications -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Notifikasi Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recent_notifications)): ?>
                    <p class="text-muted">Tidak ada notifikasi baru</p>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($recent_notifications as $notif): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?= htmlspecialchars($notif['title']) ?></h6>
                                    <small><?= date('d/m/Y', strtotime($notif['created_at'])) ?></small>
                                </div>
                                <p class="mb-1"><?= htmlspecialchars($notif['message']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?= BASE_URL ?>/notifications" class="btn btn-sm btn-primary">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Employee Distribution -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Distribusi Karyawan per Unit</h5>
            </div>
            <div class="card-body">
                <canvas id="unitChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Documents Expiring Soon -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Dokumen Segera Kadaluarsa (7 Hari)</h5>
    </div>
    <div class="card-body">
        <?php if (empty($expiring_soon)): ?>
            <p class="text-muted">Tidak ada dokumen yang akan segera kadaluarsa</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Kategori</th>
                            <th>Dokumen</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
<tbody>
                        <?php foreach ($expiring_soon as $doc): ?>
                            <tr>
                                <td><?= htmlspecialchars($doc['full_name']) ?></td>
                                <td><?= htmlspecialchars($doc['nip']) ?></td>
                                <td><?= htmlspecialchars($doc['category']) ?></td>
                                <td><?= htmlspecialchars($doc['document_name']) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($doc['expiry_date']))) ?></td>
                                <td>
                                    <?php
                                    require_once dirname(__DIR__) . '/../Helpers/DateHelper.php';
                                    echo DateHelper::getStatusBadge($doc['days_remaining']);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data staff ini?')) {
        window.location.href = '<?= BASE_URL ?>/staff/delete/' + id;
    }
}


// Unit Distribution Chart
const ctx = document.getElementById('unitChart').getContext('2d');
const unitChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($units_data, 'unit_name')) ?>,
        datasets: [{
            label: 'Jumlah Karyawan',
            data: <?= json_encode(array_column($units_data, 'employee_count')) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>