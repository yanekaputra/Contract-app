CREATE TABLE IF NOT EXISTS placement_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT NOT NULL,
    unit_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    is_current BOOLEAN DEFAULT TRUE,
    placement_reason VARCHAR(255),
    sk_number VARCHAR(100),
    sk_file VARCHAR(255),
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES units(id),
    INDEX idx_employee_unit (employee_id, unit_id),
    INDEX idx_current (is_current)
);