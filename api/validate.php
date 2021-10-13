<?php
    require_once '../functions.php';

    try {
        // echo userValidate() ? 'true' : 'false';
        // http_response_code(200);
        $username = validateAndGetUsername();
        if ($username !== false){
            http_response_code(200);
            echo $username;
        }
        else{
            http_response_code(401);
            echo "";
        }
    }
    catch(Exception $e){
        http_response_code(500);
        echo $e->getMessage();
    }
?>