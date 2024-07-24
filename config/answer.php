<?php

class Answer {

    private $author;

    private $text;

    private $date;

    private $post_id;

    private $id;

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

    public function setDate($date){
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    public function setPostId($post_id) {
        $this->post_id = $post_id;
    }

    public function getPostId() {
        return $this->post_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }


}