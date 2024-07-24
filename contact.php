<?php
require_once ("config/config.php");
session_start();
$bdd = new Bdd();
$bdd->connect();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<header class="flex flex-row justify-between items-center border-b-2 shadow-lg">
        <?php include ("content/navbar.php"); ?>
    </header>

    <main class="px-5 pt-10">
        <h1 class="flex flex-row justify-center">LE FORUM EST PARFAIT AINSI, MERCI DE NE PAS NOUS CONTACTER. FRANCHEMENT C'EST UN BANGER.</h1>
    </main>

    <footer class="flex flex-row justify-between items-center border-t-2 border-b-2 px-5 mt-10">
        <?php include ("content/footer.html"); ?>
    </footer>
</body>
</html>