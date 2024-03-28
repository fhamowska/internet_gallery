<?php

namespace App\Entity;

class Image {
    private $id;
    private $imagePath;
    private $altText;

    public function __construct($imagePath, $altText) {
        $this->imagePath = $imagePath;
        $this->altText = $altText;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function setAltText($altText) {
        $this->altText = $altText;
    }

    public function getAltText() {
        return $this->altText;
    }
}