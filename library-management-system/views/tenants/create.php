<?php
// views/tenants/create.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Create Tenant</h1>
    <p class="page-subtitle">Add a new tenant (customer) to the SaaS platform</p>
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
    <form method="POST" action="index.php?route=tenants&action=create">
        <div class="form-group">
            <label for="tenant_name" class="form-label">Tenant Name *</label>
            <input 
                type="text" 
                id="tenant_name" 
                name="tenant_name" 
                class="form-control" 
                required 
                value="<?= htmlspecialchars($tenantName ?? '') ?>"
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
            ><?= htmlspecialchars($address ?? '') ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="contact_email" class="form-label">Contact Email *</label>
            <input 
                type="email" 
                id="contact_email" 
                name="contact_email" 
                class="form-control" 
                required 
                value="<?= htmlspecialchars($contactEmail ?? '') ?>"
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
                value="<?= htmlspecialchars($contactPhone ?? '') ?>"
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
                value="<?= htmlspecialchars($domain ?? '') ?>"
                placeholder="example.com"
            >
        </div>
        
        <div class="form-group">
            <label for="subscription_id" class="form-label">Subscription Plan</label>
            <select id="subscription_id" name="subscription_id" class="form-control">
                <option value="">-- Select Subscription --</option>
                <?php if (!empty($subscriptions)): ?>
                    <?php foreach ($subscriptions as $sub): ?>
                        <option value="<?= $sub['id'] ?>" <?= (isset($subscriptionId) && $subscriptionId == $sub['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sub['subscription_name']) ?> - $<?= number_format($sub['price'], 2) ?> / <?= $sub['duration_months'] ?> months
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        
        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Create Tenant</button>
            <a href="index.php?route=tenants" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
