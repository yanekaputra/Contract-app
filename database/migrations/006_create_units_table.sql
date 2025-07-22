CREATE TABLE IF NOT EXISTS units (
    id INT PRIMARY KEY AUTO_INCREMENT,
    unit_code VARCHAR(20) UNIQUE NOT NULL,
    unit_name VARCHAR(100) NOT NULL,
    unit_type ENUM('medical', 'support', 'admin') DEFAULT 'medical',
    head_employee_id INT,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_unit_code (unit_code)
);

-- Insert sample units
INSERT INTO units (unit_code, unit_name, unit_type) VALUES
('IGD', 'Instalasi Gawat Darurat', 'medical'),
('ICU', 'Intensive Care Unit', 'medical'),
('OK', 'Ruang Operasi', 'medical'),
('LAB', 'Laboratorium', 'medical'),
('RAD', 'Radiologi', 'medical'),
('FARM', 'Farmasi', 'medical'),
('IT', 'Teknologi Informasi', 'support'),
('HR', 'Sumber Daya Manusia', 'admin'),
('FIN', 'Keuangan', 'admin');