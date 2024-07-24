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

// var_dump($id);

$arianne = $bdd->filArianne();

if (isset($_POST["envoi_reponse"])) {
    $author = $_SESSION["user"]["id_user"];
    $text = $_POST["post"];
    $date = $time;
    $post_id = $id;

    $newRep = new Answer;
    $newRep->setAuthor($author);
    $newRep->setText($text);
    $newRep->setDate($date);
    $newRep->setPostId($post_id);

    $bdd->addRep($newRep);
    header("Refresh:0");
}

if(isset($_POST["report"])) {
    foreach($answers as $answer) {
        if($_POST["report"] == $answer["id_response"]) {
            $author = $answer["author"];
            $text = $answer["text"];
            $signal_post_id = $answer["post_id"];
            $signal_response_id = $_POST["report"];
            $report_status= 0;

            $newReport = new Report;
            $newReport->setAuthor($author);
            $newReport->setText($text);
            $newReport->setSignalPostId($signal_post_id);
            $newReport->setSignalResponseId($signal_response_id);
            $newReport->setReportStatus($report_status);

            $bdd->addReport($newReport);
            header("Refresh:0");
        }
    }
}

if(isset($_POST["like"])) {
    foreach($posts as $post) {
        if ($_POST["like"] == $post["id_posts"]) {
            $bdd->addLike($post["id_posts"]);
            header("Location: index.php");
        }
    }
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
        <section class="border-b-2 w-fit">
            <?php foreach ($arianne as $ariannes) {
                if ($ariannes["id_posts"] == $id) { ?>
                    <a href="index.php"><?php print $ariannes["nom"]; ?> / <?php print $ariannes["name"]; ?> / <?php print $ariannes["titre"]; ?>
                    </a>
                <?php }
            }
            ?>
        </section>
        <section>
            <?php foreach ($posts as $post) {
                if ($post["id_posts"] == $id) { ?>
                    <section class="mt-10 mb-5 flex flex-row border-4 p-5 bg-blue-300 rounded-lg">
                        <article class="flex flex-col gap-5 items-center pr-16 border-r-2 w-[25%]">
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
                        <article class="flex flex-col justify-between">
                                    <form action="reponse.php" method="get">
                                        <button class="border-2 border-black bg-orange-500 h-fit text-white" type="submit"
                                            name="response" value=<?php echo $post['id_posts'] ?>>Répondre</button>
                                    </form>
                                    <div class="flex flex-row gap-2">
                                    <form action="" method="post">
                                        <button class="h-fit" type="submit"
                                            name="like" value=<?php echo $post['id_posts'] ?>><svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8l0-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5l0 3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20-.1-.1s0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5l0 3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2l0-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/></svg></button>
                                    </form>
                                    <p><?php echo $post['like'] ?></p>
                                    </div>
                                </article>
                    <?php } ?>
                </section>
                <?php
            }
            ?>

            <section>
                <?php foreach ($answers as $answer) {
                    if ($answer["post_id"] == $id) { ?>
                        <section class=" flex flex-row border-4 p-5 rounded-lg mb-2 ">
                            <article class="flex flex-col gap-5 items-center pr-16 border-r-2 w-[25%]">
                                <?php foreach ($users as $user) {
                                    if ($answer["author"] == $user["id_user"]) { ?>
                                        <img class="h-24 w-32" src="<?php echo $user["avatar"] ?>">
                                        <p class="flex"><?php echo $user["pseudo"] ?></p>
                                    <?php }
                                } ?>
                            </article>
                            <p> <?php echo $answer["date"] ?></p>
                            <article class="flex flex-col justify-center items-center gap-5 pl-5 w-full">
                                <div>
                                    <p><?php echo $answer['text'] ?> </p>
                                </div>
                            </article>
                            <?php if ($_SESSION["user"]["id_user"] == $answer["author"]) { ?>
                                <div class="flex flex-col justify-between">
                                    <form action="correction.php" method="get">
                                        <button class="border-2 border-black bg-orange-500 h-fit text-white" type="submit"
                                            name="correction" value=<?php echo $answer['id_response'] ?>>Modifier</button>
                                    </form>
                                    <?php } ?>
                                    <form action="" method="post">
                                        <button class="border-2 border-black bg-orange-500 h-fit text-white" name="report" value="<?php echo $answer['id_response'] ?>">REPORT</button>
                                    </form>
                                </div>
                  <?php  } ?>
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