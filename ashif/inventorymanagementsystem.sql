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
