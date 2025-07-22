<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/app/Models/Doctor.php';
require_once dirname(__DIR__) . '/app/Models/Staff.php';
require_once dirname(__DIR__) . '/app/Models/Contract.php';
require_once dirname(__DIR__) . '/app/Models/Notification.php';

$doctorModel = new Doctor();
$staffModel = new Staff();
$contractModel = new Contract();
$notificationModel = new Notification();

// Check doctor documents
foreach (NOTIFY_BEFORE_DAYS as $days) {
    $doctorDocs = $doctorModel->getExpiringDocuments($days);
    foreach ($doctorDocs as $doc) {
        if ($doc['days_remaining'] == $days) {
            $notificationModel->createExpiryNotification(
                $doc['document_type'] . '_expiry',
                $doc['employee_id'],
                $doc['expiry_date'],
                $doc['days_remaining']
            );
        }
    }
}

// Check staff documents
foreach (NOTIFY_BEFORE_DAYS as $days) {
    $staffDocs = $staffModel->getExpiringDocuments($days);
    foreach ($staffDocs as $doc) {
        if ($doc['days_remaining'] == $days) {
            $notificationModel->createExpiryNotification(
                $doc['document_type'] . '_expiry',
                $doc['employee_id'],
                $doc['expiry_date'],
                $doc['days_remaining']
            );
        }
    }
}

// Check contracts
foreach (NOTIFY_BEFORE_DAYS as $days) {
    $contracts = $contractModel->getExpiringContracts($days);
    foreach ($contracts as $contract) {
        if ($contract['days_remaining'] == $days) {
            $notificationModel->createExpiryNotification(
                'contract_expiry',
                $contract['employee_id'],
                $contract['end_date'],
                $contract['days_remaining']
            );
        }
    }
}

// Update expired contracts
$contractModel->updateExpiredContracts();

echo "Expiry check completed at " . date('Y-m-d H:i:s') . "\n";