<?php
require_once ("config/config.php");
session_start();
$bdd = new Bdd();
$bdd->connect();

$time = date('d/m/Y h:i:s');

$users = $bdd->getAllUsers();
$categorie = $bdd->getAllCategorie();
$sousCategorie = $bdd->getAllSousCategorie();
$posts = $bdd->getAllPosts();
$answers = $bdd->gatAllAnswer();

$id = $_GET['correction'];

var_dump($_POST["post"]);

if(isset($_POST["envoi_correction"])) {
    $newText = $_POST["post"];
};

var_dump($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correction</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<header class="flex flex-row justify-between items-center border-b-2 shadow-lg">
        <?php include ("content/navbar.php"); ?>
    </header>
<main class="px-5 pt-10">
        <?php foreach($answers as $answer) {
            if($answer["id_response"] == $id) { ?>
            <section class=" flex flex-row border-4 p-5 rounded-lg mb-2 mt-5 ">
                            <article class="flex flex-col gap-5 items-center pr-16 border-r-2">
                            <?php foreach ($users as $user) {
                                    if ($answer["author"] == $user["id_user"]) { ?>
                                        <img class="h-24 w-32" src="<?php echo $user["avatar"] ?>">
                                        <p><?php echo $user["pseudo"] ?></p>
                                    <?php }
                                } ?>
                            </article>
                            <p> <?php echo $answer["date"] ?></p>
                            <article class="flex flex-col justify-center items-center gap-5 pl-5 w-full">
                                <div>
                                    <p><?php echo $answer['text'] ?> </p>
                                </div>
                            </article>
                    </section>
            <?php };
            }; ?>
            <section class="flex flex-col justify-center items-center mt-10">
                <article class="mb-5">
                    <h2>Maintenant, excuse-toi! (vilain!)</h2>
                </article>
                <article>
                <form action="" method="post" class="flex flex-col justify-between">
                    <label for="post">Ecris ton mea-culpa (positivité uniquement):</label>
                    <textarea class="border-2 border-black" id="post" name="post" rows="5" cols="90"></textarea>
                    </div>
                    <button class="border-2 border-black bg-gray-300" type="submit" name="envoi_correction" value="post">Envoyer</button>
                </form>
                </article>
            </section>
        
</main>
<footer class="flex flex-row justify-between items-center border-t-2 border-b-2 px-5 mt-10">
        <?php include ("content/footer.html"); ?>
    </footer>

    
</body>
</html>