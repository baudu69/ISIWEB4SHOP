<h2>Récapitulatif</h2>
<table>
    <?php
    $total=0;
    foreach ($var1 as $unProduit) {?>
        <tr>
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
<?php
if ($var4 != null) {
    echo '<select onchange="changeAddresseValue(this)">';
    echo '<option value="-1">Choisir une ancienne adresse</option>';

    for($i=0; $i < count($var4); $i++) {
        $numAdresse = $var4[$i]['add1'];
        echo "<option value='$i'>$numAdresse</option>";
    }
    echo '</select>';
}
?>
<form method="post" action="?action=validerOrder">
    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre prénom" required value="<?php if (!empty($var3)) echo $var3->forname ?>"/>
    </div>
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom" required value="<?php if (!empty($var3)) echo $var3->surname ?>"/>
    </div>
    <div class="form-group">
        <label for="addr1">Adresse ligne 1</label>
        <input type="text" id="addr1" name="addr1" class="form-control" placeholder="ligne 1" required value="<?php if (!empty($var3)) echo $var3->add1 ?>"/>
    </div>
    <div class="form-group">
        <label for="addr2">Adresse ligne 2</label>
        <input type="text" id="addr2" name="addr2" class="form-control" placeholder="ligne 2" required value="<?php if (!empty($var3)) echo $var3->add2 ?>"/>
    </div>
    <div class="form-group">
        <label for="addr3">Adresse ligne 3</label>
        <input type="text" id="addr3" name="addr3" class="form-control" placeholder="ligne 3" required value="<?php if (!empty($var3)) echo $var3->add3 ?>"/>
    </div>
    <div class="form-group">
        <label for="cp">Code postal</label>
        <input type="number" id="cp" name="cp" class="form-control" placeholder="69000" required value="<?php if (!empty($var3)) echo $var3->postcode ?>"/>
    </div>
    <div class="form-group">
        <label for="tel">Numéro de téléphone</label>
        <input type="tel" id="tel" name="tel" class="form-control" placeholder="0701020304" required value="<?php if (!empty($var3)) echo $var3->phone ?>"/>
    </div>
    <div class="form-group">
        <label for="mail">Email</label>
        <input type="email" id="mail" name="mail" class="form-control" placeholder="abc@example.com" required value="<?php if (!empty($var3)) echo $var3->email ?>"/>
    </div>
    <div class="form-group">
        <label for="paiment">Moyen de paiment</label>
        <select multiple class="form-control form-control-sm" required id="paiment" name="paiment">
            <option value="paypal">Paypal</option>
            <option value="cheque">Chèque</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Valider les informations</button>
</form>

<script>
    let prenom = [];
    let nom = [];
    let addr1 = [];
    let addr2 = [];
    let addr3 = [];
    let cp = [];
    let tel = [];
    let mail = [];
    <?php
        foreach ($var4 as $uneAdresse) {
            $unPrenom = $uneAdresse['firstname'];
            $unNom = $uneAdresse['lastname'];
            $addr1 = $uneAdresse['add1'];
            $addr2 = $uneAdresse['add2'];
            $addr3 = $uneAdresse['city'];
            $cp = $uneAdresse['postcode'];
            $tel = $uneAdresse['phone'];
            $mail = $uneAdresse['email'];
            echo "prenom.push('$unPrenom');";
            echo "nom.push('$unNom');";
            echo "addr1.push('$addr1');";
            echo "addr2.push('$addr2');";
            echo "addr3.push('$addr3');";
            echo "cp.push('$cp');";
            echo "tel.push('$tel');";
            echo "mail.push('$mail');";
        }
    ?>
    function changeAddresseValue(select) {
        let idAddrSelected = select.value;
        if (idAddrSelected !== '-1') {
            console.log(idAddrSelected)
            document.getElementById('prenom').value=prenom[idAddrSelected];
            document.getElementById('nom').value=nom[idAddrSelected];
            document.getElementById('addr1').value=addr1[idAddrSelected];
            document.getElementById('addr2').value=addr2[idAddrSelected];
            document.getElementById('addr3').value=addr3[idAddrSelected];
            document.getElementById('cp').value=cp[idAddrSelected];
            document.getElementById('tel').value=tel[idAddrSelected];
            document.getElementById('mail').value=mail[idAddrSelected];
        }
    }
</script>
