<h2>Détail de la commande No<?php echo $var2->id;?> </h2>
<h3>Liste des produits</h3>
<?php
    foreach ($var1 as $unProduit) {
        $nomProduit = $unProduit['name'];
        $quantity = $unProduit['quantity'];
        echo "$nomProduit : $quantity <br/><br/>";
    } ?>
<h3>Adresse de livraison : </h3>
<?php
    echo "Nom : $var3->firstname<br/>";
    echo "Prénom : $var3->lastname<br/>";
    echo "Ligne 1 : $var3->add1<br/>";
    echo "Ligne 2 : $var3->add2<br/>";
    echo "Ligne 3 : $var3->city<br/>";
    echo "Code postal : $var3->postcode<br/>";
    echo "Téléphone : $var3->phone<br/>";
    echo "Email : $var3->email<br/>";
    ?>
<br/>
<a href="?action=validerEnvoi&idOrder=<?php echo $var2->id; ?>"><button class="btn-primary">Valider l'envoi</button></a>
