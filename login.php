<?php
require_once 'header.php';
$error = $user = $pass = "";

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
        $error = 'Not all fields were entered';
    else {
        $loginResult = userLogin($user, $pass);

        if ($loginResult === true){
            die("<h3>Welcome back, $user.</h3><p>Please <a href='members.php?view=$user'>click here</a> to continue.</p></div><footer></footer></body></html>");
        }
        else if ($loginResult === false){
            $error = "Invalid login attempt";
        }
        else if ($loginResult === NULL){
            $error = "You are already logged into a different account. Logout of that account first.";
        }
        // if (verifyUser($user, $pass)){
        //     $_SESSION['user'] = $user;
        //     $_SESSION['pass'] = $pass;
        //     die("<h3>Welcome back, $user.</h3><p>Please <a href='members.php?view=$user'>click here</a> to continue.</p></div><footer></footer></body></html>");
        // }
        // else{
        //     $error = "Invalid login attempt";
        // }
    }
}

echo <<<_END

    <form class='tile basicPage' method='post' action='login.php'>
        <div data-role='fieldcontain'>
            <label></label>
            <span class='error'>$error</span>
        </div>
        <div data-role='fieldcontain'>
            <label></label>
            <h3>Enter username and password</h3>
        </div>
        <div data-role='fieldcontain'>
            <label>Username</label>
            <input type='text' maxlength='256' name='user' value='$user'>
        </div>
        <div data-role='fieldcontain'>
            <label>Password</label>
            <input type='password' name='pass' value='$pass'>
        </div>
        <div data-role='fieldcontain'>
            <label></label>
            <input data-transition='slide' type='submit' value='Login'>
        </div>
    </form>
_END;
require_once 'footer.php';
?>
