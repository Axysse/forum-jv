<?php

class SousCategories {

    private $sousCategorie;

    private $sousCategorieId;

    public function setCategorie($sousCategorie) {
        $this->sousCategorie = $sousCategorie;
    }

    public function getCategorie(): string
    {
        return $this->sousCategorie;
    }

    public function setCategorieId($sousCategorieId) {
        $this->sousCategorieId = $sousCategorieId;
    }

    public function getCategorieId(): string
    {
        return $this->sousCategorieId;
    }
}