<?php
require 'DB.php';

class WorkTime {
    private $db;
    const REQUIRED_WORK_HOUR_DAILY = 8;

    public function __construct(DB $db) {
        $this->db = $db->pdo;
    }

    public function addRecord($name, $arrived_at, $leaved_at) {
        $query = "INSERT INTO work_time (name, arrived_at, leaved_at) VALUES (:name, :arrived_at, :leaved_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindValue(':arrived_at', $arrived_at->format('Y-m-d H:i'));
        $stmt->bindValue(':leaved_at', $leaved_at->format('Y-m-d H:i'));
        $stmt->execute();
    }

    public function getAllRecords() {
        $query = "SELECT * FROM work_time";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calculateWorkedTime($arrived_at, $leaved_at) {
        $diff = $arrived_at->diff($leaved_at);
        return $diff->h * 3600 + $diff->i * 60 + $diff->s;
    }

    public function calculateRemainingTime($worked_seconds) {
        $required_seconds = self::REQUIRED_WORK_HOUR_DAILY * 3600;
        return $required_seconds - $worked_seconds;
    }
}
?>
