<?php
require ('Connexion/DialogueBD.php');


    function getAccueil() {
        render('accueil.php');
    }

    function getPageConnexion() {
        render('connexion.php');
    }

    function render($page, $message=null, $var1=null, $var2=null, $var3=null, $var4=null) {
        require ('vue/layouts/master.php');
    }

    function connexion() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username=$_POST['username'];
            $password=$_POST['password'];
            $dbx = new DialogueBD();
            $unAdmin = $dbx->getUnAdmin($username);
            if ($unAdmin != false) {
                if (password_verify($password, $unAdmin->password)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['idAdmin'] = $unAdmin->id;
                    return render('accueil.php');

                }
            }
            $unUserDB=$dbx->getUserByUsername($username);
            if (!empty($unUserDB)) {
                if (password_verify($password, $unUserDB->password)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $unUserDB->id;
                    fusionnerPanierSiPossible($unUserDB->id);
                    render('accueil.php');
                } else {
                    render('connexion.php', 'Mot de passe incorrect');
                }
            } else {
                render('connexion.php', 'Utilisateur incorrect');
            }
        }
    }

    function fusionnerPanierSiPossible($idCustomer) {
        try {
            $dbx = new DialogueBD();
            $session = session_id();
            $panierSession = $dbx->getLastOrderFromSession($session);
            //Si il y a un panier session
            if ($panierSession != false) {
                $panierID = $dbx->getLastOrderFromID($idCustomer);
                //Si il n'y a pas de panier utilisateur alors on convertit le panier session en utilisateur
                if ($panierID == false) {
                    $dbx->addCustomerIdToOrder($idCustomer, $session);
                //Si il y a un panier utilisateur
                } else {
                    $lesProduitsSession = $dbx->getProduitFromSessionOrder($session);
                    //Pour chaque produit du panier session
                    foreach ($lesProduitsSession as $unProduit) {
                        $panierIdId = $panierID->id;
                        $produitId = $unProduit['product_id'];
                        $quantiteUnProdID = $dbx->getItemQuantityInOrderItem($panierIdId, $produitId);
                        //Si le produit n'existe pas dans le panier utilisateur alors on l'ajoute dedans
                        if ($quantiteUnProdID == false) {
                            $dbx->addOrderItems($panierIdId, $produitId, $unProduit['quantity']);
                        //Sinon, il existe et on met a jour dans le panier utilisateur
                        } else {
                            $quantiteFinale = $quantiteUnProdID->quantity+$unProduit['quantity'];
                            $dbx->updateOrderProduitQuantity($panierIdId, $produitId, $quantiteFinale);
                        }
                    }
                    $dbx->supprimerPanierSession($session);
                }
            }
        } catch (Exception $exception) {
            render('inscription.php', $exception->getMessage());
        }

    }

    function deconnexion() {
        session_destroy();
        $_SESSION = array();
        render('accueil.php');
    }

    function getPageInscription() {
        render('inscription.php');
    }

    function inscription() {
        $username=$_POST['username'];
        $password=$_POST['password'];
        try {
            $dbx = new DialogueBD();
            $dbx->addUser($username, $password);
            render('connexion.php', 'Inscription effectué');
        } catch (Exception $exception) {
            render('inscription.php', $exception->getMessage());
        }
    }

    function affichProduits() {
        try {
            $codeCat = $_GET['codeCat'];
            $dbx = new DialogueBD();
            $uneCategorie=$dbx->getUneCat($codeCat);
            $lesProduits = $dbx->getProduitByCodeCat($codeCat);
            render('listeProduit.php', $uneCategorie->name, $lesProduits);
        } catch (Exception $exception) {
            render('error.php', $exception->getMessage());
        }
    }

    function getOrder($customer_id=null) {
        $dbx = new DialogueBD();
        //Si pas connecté
        if ($customer_id==null) {
            $unOrder = $dbx->getLastOrderFromSession(session_id());
        } else {
            $unOrder = $dbx->getLastOrderFromID($customer_id);
        }

        //Si il n'y a pas de panier déjà ouvert
        if (empty($unOrder)) {
            $dbx->createOrder(session_id(), $customer_id);
            if ($customer_id==null) {
                $unOrder = $dbx->getLastOrderFromSession(session_id());
            } else {
                $unOrder = $dbx->getLastOrderFromID($customer_id);
            }
        }
        return $unOrder;
    }

    function ajouterObjetPanier() {
        try {
            //Si connecté
            if (isset($_SESSION['id'])) {
                $unOrder = getOrder($_SESSION['id']);
            } else {
                $unOrder = getOrder();
            }
            $idProduit=$_GET['idProduit'];
            $quantity = $_GET['quantity'];

            //On insère ensuite dans orderitem
            $dbx = new DialogueBD();
            //On vérifie que si le produit existe déjà
            if ($dbx->isProduitExist($unOrder->id, $idProduit)) {
                $quantiteInitiale = $dbx->getQuantityproductorder($unOrder->id, $idProduit);
                $dbx->updateOrderProduitQuantity($unOrder->id, $idProduit, $quantiteInitiale + $quantity);
            } else {
                $dbx->addOrderItems($unOrder->id, $idProduit, $quantity);
            }
            affichPanier();
        }
        catch (Exception $e) {
            render('error.php', $e->getMessage());
        }

    }

    function affichPanier() {
        try {
            if (isset($_SESSION['id'])) {
                $unOrder = getOrder($_SESSION['id']);
            } else {
                $unOrder = getOrder();
            }
            $dbx = new DialogueBD();
            $lesArticles = $dbx->getItemByOrderId($unOrder->id);
            render('panier.php', null, $lesArticles);
        }
        catch (Exception $e) {
            render('error.php', $e->getMessage());
        }
    }

    function supprimerPanier() {
        try {
            $idOrderItem = $_GET['idProduit'];
            $dbx = new DialogueBD();
            $dbx->delOrderItemRow($idOrderItem);
            affichPanier();
        }catch (Exception $e) {
            render('error.php', $e->getMessage());
        }
    }

    function formValiderPanier() {
        try {
            if (!isset($_SESSION['id'])) {
                getPageConnexion();
            } else {
                $dbx = new DialogueBD();
                $userInfo = $dbx->getUserById($_SESSION['id']);
                $customerInfo = $dbx->getCustomerInfo($userInfo->customer_id);
                $unOrder = getOrder($_SESSION['id']);
                $lesArticles = $dbx->getItemByOrderId($unOrder->id);
                $lesAdresses = $dbx->getLesAdresses($userInfo->customer_id);
                render('validPanier.php', null, $lesArticles, $userInfo, $customerInfo, $lesAdresses);
            }
        }
        catch (Exception $e) {
            render('error.php', $e->getMessage());
        }
    }

    function validerOrder()
    {
        try {
            $idCust = $_SESSION['id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $addr1 = $_POST['addr1'];
            $addr2 = $_POST['addr2'];
            $addr3 = $_POST['addr3'];
            $cp = $_POST['cp'];
            $tel = $_POST['tel'];
            $mail = $_POST['mail'];
            $paiment = $_POST['paiment'];
            $dbx = new DialogueBD();
            $custInfo = $dbx->getCustomerInfo($idCust);
            $dbx->ajouterAdresse($prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail);
            $adresse = $dbx->getLastAdresse();
            if ($custInfo != false) {
                $dbx->updateCustomer($idCust, $prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail);
            } else {
                $dbx->createCustomer($idCust, $prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail);
            }
            $dbx->updateStatutAndPaimentAndAddressOrder($idCust, $adresse->id, $paiment, "5");
            render('Valider.php');
        } catch (Exception $e) {
            render('error.php', $e->getMessage());
        }
    }

    function afficherListeCommandes() {
        try {
            $dbx = new DialogueBD();
            $lesCommandes = $dbx->getLesCommandesAValider();
            render('listeCommande.php', null, $lesCommandes);
        }
        catch (Exception $e) {
            render('error.php', $e->getMessage());
        }
    }

    function afficherDetailCommande() {
        try {
            $dbx = new DialogueBD();
            $idOrder = $_GET['id'];
            $lesProduits = $dbx->getItemByOrderId($idOrder);
            $unOrder = $dbx->getOrderById($idOrder);
            $adresse = $dbx->getDeliveryAdressById($unOrder->delivery_add_id);
            render('detailsCommande.php', null, $lesProduits, $unOrder, $adresse);
        }
        catch (Exception $e) {
            render('error.php', $e->getMessage());
        }
    }

    function validerEnvoi() {
        try {
            $dbx = new DialogueBD();
            $idOrder = $_GET['idOrder'];
            $dbx->changeStatusOrder($idOrder, 10);
            afficherListeCommandes();
        }
        catch (Exception $e) {
            render('error.php', $e->getMessage());
        }
    }
