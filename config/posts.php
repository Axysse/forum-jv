<?php

class Posts {
    private $titre;

    private $author;

    private $text;

    private $like;

    private $sCategorieId;

    private $time;

    

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function getTitre() {   
        return $this->titre;    
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }

    public function setLike($like) {
        $this->like = $like;
    }

    public function getLike() {
        return $this->like;
    }

    public function setsCategorieId($sCategorieId) {
        $this->sCategorieId = $sCategorieId;
    }

    public function getsCategorieId() {
        return $this->sCategorieId;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function getTime() {   
        return $this->time;    
    }

}