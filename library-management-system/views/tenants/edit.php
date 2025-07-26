<?php
// views/tenants/edit.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Edit Tenant</h1>
    <p class="page-subtitle">Modify tenant details</p>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="index.php?route=tenants&action=edit&id=<?= $tenant['id'] ?>">
        <div class="form-group">
            <label for="tenant_name" class="form-label">Tenant Name *</label>
            <input 
                type="text" 
                id="tenant_name" 
                name="tenant_name" 
                class="form-control" 
                required 
                value="<?= htmlspecialchars($tenant['tenant_name'] ?? '') ?>"
                placeholder="Enter tenant name"
            >
        </div>
        
        <div class="form-group">
            <label for="address" class="form-label">Address</label>
            <textarea 
                id="address" 
                name="address" 
                class="form-control" 
                rows="3"
                placeholder="Enter tenant address"
            ><?= htmlspecialchars($tenant['address'] ?? '') ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="contact_email" class="form-label">Contact Email *</label>
            <input 
                type="email" 
                id="contact_email" 
                name="contact_email" 
                class="form-control" 
                required 
                value="<?= htmlspecialchars($tenant['contact_email'] ?? '') ?>"
                placeholder="contact@example.com"
            >
        </div>
        
        <div class="form-group">
            <label for="contact_phone" class="form-label">Contact Phone</label>
            <input 
                type="tel" 
                id="contact_phone" 
                name="contact_phone" 
                class="form-control" 
                value="<?= htmlspecialchars($tenant['contact_phone'] ?? '') ?>"
                placeholder="+1 555 123 4567"
            >
        </div>
        
        <div class="form-group">
            <label for="domain" class="form-label">Domain</label>
            <input 
                type="text" 
                id="domain" 
                name="domain" 
                class="form-control" 
                value="<?= htmlspecialchars($tenant['domain'] ?? '') ?>"
                placeholder="example.com"
            >
        </div>
        
        <div class="form-group">
            <label for="subscription_id" class="form-label">Subscription Plan</label>
            <select id="subscription_id" name="subscription_id" class="form-control">
                <option value="">-- Select Subscription --</option>
                <?php if (!empty($subscriptions)): ?>
                    <?php foreach ($subscriptions as $sub): ?>
                        <option value="<?= $sub['id'] ?>" <?= (isset($tenant['subscription_id']) && $tenant['subscription_id'] == $sub['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sub['subscription_name']) ?> - $<?= number_format($sub['price'], 2) ?> / <?= $sub['duration_months'] ?> months
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        
        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Update Tenant</button>
            <a href="index.php?route=tenants" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    
    <?php if (hasRole('super_admin') && isset($tenant)): ?>
    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-title">Tenant Administrator</h2>
        </div>
        <div class="card-content">
            <?php
            require_once __DIR__ . '/../../app/models/User.php';
            $userModel = new User($pdo);
            $adminUser = $userModel->getUserByTenantAndRole($tenant['id'], 'admin');
            ?>
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($adminUser['username'] ?? 'N/A') ?>" readonly>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-title">Tenant Administrator Password Reset</h2>
        </div>
        <form method="POST" action="index.php?route=tenants&action=reset_password&id=<?= $tenant['id'] ?>">
            <div class="form-group">
                <label for="new_password" class="form-label">New Password</label>
                <input 
                    type="password" 
                    id="new_password" 
                    name="new_password" 
                    class="form-control" 
                    required 
                    placeholder="Enter new password"
                >
            </div>
            <div class="form-group">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    class="form-control" 
                    required 
                    placeholder="Confirm new password"
                >
            </div>
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </div>
        </form>
    </div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
