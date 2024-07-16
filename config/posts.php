<?php

class Posts {
    private $titre;

    private $author;

    private $text;

    private $date;

    private $like;

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

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    public function setLike($like) {
        $this->like = $like;
    }

    public function getLike() {
        return $this->like;
    }
}