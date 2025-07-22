<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Laporan Dokumen Kadaluarsa</h2>
    <div>
        <button onclick="printReport('reportContent')" class="btn btn-secondary">
            <i class="bi bi-printer"></i> Print
        </button>
        <a href="<?= BASE_URL ?>/reports/export/expired-documents?days=<?= $days ?>" class="btn btn-success">
            <i class="bi bi-file-excel"></i> Export Excel
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="form-inline">
            <label class="mr-2">Filter dokumen yang akan kadaluarsa dalam:</label>
            <select name="days" class="form-control mr-2" onchange="this.form.submit()">
                <option value="7" <?= $days == 7 ? 'selected' : '' ?>>7 hari</option>
                <option value="14" <?= $days == 14 ? 'selected' : '' ?>>14 hari</option>
                <option value="30" <?= $days == 30 ? 'selected' : '' ?>>30 hari</option>
                <option value="60" <?= $days == 60 ? 'selected' : '' ?>>60 hari</option>
                <option value="90" <?= $days == 90 ? 'selected' : '' ?>>90 hari</option>
            </select>
        </form>
    </div>
</div>

<div id="reportContent">
    <!-- Doctor STR/SIP -->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Dokumen Dokter (STR/SIP)</h5>
        </div>
        <div class="card-body">
            <?php if (empty($doctorDocs)): ?>
                <p class="text-muted">Tidak ada dokumen dokter yang akan kadaluarsa</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Dokumen</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Sisa Hari</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctorDocs as $doc): ?>
                                <tr>
                                    <td><?= htmlspecialchars($doc['employee_code']) ?></td>
                                    <td><?= htmlspecialchars($doc['full_name']) ?></td>
                                    <td><?= strtoupper($doc['document_type']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($doc['expiry_date'])) ?></td>
                                    <td><?= $doc['days_remaining'] ?></td>
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
    
    <!-- Staff STR/SIP -->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Dokumen Staff (STR/SIP)</h5>
        </div>
        <div class="card-body">
            <?php if (empty($staffDocs)): ?>
                <p class="text-muted">Tidak ada dokumen staff yang akan kadaluarsa</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Dokumen</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Sisa Hari</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($staffDocs as $doc): ?>
                                <tr>
                                    <td><?= htmlspecialchars($doc['employee_code']) ?></td>
                                    <td><?= htmlspecialchars($doc['full_name']) ?></td>
                                    <td><?= strtoupper($doc['document_type']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($doc['expiry_date'])) ?></td>
                                    <td><?= $doc['days_remaining'] ?></td>
                                    <td><?= DateHelper::getStatusBadge($doc['days_remaining']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Contracts -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Kontrak Kerja</h5>
        </div>
        <div class="card-body">
            <?php if (empty($contracts)): ?>
                <p class="text-muted">Tidak ada kontrak yang akan berakhir</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>No. Kontrak</th>
                                <th>Tanggal Berakhir</th>
                                <th>Sisa Hari</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contracts as $contract): ?>
                                <tr>
                                    <td><?= htmlspecialchars($contract['employee_code']) ?></td>
                                    <td><?= htmlspecialchars($contract['full_name']) ?></td>
                                    <td><?= htmlspecialchars($contract['contract_number']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($contract['end_date'])) ?></td>
                                    <td><?= $contract['days_remaining'] ?></td>
                                    <td><?= DateHelper::getStatusBadge($contract['days_remaining']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?> htmlspecialchars($doc['full_name']) ?></td>
                                <td><?= htmlspecialchars($doc['employee_code']) ?></td>
                                <td><?= $doc['category'] ?></td>
                                <td>
                                    <?php
                                    $docTypes = [
                                        'str' => 'STR',
                                        'sip' => 'SIP',
                                        'contract' => 'Kontrak'
                                    ];
                                    echo $docTypes[$doc['document_type']] ?? $doc['document_type'];
                                    ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($doc['expiry_date'] ?? $doc['end_date'])) ?></td>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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