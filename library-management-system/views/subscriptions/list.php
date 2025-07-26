<?php
// views/subscriptions/list.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Subscription Management</h1>
    <p class="page-subtitle">Manage library subscriptions and plans</p>
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

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Subscriptions</h2>
        <a href="index.php?route=subscriptions&action=create" class="btn btn-primary">Create New Subscription</a>
    </div>
    
    <?php if (empty($subscriptions)): ?>
        <div class="text-center" style="padding: 3rem; color: #6c757d;">
            <p>No subscriptions found.</p>
            <a href="index.php?route=subscriptions&action=create" class="btn btn-primary mt-2">Create First Subscription</a>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Duration (Months)</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscriptions as $subscription): ?>
                        <tr>
                            <td><?= htmlspecialchars($subscription['subscription_name']) ?></td>
                            <td>$<?= number_format($subscription['price'], 2) ?></td>
                            <td><?= $subscription['duration_months'] ?></td>
                            <td>
                                <?= $subscription['is_active'] ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>' ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="index.php?route=subscriptions&action=edit&id=<?= $subscription['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                    <a href="index.php?route=subscriptions&action=delete&id=<?= $subscription['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subscription?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
