<?php
// views/reservations/list.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Seat Reservations</h1>
    <p class="page-subtitle">Manage seat reservations and availability</p>
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
        <div class="stat-number"><?= $stats['total_seats'] ?? 0 ?></div>
        <div class="stat-label">Total Seats</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['available_seats'] ?? 0 ?></div>
        <div class="stat-label">Available Seats</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $stats['todays_reservations'] ?? 0 ?></div>
        <div class="stat-label">Today's Reservations</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Seat Reservations</h2>
        <a href="index.php?route=reservations&action=create" class="btn btn-primary">Reserve Seat</a>
    </div>
    
    <div class="text-center" style="padding: 3rem;">
        <p style="color: #6c757d; font-size: 1.1rem;">
            Seat reservation system is ready for implementation.
        </p>
        <a href="index.php?route=reservations&action=create" class="btn btn-primary mt-2">Make Reservation</a>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
