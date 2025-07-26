<?php
// views/reports/dashboard.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Welcome to the Library Management System</p>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Main Statistics Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= $stats['total_students'] ?? 0 ?></div>
        <div class="stat-label">Total Students</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['active_students'] ?? 0 ?></div>
        <div class="stat-label">Active Members</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['total_books'] ?? 0 ?></div>
        <div class="stat-label">Total Books</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['available_copies'] ?? 0 ?></div>
        <div class="stat-label">Available Copies</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['todays_reservations'] ?? 0 ?></div>
        <div class="stat-label">Today's Reservations</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['available_seats'] ?? 0 ?></div>
        <div class="stat-label">Available Seats</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['available_lockers'] ?? 0 ?></div>
        <div class="stat-label">Available Lockers</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">$<?= number_format($stats['total_outstanding_dues'] ?? 0, 2) ?></div>
        <div class="stat-label">Outstanding Dues</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-top: 2rem;">
    <!-- Recent Activities -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Recent Activities</h2>
        </div>
        
        <?php if (empty($recentActivities)): ?>
            <div class="text-center" style="padding: 2rem; color: #6c757d;">
                <p>No recent activities to display.</p>
            </div>
        <?php else: ?>
            <div style="max-height: 400px; overflow-y: auto;">
                <?php foreach ($recentActivities as $activity): ?>
                    <div style="padding: 1rem; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 500; margin-bottom: 0.25rem;">
                                <?php
                                $icon = '';
                                switch ($activity['type']) {
                                    case 'student_registered':
                                        $icon = '👤';
                                        $text = $activity['title'] . ' registered';
                                        break;
                                    case 'seat_reserved':
                                        $icon = '🪑';
                                        $text = $activity['title'];
                                        break;
                                    case 'fee_paid':
                                        $icon = '💰';
                                        $text = $activity['title'];
                                        break;
                                    case 'event_registered':
                                        $icon = '📅';
                                        $text = $activity['title'];
                                        break;
                                    default:
                                        $icon = '📋';
                                        $text = $activity['title'];
                                }
                                ?>
                                <span style="margin-right: 0.5rem;"><?= $icon ?></span>
                                <?= htmlspecialchars($text) ?>
                            </div>
                        </div>
                        <div style="font-size: 0.8rem; color: #6c757d;">
                            <?= date('M j, g:i A', strtotime($activity['timestamp'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Quick Actions & Alerts -->
    <div>
        <!-- Quick Actions -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php if (hasRole('admin') || hasRole('staff')): ?>
                    <a href="index.php?route=students&action=create" class="btn btn-primary">Add New Student</a>
                    <a href="index.php?route=books&action=create" class="btn btn-secondary">Add New Book</a>
                    <a href="index.php?route=events&action=create" class="btn btn-secondary">Create Event</a>
                <?php endif; ?>
                <a href="index.php?route=reservations&action=create" class="btn btn-outline">Reserve Seat</a>
                <a href="index.php?route=lockers" class="btn btn-outline">View Lockers</a>
            </div>
        </div>
        
        <!-- Alerts & Notifications -->
        <?php if (!empty($overdueItems)): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="color: #dc3545;">⚠️ Overdue Items</h3>
                </div>
                <div style="max-height: 200px; overflow-y: auto;">
                    <?php foreach (array_slice($overdueItems, 0, 5) as $item): ?>
                        <div style="padding: 0.75rem; border-bottom: 1px solid #e9ecef;">
                            <div style="font-weight: 500; font-size: 0.9rem;">
                                <?= htmlspecialchars($item['title']) ?>
                            </div>
                            <div style="font-size: 0.8rem; color: #dc3545;">
                                <?= ucfirst($item['type']) ?> overdue since <?= date('M j, Y', strtotime($item['due_date'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (count($overdueItems) > 5): ?>
                        <div style="padding: 0.75rem; text-align: center;">
                            <small style="color: #6c757d;">
                                And <?= count($overdueItems) - 5 ?> more overdue items...
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Upcoming Events -->
<?php if (!empty($upcomingEvents)): ?>
    <div class="card mt-3">
        <div class="card-header">
            <h2 class="card-title">Upcoming Events</h2>
            <?php if (hasRole('admin') || hasRole('staff')): ?>
                <a href="index.php?route=events" class="btn btn-outline btn-sm">View All Events</a>
            <?php endif; ?>
        </div>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date & Time</th>
                        <th>Location</th>
                        <th>Registrations</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($upcomingEvents as $event): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($event['title']) ?></strong>
                                <?php if ($event['description']): ?>
                                    <br><small style="color: #6c757d;"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?><?= strlen($event['description']) > 100 ? '...' : '' ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= date('M j, Y', strtotime($event['event_date'])) ?><br>
                                <small><?= date('g:i A', strtotime($event['start_time'])) ?> - <?= date('g:i A', strtotime($event['end_time'])) ?></small>
                            </td>
                            <td><?= htmlspecialchars($event['location'] ?: 'TBA') ?></td>
                            <td>
                                <span class="badge <?= $event['registration_count'] >= $event['max_participants'] ? 'badge-danger' : 'badge-success' ?>">
                                    <?= $event['registration_count'] ?>/<?= $event['max_participants'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?route=events&action=view&id=<?= $event['id'] ?>" class="btn btn-outline btn-sm">View Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<!-- Monthly Statistics Chart (Simple Text-based) -->
<?php if (!empty($monthlyStats) && (hasRole('admin') || hasRole('staff'))): ?>
    <div class="card mt-3">
        <div class="card-header">
            <h2 class="card-title">Monthly Trends (Last 6 Months)</h2>
        </div>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>New Students</th>
                        <th>Fee Collection</th>
                        <th>Reservations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monthlyStats as $stat): ?>
                        <tr>
                            <td><strong><?= $stat['month'] ?></strong></td>
                            <td><?= $stat['new_students'] ?></td>
                            <td>$<?= number_format($stat['fee_collection'], 2) ?></td>
                            <td><?= $stat['reservations'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
