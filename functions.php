<?php
error_reporting(E_ERROR | E_PARSE);

require_once 'connectToDatabase.php';
session_start();


// one thing I did was I tried to better secure user login.
// Passwords are hashed now. And I made an attempt at creating an authentication token stored in the session.

// The token is the hash of: username + sign-in-time-in-seconds-since-epoch + secret
// I'm not sure how secret is suppose to work. It's probably suppose to be refreshed every so often.
// The sign in time is also recorded in the session and it's used to sign-out the user if they try to access something to long after the last time they were logged in or successfull validated.

// validation just involves calling password_validate against the username + sign in time + secret and the authentication token
// if validation fails, the user is logged out.
// if it succeeds, they're allowed to access whatever they were accessing and their authentication token is refreshed with the current date and time.

// of course the correct way to do this stuff is to let a library handle it.


// TODO: put this in an ini file or something
$secret = "alkds;fjalfnf32on3wnfdaowfn";
// how long the user is logged in for
$logginTimeout = new DateInterval("PT1H"/*1 hour*/);
// $logginTimeout = new DateInterval("PT10S"/*10 seconds*/); /*<--- for testing*/
// there's more after the "my additions" comment





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







// my additions: -----------------------------------------------------------------------------------------------------------------------------------------------------

// some exceptions
class NotFoundException extends Exception{}
class AlreadyExistsException extends Exception{}

class UserExistsException extends AlreadyExistsException {
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

// I never actually used this
function prepQueryMysql($query, $types, ...$params){
    global $connection;
    $statement = $connection->prepare($query);
    $statement->bind_param($types, ...$params);
    $statement->execute();
    return $statement->get_result();
}

// query statements
$getUserStatement = $connection->prepare("SELECT * FROM members WHERE user = ?");
$getPassHashStatement = $connection->prepare("SELECT pass FROM members WHERE user = ?");
$createUserStatement = $connection->prepare("INSERT INTO members VALUES(?, ?)");
$getVerifiedUserStatement = $connection->prepare("SELECT * FROM members WHERE user = ? AND pass = ?");

/**
 * @return bool Whether the user with the given username exists in the database
 */
function userExists($username){
    global $getUserStatement;
    $getUserStatement->bind_param("s", $username);
    $getUserStatement->execute();
    return $getUserStatement->get_result()->num_rows > 0;
}

/**
 * Creates the user with the given username and password
 * @throws UserExistsException thrown if the user already exists.
 */
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
 * Checks the given username against the given password
 * 
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

// these next two functions are used for creating and checking the authentication string

/** @return string authentication string based on the username and date*/
function createAuthenticationString($username, string $secondsSinceEpoch){
    global $secret;
    return password_hash($username . $secondsSinceEpoch . $secret, PASSWORD_BCRYPT);
}

/** @return bool whether the authentication string matches the username date*/
function validateAuthenticationString($username, string $secondsSinceEpoch, $authenticationString){
    global $secret;
    return password_verify($username . $secondsSinceEpoch . $secret, $authenticationString);
}

/** Called on successful login. Creates the user's authentication token and stores in in the session */
function createUserAuthentication($username){
    $currentTime = new DateTime();
    $timeString = $currentTime->format("U");

    $_SESSION['user'] = $username;
    $_SESSION['signInSecondsSinceEpoch'] = $timeString;

    $_SESSION['authentication'] = createAuthenticationString($username, $timeString);
}


// User validation
// These two functions are used to check if the user is logged in

/**
 * @return String|bool The username of whoever is currently logged in or false if nobody is logged in.
 */
function validateAndGetUsername(){
    global $logginTimeout;

    if (isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        $authenticationString = $_SESSION['authentication'];
        $signInTimeString = $_SESSION['signInSecondsSinceEpoch'];
        
        if (validateAuthenticationString($username, $signInTimeString, $authenticationString)){
            $currentTime = new DateTime();
            $signInTime = DateTime::createFromFormat("U", $signInTimeString);
            $signInExpirationTime = $signInTime->add($logginTimeout);
            

            // if current time is passed expiration time (diff is backwards so a.diff(b) == b - a)
            if ($currentTime->diff($signInExpirationTime)->invert === 1){
                // session expired
                userLogout();
                return false;
            }
            else{
                // renew user authentication
                createUserAuthentication($username);
                return $username;
            }

            
        }
        else
            return false;
    }
    else {
        return false;
    }
}

function userValidate(){
    return validateAndGetUsername() !== false;
}

/**
 * Attempts to login the user.
 * @return bool? Whether the login was successful or not. If null: a different user is already logged in.
 */
function userLogin($username, $password){
    $loggedInUser = validateAndGetUsername();
    if ($loggedInUser !== false){
        if ($loggedInUser === $username){
            return true;
        } else {
            return NULL;
        }
    }
    else if (verifyUser($username, $password)){
        session_start();
        createUserAuthentication($username);
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
