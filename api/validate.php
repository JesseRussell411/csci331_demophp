<?php
    require_once '../functions.php';

    try {
        // echo userValidate() ? 'true' : 'false';
        // http_response_code(200);
        if (userValidate()){
            http_response_code(200);
            echo $_SESSION['user'];
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