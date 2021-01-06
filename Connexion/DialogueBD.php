<?php
require_once "Connexion.php";

class DialogueBD
{
    function getUserByUsername($username) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM logins WHERE username=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($username));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();

        }
    }
}