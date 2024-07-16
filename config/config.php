<?php


include ("users.php");
include ("posts.php");

class bdd
{

    private $bdd;

    public function connect()
    {

        try {
            $this->bdd = new PDO("mysql:host=localhost;dbname=forumjv", 'root', '');

            return $this->bdd;
        } catch (PDOException $e) {

            $error = fopen("error.log", "w");
            $txt = $e . "\n";
            fwrite($error, $txt);

            throw new Exception("non garçon");
        }
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";

        $done = $this->bdd->query($sql);

        return $done->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(Users $user): void
    {

        $pseudo = $user->getPseudo();
        $password = $user->getPassword();
        $mail = $user->getMail();


        $sql = $this->bdd->prepare("INSERT INTO users (pseudo, password, mail) VALUES (:pseudo, :password, :mail)");
        $sql->bindParam(":pseudo", $pseudo);
        $sql->bindParam(":password", $password);
        $sql->bindParam(":mail", $mail);
        $sql->execute();

    }

    public function userConnect($param = [])
    {
        $users = $this->getAllUsers();

        foreach ($users as $user) {
            if ($param["user"] == $user["pseudo"] && password_verify($param["password"], $user["password"])) {
                return $user;
            }
        }
    }

    public function disconnect() {
        $this->bdd = null;
    }

    public function getAllPosts()
    {

        $sql = "SELECT * FROM posts";

        $done = $this->bdd->query($sql);

        return $done->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPost(Posts $post): void {
        $titre = $post->getTitre();
        $author = $post->getAuthor();
        $text = $post->getText();

        $sql = $this->bdd->prepare("INSERT INTO posts (titre, author, text) VALUES (:titre, :author, :text)");
        $sql->bindParam(":titre", $titre);
        $sql->bindParam(":author", $author);
        $sql->bindParam(":text", $text);
        $sql->execute();
    }

}