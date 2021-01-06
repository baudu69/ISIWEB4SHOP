<?php
require('Controller/controller.php');

if (isset($_GET['action'])) $url=$_GET['action'];
if (!isset($url))
    getAccueil();
else {
    switch ($url) {
        case 'accueil':
            getAccueil();
            break;

    }
}