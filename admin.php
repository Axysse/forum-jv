<?php
require_once ("config/config.php");
session_start();
$bdd = new Bdd();
$bdd->connect();

if($_SESSION["user"]["admin"] != 1){
    header("location: index.php");
}

$users = $bdd->getAllUsers();
$categorie = $bdd->getAllCategorie();
$sousCategorie = $bdd->getAllSousCategorie();
$posts = $bdd->getAllPosts();
$answers = $bdd->gatAllAnswer();



?><pre><?php
// print_r($answers);
?></pre>
<?php

$userjson = json_encode($users);

if(isset($_GET["delete_response"])) {
    foreach($answers as $answer) {
        if($_GET["delete_response"] == $answer["id_response"]) {
            $bdd->deleteResponse($answer["id_response"]);
            header("Location: admin.php");
            exit;
        }
    }
}

if(isset($_GET["delete_post"])) {
    foreach($posts as $post) {
        if($_GET["delete_post"] == $post["id_posts"]) {
            $bdd->deletePost($post["id_posts"]); 
            header("Location: admin.php");
            exit;
        }
    }
}

if(isset($_GET["delete_user"])) {
    foreach($users as $user) {
        if($_GET["delete_user"] == $user["id_user"]) {
            $bdd->deleteUser($user["id_user"]);
            header("Location: admin.php");
        }
    }
}

if(isset($_POST["envoi_cat"])) {
$titre = $_POST["cat"];

$newCat = new Categories;
$newCat-> setsCategorie($titre);
$bdd-> addCat($newCat);
header("Location: admin.php");
}

if(isset($_POST["envoi_sous_cat"])) {
    foreach($categorie as $categories) {
        if($_POST["categorie"] == $categories["nom"]) {
            $titre = $_POST["sous_cat"];
            $categorieID = $categories["id_categorie"];

            $newSousCat = new SousCategories;
            $newSousCat-> setCategorie($titre);
            $newSousCat-> setCategorieId($categorieID);
            $bdd-> addSousCat($newSousCat);
            header("Location: admin.php");
        }
    }  
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
</head>
<body>
<header class="flex flex-row justify-between items-center border-b-2 shadow-lg">
        <?php include ("content/navbar.php"); ?>
    </header>
    <main class="px-5">
        <h1 class="flex pt-5 justify-center">Loué soit le grand admin (on vous attendait pour le sacrifice humain)!</h1>
        <section class="pt-5 border-b-2 shadow-md pb-5 flex flex-row justify-around">
            <article>
                <button id="clk">Users</button>
            </article>
            <article>
                <button id="clk3">Posts</button>
            </article>
            <article>
                <button id="clk2">Réponses</button>
            </article>
        </section>
        <section class="flex flex-col justify-center items-center">
            <article id="navUsers" class="flex flex-col justify-center items-center hidden">
                <h2 class="py-5">Utilisateurs:</h2>
                <table class="">
                    <thead>
                        <tr class="">
                            <th class="px-5 py-2 border-2 border-black bg-blue-100">Id pseudo</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">Pseudo</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">E-mail</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">Delete ?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user) { ?>
                            <tr>
                            <th class=" px-5 py-2 border-2 border-black" class="bg-blue-200" scope="row"><?php echo $user["id_user"]; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"><?php echo $user["pseudo"]; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"><?php echo $user["mail"]; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"> <form method="GET" action=""><button class="bg-orange-700 text-white border-2 border-black p-2" type="submit" name="delete_user" value="<?php print $user["id_user"] ?>">Delete</button></form></th>
                        </tr>
                       <?php } ?>
                        
                    </tbody>
                </table>
            </article>
            <article id="navRep" class="flex flex-col justify-center items-center hidden">
                <h2 class="py-5">Réponses:</h2>
                <table class="">
                    <thead>
                        <tr class="">
                            <th class="px-5 py-2 border-2 border-black bg-blue-100">Id réponse</th>
                            <th class="px-5 py-2 border-2 border-black bg-blue-100">Id post</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">Auteur</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">Texte</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">Delete ?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($answers as $answer) { ?>
                            <tr>
                            <th class=" px-5 py-2 border-2 border-black" class="bg-blue-200" scope="row"><?php echo $answer["id_response"]; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"><?php foreach ($posts as $post){if ($answer["post_id"] == $post["id_posts"]) {echo $post["id_posts"];};}; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"><?php foreach ($users as $user){if ($answer["author"] == $user["id_user"]) {echo $user["pseudo"];};}; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"><?php echo $answer["text"]; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"> <form method="GET" action=""><button class="bg-orange-700 text-white border-2 border-black p-2" type="submit" name="delete_response" value="<?php print $answer["id_response"] ?>">Delete</button></form></th>
                        </tr>
                       <?php } ?>
                        
                    </tbody>
                </table>
            </article>
            <article>
            <article id="navPost" class="flex flex-col justify-center items-center hidden">
                <h2 class="py-5">Posts:</h2>
                <table class="">
                    <thead>
                        <tr class="">
                            <th class="px-5 py-2 border-2 border-black bg-blue-100">Id post</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">Auteur</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">Texte</th>
                            <th class=" px-5 py-2 border-2 border-black bg-blue-100">Delete ?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($posts as $post) { ?>
                            <tr>
                            <th class=" px-5 py-2 border-2 border-black" class="bg-blue-200" scope="row"><?php echo $post["id_posts"]; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"><?php foreach ($users as $user){if ($post["author"] == $user["id_user"]) {echo $user["pseudo"];};}; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"><?php echo $post["text"]; ?></th>
                            <th class=" px-5 py-2 border-2 border-black"> <form method="GET" action=""><button class="bg-orange-700 text-white border-2 border-black p-2" type="submit" name="delete_post" value="<?php print $post["id_posts"] ?>">Delete</button></form></th>
                        </tr>
                       <?php } ?>
                        
                    </tbody>
                </table>
            </article>
        </section>
        <section class="flex flex-row gap-5 justify-center">
        <article class="flex flex-col justify-center items-center py-5 w-[45%]">
                <h3 class="mb-5">Nouvelle catégorie:</h3>
                <form action="" method="post" class="flex flex-col justify-between">
                    <div class="flex flex-col just ify-center items-center">
                        <label for="post">Nom de la catégorie:</label>
                        <textarea class="border-2 border-black"  name="cat" rows="5" cols="70"></textarea>
                    </div>
                    <button class="border-2 border-black bg-gray-300" type="submit" name="envoi_cat">Envoyer</button>
                </form>
            </article>
            <article class="flex flex-col justify-center items-center py-5 w-[45%]">
                <h3 class="mb-5">Nouvelle sous-catégorie:</h3>
                <form action="" method="post" class="flex flex-col justify-between">
                    <div class="flex flex-col justify-center items-center">
                        <label for="post">Nom de la sous-catégorie:</label>
                        <textarea class="border-2 border-black"  name="sous_cat" rows="5" cols="70"></textarea>
                    </div>
                    <select name="categorie">
                        <?php foreach($categorie as $categories) { ?>
                            <option><?php echo $categories["nom"] ?></option>
                      <?php  } ?>
                    </select>
                    <button class="border-2 border-black bg-gray-300" type="submit" name="envoi_sous_cat">Envoyer</button>
                </form>
            </article>
            </section>
        <script src="JS/admin.js"></script>
    </main>
    <footer class="flex flex-row justify-between items-center border-t-2 border-b-2 px-5 mt-10">
        <?php include ("content/footer.html"); ?>
    </footer>
</body>
</html>