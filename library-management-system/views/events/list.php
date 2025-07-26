<?php
// views/events/list.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Event Management</h1>
    <p class="page-subtitle">Manage library events and registrations</p>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= $stats['total_events'] ?? 0 ?></div>
        <div class="stat-label">Total Events</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['upcoming_events'] ?? 0 ?></div>
        <div class="stat-label">Upcoming Events</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['total_registrations'] ?? 0 ?></div>
        <div class="stat-label">Total Registrations</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Library Events</h2>
        <?php if (hasRole('admin') || hasRole('staff')): ?>
            <a href="index.php?route=events&action=create" class="btn btn-primary">Create Event</a>
        <?php endif; ?>
    </div>
    
    <div class="text-center" style="padding: 3rem;">
        <p style="color: #6c757d; font-size: 1.1rem;">
            Event management system is ready for implementation.
        </p>
        <p style="color: #6c757d;">
            Features include event creation, registration management, and attendance tracking.
        </p>
        <?php if (hasRole('admin') || hasRole('staff')): ?>
            <a href="index.php?route=events&action=create" class="btn btn-primary mt-2">Create First Event</a>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
