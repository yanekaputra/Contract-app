$(document).ready(function() {
    // Initialize DataTables
    $('.data-table').DataTable({
        responsive: true,
        language: {
            "sEmptyTable": "Tidak ada data yang tersedia pada tabel ini",
            "sProcessing": "Sedang memproses...",
            "sLengthMenu": "Tampilkan _MENU_ entri",
            "sZeroRecords": "Tidak ditemukan data yang sesuai",
            "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix": "",
            "sSearch": "Cari:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Pertama",
                "sPrevious": "Sebelumnya",
                "sNext": "Selanjutnya",
                "sLast": "Terakhir"
            }
        }
    });
    
    // Initialize datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        language: 'id'
    });
    
    // File upload preview
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
    
    // Check expiry dates on dashboard
    if (window.location.pathname.includes('dashboard')) {
        checkExpiryDates();
        setInterval(checkExpiryDates, 300000); // Check every 5 minutes
    }
});

// Check expiry dates function
function checkExpiryDates() {
    $.ajax({
        url: '/hospital-contract-app/api/check-expiry',
        method: 'GET',
        success: function(response) {
            if (response.expired && response.expired.length > 0) {
                showExpiryAlert(response.expired);
            }
        },
        error: function() {
            console.log('Error checking expiry dates');
        }
    });
}

// Show expiry alert in dashboard
function showExpiryAlert(expiredDocs) {
    let alertHtml = '<div class="alert alert-warning alert-dismissible fade show">';
    alertHtml += '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
    alertHtml += '<h4 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Peringatan Dokumen!</h4>';
    alertHtml += '<p>Dokumen berikut mendekati atau sudah kadaluarsa:</p><ul>';
    
    expiredDocs.forEach(function(doc) {
        let docType = doc.document_type.toUpperCase().replace('_EXPIRY', '');
        let status = doc.days_remaining <= 0 ? 'EXPIRED' : doc.days_remaining + ' hari lagi';
        alertHtml += '<li><strong>' + doc.full_name + '</strong> (' + doc.employee_code + ') - ' + 
                     docType + ' - <span class="text-danger">' + status + '</span></li>';
    });
    
    alertHtml += '</ul></div>';
    $('#expiry-alerts').html(alertHtml);
}

// Placement history modal
function showPlacementHistory(employeeId) {
    $.ajax({
        url: '/hospital-contract-app/api/placement-history/' + employeeId,
        method: 'GET',
        success: function(response) {
            let html = '<table class="table table-sm">';
            html += '<thead><tr><th>Unit</th><th>Mulai</th><th>Selesai</th><th>Alasan</th></tr></thead>';
            html += '<tbody>';
            
            response.forEach(function(placement) {
                html += '<tr>';
                html += '<td>' + placement.unit_name + '</td>';
                html += '<td>' + formatDate(placement.start_date) + '</td>';
                html += '<td>' + (placement.end_date ? formatDate(placement.end_date) : 'Sekarang') + '</td>';
                html += '<td>' + (placement.placement_reason || '-') + '</td>';
                html += '</tr>';
            });
            
            html += '</tbody></table>';
            
            $('#placementHistoryModal .modal-body').html(html);
            $('#placementHistoryModal').modal('show');
        },
        error: function() {
            alert('Error loading placement history');
        }
    });
}

// Format date helper
function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

// Dynamic form for staff STR/SIP
$('#is_medical_staff').change(function() {
    if ($(this).is(':checked')) {
        $('#medical-documents').show();
        $('#medical-documents input').prop('required', true);
    } else {
        $('#medical-documents').hide();
        $('#medical-documents input').prop('required', false);
    }
});

// Contract type change handler
$('select[name="contract_type"]').change(function() {
    if ($(this).val() === 'permanent') {
        $('input[name="end_date"]').prop('disabled', true).val('');
    } else {
        $('input[name="end_date"]').prop('disabled', false);
    }
});

// Search functionality enhancement
$('#searchEmployee').on('keyup', function() {
    const value = $(this).val().toLowerCase();
    $('.employee-card').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

// Print functionality
function printReport(elementId) {
    const printContents = document.getElementById(elementId).innerHTML;
    const originalContents = document.body.innerHTML;
    
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

// Export to Excel functionality
function exportToExcel(tableId, filename) {
    const table = document.getElementById(tableId);
    const html = table.outerHTML;
    const blob = new Blob([html], {
        type: 'application/vnd.ms-excel'
    });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename + '.xls';
    a.click();
}

// Notification mark as read
function markNotificationAsRead(notificationId) {
    $.ajax({
        url: '/hospital-contract-app/notifications/read/' + notificationId,
        method: 'POST',
        success: function() {
            $('#notification-' + notificationId).removeClass('unread');
            updateNotificationCount();
        }
    });
}

// Update notification count
function updateNotificationCount() {
    $.ajax({
        url: '/hospital-contract-app/api/notifications/unread-count',
        method: 'GET',
        success: function(response) {
            if (response.count > 0) {
                $('.notification-count').text(response.count).show();
            } else {
                $('.notification-count').hide();
            }
        }
    });
}

// Form validation enhancement
(function() {
    'use strict';
    window.addEventListener('load', function() {
        const forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();