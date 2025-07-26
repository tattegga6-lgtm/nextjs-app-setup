<?php
// views/subscriptions/create.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Create Subscription Plan</h1>
    <p class="page-subtitle">Add a new subscription plan for tenants</p>
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
    <form method="POST" action="index.php?route=subscriptions&action=create">
        <div class="form-group">
            <label for="subscription_name" class="form-label">Subscription Name *</label>
            <input 
                type="text" 
                id="subscription_name" 
                name="subscription_name" 
                class="form-control" 
                required 
                value="<?= htmlspecialchars($subscriptionName ?? '') ?>"
                placeholder="Enter subscription name"
            >
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea 
                id="description" 
                name="description" 
                class="form-control" 
                rows="3"
                placeholder="Describe the subscription plan"
            ><?= htmlspecialchars($description ?? '') ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="price" class="form-label">Price ($) *</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    class="form-control" 
                    required 
                    step="0.01" 
                    min="0"
                    value="<?= htmlspecialchars($price ?? '') ?>"
                    placeholder="0.00"
                >
            </div>
            <div class="form-group">
                <label for="duration_months" class="form-label">Duration (Months) *</label>
                <input 
                    type="number" 
                    id="duration_months" 
                    name="duration_months" 
                    class="form-control" 
                    required 
                    min="1"
                    value="<?= htmlspecialchars($durationMonths ?? '') ?>"
                    placeholder="12"
                >
            </div>
        </div>
        
        <div class="form-group">
            <label for="features" class="form-label">Features</label>
            <textarea 
                id="features" 
                name="features" 
                class="form-control" 
                rows="4"
                placeholder="List features separated by commas"
            ><?= htmlspecialchars($features ?? '') ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="is_active" class="form-label">Active</label>
            <input 
                type="checkbox" 
                id="is_active" 
                name="is_active" 
                value="1" 
                <?= (isset($isActive) && $isActive) ? 'checked' : 'checked' ?>
            >
        </div>
        
        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Create Subscription</button>
            <a href="index.php?route=subscriptions" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
