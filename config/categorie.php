<?php

class Categories {

    private $categorie;

    public function setsCategorie($categorie) {
        $this->categorie = $categorie;
    }

    public function getsCategorie(): string
    {
        return $this->categorie;
    }
}