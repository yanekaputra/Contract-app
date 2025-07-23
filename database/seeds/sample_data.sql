-- Sample employees
INSERT INTO employees (employee_code, full_name, birth_date, birth_place, gender, address, phone, email, employee_type, join_date) VALUES
('DR20240001', 'Dr. Ahmad Wijaya, Sp.PD', '1980-05-15', 'Jakarta', 'L', 'Jl. Sudirman No. 123', '081234567890', 'ahmad.wijaya@hospital.com', 'doctor', '2020-01-01'),
('DR20240002', 'Dr. Siti Nurhaliza, Sp.OG', '1985-08-20', 'Bandung', 'P', 'Jl. Gatot Subroto No. 456', '081234567891', 'siti.nurhaliza@hospital.com', 'doctor', '2019-06-15'),
('ST20240001', 'Ns. Budi Santoso, S.Kep', '1990-03-10', 'Surabaya', 'L', 'Jl. Ahmad Yani No. 789', '081234567892', 'budi.santoso@hospital.com', 'staff', '2021-03-01'),
('ST20240002', 'Maria Angelina, A.Md.Kep', '1995-12-25', 'Medan', 'P', 'Jl. Diponegoro No. 321', '081234567893', 'maria.angelina@hospital.com', 'staff', '2022-01-10');

-- Sample doctors data
INSERT INTO doctors (employee_id, str_number, str_issue_date, str_expiry_date, sip_number, sip_issue_date, sip_expiry_date, specialization) VALUES
(1, 'STR/2022/001', '2022-01-01', '2027-01-01', 'SIP/2022/001', '2022-02-01', '2025-02-01', 'Penyakit Dalam'),
(2, 'STR/2021/002', '2021-06-15', '2026-06-15', 'SIP/2021/002', '2021-07-01', '2024-07-01', 'Obstetri dan Ginekologi');

-- Sample staff data
INSERT INTO staff (employee_id, position, department, education_level, has_str, has_sip, str_number, str_issue_date, str_expiry_date, sip_number, sip_issue_date, sip_expiry_date) VALUES
(3, 'Perawat Senior', 'IGD', 'S1', 1, 1, 'STR/2023/003', '2023-01-01', '2028-01-01', 'SIP/2023/003', '2023-02-01', '2026-02-01'),
(4, 'Perawat', 'Rawat Inap', 'D3', 1, 0, 'STR/2023/004', '2023-03-01', '2028-03-01', NULL, NULL, NULL);

-- Sample contracts
INSERT INTO contracts (employee_id, contract_number, contract_type, start_date, end_date, status) VALUES
(1, 'CTR/2024/01/0001', 'permanent', '2020-01-01', NULL, 'active'),
(2, 'CTR/2024/01/0002', 'contract', '2019-06-15', '2024-12-31', 'active'),
(3, 'CTR/2024/01/0003', 'contract', '2021-03-01', '2025-02-28', 'active'),
(4, 'CTR/2024/01/0004', 'contract', '2022-01-10', '2025-01-09', 'active');

-- Sample placements
INSERT INTO placement_history (employee_id, unit_id, start_date, is_current, placement_reason) VALUES
(1, 1, '2020-01-01', 1, 'Penempatan Awal'),
(2, 5, '2019-06-15', 1, 'Penempatan Awal'),
(3, 1, '2021-03-01', 0, 'Penempatan Awal'),
(3, 2, '2023-01-01', 1, 'Rotasi'),
(4, 3, '2022-01-10', 1, 'Penempatan Awal');