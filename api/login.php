<?php
    require_once '../functions.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    // abort with 400 if the fields are blank
    if ($username === "" || $password === ""){
            http_response_code(400);
            die("username or password is empty");
    }

    // attempt to login
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