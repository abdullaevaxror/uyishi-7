<?php

if (!class_exists('DB')) {
    class DB {
        private $host = '127.0.0.1';
        private $dbname = 'work_of_tracker';
        private $user = 'axror';
        private $password = 'Xc0~t05VF"`_';
        public $pdo;

        public function __construct() {
            try {
                $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
    }
}
?>
