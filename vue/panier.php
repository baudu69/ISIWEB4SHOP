<h2>Panier</h2>
<table>
    <?php
    $total=0;
    foreach ($var1 as $unProduit) {?>
        <tr>
            <td class="imgGauche">
                <?php $imgProd=$unProduit['image']; echo "<img alt='' src='productimages/$imgProd' />" ?>
            </td>
            <td class="descrDroite">
                <?php
                $idOrderProduit=$unProduit['id'];
                $nomProduit = $unProduit['name'];
                $description=$unProduit['description'];
                $prix=$unProduit['price'];
                $quantite=$unProduit['quantity'];
                echo "<b>$nomProduit</b><br/>";
                echo "Prix : $prix €<br/>";
                echo "Quantité : $quantite";
                echo "<br /><br /><a class='linkNoStyle' href='?action=supprimerPanier&idProduit=$idOrderProduit'>[Supprimer]</a>";
                $total+=$prix*$quantite;
                ?>
            </td>
        </tr>
    <?php } ?>
</table>
<h3>Le total est de : <?php echo "$total €" ?></h3>
<a href="?action=validerPanier"><button class="btn-3" <?php if ($total == 0) echo "disabled"; ?>>Valider le panier</button></a>
