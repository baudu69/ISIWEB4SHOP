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
        throw new Exception($erreur);
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

    function getProduitByCodeCat($codeCat) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM products WHERE cat_id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($codeCat));
            return $sth->fetchAll();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getUneCat($codeCat) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM categories WHERE id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($codeCat));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function addOrderItems($order_id, $product_id, $quantity) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "INSERT INTO orderitems(order_id, product_id, quantity) VALUE(?, ?, ?)";
            $sth = $conn->prepare($sql);
            $sth->execute(array($order_id, $product_id, $quantity));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function isProduitExist($order_id, $product_id) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM orderitems WHERE product_id = ? AND order_id = ?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($product_id, $order_id));
            $result = $sth->fetchAll();
            return !empty($result);
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getQuantityproductorder($order_id, $product_id) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT quantity FROM orderitems WHERE product_id = ? AND order_id = ?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($product_id, $order_id));
            $result = $sth->fetchObject();
            return $result->quantity;
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function updateOrderProduitQuantity($order_id, $product_id, $quantity) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "UPDATE orderitems SET quantity=? WHERE order_id=? AND product_id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($quantity, $order_id, $product_id));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getLastOrderFromSession($session_ID) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM orders WHERE session=? AND status=0 AND customer_id IS NULL";
            $sth = $conn->prepare($sql);
            $sth->execute(array($session_ID));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getLastOrderFromID($customer_id) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM orders WHERE customer_id=? AND status=0";
            $sth = $conn->prepare($sql);
            $sth->execute(array($customer_id));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getProduitFromSessionOrder($session) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM orderitems JOIN orders o on orderitems.order_id = o.id WHERE session=? AND status=0";
            $sth = $conn->prepare($sql);
            $sth->execute(array($session));
            return $sth->fetchAll();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function addCustomerIdToOrder($customerID, $sessionID) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "UPDATE orders SET customer_id=? WHERE session=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($customerID, $sessionID));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function createOrder($session_ID, $customer_id = null) {
        try{
            $conn = Connexion::getConnexion();
            $sql = "INSERT INTO orders(customer_id, registered, date, status, session) VALUE(?, 1, now(), 0, ?)";
            $sth = $conn->prepare($sql);
            $sth->execute(array($customer_id, $session_ID));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getItemQuantityInOrderItem($idOrder, $idProducts) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT quantity from orderitems WHERE product_id=? AND order_id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($idProducts, $idOrder));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getItemByOrderId($orderId) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT OD.id, p.cat_id, p.name, p.description, p.image, p.price, OD.quantity FROM orderitems OD JOIN products p on OD.product_id = p.id WHERE order_id = ?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($orderId));
            return $sth->fetchAll();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function supprimerPanierSession($session) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "DELETE FROM orders WHERE session=? AND customer_id IS NULL";
            $sth = $conn->prepare($sql);
            $sth->execute(array($session));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function delOrderItemRow($id) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "DELETE FROM orderitems WHERE id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($id));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getCustomerInfo($idCustomer) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT *  FROM customers WHERE id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($idCustomer));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getUserById($id) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM logins WHERE id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($id));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }


    function updateCustomer($id, $prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "UPDATE customers SET forname=?, surname=?, add1=?, add2=?, add3=?, postcode=?, phone=?, email=? WHERE id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail, $id));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function createCustomer($id, $prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "INSERT INTO customers VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
            $sth = $conn->prepare($sql);
            $sth->execute(array($id, $prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function updateStatutAndPaimentAndAddressOrder($customerId, $idAdresse, $paiment, $statut) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "UPDATE orders SET status=?, delivery_add_id=?, payment_type=? WHERE customer_id=? AND status=0";
            $sth = $conn->prepare($sql);
            $sth->execute(array($statut, $idAdresse, $paiment, $customerId));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getLesAdresses($idCustomer) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM delivery_addresses d JOIN orders o ON d.id = o.delivery_add_id WHERE customer_id = $idCustomer";
            $sth = $conn->prepare($sql);
            $sth->execute(array($idCustomer));
            return $sth->fetchAll();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function ajouterAdresse($prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "INSERT INTO delivery_addresses(firstname, lastname, add1, add2, city, postcode, phone, email) VALUE (?, ?, ?, ?, ?, ?, ?, ?)";
            $sth = $conn->prepare($sql);
            $sth->execute(array($prenom, $nom, $addr1, $addr2, $addr3, $cp, $tel, $mail));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getLastAdresse() {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM delivery_addresses ORDER BY id DESC";
            $sth = $conn->prepare($sql);
            $sth->execute(array());
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getUnAdmin($username) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM admin WHERE username=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($username));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getLesCommandesAValider() {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM orders WHERE status=5";
            $sth = $conn->prepare($sql);
            $sth->execute(array());
            return $sth->fetchAll();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getOrderById($idOrder) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM orders WHERE id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($idOrder));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function getDeliveryAdressById($idAdresse) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM delivery_addresses WHERE id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($idAdresse));
            return $sth->fetchObject();
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }

    function changeStatusOrder($idOrder, $status) {
        try {
            $conn = Connexion::getConnexion();
            $sql = "UPDATE orders SET status=? WHERE id=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($status, $idOrder));
        }
        catch (PDOException $e)
        {
            $erreur = $e->getMessage();
            throw new Exception($erreur);
        }
    }
}