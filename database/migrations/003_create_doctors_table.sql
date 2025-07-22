CREATE TABLE IF NOT EXISTS doctors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT NOT NULL,
    str_number VARCHAR(50),
    str_file VARCHAR(255),
    str_issue_date DATE,
    str_expiry_date DATE,
    sip_number VARCHAR(50),
    sip_file VARCHAR(255),
    sip_issue_date DATE,
    sip_expiry_date DATE,
    specialization VARCHAR(100),
    sub_specialization VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    INDEX idx_str_expiry (str_expiry_date),
    INDEX idx_sip_expiry (sip_expiry_date)
);