<h2>Liste des commandes à valider</h2>
<?php
    foreach ($var1 as $uneCommande) {
        $idCommande = $uneCommande['id'];
        echo "<a href='?action=detailsCommande&id=$idCommande'> Commande No $idCommande</a><br/><br/>";
    }
?>