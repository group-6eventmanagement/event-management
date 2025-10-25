-- Email logging table for simulated emails
USE event_registration_system;

CREATE TABLE IF NOT EXISTS email_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  recipient_email VARCHAR(255) NOT NULL,
  recipient_name VARCHAR(255),
  subject VARCHAR(500) NOT NULL,
  message_body TEXT NOT NULL,
  email_type ENUM('registration', 'event_confirmation', 'contact_acknowledgment', 'general') DEFAULT 'general',
  status ENUM('sent', 'failed', 'pending') DEFAULT 'sent',
  metadata JSON,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_recipient (recipient_email),
  INDEX idx_type (email_type),
  INDEX idx_sent_at (sent_at)
);
