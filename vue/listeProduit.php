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
            echo "<br /><br /><a class='linkNoStyle' id='btn_$idProduit' href='?action=ajouterPanier&idProduit=$idProduit&quantity=1'>[acheter]</a>";
            ?>
            <label>Quantité</label>
            <input type="number" min="1" width="10px" id="<?php echo $idProduit; ?>" name="quantity" value="1" onchange="changerQuantity(this)" />
        </td>
    </tr>
<?php } ?>
</table>
<script>
    function changerQuantity(input) {
        let idProduitChange = input.id;
        let btnAModifier = document.getElementById('btn_'+idProduitChange);
        btnAModifier.href = '?action=ajouterPanier&idProduit='+idProduitChange+'&quantity='+input.value;
    }
</script>