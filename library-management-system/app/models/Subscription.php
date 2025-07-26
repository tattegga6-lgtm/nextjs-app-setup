<?php
// app/models/Subscription.php
class Subscription {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllSubscriptions() {
        try {
            $sql = "SELECT * FROM subscriptions ORDER BY subscription_name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching subscriptions: " . $e->getMessage());
            return [];
        }
    }
    
    public function getSubscriptionById($id) {
        try {
            $sql = "SELECT * FROM subscriptions WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching subscription: " . $e->getMessage());
            return false;
        }
    }
    
    public function createSubscription($data) {
        try {
            $sql = "INSERT INTO subscriptions (subscription_name, description, price, duration_months, features, is_active) 
                    VALUES (:name, :description, :price, :duration, :features, :active)";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'name' => $data['subscription_name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'duration' => $data['duration_months'],
                'features' => $data['features'],
                'active' => $data['is_active'] ?? 1
            ]);
        } catch (PDOException $e) {
            error_log("Error creating subscription: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateSubscription($id, $data) {
        try {
            $sql = "UPDATE subscriptions SET 
                    subscription_name = :name,
                    description = :description,
                    price = :price,
                    duration_months = :duration,
                    features = :features,
                    is_active = :active
                    WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'name' => $data['subscription_name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'duration' => $data['duration_months'],
                'features' => $data['features'],
                'active' => $data['is_active']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating subscription: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteSubscription($id) {
        try {
            $sql = "DELETE FROM subscriptions WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting subscription: " . $e->getMessage());
            return false;
        }
    }
    
    public function getStudentSubscriptions($studentId = null) {
        try {
            if ($studentId) {
                $sql = "SELECT ss.*, s.subscription_name, s.price, st.full_name as student_name, st.student_id
                        FROM student_subscriptions ss
                        JOIN subscriptions s ON ss.subscription_id = s.id
                        JOIN students st ON ss.student_id = st.id
                        WHERE ss.student_id = :student_id
                        ORDER BY ss.created_at DESC";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['student_id' => $studentId]);
            } else {
                $sql = "SELECT ss.*, s.subscription_name, s.price, st.full_name as student_name, st.student_id
                        FROM student_subscriptions ss
                        JOIN subscriptions s ON ss.subscription_id = s.id
                        JOIN students st ON ss.student_id = st.id
                        ORDER BY ss.created_at DESC";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching student subscriptions: " . $e->getMessage());
            return [];
        }
    }
    
    public function assignSubscriptionToStudent($studentId, $subscriptionId, $startDate = null) {
        try {
            $subscription = $this->getSubscriptionById($subscriptionId);
            if (!$subscription) {
                return false;
            }
            
            $startDate = $startDate ?: date('Y-m-d');
            $endDate = date('Y-m-d', strtotime($startDate . ' + ' . $subscription['duration_months'] . ' months'));
            
            $sql = "INSERT INTO student_subscriptions (student_id, subscription_id, start_date, end_date, status, payment_status) 
                    VALUES (:student_id, :subscription_id, :start_date, :end_date, 'active', 'pending')";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'student_id' => $studentId,
                'subscription_id' => $subscriptionId,
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);
        } catch (PDOException $e) {
            error_log("Error assigning subscription: " . $e->getMessage());
            return false;
        }
    }
    
    public function getSubscriptionStats() {
        try {
            $stats = [];
            
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM subscriptions WHERE is_active = 1");
            $stats['active_subscriptions'] = $stmt->fetchColumn();
            
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM student_subscriptions WHERE status = 'active'");
            $stats['active_student_subscriptions'] = $stmt->fetchColumn();
            
            $stmt = $this->pdo->query("SELECT SUM(s.price) FROM student_subscriptions ss JOIN subscriptions s ON ss.subscription_id = s.id WHERE ss.payment_status = 'paid'");
            $stats['total_revenue'] = $stmt->fetchColumn() ?: 0;
            
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM student_subscriptions WHERE end_date < date('now') AND status = 'active'");
            $stats['expired_subscriptions'] = $stmt->fetchColumn();
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error getting subscription stats: " . $e->getMessage());
            return [];
        }
    }
}
?>
