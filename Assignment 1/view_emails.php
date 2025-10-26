<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Logs - Campus Event Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .filters {
            padding: 20px 30px;
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .filters label {
            font-weight: 600;
            color: #333;
        }
        
        .filters select, .filters input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .filters button {
            padding: 10px 25px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .filters button:hover {
            background: #45a049;
        }
        
        .stats {
            padding: 20px 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-card.success {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .stat-card.info {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .stat-card h3 {
            font-size: 2em;
            margin-bottom: 5px;
        }
        
        .stat-card p {
            opacity: 0.9;
        }
        
        .email-list {
            padding: 30px;
        }
        
        .email-item {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .email-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: #f8f9fa;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        
        .email-info {
            flex: 1;
        }
        
        .email-type {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .type-registration {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .type-event_confirmation {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .type-contact_acknowledgment {
            background: #fff3e0;
            color: #f57c00;
        }
        
        .type-general {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        
        .email-recipient {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .email-subject {
            color: #666;
            font-size: 14px;
        }
        
        .email-time {
            color: #999;
            font-size: 12px;
        }
        
        .email-body {
            padding: 20px;
            background: white;
            display: none;
            border-top: 2px solid #4CAF50;
        }
        
        .email-body.active {
            display: block;
        }
        
        .no-emails {
            text-align: center;
            padding: 50px;
            color: #999;
        }
        
        .no-emails i {
            font-size: 4em;
            margin-bottom: 20px;
            display: block;
        }
        
        .pagination {
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .pagination a {
            display: inline-block;
            padding: 8px 15px;
            margin: 0 5px;
            background: #f8f9fa;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .pagination a:hover {
            background: #4CAF50;
            color: white;
        }
        
        .pagination a.active {
            background: #4CAF50;
            color: white;
        }
        
        .back-btn {
            display: inline-block;
            margin: 20px 30px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .back-btn:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <?php
    require 'event_registration_system.php';
    require 'EmailSimulator.php';
    
    $emailSimulator = new EmailSimulator($conn);
    
    // Get filter parameters
    $filter_type = $_GET['type'] ?? null;
    $search = $_GET['search'] ?? '';
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    
    // Get emails
    $emails = $emailSimulator->getEmailLogs($per_page, $offset, $filter_type);
    $total_emails = $emailSimulator->getTotalEmailCount($filter_type);
    $total_pages = ceil($total_emails / $per_page);
    
    // Get statistics
    $stats_registration = $emailSimulator->getTotalEmailCount('registration');
    $stats_event = $emailSimulator->getTotalEmailCount('event_confirmation');
    $stats_contact = $emailSimulator->getTotalEmailCount('contact_acknowledgment');
    ?>
    
    <div class="container">
        <div class="header">
            <h1>📧 Email Simulation Logs</h1>
            <p>View all simulated emails sent by the system</p>
        </div>
        
        <div class="stats">
            <div class="stat-card success">
                <h3><?php echo $total_emails; ?></h3>
                <p>Total Emails</p>
            </div>
            <div class="stat-card info">
                <h3><?php echo $stats_registration; ?></h3>
                <p>Registration Emails</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $stats_event; ?></h3>
                <p>Event Confirmations</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $stats_contact; ?></h3>
                <p>Contact Acknowledgments</p>
            </div>
        </div>
        
        <form method="GET" class="filters">
            <label for="type">Filter by Type:</label>
            <select name="type" id="type">
                <option value="">All Types</option>
                <option value="registration" <?php echo $filter_type === 'registration' ? 'selected' : ''; ?>>Registration</option>
                <option value="event_confirmation" <?php echo $filter_type === 'event_confirmation' ? 'selected' : ''; ?>>Event Confirmation</option>
                <option value="contact_acknowledgment" <?php echo $filter_type === 'contact_acknowledgment' ? 'selected' : ''; ?>>Contact Acknowledgment</option>
                <option value="general" <?php echo $filter_type === 'general' ? 'selected' : ''; ?>>General</option>
            </select>
            
            <button type="submit">Apply Filter</button>
            
            <?php if ($filter_type): ?>
                <a href="view_emails.php" style="text-decoration: none; color: #666;">Clear Filter</a>
            <?php endif; ?>
        </form>
        
        <div class="email-list">
            <?php if (empty($emails)): ?>
                <div class="no-emails">
                    <i>📭</i>
                    <h3>No emails found</h3>
                    <p>No simulated emails have been sent yet.</p>
                </div>
            <?php else: ?>
                <?php foreach ($emails as $email): ?>
                    <div class="email-item">
                        <div class="email-header" onclick="toggleEmail(<?php echo $email['id']; ?>)">
                            <div class="email-info">
                                <div>
                                    <span class="email-type type-<?php echo $email['email_type']; ?>">
                                        <?php echo str_replace('_', ' ', ucfirst($email['email_type'])); ?>
                                    </span>
                                </div>
                                <div class="email-recipient">
                                    <?php echo htmlspecialchars($email['recipient_name']); ?> 
                                    &lt;<?php echo htmlspecialchars($email['recipient_email']); ?>&gt;
                                </div>
                                <div class="email-subject">
                                    <?php echo htmlspecialchars($email['subject']); ?>
                                </div>
                            </div>
                            <div class="email-time">
                                <?php echo date('M d, Y H:i', strtotime($email['sent_at'])); ?>
                            </div>
                        </div>
                        <div class="email-body" id="email-<?php echo $email['id']; ?>">
                            <?php echo $email['message_body']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo $filter_type ? '&type=' . $filter_type : ''; ?>">← Previous</a>
                <?php endif; ?>
                
                <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                    <a href="?page=<?php echo $i; ?><?php echo $filter_type ? '&type=' . $filter_type : ''; ?>" 
                       class="<?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo $filter_type ? '&type=' . $filter_type : ''; ?>">Next →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <a href="index.php" class="back-btn">← Back to Home</a>
    </div>
    
    <script>
        function toggleEmail(id) {
            const emailBody = document.getElementById('email-' + id);
            emailBody.classList.toggle('active');
        }
    </script>
</body>
</html>
