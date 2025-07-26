<?php
// views/subscriptions/assign.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Assign Subscription</h1>
    <p class="page-subtitle">Assign a subscription plan to a tenant or student</p>
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
    <form method="POST" action="index.php?route=subscriptions&action=assign">
        <div class="form-group">
            <label for="tenant_or_student" class="form-label">Assign To *</label>
            <select id="tenant_or_student" name="assign_type" class="form-control" required>
                <option value="">-- Select Type --</option>
                <option value="tenant" <?= (isset($assignType) && $assignType === 'tenant') ? 'selected' : '' ?>>Tenant</option>
                <option value="student" <?= (isset($assignType) && $assignType === 'student') ? 'selected' : '' ?>>Student</option>
            </select>
        </div>
        
        <div class="form-group" id="tenant_select_group" style="display: none;">
            <label for="tenant_id" class="form-label">Tenant *</label>
            <select id="tenant_id" name="tenant_id" class="form-control">
                <option value="">-- Select Tenant --</option>
                <?php if (!empty($tenants)): ?>
                    <?php foreach ($tenants as $tenant): ?>
                        <option value="<?= $tenant['id'] ?>" <?= (isset($tenantId) && $tenantId == $tenant['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tenant['tenant_name']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        
        <div class="form-group" id="student_select_group" style="display: none;">
            <label for="student_id" class="form-label">Student *</label>
            <select id="student_id" name="student_id" class="form-control">
                <option value="">-- Select Student --</option>
                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $student): ?>
                        <option value="<?= $student['id'] ?>" <?= (isset($studentId) && $studentId == $student['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($student['full_name']) ?> (<?= htmlspecialchars($student['student_id']) ?>)
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="subscription_id" class="form-label">Subscription Plan *</label>
            <select id="subscription_id" name="subscription_id" class="form-control" required>
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
        
        <div class="form-group">
            <label for="start_date" class="form-label">Start Date *</label>
            <input 
                type="date" 
                id="start_date" 
                name="start_date" 
                class="form-control" 
                required 
                value="<?= htmlspecialchars($startDate ?? date('Y-m-d')) ?>"
            >
        </div>
        
        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Assign Subscription</button>
            <a href="index.php?route=subscriptions" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const assignTypeSelect = document.getElementById('tenant_or_student');
    const tenantGroup = document.getElementById('tenant_select_group');
    const studentGroup = document.getElementById('student_select_group');
    
    function toggleAssignGroups() {
        if (assignTypeSelect.value === 'tenant') {
            tenantGroup.style.display = 'block';
            studentGroup.style.display = 'none';
        } else if (assignTypeSelect.value === 'student') {
            tenantGroup.style.display = 'none';
            studentGroup.style.display = 'block';
        } else {
            tenantGroup.style.display = 'none';
            studentGroup.style.display = 'none';
        }
    }
    
    assignTypeSelect.addEventListener('change', toggleAssignGroups);
    toggleAssignGroups();
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
