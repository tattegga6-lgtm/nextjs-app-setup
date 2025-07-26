<?php
// views/fees/list.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Fee Management</h1>
    <p class="page-subtitle">Track and manage student fees and payments</p>
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
        <div class="stat-number"><?= $stats['total_fees'] ?? 0 ?></div>
        <div class="stat-label">Total Fees</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['pending_fees'] ?? 0 ?></div>
        <div class="stat-label">Pending Fees</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">$<?= number_format($stats['total_amount'] ?? 0, 2) ?></div>
        <div class="stat-label">Total Amount</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">$<?= number_format($stats['collected_amount'] ?? 0, 2) ?></div>
        <div class="stat-label">Collected Amount</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Fee Records</h2>
        <?php if (hasRole('admin') || hasRole('staff')): ?>
            <a href="index.php?route=fees&action=create" class="btn btn-primary">Add Fee</a>
        <?php endif; ?>
    </div>
    
    <div class="text-center" style="padding: 3rem;">
        <p style="color: #6c757d; font-size: 1.1rem;">
            Fee management system is ready for implementation.
        </p>
        <p style="color: #6c757d;">
            Features include fee tracking, payment recording, and invoice generation.
        </p>
        <?php if (hasRole('admin') || hasRole('staff')): ?>
            <a href="index.php?route=fees&action=create" class="btn btn-primary mt-2">Add First Fee</a>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
