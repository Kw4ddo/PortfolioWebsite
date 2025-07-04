<?php
require_once 'Project.php';

class SchoolProject extends Project {
    private $subject;
    private $teacherName;

    public function __construct($title, $description, $date, $category, $image, $subject, $teacherName) {
        parent::__construct($title, $description, $date, $category, $image);
        $this->subject = $subject;
        $this->teacherName = $teacherName;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getTeacherName() {
        return $this->teacherName;
    }

    public function setTeacherName($teacherName) {
        $this->teacherName = $teacherName;
    }
}
?>