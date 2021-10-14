<?php
require_once '../../functions.php';

class MarketplaceItemExistsException extends AlreadyExistsException {
    private $username;
    private $title;

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
}

class MarketplaceItemNotFoundException extends NotFoundException {
    private $title;

    public function __construct(string $title, Throwable $previouse = NULL) {
        parent::__construct("Marketplace item with title $title not found.", 0, $previouse);
        $this->title = $title;
    }

    public function getTitle(){
        return $this->title;
    }
}

$getAllItemsStatement = $connection->prepare("SELECT * FROM `marketplaceitems`");
$getUsersItemsStatement = $connection->prepare("SELECT * FROM `marketplaceitems` WHERE user = ?");
$createItemStatement = $connection->prepare("INSERT INTO `marketplaceitems` VALUES(?, ?, ?, ?)");
$removeItemStatement = $connection->prepare("DELETE FROM `marketplaceitems` WHERE user = ? AND title = ?");
$getItemOwnerStatement = $connection->prepare("SELECT user FROM `marketplaceitems` WHERE title = ?");

function getAllMarketplaceItems(){
    global $getAllItemsStatement;
    $getAllItemsStatement->execute();
    $result = $getAllItemsStatement->get_result();

    return $result->fetch_all();
}

function createItem(string $username, string $title, string $description, string $prince_cents) {
    global $createItemStatement;
    $createItemStatement->bind_param("sssi", $username, $title, $description, $prince_cents);
    $createItemStatement->execute();
    if ($createItemStatement->errno === 1062){
        throw new MarketplaceItemExistsException($username, $title);
    }
}

function getItemOwner($title){
    global $getItemOwnerStatement;
    $getItemOwnerStatement->bind_param("s", $title);
    $getItemOwnerStatement->execute();

    $result = $getItemOwnerStatement->get_result();

    if ($result->num_rows > 0)
        return $result->fetch_row()[0];
    else
        throw new MarketplaceItemNotFoundException($title);
}

function getUsersMarketplaceItems($username){
    global $getUsersItemsStatement;
    $getUsersItemsStatement->bind_param("s", $username);
    $getUsersItemsStatement->execute();

    return $getUsersItemsStatement->get_result()->fetch_all();
}

function removeItem($username, $title){
    global $removeItemStatement;
    $removeItemStatement->bind_param("ss", $username, $title);
    $removeItemStatement->execute();

    if ($removeItemStatement->affected_rows === 0)
        throw new MarketplaceItemNotFoundException($title);
}
?>