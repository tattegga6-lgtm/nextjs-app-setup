<?php
// views/shifts/list.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Shift Management</h1>
    <p class="page-subtitle">Manage library operating shifts and schedules</p>
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
        <div class="stat-number"><?= $stats['total_shifts'] ?? 0 ?></div>
        <div class="stat-label">Total Shifts</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['active_shifts'] ?? 0 ?></div>
        <div class="stat-label">Active Shifts</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Library Shifts</h2>
        <a href="index.php?route=shifts&action=create" class="btn btn-primary">Create Shift</a>
    </div>
    
    <div class="text-center" style="padding: 3rem;">
        <p style="color: #6c757d; font-size: 1.1rem;">
            Shift management system is ready for implementation.
        </p>
        <p style="color: #6c757d;">
            Features include shift scheduling, time period management, and capacity tracking.
        </p>
        <a href="index.php?route=shifts&action=create" class="btn btn-primary mt-2">Create First Shift</a>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
