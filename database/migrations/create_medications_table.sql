-- Create medications table
CREATE TABLE IF NOT EXISTS medications (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    generic_name VARCHAR(255),
    brand_name VARCHAR(255),
    category VARCHAR(100),
    dosage_form VARCHAR(50) NOT NULL,
    strength VARCHAR(50) NOT NULL,
    manufacturer VARCHAR(255),
    description TEXT,
    side_effects TEXT,
    contraindications TEXT,
    storage_instructions TEXT,
    quantity INT(11) NOT NULL DEFAULT 0,
    reorder_level INT(11) NOT NULL DEFAULT 10,
    unit_price DECIMAL(10,2),
    expiration_date DATE,
    prescription_required TINYINT(1) NOT NULL DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_by INT(11) NOT NULL,
    updated_by INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create inventory_logs table for tracking stock changes
CREATE TABLE IF NOT EXISTS inventory_logs (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    item_id INT(11) NOT NULL,
    adjustment_quantity INT(11) NOT NULL,
    notes TEXT,
    adjusted_by INT(11) NOT NULL,
    adjusted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES medications(id),
    FOREIGN KEY (adjusted_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create medication_prescriptions table
CREATE TABLE IF NOT EXISTS medication_prescriptions (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    medication_id INT(11) NOT NULL,
    patient_id INT(11) NOT NULL,
    prescribed_by INT(11) NOT NULL,
    dosage VARCHAR(100) NOT NULL,
    frequency VARCHAR(100) NOT NULL,
    duration VARCHAR(100) NOT NULL,
    quantity INT(11) NOT NULL,
    instructions TEXT,
    status ENUM('active', 'completed', 'cancelled') NOT NULL DEFAULT 'active',
    prescribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (medication_id) REFERENCES medications(id),
    FOREIGN KEY (patient_id) REFERENCES users(id),
    FOREIGN KEY (prescribed_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add indexes for better performance
ALTER TABLE medications ADD INDEX idx_category (category);
ALTER TABLE medications ADD INDEX idx_name (name);
ALTER TABLE medications ADD INDEX idx_active_stock (is_active, quantity);
ALTER TABLE inventory_logs ADD INDEX idx_item_date (item_id, adjusted_at);
ALTER TABLE medication_prescriptions ADD INDEX idx_patient (patient_id);
ALTER TABLE medication_prescriptions ADD INDEX idx_medication (medication_id);
ALTER TABLE medication_prescriptions ADD INDEX idx_status (status); 