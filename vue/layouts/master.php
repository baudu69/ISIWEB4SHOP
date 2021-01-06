<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ISIWEB4SHOP</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/site.css" />
</head>
<body>
<div class="titre">
    ISIWEB4SHOP
</div>
<div class="laNavbar">
    <a class="linkNoStyle" href="">Accueil</a>
    -
    <a class="linkNoStyle" href="">Panier</a>
</div>
<div class="sidebar">
    <span class="titreSide"> Notre Offre </span>
    <div class="listeCat">
        <ul>
            <li>Boissons</li>
            <li>Biscuits</li>
            <li>Fruits sec</li>
        </ul>
    </div>
    <hr />
    <?php if (isset($_SESSION['username'])) {
        $username=$_SESSION['username'];
        echo "Bonjour <b>$username</b> [<a class='linkNoStyle' href='#'>Logout</a>]";
    } else {
        echo "<a class='linkNoStyle' href='#'>Connexion</a>";
    }
    ?>
</div>
<div class="contenu">
    <?php require ('vue/'.$page)?>
</div>
</body>
</html>