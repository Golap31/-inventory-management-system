CREATE TABLE LossAnalysis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    batch_code VARCHAR(50),
    harvest_date DATE,
    storage_location VARCHAR(100),
    detected_issue ENUM('Physical Damage', 'Spoilage', 'Other') NOT NULL,
    issue_description TEXT,
    detected_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    expiry_date DATE,
    alert_status ENUM('Pending', 'Alert Sent', 'Resolved') DEFAULT 'Pending'
);
INSERT INTO LossAnalysis 
(product_name, batch_code, harvest_date, storage_location, detected_issue, issue_description, detected_date, expiry_date, alert_status)
VALUES 
('Tomatoes', 'BATCH001', '2025-04-10', 'Cold Storage A', 'Spoilage', 'Signs of mold on surface', NOW(), '2025-04-25', 'Pending'),
('Bananas', 'BATCH002', '2025-04-12', 'Warehouse B', 'Physical Damage', 'Bruised during transport', NOW(), '2025-04-24', 'Pending'),
('Spinach', 'BATCH003', '2025-04-15', 'Refrigerator Unit 3', 'Spoilage', 'Leaves turning yellow', NOW(), '2025-04-20', 'Alert Sent'),
('Apples', 'BATCH004', '2025-04-05', 'Cold Storage A', 'Physical Damage', 'Cracks on the skin observed', NOW(), '2025-05-01', 'Resolved'),
('Strawberries', 'BATCH005', '2025-04-16', 'Warehouse C', 'Spoilage', 'Soft patches and foul smell', NOW(), '2025-04-22', 'Pending');

ALTER TABLE LossAnalysis 
ADD reported_by VARCHAR(100) AFTER issue_description;

CREATE TABLE NotificationLog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loss_id INT NOT NULL,
    notification_type ENUM('Email', 'Push', 'Banner', 'SMS') NOT NULL,
    status ENUM('Sent', 'Failed') DEFAULT 'Sent',
    message TEXT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loss_id) REFERENCES LossAnalysis(id)
);
g