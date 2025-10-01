-- Create activity_logs table
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    user_id INT(11),
    action VARCHAR(255) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add indexes for better performance
ALTER TABLE activity_logs ADD INDEX idx_user_id (user_id);
ALTER TABLE activity_logs ADD INDEX idx_action (action);
ALTER TABLE activity_logs ADD INDEX idx_created_at (created_at); 