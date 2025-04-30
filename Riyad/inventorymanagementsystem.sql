CREATE TABLE preventive_measures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(50) NOT NULL,
    batch_id VARCHAR(50) NOT NULL,
    farmer_name VARCHAR(100) NOT NULL,
    farmer_id VARCHAR(50) NOT NULL,
    reason TEXT NOT NULL,
    suggestion TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO preventive_measures (product_id, batch_id, farmer_name, farmer_id, reason, suggestion)
VALUES
('P001', 'B001', 'Ravi Kumar', 'F123', 'Excess fertilizer use in cauliflower, causing spoilage.', 'Reduce fertilizer application and monitor soil quality.'),
('P002', 'B002', 'Sita Devi', 'F124', 'Incorrect pesticide spraying schedule.', 'Follow recommended pesticide spraying intervals.');


CREATE TABLE improvement_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(50) NOT NULL,
    batch_id VARCHAR(50) NOT NULL,
    farmer_name VARCHAR(100) NOT NULL,
    farmer_id VARCHAR(50) NOT NULL,
    update_status TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO improvement_updates (product_id, batch_id, farmer_name, farmer_id, update_status)
VALUES
('P001', 'B001', 'Ravi Kumar', 'F123', 'Farmer is improving. Has reduced fertilizer usage.'),
('P002', 'B002', 'Sita Devi', 'F124', 'Farmer is not improving. No change in pesticide routine.');