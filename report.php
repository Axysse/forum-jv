<?php
require_once ("config/config.php");
session_start();
$bdd = new Bdd();
$bdd->connect();

if ($_SESSION["user"]["admin"] != 1) {
    header("location: index.php");
}

$users = $bdd->getAllUsers();
$categorie = $bdd->getAllCategorie();
$sousCategorie = $bdd->getAllSousCategorie();
$posts = $bdd->getAllPosts();
$answers = $bdd->gatAllAnswer();
$reports = $bdd->getAllReport();

if (isset($_POST["unban"])) {
    foreach ($reports as $report) {
        if ($_POST["unban"] == $report["id_signal"]) {
            $bdd->deleteReport($report["id_signal"]);
            header("Location: report.php");
        }
    }
}

if (isset($_POST["delete"])) {
    foreach ($reports as $report) {
        if ($_POST["delete"] == $report["id_signal"]) {
            foreach ($answers as $answer) {
                if ($report["signal_response_id"] == $answer["id_response"]) {
                    $bdd->deleteResponse($answer["id_response"]);
                    header("Location: report.php");
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signalements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <header class="flex flex-row justify-between items-center border-b-2 shadow-lg">
        <?php include ("content/navbar.php"); ?>
    </header>

    <main class="px-5">
        <?php
        foreach ($reports as $report) { ?>
            <section class="mt-10 mb-5 flex flex-row border-4 p-5 bg-blue-300 rounded-lg">
                <article class="flex flex-col gap-5 items-center pr-16 border-r-2">
                    <?php foreach ($users as $user) {
                        if ($report["author"] == $user["id_user"]) { ?>
                            <img class="h-24 w-32" src="<?php echo $user["avatar"] ?>">
                            <p><?php echo $user["pseudo"] ?></p>
                        <?php }
                    } ?>
                </article>
                <article class="flex flex-col justify-center items-center gap-5 pl-5 w-full">
                    <div>
                        <p><?php echo $report['text'] ?> </p>
                    </div>
                    <div class="flex flex-col justify-center items-center text-red-600">
                        <p> id réponse = <?php echo $report["signal_response_id"] ?></p>
                        <p> Réponse à " <?php foreach ($posts as $post) {
                            if ($report["signal_post_id"] == $post["id_posts"]) {
                                echo $post["titre"];
                            }
                        } ?>"</p>
                    </div>
                </article>
                <article class="flex flex-col justify-between">
                    <form action="correction.php" method="get">
                        <button class="border-2 border-black bg-orange-500 h-fit text-white" type="submit" name="unban"
                            value=<?php echo $report['id_signal'] ?>>UNBAN</button>
                    </form>
                    <form action="" method="post">
                        <button class="border-2 border-black bg-orange-500 h-fit text-white" name="delete"
                            value="<?php echo $report['id_signal'] ?>">DELETE</button>
                    </form>
                </article>
            </section>
        <?php } ?>

    </main>
    <footer class="flex flex-row justify-between items-center border-t-2 border-b-2 px-5 mt-10">
        <?php include ("content/footer.html"); ?>
    </footer>
</body>

</html>