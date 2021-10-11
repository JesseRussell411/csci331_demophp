<?php
    require_once 'header.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $result = userLogin($username, $password);

        if ($result === true) {
                http_response_code(200);
                echo "Login Successful";
        }
        else if ($result === false) {
                http_response_code(401);
                echo "Username and password do not match.";
        }
        else if ($result === NULL) {
                http_response_code(409);
                echo "A different user is still logged in.";
        }
        else {
                throw new Exception("Unknown Error");
        }
    }
    catch(Exception $e){
        http_response_code(500);
        echo $e->getMessage();
    }
?>