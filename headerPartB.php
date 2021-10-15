<?php
echo <<<_INIT
        </head>
_INIT;

require_once 'functions.php';

if (isset($_SESSION['user'])) {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Logged in as: $user";
}
else $loggedin = FALSE;

echo <<<_HEADER_OPEN
    
    <body>
        <div class="outerWrapper">
            <div id="wrapper">
            <header>
                <div id='logo'>eye Space</div>
_HEADER_OPEN;

if ($loggedin) {
echo <<<_LOGGEDIN

                <nav><ul>
                    <li><a href='members.php?view=$user'>Home</a></li>
                    <li><a href='marketplace.php'>Marketplace</a></li>
                    <li><a href='members.php'>Members</a></li>
                    <li><a href='friends.php'>Friends</a></li>
                    <li><a href='messages.php'>Messages</a></li>
                    <li><a href='profile.php'>Edit Profile</a></li>
                    <li><a href='logout.php'>Log out</a></li>
                </ul></nav>
_LOGGEDIN;
} else {
echo <<<_GUEST

                <nav><ul>
                    <li><a href='index.php'>Home</a></li>
                    <li><a href='marketplace.php'>Marketplace</a></li>
                    <li><a href='signup.php'>Sign Up</a></li>
                    <li><a href='login.php'>Log In</a></li>
                </ul></nav>
_GUEST;
 }

echo <<<_HEADER_CLOSE

            </header>
            <div class='username'>$userstr</div>
            <div id="content">
_HEADER_CLOSE;

?>
