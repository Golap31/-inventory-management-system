-
CREATE TABLE preventive_measures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    measure_name VARCHAR(255) NOT NULL,
    description TEXT,
    implementation_date DATE,
    responsible_person VARCHAR(255)
);


CREATE TABLE measure_effects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    measure_id INT,
    date_tracked DATE,
    spoilage_rate FLOAT,
    observations TEXT,
    FOREIGN KEY (measure_id) REFERENCES preventive_measures(id) ON DELETE CASCADE
);


INSERT INTO preventive_measures (measure_name, description, implementation_date, responsible_person)
VALUES 
('Regular Temperature Monitoring', 'Daily monitoring of storage temperature to ensure optimal conditions.', '2025-04-01', 'John Doe'),
('Humidity Control System', 'Installation of humidity sensors to maintain appropriate levels.', '2025-04-05', 'Jane Smith'),
('Weekly Cleaning Schedule', 'Cleaning the storage area every week to reduce contamination risk.', '2025-04-07', 'Ahmed Khan');


INSERT INTO measure_effects (measure_id, date_tracked, spoilage_rate, observations)
VALUES 
(1, '2025-04-10', 2.5, 'Spoilage rate slightly reduced after monitoring started.'),
(1, '2025-04-17', 1.8, 'Further reduction noted, temperature stable.'),
(2, '2025-04-12', 3.2, 'Initial reading before full effect of humidity control.'),
(2, '2025-04-19', 1.9, 'Noticeable improvement in storage conditions.'),
(3, '2025-04-14', 2.8, 'Cleanliness improved, spoilage reduced.'),
(3, '2025-04-21', 1.5, 'Systematic cleaning showing positive results.');
