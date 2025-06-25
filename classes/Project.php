<?php
class Project {
    private $title;
    private $description;
    private $date;
    private $category;

    public function __construct($title, $description, $date, $category) {
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->category = $category;
    }

    public function getTitle() {
    return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }
}
?>