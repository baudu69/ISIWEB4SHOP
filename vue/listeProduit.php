<h2>Liste des <?php echo $message; ?></h2>
<table>
<?php foreach ($var1 as $unProduit) {?>
    <tr>
        <td class="imgGauche">
            <?php $imgProd=$unProduit['image']; echo "<img alt='' src='productimages/$imgProd' />" ?>
        </td>
        <td class="descrDroite">
            <?php
            $idProduit=$unProduit['id'];
            $nomProduit = $unProduit['name'];
            $description=$unProduit['description'];
            $prix=$unProduit['price'];
            echo "<h3>$nomProduit</h3><br/>";
            echo "<p>$description</p>";
            echo "<b>Notre prix : $prix €";
            echo "<br /><br /><a class='linkNoStyle' href='?action=ajouterPanier&idProduit=$idProduit'>[acheter]</a>";
            ?>
        </td>
    </tr>
<?php } ?>
</table>
