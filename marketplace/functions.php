<?php
require_once '../connectToDatabase.php';
$getAllMarketplaceItemsStatement = $connection->prepare("SELECT * FROM `marketplaceitems`");
$createMarketplaceItemStatement = $connection->prepare("INSERT INTO `marketplaceitems` VALUES(?, ?, ?, ?)");

function getAllMarketplaceItems(){
    global $getAllMarketplaceItemsStatement;
    $getAllMarketplaceItemsStatement->execute();
    $result = $getAllMarketplaceItemsStatement->get_result();
    return json_encode($result->fetch_all());
}

function addMarketplaceItem(){

}

print(getAllMarketplaceItems());
?>