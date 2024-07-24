<section class="flex max-lg:flex-col items-center gap-5 pl-10">
  <article class="max-md:hidden"><img class="h-20 w-20" src="ressources/Logo_forum.png" /></article>
  <article>
    <h2>Blogature</h2>
  </article>
  <article>
  <?php echo date('d/m/Y h:i:s') ?>
  </article>
  <?php if (isset($_SESSION["user"])) { ?>
    <article class="max-md:hidden">
      <p>Il est trop fort, c'est <?php echo $_SESSION["user"]["pseudo"] ?> bien sûr! </p>
    </article>
  <?php } ?>
  <?php if (isset($_SESSION["user"])) { ?>
  <?php if (!isset($_SESSION["user"]["avatar"])) { ?>
    <img class="h-12 w-18" src="ressources/GiantST.webp" alt="placeholder image profil">
  <?php } else { ?>
    <img class="h-12 w-18" src="<?php echo $_SESSION["user"]["avatar"] ?>">
  <?php } ?>
  <?php } ?>
</section>
<section class="flex pr-10">
  <ul class="flex flex-col lg:flex-row lg:gap-5">
    <?php if(isset($_SESSION["user"]["admin"]) == 1) { ?>
      <li><a class="hover:text-violet-500" href="admin.php">Le grand et puissant ADMIN !</a></li>
    <?php } else {
      print "Nous, on aime les cookies!";
    } ?>
    <li><a class="hover:text-violet-500" href="index.php">Accueil</a></li>
    <li><a class="hover:text-violet-500" href="profil.php">Profil</a></li>
    <li><a class="hover:text-violet-500" href="deconnexion.php">Déconnexion</a></li>
    <li><a class="hover:text-violet-500" href="contact.php">Contact</a></li>
  </ul>
</section>