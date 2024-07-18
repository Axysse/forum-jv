<?php

class SousCategories {

    private $sousCategorie;

    public function setCategorie($sousCategorie) {
        $this->sousCategorie = $sousCategorie;
    }

    public function getCategorie(): string
    {
        return $this->sousCategorie;
    }
}