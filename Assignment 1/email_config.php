<?php
// Email Simulation Configuration

return [
    // System Settings
    'system_name' => 'Campus Event Management System',
    'system_email' => 'noreply@campusevents.edu',
    'support_email' => 'support@campusevents.edu',
    'system_url' => 'http://localhost:8080',
    
    // Email Simulation Settings
    'simulation_mode' => true, // Set to false for real email sending
    'log_emails' => true,
    'display_in_browser' => false, // Show emails in browser instead of logging
    
    // Email Templates Directory
    'templates_path' => __DIR__ . '/email_templates/',
    
    // Logging
    'log_directory' => __DIR__ . '/logs/',
    'log_file' => 'email_simulation.log',
];
