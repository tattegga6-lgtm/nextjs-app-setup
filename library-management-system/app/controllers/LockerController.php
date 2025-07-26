<?php
// app/controllers/LockerController.php
class LockerController {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function index() {
        $pageTitle = 'Locker Management';
        $lockers = [];
        $stats = ['total_lockers' => 100, 'assigned_lockers' => 65, 'available_lockers' => 35];
        include __DIR__ . '/../../views/lockers/list.php';
    }
    
    public function assign($id) {
        $_SESSION['success'] = "Locker assigned successfully.";
        redirect('lockers');
    }
    
    public function unassign($id) {
        $_SESSION['success'] = "Locker unassigned successfully.";
        redirect('lockers');
    }
}
?>
