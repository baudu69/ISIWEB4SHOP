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

    function addUser($username, $password) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "INSERT INTO logins(username, password) VALUE (?, ?)";
            $sth = $conn->prepare($sql);
            $sth->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }
}