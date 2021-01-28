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
    <a class="linkNoStyle" href="?action=accueil">Accueil</a>
    -
    <a class="linkNoStyle" href="?action=panier">Panier</a>
    <?php
    if (isset($_SESSION['idAdmin'])) {
        echo '-';
        echo '<a class="linkNoStyle" href="?action=commande">Commandes</a>';
    }

    ?>
</div>
<div class="sidebar">
    <span class="titreSide"> Notre Offre </span>
    <div class="listeCat">
        <ul>
            <li><a class='linkNoStyle' href='?action=produits&codeCat=1'>Boissons</a></li>
            <li><a class='linkNoStyle' href='?action=produits&codeCat=2'>Biscuits</a></li>
            <li><a class='linkNoStyle' href='?action=produits&codeCat=3'>Fruits sec</a></li>
        </ul>
    </div>
    <hr />
    <?php if (isset($_SESSION['username']) || isset($_SESSION['idAdmin'])) {
        $username=$_SESSION['username'];
        echo "Bonjour <b>$username</b> [<a class='linkNoStyle' href='?action=deconnexion'>Logout</a>]";
    } else {
        echo "<a class='linkNoStyle' href='?action=connexion'>Connexion</a> - <a class='linkNoStyle' href='?action=inscription'>Inscription</a>";
    }
    ?>
</div>
<div class="contenu">
    <?php require ('vue/'.$page)?>
</div>
</body>
</html>