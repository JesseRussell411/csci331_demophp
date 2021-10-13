<?php
require_once '../functions.php';
$title = $_POST['title'];
$description = $_POST['description'];
$price_cents = $_POST['price_cents'];

$username = validateAndGetUsername();
if ($username === false){
    http_response_code(401);
    echo "User is not logged in.";
}
else{
    if ($title === ""){
        http_response_code(400);
        die("No title provided.");
    }
    else if ($price_cents < 0){
        http_response_code(400);
        die("Price cannot be negative.");
    }
    else if (!ctype_digit($price_cents)){
        http_response_code(400);
        die("Price is not a number.");
    }


    try{
        createItem($username, $title, $description, $price_cents);
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
?>