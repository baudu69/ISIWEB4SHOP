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

    }
}