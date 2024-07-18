<?php
require_once ("config/config.php");
session_start();
$bdd = new Bdd();
$bdd->connect();

$posts = $bdd->getAllPosts();
$pseudo = $_SESSION["user"]["pseudo"];

var_dump($pseudo);

var_dump($posts);



if(isset($_POST["envoi_post"])) {
    $titre = $_POST["title"];
    $text = $_POST["post"];
    $author = $_SESSION["user"]["pseudo"];
    $sCategorieId = 1;

    $newPost = new Posts();
    $newPost->setTitre($titre);
    $newPost->setText($text);
    $newPost->setAuthor($author);
    $newPost->setSCategorieId($sCategorieId);

    $bdd->addPost($newPost);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<header class="flex flex-row justify-between items-center border-b-2 shadow-lg">
        <?php include ("content/navbar.php"); ?>
    </header>
    <main class="px-5 pt-10">
        <section>
            <article class="flex flex-col justify-center items-center items-center">
                <div class="w-[75%] bg-blue-400 px-1 pl-5 py-1 border-b-2 border-gray-400">
                <h1>JEUX VIDEO</h1>
                </div>
                <div class="w-[75%] bg-blue-200 px-1 pl-10 py-1 border-b-1 border-gray-400 flex flex-row justify-between">
                <h2>CS2</h2>
                </div>
            </article>
        </section>
        <section>
            <article>

            </article>
        </section>
        </section>
        <?php if (isset($_SESSION["user"])) { ?>
            <section class="flex flex-col justify-center items-center py-5">
                <h3>Nouveau Topic:</h3>
                <form class="flex flex-col justify-between">
                    <div class="flex flex-col justify-center items-center">
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