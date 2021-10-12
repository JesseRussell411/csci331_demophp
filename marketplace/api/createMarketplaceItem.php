<?php
require_once '../functions.php';
$username = $_SESSION['user'];
$title = $_POST['title'];
$description = $_POST['description'];
$price_cents = $_POST['price_cents'];

if ($username === $_SESSION['user'] || true){
    if (userValidate()){
        try{
            createMarketplaceItem($username, $title, $description, $price_cents);
            http_response_code(201);
        }
        catch(MarketplaceItemExistsException $e){
            http_response_code(409);
            echo $e->getMessage();
        }
        catch(Exception $e){
            http_response_code(500);
            echo $e->getMessage();
        }
    }
    else{
        http_response_code(401);
        echo "User is not logged.";
    }
}
else{
    http_response_code(401);
    echo "Cannot post marketplace items that belong to other users.";
}
?>