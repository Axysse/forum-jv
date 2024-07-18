<?php
session_start();
require_once ("config/config.php");
$bdd = new Bdd();
$bdd->connect();

// echo "<pre>";
// var_dump($_SESSION["user"]);
// echo "</pre>";

$pseudo = $_SESSION["user"]["pseudo"];
$mail = $_SESSION["user"]["mail"];

if (isset($_POST["upload"])) {
    $avatar = $_FILES["image"];
    $bdd->insert($avatar);
    if (isset($avatar)) {
        move_uploaded_file($avatar["tmp_name"], "ressources/uploads/" . $avatar["name"]);
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="flex flex-row justify-between items-center border-b-2 shadow-lg">
        <?php include ("content/navbar.php"); ?>
    </header>
    <main class="px-5">
        <?php if (!isset($_SESSION["user"])) {
            echo "Qu'est-ce que tu fous là toi?";
        } else { ?>
            <section class="flex flex-col justify-center items-center gap-5 py-5 border-b-2 shadow-md">
                <article>
                    <?php if (!isset($_SESSION["user"]["avatar"])) { ?>
                        <img class="h-18 w-28" src="ressources/GiantST.webp" alt="placeholder image profil">
                    <?php } else { ?>
                        <img class="h-18 w-28" src="<?php echo $_SESSION["user"]["avatar"] ?>">
                    <?php } ?>
                </article>
                <article class="flex flex-col justify-center items-center">
                    <h2 class="pb-2">Voici le TERRIBLE : <?php echo $pseudo ?></h2>
                    <form class=" flex flex-col justify-center items-center" action="" method="post"
                        enctype="multipart/form-data">
                        <label for="image">Nouvelle image de profil?</label><br>
                        <input type="file" name="image" id="image"><br>
                        <button class="border-solid-2 border-black bg-gray-400" type="submit" name="upload">Envoyer</button>
                    </form>
                </article>
            </section>
            <section class="flex flex-row pt-5 gap-5">
                <article
                    class="w-[35%] flex flex-col justify-center items-center items-align border-2 shadow-md rounded-md pb-5">
                    <h3 class="pb-5">Informations personnelles:</h3>
                    <ul>
                        <li class="px-2 border-t-2 border-b-2">Pseudo: <?php echo $pseudo ?></li>
                        <li class="px-2 border-b-2">E-mail: <?php echo $mail ?></li>
                    </ul>
                </article>
                <article class="flex flex-col justify-center items-center border-2 shadow-md rounded-md">
                    <h3>Description personelle:</h3>
                    <p>DESCRIPTION PERSO (TRES) BIEN ECRITE AVEC UNE BACKSTORY DE FOU ET TRES TRES LONGUE SA MERE QUI PREND
                        BEAUCOUP DE PLACE GENRE TOUTE LA PLACE SI POSSIBLE CE SERAIT NICKEL MERCI! Bien à vous.</p>
                </article>
            </section>
        <?php } ?>
    </main>
    <footer class="flex flex-row justify-between items-center border-t-2 border-b-2 px-5 mt-10">
        <?php include ("content/footer.html"); ?>
    </footer>
</body>

</html>