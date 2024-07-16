<?php
require_once("config/config.php");
session_start();
$bdd = new Bdd();
$bdd->connect();

$users = $bdd->getAllUsers();

if(isset($_POST["submit_inscr"])) {
    $pseudo = htmlspecialchars(stripcslashes(trim($_POST["pseudo_inscr"])));
    $password = htmlspecialchars(stripcslashes(trim($_POST["password_inscr"])));
    $mail = htmlspecialchars(stripcslashes(trim($_POST["mail_inscr"])));

    $newUser = new Users();
    $newUser->setPseudo($pseudo);
    $newUser->setPassword(password_hash($password, PASSWORD_ARGON2ID));
    $newUser->setMail($mail);

    $bdd->addUser($newUser);
}

if(isset($_POST["submit_con"])) {

    $pseudo = htmlspecialchars(stripcslashes(trim($_POST["pseudo_con"])));
    $password = htmlspecialchars($_POST["password_con"]);

    if(!empty($pseudo) && !empty($password)) {
        $user = $bdd->userConnect(["user" => $pseudo, "password" => $password]);
        if($user) {
            $_SESSION['user'] = $user;
            $message =null;
            print "Bienvenue ".$user["pseudo"];
} else {
    print "C'est pas bon";
}
    } else {
        print "T'as rien rentré";
    }
}

if(isset($_POST["envoi_post"])) {
    $post = ($_POST["post"]);
    $titrePost = ($_POST["title"]);

    $newPost = new Posts();
    $newPost->setTitre($titrePost);
    $newPost->setAuthor($_SESSION["pseudo"]);
    $newPost->setText($post);

    $bdd->addPost($newPost);
}

// var_dump($user);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="flex flex-row justify-between items-center border-b-2 shadow-lg">
        <?php include ("content/navbar.php"); ?>
    </header>
    <main class="px-5 pt-10">
        <?php if (!isset($_SESSION["user"])) { ?>
        <section class="flex flex-row justify-around pb-5 border-b-2 shadow-lg">
            <article class="flex flex-col items-center align-items border-r-2 border-black pr-96">
                <h2 class="text-center">Rejoint le côté obscur!<br> (Viens on a des cookies)</h2>
                <form class="flex flex-col justify-center" action="" method="post">
                    <ul class="flex flex-col justify-center items-center gap-2">
                        <li>
                            
                            <input class="border-2 border-black" type="text" id="pseudo" name="pseudo_inscr" placeholder="pseudo">
                        </li>
                        <li>
                            <input class="border-2 border-black" type="text" id="password" name="password_inscr" placeholder="mot de passe">
                        </li>
                        <li>
                            <input class="border-2 border-black" type="email" id="mail" name="mail_inscr" placeholder="mail">
                        </li>
                        <li>
                            <button class="border-2 border-black bg-gray-300" type="submit" name="submit_inscr">Envoyer</button>
                        </li>
                        
                    </ul>
                </form>
            </article>
            
            <article class="flex flex-col items-center align-items">
                <h2 class="text-center">Déjà passé de l'autre côté?<br> (BG)</h2>
                <form class="flex flex-col justify-center" action="" method="post">
                    <ul class="flex flex-col justify-center items-center gap-2">
                        <li>
                            
                            <input class="border-2 border-black" type="text" id="pesudo" name="pseudo_con" placeholder="pseudo">
                        </li>
                        <li>
                            <input class="border-2 border-black" type="text" id="password" name="password_con" placeholder="mot de passe">
                        </li>
                        <li>
                            <button class="border-2 border-black bg-gray-300" type="submit" name="submit_con">Envoyer</button>
                        </li>
                    </ul>
                </form>
            </article>
        </section>
        <?php } ?>
        <section>
            <!-- <?php
                // foreach($posts as $post) {


                // }
            ?> -->
        </section>
        <section class="flex flex-col justify-center items-center py-5">
            <h3>Nouveau Topic:</h3>
            <form class="flex flex-col justify-between">
                <div class="flex flex-col justify-center items-center">
                <input class="border-2 border-black" type="text" name="title" id="text_post" placeholder="titre du post"> 
                <label for="post">Ecris ton post:</label>
                <textarea class="border-2 border-black" id="post" name="post" rows="5" cols="90"></textarea>
                </div>
                <button class="border-2 border-black bg-gray-300" type="submit" name="envoi_post">Envoyer</button>
            </form>
        </section>
    </main>
    <footer class="flex flex-row justify-between items-center border-t-2 border-b-2 px-5">
            <?php include ("content/footer.html"); ?>
    </footer>
</body>

</html>