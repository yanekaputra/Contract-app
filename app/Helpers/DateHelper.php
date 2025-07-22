<?php
class DateHelper {
    public static function formatDate($date, $format = 'd/m/Y') {
        if (empty($date)) return '-';
        return date($format, strtotime($date));
    }
    
    public static function getDaysRemaining($date) {
        if (empty($date)) return null;
        
        $now = new DateTime();
        $expiry = new DateTime($date);
        $diff = $now->diff($expiry);
        
        return $expiry < $now ? -$diff->days : $diff->days;
    }
    
    public static function getStatusBadge($days) {
        if ($days === null) return '';
        
        if ($days < 0) {
            return '<span class="badge badge-danger">Expired</span>';
        } elseif ($days <= 7) {
            return '<span class="badge badge-danger">Urgent</span>';
        } elseif ($days <= 30) {
            return '<span class="badge badge-warning">Warning</span>';
        } elseif ($days <= 90) {
            return '<span class="badge badge-info">Notice</span>';
        } else {
            return '<span class="badge badge-success">Active</span>';
        }
    }
}