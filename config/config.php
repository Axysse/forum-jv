<?php


include ("users.php");
include ("posts.php");
include ("categorie.php");
include ("sous_categorie.php");
include ("answer.php");
include ("report.php");

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

    public function getAllPosts()
    {
        $sql = "SELECT * FROM posts";

        $done = $this->bdd->query($sql);

        return $done->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategorie()
    {
        $sql = "SELECT * FROM catégorie";
        $done = $this->bdd->query($sql);
        return $done->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSousCategorie()
    {
        $sql = "SELECT * FROM sous_categorie";
        $done = $this->bdd->query($sql);
        return $done->fetchAll(PDO::FETCH_ASSOC);
    }

    public function gatAllAnswer()
    {
        $sql = "SELECT * FROM response";
        $done = $this->bdd->query($sql);
        return $done->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getAllReport()
    {
        $sql = "SELECT * FROM signalement";
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

    public function addPost(Posts $post) {
        $titre = $post->getTitre();
        $author = $post->getAuthor();
        $text = $post->getText();
        $sCategorieId = $post->getsCategorieId();
        $time= $post->getTime();
        $like= $post->getLike();


        $sql = $this->bdd->prepare("INSERT INTO posts (titre, souscategorie_id, author, `text`, `date`, `like`) VALUES (:titre, :souscategorie_id, :author, :text, :date, :like)");
        $sql->bindParam(":titre", $titre);
        $sql->bindParam(":author", $author);
        $sql->bindParam(":text", $text);
        $sql->bindParam(":souscategorie_id", $sCategorieId);
        $sql->bindParam(":date", $time);
        $sql->bindParam(":like", $like);
        $sql->execute();
    }

    public function addRep(Answer $answer ) {
        $author = $answer->getAuthor();
        $text = $answer->getText();
        $date = $answer->getDate();
        $post_id = $answer->getPostId();

        $sql = $this->bdd->prepare("INSERT INTO response (author, text, date, post_id) VALUES (:author, :text, :date, :post_id)");
        $sql->bindParam(":author", $author);
        $sql->bindParam(":text", $text);
        $sql->bindParam(":date", $date);
        $sql->bindParam(":post_id", $post_id);
        $sql->execute();
    }

    public function addLike($id) {
        $sql = $this->bdd->prepare("UPDATE posts SET `like` = `like` + 1 WHERE id_posts = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function addCat (Categories $categorie) {
        $titre = $categorie->getsCategorie();

        $sql = $this->bdd->prepare("INSERT INTO catégorie (nom) VALUES (:nom)");
        $sql->bindParam(":nom", $titre);
        $sql->execute();
    }

    public function addSousCat (SousCategories $sousCategorie) {
        $titre = $sousCategorie->getCategorie();
        $idCat = $sousCategorie->getCategorieId();

        $sql = $this->bdd->prepare("INSERT INTO sous_categorie (categorie_id, name) VALUES (:categorie_id, :name)");
        $sql->bindParam(":categorie_id", $idCat);
        $sql->bindParam(":name", $titre);
        $sql->execute(); 
    }

    public function insert($image) {

        $id = $_SESSION["user"]["id_user"];
        $avatar = "./ressources/uploads/".$image["name"];

        $sql = ("UPDATE users SET avatar='$avatar' WHERE id_user='$id'");
        $exe = $this->bdd->prepare($sql);
        $exe->execute();
    }

    public function deleteResponse($id) {
        $sql = $this->bdd->prepare("DELETE FROM response WHERE id_response = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function deletePost($id) {
        $sql = $this->bdd->prepare("DELETE FROM posts WHERE id_posts = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function deleteUser($id) {
        $sql = $this->bdd->prepare("DELETE FROM users WHERE id_user = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function deleteSousCat($id) {
        $sql = $this->bdd->prepare("DELETE FROM sous_categorie WHERE id_souscategorie = :id");

        $sql->bindParam(":id",$id );
        $sql->execute();
    }

    public function deleteCat($id) {
        $sql = $this->bdd->prepare("DELETE FROM catégorie WHERE id_categorie = :id");

        $sql->bindParam(":id",$id );
        $sql->execute();
    }

    public function deleteReport($id) {
        $sql = $this->bdd->prepare("DELETE from signalement WHERE id_signal = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function modifRep($param = []) {
        $sql = $this->bdd->prepare("UPDATE response  SET text = :text WHERE id_response = :id");

        $sql->bindParam(":text", $param["text"]);
        $sql->bindParam(":id", $param["id_response"]);
        $sql->execute();
    }

    public function filArianne() {
        $sql = "SELECT * FROM sous_categorie  JOIN catégorie ON sous_categorie.categorie_id = catégorie.id_categorie
                                            JOIN posts ON sous_categorie.id_souscategorie = posts.souscategorie_id";

        $done = $this->bdd->query($sql);
        return $done->fetchAll();
    }

    public function countPosts($id) {
        $sql = "SELECT COUNT(*) FROM `posts` WHERE `souscategorie_id` = $id"; 

        $done = $this->bdd->query($sql);
        return $done->fetchAll();
    }

    // public function getAnswerId(Answer $id) {

    //     $nid = $id->getId();

    //     $sql = $this->bdd->prepare("SELECT * FROM response JOIN users ON response.author = users.id_user WHERE id_response = :id");

    //     $sql->bindParam(":id", $nid);

    //     $done = $this->bdd->query($sql);
    //     return $done->fetchAll();
    // }

    public function AddReport(Report $report){
        $author = $report->getAuthor();
        $text = $report->getText();
        $signal_post_id = $report->getSignalPostId();
        $signal_response_id = $report->getSignalResponseId();
        $report_status = $report->getReportStatus();

        $sql = $this->bdd->prepare("INSERT INTO signalement (author, text, signal_post_id, signal_response_id, report_status) VALUES (:author, :text, :signal_post_id, :signal_response_id, :report_status)");

        $sql->bindParam(":author", $author);
        $sql->bindParam(":text", $text);
        $sql->bindParam(":signal_post_id", $signal_post_id);
        $sql->bindParam(":signal_response_id", $signal_response_id);
        $sql->bindParam(":report_status", $report_status);
        $sql->execute();
    }
}