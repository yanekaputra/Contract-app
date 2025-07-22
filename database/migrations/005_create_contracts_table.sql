CREATE TABLE IF NOT EXISTS contracts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT NOT NULL,
    contract_number VARCHAR(50) UNIQUE NOT NULL,
    contract_type ENUM('permanent', 'contract', 'internship', 'honorary'),
    start_date DATE NOT NULL,
    end_date DATE,
    contract_file VARCHAR(255),
    salary_info TEXT,
    status ENUM('active', 'expired', 'terminated', 'renewed') DEFAULT 'active',
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    INDEX idx_contract_number (contract_number),
    INDEX idx_end_date (end_date),
    INDEX idx_status (status)
);