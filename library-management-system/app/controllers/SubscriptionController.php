<?php
// app/controllers/SubscriptionController.php
require_once __DIR__ . '/../models/Subscription.php';
require_once __DIR__ . '/../models/Student.php';

class SubscriptionController {
    private $pdo;
    private $subscriptionModel;
    private $studentModel;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->subscriptionModel = new Subscription($pdo);
        $this->studentModel = new Student($pdo);
    }
    
    public function index() {
        // Only Super Admin can access subscription management
        if (!hasRole('super_admin')) {
            redirect('dashboard');
        }
        
        $subscriptions = $this->subscriptionModel->getAllSubscriptions();
        $stats = $this->subscriptionModel->getSubscriptionStats();
        
        $pageTitle = 'Subscription Management';
        include __DIR__ . '/../../views/subscriptions/list.php';
    }
    
    public function create() {
        if (!hasRole('super_admin')) {
            redirect('dashboard');
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subscriptionName = trim(filter_input(INPUT_POST, 'subscription_name', FILTER_SANITIZE_STRING));
            $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $durationMonths = filter_input(INPUT_POST, 'duration_months', FILTER_VALIDATE_INT);
            $features = trim(filter_input(INPUT_POST, 'features', FILTER_SANITIZE_STRING));
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            
            if (empty($subscriptionName) || empty($description) || $price === false || $durationMonths === false) {
                $error = "Please fill in all required fields with valid data.";
            } elseif ($price < 0) {
                $error = "Price cannot be negative.";
            } elseif ($durationMonths < 1) {
                $error = "Duration must be at least 1 month.";
            } else {
                $subscriptionData = [
                    'subscription_name' => $subscriptionName,
                    'description' => $description,
                    'price' => $price,
                    'duration_months' => $durationMonths,
                    'features' => $features,
                    'is_active' => $isActive
                ];
                
                if ($this->subscriptionModel->createSubscription($subscriptionData)) {
                    $success = "Subscription created successfully.";
                    // Clear form data
                    $subscriptionName = $description = $features = '';
                    $price = $durationMonths = null;
                    $isActive = 1;
                } else {
                    $error = "Failed to create subscription. Please try again.";
                }
            }
        }
        
        $pageTitle = 'Create Subscription';
        include __DIR__ . '/../../views/subscriptions/create.php';
    }
    
    public function edit($id) {
        if (!hasRole('super_admin')) {
            redirect('dashboard');
        }
        
        if (!$id) {
            redirect('subscriptions');
        }
        
        $subscription = $this->subscriptionModel->getSubscriptionById($id);
        if (!$subscription) {
            redirect('subscriptions');
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subscriptionName = trim(filter_input(INPUT_POST, 'subscription_name', FILTER_SANITIZE_STRING));
            $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $durationMonths = filter_input(INPUT_POST, 'duration_months', FILTER_VALIDATE_INT);
            $features = trim(filter_input(INPUT_POST, 'features', FILTER_SANITIZE_STRING));
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            
            if (empty($subscriptionName) || empty($description) || $price === false || $durationMonths === false) {
                $error = "Please fill in all required fields with valid data.";
            } elseif ($price < 0) {
                $error = "Price cannot be negative.";
            } elseif ($durationMonths < 1) {
                $error = "Duration must be at least 1 month.";
            } else {
                $subscriptionData = [
                    'subscription_name' => $subscriptionName,
                    'description' => $description,
                    'price' => $price,
                    'duration_months' => $durationMonths,
                    'features' => $features,
                    'is_active' => $isActive
                ];
                
                if ($this->subscriptionModel->updateSubscription($id, $subscriptionData)) {
                    $success = "Subscription updated successfully.";
                    // Refresh subscription data
                    $subscription = $this->subscriptionModel->getSubscriptionById($id);
                } else {
                    $error = "Failed to update subscription. Please try again.";
                }
            }
        }
        
        $pageTitle = 'Edit Subscription';
        include __DIR__ . '/../../views/subscriptions/edit.php';
    }
    
    public function delete($id) {
        if (!hasRole('super_admin')) {
            redirect('subscriptions');
        }
        
        if (!$id) {
            redirect('subscriptions');
        }
        
        if ($this->subscriptionModel->deleteSubscription($id)) {
            $_SESSION['success'] = "Subscription deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete subscription.";
        }
        
        redirect('subscriptions');
    }
    
    public function studentSubscriptions() {
        if (!hasRole('super_admin')) {
            redirect('dashboard');
        }
        
        $studentSubscriptions = $this->subscriptionModel->getStudentSubscriptions();
        $stats = $this->subscriptionModel->getSubscriptionStats();
        
        $pageTitle = 'Student Subscriptions';
        include __DIR__ . '/../../views/subscriptions/student_subscriptions.php';
    }
    
    public function assignSubscription() {
        if (!hasRole('super_admin')) {
            redirect('dashboard');
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentId = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);
            $subscriptionId = filter_input(INPUT_POST, 'subscription_id', FILTER_VALIDATE_INT);
            $startDate = trim(filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING));
            
            if (!$studentId || !$subscriptionId) {
                $error = "Please select both student and subscription.";
            } else {
                if ($this->subscriptionModel->assignSubscriptionToStudent($studentId, $subscriptionId, $startDate)) {
                    $success = "Subscription assigned successfully.";
                } else {
                    $error = "Failed to assign subscription. Please try again.";
                }
            }
        }
        
        $tenantId = $_SESSION['tenant_id'] ?? null;
        $students = $this->studentModel->getAllStudents(null, 0, $tenantId);
        $subscriptions = $this->subscriptionModel->getAllSubscriptions();
        
        $pageTitle = 'Assign Subscription';
        include __DIR__ . '/../../views/subscriptions/assign.php';
    }
}
?>
