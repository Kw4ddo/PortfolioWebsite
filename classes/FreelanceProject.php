<?php
require_once 'Project.php';

class FreelanceProject extends Project {
    private $clientName;
    private $budget;

    public function __construct($title, $description, $date, $category, $image, $clientName, $budget) {
        parent::__construct($title, $description, $date, $category, $image);
        $this->clientName = $clientName;
        $this->budget = $budget;
    }
    public function getClientName() {
        return $this->clientName;
    }

    public function setClientName($clientName) {
        $this->clientName = $clientName;
    }

    public function getBudget() {
        return $this->budget;
    }

    public function setBudget($budget) {
        $this->budget = $budget;
    }
}
?>