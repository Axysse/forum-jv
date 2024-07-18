<?php

class Categories {

    private $categorie;

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }
}