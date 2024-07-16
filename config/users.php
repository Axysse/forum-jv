<?php

class Users
{
    private $pseudo;

    private $password;

    private $mail;

    private $avatar;
    
    private $admin;

    public function setPseudo($pseudo){
        $this->pseudo = $pseudo;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setMail($mail){
        $this->mail = $mail;
    }

    public function getMail(): string {
        return $this->mail;
    }

    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }

    public function getAvatar(): string {
        return $this->avatar;
    }

}