<?php
    require_once "../functions.php";
    $title = $_GET['title'];


    try{
        $username = validateAndGetUsername();
        if ($username !== false && $username === getItemOwner($title)){
            removeItem($username, $title);
            http_response_code(200);
        }
        else {
            http_response_code(403);
        }
    }
    catch(MarketplaceItemNotFoundException $e){
        http_response_code(404);
        echo($e->getMessage());
    }
?>