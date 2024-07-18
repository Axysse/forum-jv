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

$id = $_GET['response'];

var_dump($id);

// var_dump($_GET);

if(isset($_POST["envoi_reponse"])) {
    $author = $_SESSION["user"]["id_user"];
    $text = $_POST["post"];
    $date = $time;
    $post_id = $id;

    $newRep= new Answer;
    $newRep->setAuthor($author);
    $newRep->setText($text);
    $newRep->setDate($date);
    $newRep->setPostId($post_id);

    $bdd->addRep($newRep);
    header("Refresh:0");

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reponse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="flex flex-row justify-between items-center border-b-2 shadow-lg">
        <?php include ("content/navbar.php"); ?>
    </header>

    <main class="px-5 pt-10">
        <section>
            <?php foreach ($posts as $post) {
                if ($post["id_posts"] == $id) { ?>
                    <section class="mt-10 flex flex-row border-4 p-5 ">
                        <article class="flex flex-col gap-5 items-center pr-16 border-r-2">
                            <?php foreach ($users as $user) {
                                if ($post["author"] == $user["id_user"]) { ?>
                                    <img class="h-24 w-32" src="<?php echo $user["avatar"] ?>">
                                    <p><?php echo $user["pseudo"] ?></p>
                                <?php }
                            } ?>
                        </article>
                        <p> <?php echo $post["date"] ?></p>
                        <article class="flex flex-col justify-center items-center gap-5 pl-5 w-full">
                            <div class="border-b-2 pb-2">
                                <p><?php echo $post['titre'] ?> </p>
                            </div>
                            <div>
                                <p><?php echo $post['text'] ?> </p>
                            </div>
                        </article>
                    <?php } ?>
                </section>
                <?php
            }
            ?>

            <section>
                <?php foreach($answers as $answer) {
                    if($answer["post_id"] == $id) { ?>
                        <section class="mt-10 flex flex-row border-4 p-5 ">
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
                        <?php } ?>
                    </section>
                    <?php
                }
            ?>
            </section>
        </section>
        <?php if (isset($_SESSION["user"]) && (isset($id))) { ?>
            <section class="flex flex-col justify-center items-center py-5">
                <h3>Répond gentiment:</h3>
                <form action="" method="post" class="flex flex-col justify-between">
                    <label for="post">Ecris ta réponse (positivité uniquement):</label>
                    <textarea class="border-2 border-black" id="post" name="post" rows="5" cols="90"></textarea>
                    </div>
                    <button class="border-2 border-black bg-gray-300" type="submit" name="envoi_reponse">Envoyer</button>
                </form>
            </section>
        <?php } ?>
    </main>
    <footer class="flex flex-row justify-between items-center border-t-2 border-b-2 px-5 mt-10">
        <?php include ("content/footer.html"); ?>
    </footer>
</body>

</html>