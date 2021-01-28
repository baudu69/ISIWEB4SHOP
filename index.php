<?php
require('Controller/controller.php');
session_start();
if (isset($_GET['action'])) $url=$_GET['action'];
if (!isset($url))
    getAccueil();
else {
    switch ($url) {
        case 'accueil':
            getAccueil();
            break;
        case 'connexion':
            getPageConnexion();
            break;
        case 'postConnection':
            connexion();
            break;
        case 'deconnexion':
            deconnexion();
            break;
        case 'inscription':
            getPageInscription();
            break;
        case 'postInscription':
            inscription();
            break;
        case 'produits':
            affichProduits();
            break;
        case 'ajouterPanier':
            ajouterObjetPanier();
            break;
        case 'panier':
            affichPanier();
            break;
        case 'supprimerPanier':
            supprimerPanier();
            break;
        case 'validerPanier':
            formValiderPanier();
            break;
        case 'validerOrder':
            validerOrder();
            break;
        case 'commande':
            afficherListeCommandes();
            break;
        case 'detailsCommande':
            afficherDetailCommande();
            break;
        case 'validerEnvoi':
            validerEnvoi();
            break;


        default:
            getAccueil();
            break;
    }
}