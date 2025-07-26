<?php
// views/lockers/list.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Locker Management</h1>
    <p class="page-subtitle">Manage locker assignments and availability</p>
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
        <div class="stat-number"><?= $stats['total_lockers'] ?? 0 ?></div>
        <div class="stat-label">Total Lockers</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['assigned_lockers'] ?? 0 ?></div>
        <div class="stat-label">Assigned Lockers</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['available_lockers'] ?? 0 ?></div>
        <div class="stat-label">Available Lockers</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Locker Assignments</h2>
    </div>
    
    <div class="text-center" style="padding: 3rem;">
        <p style="color: #6c757d; font-size: 1.1rem;">
            Locker management system is ready for implementation.
        </p>
        <p style="color: #6c757d;">
            Features include locker assignment, availability tracking, and student management.
        </p>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
