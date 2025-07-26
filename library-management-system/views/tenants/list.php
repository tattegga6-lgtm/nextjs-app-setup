<?php
// views/tenants/list.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Tenant Management</h1>
    <p class="page-subtitle">Manage tenants (customers) of the SaaS platform</p>
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
        <h2 class="card-title">Tenants</h2>
        <a href="index.php?route=tenants&action=create" class="btn btn-primary">Create New Tenant</a>
    </div>
    
    <?php if (empty($tenants)): ?>
        <div class="text-center" style="padding: 3rem; color: #6c757d;">
            <p>No tenants found.</p>
            <a href="index.php?route=tenants&action=create" class="btn btn-primary mt-2">Create First Tenant</a>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Contact Email</th>
                        <th>Subscription</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tenants as $tenant): ?>
                        <tr>
                            <td><?= htmlspecialchars($tenant['tenant_name']) ?></td>
                            <td><?= htmlspecialchars($tenant['contact_email'] ?: '-') ?></td>
                            <td><?= htmlspecialchars($tenant['subscription_id'] ?: 'N/A') ?></td>
                            <td><?= htmlspecialchars($tenant['created_at']) ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="index.php?route=tenants&action=edit&id=<?= $tenant['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                    <a href="index.php?route=tenants&action=delete&id=<?= $tenant['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this tenant?')">Delete</a>
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
