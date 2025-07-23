# Hospital Contract Management System

Sistem manajemen kontrak dan dokumen karyawan rumah sakit berbasis web.

## Fitur Utama

- **Manajemen Dokter**: Tracking STR, SIP, dan kontrak kerja
- **Manajemen Staff**: Conditional STR/SIP untuk staff medis
- **Sistem Notifikasi**: Alert otomatis untuk dokumen yang akan kadaluarsa
- **Penempatan Unit**: Tracking perpindahan karyawan antar unit
- **Reporting**: Export data dan laporan dokumen kadaluarsa

## Requirements

- PHP >= 7.4
- MySQL >= 5.7
- Apache dengan mod_rewrite enabled
- Composer

## Instalasi

1. Clone repository
```bash
git clone [repository-url]
cd hospital-contract-app
```

2. Install dependencies
```bash
composer install
```

3. Setup database
```bash
# Buat database
mysql -u root -p
CREATE DATABASE hospital_contract_db;
exit;

# Import semua file di folder database/migrations/
```

4. Configure application
```bash
# Edit config/database.php
# Set database credentials
```

5. Setup permissions
```bash
chmod -R 755 public/uploads
chmod -R 755 logs
```

6. Setup virtual host atau akses via:
```
http://localhost/hospital-contract-app
```

## Default Login

- Username: `admin`
- Password: `password`

## Cron Job Setup

Untuk notifikasi otomatis, setup cron job:
```bash
# Edit crontab
crontab -e

# Tambahkan
0 8 * * * /usr/bin/php /path/to/hospital-contract-app/scripts/check-expiry.php
```

## Struktur Folder

```
hospital-contract-app/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   └── Helpers/
├── config/
├── database/
├── public/
│   ├── assets/
│   └── uploads/
├── routes/
├── scripts/
└── logs/
```

## User Roles

1. **Admin**: Full access
2. **HR**: Manage employees, contracts, placements
3. **Viewer**: Read-only access

## Teknologi

- Backend: PHP (Native MVC)
- Frontend: Bootstrap 4, jQuery, DataTables
- Database: MySQL
- Libraries: PHPMailer, Chart.js

## License

Proprietary

// ===== MISSING JAVASCRIPT FILES =====

// public/assets/js/jquery.min.js
// Note: In production, download jQuery 3.6.0 from https://jquery.com/download/

// public/assets/js/bootstrap.min.js  
// Note: In production, download Bootstrap 4.6 from https://getbootstrap.com/docs/4.6/getting-started/download/

// ===== MISSING CSS FILES =====

// public/assets/css/bootstrap.min.css
// Note: In production, download Bootstrap 4.6 CSS from https://getbootstrap.com/docs/4.6/getting-started/download/