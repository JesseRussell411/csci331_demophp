<?php
    require_once 'functions.php';

    try {
        // echo userValidate() ? 'true' : 'false';
        // http_response_code(200);
        if (userValidate()){
            http_response_code(200);
        }
        else{
            http_response_code(401);
        }
    }
    catch(Exception $e){
        http_response_code(500);
        echo $e->getMessage();
    }
?>