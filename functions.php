<?php
error_reporting(E_ERROR | E_PARSE);

require_once 'connectToDatabase.php';
session_start();

// TODO: put this in an ini file
$secret = "alkds;fjalfnf32on3wnfdaowfn";
// test change




function createTable($name, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}


function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error 2");
    return $result;
}

function destroySession() {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var){
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    if (get_magic_quotes_gpc())
        $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

function showProfile($user) {
    if (file_exists("userpics/$user.jpg"))
        echo "<img class='userpic' src='userpics/$user.jpg'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
    else echo "<p>Nothing to see here, yet</p><br>";
}







// my additions:
class UserExistsException extends Exception {
    public $username;

    public function __construct(string $username, Throwable $previouse = NULL){
        parent::__construct("user: $username, already exists.", 0, $previouse);
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function __toString(){
        return __CLASS__ . " -- $this->message";
    }
}

function prepQueryMysql($query, $types, ...$params){
    global $connection;
    $statement = $connection->prepare($query);
    $statement->bind_param($types, ...$params);
    $statement->execute();
    return $statement->get_result();
}
$getUserStatement = $connection->prepare("SELECT * FROM members WHERE user = ?");
$getPassHashStatement = $connection->prepare("SELECT pass FROM members WHERE user = ?");
$createUserStatement = $connection->prepare("INSERT INTO members VALUES(?, ?)");
$getVerifiedUserStatement = $connection->prepare("SELECT * FROM members WHERE user = ? AND pass = ?");


function userExists($username){
    global $getUserStatement;
    $getUserStatement->bind_param("s", $username);
    $getUserStatement->execute();
    return $getUserStatement->get_result()->num_rows > 0;
}

function createUser($username, $password){
    global $createUserStatement;
    $pass_hash = password_hash($password, PASSWORD_BCRYPT);

    $createUserStatement->bind_param("ss", $username, $pass_hash);
    $createUserStatement->execute();
    if ($createUserStatement->errno === 1062){
        throw new UserExistsException($username);
    }
}

/**
 * @return bool whether the username and password match
 */
function verifyUser($username, $password){
    global $getPassHashStatement;
    // fetch to password hash from the database
    $getPassHashStatement->bind_param("s", $username);
    $getPassHashStatement->execute();

    // if the user's row wasn't found, they don't exist, treat this the same as an invalid password.
    $result = $getPassHashStatement->get_result();
    if ($result->num_rows === 0) return false;

    // verify the password
    $pass_hash = $result->fetch_row()[0];
    return password_verify($password, $pass_hash);
}

/** @return string authentication string based on the username */
function createAuthenticationString($username){
    global $secret;
    return password_hash($username . $secret, PASSWORD_BCRYPT);
}

/** @return bool whether the authentication string matches the username */
function validateAuthenticationString($username, $authenticationString){
    global $secret;
    return password_verify($username . $secret, $authenticationString);
}

/** Store user authentication string in session */
function createUserAuthentication(){
    $username = $_SESSION['user'];
    $_SESSION['authentication'] = createAuthenticationString($username);
}

/** Checks if the authentication string stored in session matches the username stored in session */
function userValidate(){
    if (isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        $authenticationString = $_SESSION['authentication'];
        
        return validateAuthenticationString($username, $authenticationString);
    }
    else {
        return false;
    }
}

/**
 * Attempts to login the user.
 * @return bool? Whether the login was successful or not. If null: a different user is already logged in.
 */
function userLogin($username, $password){
    if (userValidate()){
        if ($_SESSION['user'] === $username){
            return true;
        } else {
            return NULL;
        }
    }
    else if (verifyUser($username, $password)){
        session_start();
        $_SESSION['user'] = $username;
        createUserAuthentication();
        return true;
    }
    else{
        return false;
    }
}

/** destroys the session */
function userLogout(){
    destroySession();
}

?>
