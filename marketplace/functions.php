<?php
require_once '../../functions.php';

class MarketplaceItemExistsException extends Exception {
    public $username;
    public $title;

    public function __construct(string $username, string $title, Throwable $previouse = NULL){
        parent::__construct("Marketplace item belonging to '$username' with the title '$title' already exists.", 0, $previouse);
        $this->username = $username;
        $this->title = $title;
    }

    public function getUsername(){
        return $this->username;
    }
    public function getTitle(){
        return $this->title;
    }

    public function __toString(){
        return __CLASS__ . " -- $this->message";
    }
}

$getAllMarketplaceItemsStatement = $connection->prepare("SELECT * FROM `marketplaceitems`");
$getUsersMarketplaceItemsStatement = $connection->prepare("SELECT * FROM `marketplaceitems` WHERE user = ?");
$createMarketplaceItemStatement = $connection->prepare("INSERT INTO `marketplaceitems` VALUES(?, ?, ?, ?)");

function getAllMarketplaceItems(){
    global $getAllMarketplaceItemsStatement;
    $getAllMarketplaceItemsStatement->execute();
    $result = $getAllMarketplaceItemsStatement->get_result();

    return $result->fetch_all();
}

function createMarketplaceItem(string $username, string $title, string $description, string $prince_cents) {
    global $createMarketplaceItemStatement;
    $createMarketplaceItemStatement->bind_param("sssi", $username, $title, $description, $prince_cents);
    $createMarketplaceItemStatement->execute();
    if ($createMarketplaceItemStatement->errno === 1062){
        throw new MarketplaceItemExistsException($username, $title);
    }
}

function getUsersMarketplaceItems($username){
    global $getUsersMarketplaceItemsStatement;
    $getUsersMarketplaceItemsStatement->bind_param("s", $username);
    $getUsersMarketplaceItemsStatement->execute();

    return $getUsersMarketplaceItemsStatement->get_result()->fetch_all();
}
?>