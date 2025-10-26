<?php
/**
 * Email Simulation Engineer Component
 * Handles confirmation email simulation and message logging
 */

class EmailSimulator {
    private $conn;
    private $config;
    
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
        $this->config = require __DIR__ . '/email_config.php';
        
        // Ensure log directory exists
        if (!file_exists($this->config['log_directory'])) {
            mkdir($this->config['log_directory'], 0755, true);
        }
    }
    
    /**
     * Send a simulated email
     */
    public function sendEmail($to, $toName, $subject, $body, $type = 'general', $metadata = []) {
        try {
            // Log to database
            if ($this->config['log_emails']) {
                $this->logToDatabase($to, $toName, $subject, $body, $type, $metadata);
            }
            
            // Log to file
            $this->logToFile($to, $toName, $subject, $type);
            
            // Display in browser if enabled
            if ($this->config['display_in_browser']) {
                $this->displayInBrowser($to, $toName, $subject, $body);
            }
            
            return [
                'success' => true,
                'message' => 'Email simulated successfully',
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            $this->logError($e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to simulate email: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Send registration confirmation email
     */
    public function sendRegistrationConfirmation($user) {
        $subject = "Welcome to " . $this->config['system_name'];
        $body = $this->loadTemplate('registration_confirmation', [
            'name' => $user['name'],
            'email' => $user['email'],
            'srn' => $user['srn'] ?? '',
            'system_name' => $this->config['system_name'],
            'system_url' => $this->config['system_url'],
            'support_email' => $this->config['support_email']
        ]);
        
        return $this->sendEmail(
            $user['email'],
            $user['name'],
            $subject,
            $body,
            'registration',
            ['user_id' => $user['id'] ?? null, 'srn' => $user['srn'] ?? '']
        );
    }
    
    /**
     * Send event confirmation email
     */
    public function sendEventConfirmation($participant, $event) {
        $subject = "Event Registration Confirmed: " . $event['title'];
        $body = $this->loadTemplate('event_confirmation', [
            'name' => $participant['name'],
            'event_title' => $event['title'],
            'event_description' => $event['description'] ?? '',
            'event_date' => $event['event_date'] ?? 'TBA',
            'system_name' => $this->config['system_name'],
            'system_url' => $this->config['system_url'],
            'support_email' => $this->config['support_email']
        ]);
        
        return $this->sendEmail(
            $participant['email'],
            $participant['name'],
            $subject,
            $body,
            'event_confirmation',
            ['event_id' => $event['id'], 'participant_id' => $participant['id'] ?? null]
        );
    }
    
    /**
     * Send contact form acknowledgment
     */
    public function sendContactAcknowledgment($contact) {
        $subject = "We received your message";
        $body = $this->loadTemplate('contact_acknowledgment', [
            'name' => $contact['name'],
            'message_preview' => substr($contact['message'], 0, 100) . '...',
            'system_name' => $this->config['system_name'],
            'support_email' => $this->config['support_email']
        ]);
        
        return $this->sendEmail(
            $contact['email'],
            $contact['name'],
            $subject,
            $body,
            'contact_acknowledgment',
            ['message_id' => $contact['id'] ?? null]
        );
    }
    
    /**
     * Log email to database
     */
    private function logToDatabase($to, $toName, $subject, $body, $type, $metadata) {
        $metadataJson = json_encode($metadata);
        $stmt = $this->conn->prepare(
            "INSERT INTO email_logs (recipient_email, recipient_name, subject, message_body, email_type, status, metadata) 
             VALUES (?, ?, ?, ?, ?, 'sent', ?)"
        );
        $stmt->bind_param('ssssss', $to, $toName, $subject, $body, $type, $metadataJson);
        $stmt->execute();
        $stmt->close();
    }
    
    /**
     * Log email to file
     */
    private function logToFile($to, $toName, $subject, $type) {
        $logFile = $this->config['log_directory'] . $this->config['log_file'];
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = sprintf(
            "[%s] EMAIL SIMULATED - Type: %s | To: %s <%s> | Subject: %s\n",
            $timestamp, $type, $toName, $to, $subject
        );
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
    
    /**
     * Log errors
     */
    private function logError($message) {
        $logFile = $this->config['log_directory'] . 'email_errors.log';
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = sprintf("[%s] ERROR: %s\n", $timestamp, $message);
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
    
    /**
     * Display email in browser (for debugging)
     */
    private function displayInBrowser($to, $toName, $subject, $body) {
        echo "<div style='border: 2px solid #4CAF50; padding: 20px; margin: 20px; background: #f9f9f9;'>";
        echo "<h3 style='color: #4CAF50;'>📧 Email Simulated</h3>";
        echo "<p><strong>To:</strong> $toName &lt;$to&gt;</p>";
        echo "<p><strong>Subject:</strong> $subject</p>";
        echo "<div style='border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px;'>$body</div>";
        echo "</div>";
    }
    
    /**
     * Load email template
     */
    private function loadTemplate($templateName, $variables) {
        $templateFile = $this->config['templates_path'] . $templateName . '.php';
        
        // If template file exists, use it
        if (file_exists($templateFile)) {
            ob_start();
            extract($variables);
            include $templateFile;
            return ob_get_clean();
        }
        
        // Otherwise, use inline templates
        return $this->getInlineTemplate($templateName, $variables);
    }
    
    /**
     * Get inline email templates (fallback)
     */
    private function getInlineTemplate($templateName, $vars) {
        $baseStyle = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff;'>
                <div style='background-color: #4CAF50; color: white; padding: 20px; text-align: center;'>
                    <h1 style='margin: 0;'>{$vars['system_name']}</h1>
                </div>
                <div style='padding: 30px; background-color: #f9f9f9;'>
        ";
        
        $footer = "
                </div>
                <div style='background-color: #333; color: #fff; padding: 15px; text-align: center; font-size: 12px;'>
                    <p>Need help? Contact us at <a href='mailto:{$vars['support_email']}' style='color: #4CAF50;'>{$vars['support_email']}</a></p>
                    <p>&copy; " . date('Y') . " {$vars['system_name']}. All rights reserved.</p>
                </div>
            </div>
        ";
        
        switch ($templateName) {
            case 'registration_confirmation':
                return $baseStyle . "
                    <h2 style='color: #333;'>Welcome, {$vars['name']}! 🎉</h2>
                    <p>Thank you for registering with {$vars['system_name']}.</p>
                    <p><strong>Your Account Details:</strong></p>
                    <ul>
                        <li>Name: {$vars['name']}</li>
                        <li>Email: {$vars['email']}</li>
                        <li>SRN: {$vars['srn']}</li>
                    </ul>
                    <p>You can now log in to browse and register for exciting campus events.</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='{$vars['system_url']}/login.php' style='background-color: #4CAF50; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>Login Now</a>
                    </div>
                " . $footer;
                
            case 'event_confirmation':
                return $baseStyle . "
                    <h2 style='color: #333;'>Event Registration Confirmed! ✅</h2>
                    <p>Hi {$vars['name']},</p>
                    <p>You have successfully registered for the following event:</p>
                    <div style='background-color: white; padding: 20px; border-left: 4px solid #4CAF50; margin: 20px 0;'>
                        <h3 style='margin-top: 0; color: #4CAF50;'>{$vars['event_title']}</h3>
                        <p>{$vars['event_description']}</p>
                        <p><strong>Date:</strong> {$vars['event_date']}</p>
                    </div>
                    <p>We look forward to seeing you there!</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='{$vars['system_url']}/events.php' style='background-color: #4CAF50; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>View All Events</a>
                    </div>
                " . $footer;
                
            case 'contact_acknowledgment':
                return $baseStyle . "
                    <h2 style='color: #333;'>Message Received! 📬</h2>
                    <p>Hi {$vars['name']},</p>
                    <p>Thank you for contacting us. We have received your message and will get back to you as soon as possible.</p>
                    <div style='background-color: white; padding: 15px; border-left: 4px solid #4CAF50; margin: 20px 0;'>
                        <p><em>{$vars['message_preview']}</em></p>
                    </div>
                    <p>Our team typically responds within 24-48 hours.</p>
                " . $footer;
                
            default:
                return $baseStyle . "<p>Email content</p>" . $footer;
        }
    }
    
    /**
     * Get all email logs (for viewing interface)
     */
    public function getEmailLogs($limit = 50, $offset = 0, $type = null) {
        $sql = "SELECT * FROM email_logs";
        if ($type) {
            $sql .= " WHERE email_type = ?";
        }
        $sql .= " ORDER BY sent_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->conn->prepare($sql);
        if ($type) {
            $stmt->bind_param('sii', $type, $limit, $offset);
        } else {
            $stmt->bind_param('ii', $limit, $offset);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $logs;
    }
    
    /**
     * Get total count of email logs
     */
    public function getTotalEmailCount($type = null) {
        $sql = "SELECT COUNT(*) as total FROM email_logs";
        if ($type) {
            $sql .= " WHERE email_type = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $type);
        } else {
            $stmt = $this->conn->prepare($sql);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['total'];
    }
}
