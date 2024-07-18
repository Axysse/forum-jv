<?php
require_once ("config/config.php");
session_start();
$bdd = new Bdd();
$bdd->connect();

$id = $_GET['id'];
var_dump($id);
$posts = $bdd->getAllPosts();
var_dump($posts);

$users = $bdd->getAllUsers();
$categorie = $bdd->getAllCategorie();
$sousCategorie = $bdd->getAllSousCategorie();

// var_dump($categorie);
// var_dump($sousCategorie);


if (isset($_POST["submit_inscr"])) {
    $pseudo = htmlspecialchars(stripcslashes(trim($_POST["pseudo_inscr"])));
    $password = htmlspecialchars(stripcslashes(trim($_POST["password_inscr"])));
    $mail = htmlspecialchars(stripcslashes(trim($_POST["mail_inscr"])));

    $newUser = new Users();
    $newUser->setPseudo($pseudo);
    $newUser->setPassword(password_hash($password, PASSWORD_ARGON2ID));
    $newUser->setMail($mail);

    $bdd->addUser($newUser);
}

if (isset($_POST["submit_con"])) {

    $pseudo = htmlspecialchars(stripcslashes(trim($_POST["pseudo_con"])));
    $password = htmlspecialchars($_POST["password_con"]);

    if (!empty($pseudo) && !empty($password)) {
        $user = $bdd->userConnect(["user" => $pseudo, "password" => $password]);
        if ($user) {
            $_SESSION['user'] = $user;
            $message = null;
            print "Bienvenue " . $user["pseudo"];
        } else {
            print "C'est pas bon";
        }
    } else {
        print "T'as rien rentré";
    }
}


if(isset($_POST["envoi_post"])) {
    $titre = $_POST["title"];
    $text = $_POST["post"];
    $author = $_SESSION["user"]["id_user"];
    $sCategorieId = $id;

    $newPost = new Posts;
    $newPost->setTitre($titre);
    $newPost->setText($text);
    $newPost->setAuthor($author);
    $newPost->setsCategorieId($sCategorieId);

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

                                <input class="border-2 border-black" type="text" id="pseudo" name="pseudo_inscr"
                                    placeholder="pseudo">
                            </li>
                            <li>
                                <input class="border-2 border-black" type="text" id="password" name="password_inscr"
                                    placeholder="mot de passe">
                            </li>
                            <li>
                                <input class="border-2 border-black" type="email" id="mail" name="mail_inscr"
                                    placeholder="mail">
                            </li>
                            <li>
                                <button class="border-2 border-black bg-gray-300" type="submit"
                                    name="submit_inscr">Envoyer</button>
                            </li>

                        </ul>
                    </form>
                </article>

                <article class="flex flex-col items-center align-items">
                    <h2 class="text-center">Déjà passé de l'autre côté?<br> (BG)</h2>
                    <form class="flex flex-col justify-center" action="" method="post">
                        <ul class="flex flex-col justify-center items-center gap-2">
                            <li>

                                <input class="border-2 border-black" type="text" id="pesudo" name="pseudo_con"
                                    placeholder="pseudo">
                            </li>
                            <li>
                                <input class="border-2 border-black" type="text" id="password" name="password_con"
                                    placeholder="mot de passe">
                            </li>
                            <li>
                                <button class="border-2 border-black bg-gray-300" type="submit"
                                    name="submit_con">Envoyer</button>
                            </li>
                        </ul>
                    </form>
                </article>
            </section>
        <?php } ?>
        <section class="flex flex-col justify-center items-center items-center">
            <?php foreach ($categorie as $catégories) { ?>
                <article class="w-[75%] bg-blue-400 px-1 pl-5 py-1 border-b-2 border-gray-400">
                <?php print $catégories["nom"]; ?>
                </article>
                <?php foreach ($sousCategorie as $sousCategories) {
                    if ($sousCategories["categorie_id"] == $catégories["id_categorie"]) { ?>
                    <article class="w-[75%] bg-blue-200 px-1 pl-10 py-1 border-b-1 border-gray-400 flex flex-row justify-between">
                        <div>
                      <a href="index.php?id=<?php echo $sousCategories["id_souscategorie"]?>"><?php  print $sousCategories["name"]; ?></a>
                      </div>
                      <div class="pr-24 border-l-2 pl-5 border-gray-400 flex flex-row gap-2">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9l.3-.5z"/></svg>
                            <!-- nbr posts -->
                             <p>272 500 831</p>
                      </div>
                      </article>
                    <?php  }
                }
            } ?>
            </section>
        <?php if (isset($_SESSION["user"]) && (isset($id))) { ?>
            <section class="flex flex-col justify-center items-center py-5">
                <h3>Nouveau Topic:</h3>
                <form action="" method="post" class="flex flex-col justify-between">
                    <div class="flex flex-col just ify-center items-center">
                        <input class="border-2 border-black" type="text" name="title" id="text_post"
                            placeholder="titre du post">
                        <label for="post">Ecris ton post:</label>
                        <textarea class="border-2 border-black" id="post" name="post" rows="5" cols="90"></textarea>
                    </div>
                    <button class="border-2 border-black bg-gray-300" type="submit" name="envoi_post">Envoyer</button>
                </form>
            </section>
        <?php } ?>
    </main>
    <footer class="flex flex-row justify-between items-center border-t-2 border-b-2 px-5 mt-10">
        <?php include ("content/footer.html"); ?>
    </footer>
</body>

</html>





<!-- ?php echo $sousCategories["name"]?>.php"> -->