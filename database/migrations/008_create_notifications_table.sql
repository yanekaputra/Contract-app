CREATE TABLE IF NOT EXISTS notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('str_expiry', 'sip_expiry', 'contract_expiry', 'birthday', 'placement'),
    employee_id INT NOT NULL,
    title VARCHAR(255),
    message TEXT,
    expiry_date DATE,
    days_before_expiry INT,
    is_read BOOLEAN DEFAULT FALSE,
    is_sent BOOLEAN DEFAULT FALSE,
    sent_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    INDEX idx_type_read (type, is_read),
    INDEX idx_created (created_at)
);
