<?php
$dbhost  = 'localhost';

$dbname  = 'db60';   // Modify these...
$dbuser  = 'user60';   // ...variables according
$dbpass  = '60mice';   // ...to your installation
// test change


$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) 
    throw new Exception("Cannot connect to database");


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

function prepQueryMysql($query, $types, ...$params){
    global $connection;
    $statement = $connection->prepare($query);
    $statement->bind_param($types, ...$params);
    $statement->execute();
    return $statement->get_result();
}
$result = queryMysql("SELECT * FROM members WHERE user='$user'");
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
    if (userExists($username))
        throw new Exception("User exists");

    $pass_hash = password_hash($password, PASSWORD_BCRYPT);
    global $createUserStatement;
    $createUserStatement->bind_param("ss", $username, $pass_hash);
    $createUserStatement->execute();
}

function verifyUser($username, $password){
    // return password_verify($password, password_hash($password, PASSWORD_BCRYPT));
    global $getPassHashStatement;
    $getPassHashStatement->bind_param("s", $username);
    $getPassHashStatement->execute();
    $pass_hash = $getPassHashStatement->get_result()->fetch_row()[0];
    return password_verify($password, $pass_hash);
}
?>
