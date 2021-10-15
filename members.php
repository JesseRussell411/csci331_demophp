<?php
require_once 'header.php';

if (!$loggedin) {
    echo "<h3>Log in to view members</h3>";
    die(require 'footer.php');
}

if (isset($_GET['view'])) {
    $view = sanitizeString($_GET['view']);

    if ($view == $user)
        $name = "Your";
    else
        $name = "$view's";

    echo '<div class="tile basicFullPage">';
    echo "<h3>$name Profile</h3>";
    echo '<div id="memberPicContainer">';
    showUserPic($view);
    echo '</div>';
    showProfile($view);
    echo "<a href='messages.php?view=$view'>View $name messages</a>";
    echo '</div>';
    die(require 'footer.php');
}

if (isset($_GET['add'])) {
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
    queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
} 
elseif (isset($_GET['remove'])) {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num    = $result->num_rows;

echo "<div class='tile basicPage'>";
echo "<h3>Members: $clubstr</h3><ul>";

for ($j = 0 ; $j < $num ; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user)
        continue;

    echo "<li><a data-transition='slide' href='members.php?view=" .
    $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = queryMysql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) 
        echo " &harr; is a mutual friend";
    elseif ($t1) 
        echo " &larr; you are following";
    elseif ($t2) { 
        echo " &rarr; is following you";
        $follow = "recip"; 
    }

    if (!$t1) 
        echo " [<a href='members.php?add=" . $row['user'] . "'>$follow</a>]";
    else
        echo " [<a href='members.php?remove=" . $row['user'] . "'>drop</a>]";
}
echo "</ul>";
echo "</div>";
require_once 'footer.php';
?>
