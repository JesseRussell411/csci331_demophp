<?php
session_start();
require_once 'header.php';

echo "<div class='tile basicPage'>";
echo "<h3>Welcome to $clubstr. </h3>";

if ($loggedin)
    echo " $user, you are logged in";
else
    echo 'Please sign up, or log in if you\'re already a member.';

?>


<h1> what I have done </h1>
<ul>
    <li>backend
        <ul>
            <li>Password hashing</li>
            <li>authorization token for user validation after login
                <ul>
                    <li>combined hash of: username, time of login, and serverside secret</li>
                    <li>expires after one hour of inactivity. Token is refreshed with every validation</li>
                </ul>
            </li>
            <li>RESTful api for added pages
                <ul>
                    <li>A littled hacky. I briefly looked into libraries for making rest apis with php, but I think what I've done is fine for a first attempt</li>
                    <li>Each route corresponds to a php file on the server. The file returns an appropriate status code and message instead of pre-rendered html like usual.</li>
                    <li>I'm only using the GET and POST methods which is a little akward since, for example, I'm using a GET request for one of the delete routes.</li>
                    <li>The user authentication comes into play for certain routes that should only be open to certain users. For example, the 'marketplace/api/removeItem.php' route will only work for the owner of that item (well it's actually a little diferent since different users can post items with the same title and this route doesn't ask for your username, it gets it from the validation system but regardlesss, tim can't delete one of ted's items).</li>
                    <li>I also have routes for user authentication: 'api/login.php', 'api/logout.php', 'api/validate.php' they're not actually used on the website but can be handy if your testing routes with postman or insomnia.</li>
                </ul>
            </li>
            <li>Database changes<ul>
                    <li>Added a table for the marketplace with columns: user,title,description,price_cents. The primary key is user and title combined. This way different users can post items with the same title.</li>
                    <li>Increased character limit on user and pass fields in members table. Maybe user was fine, but to store a bcrypt hash I needed way more characters than 16.</li>
                </ul>
            </li>

        </ul>
    </li>
    <li>frontend
        <ul>
            <li>REACT
                <ul>
                    <li>Used by the two pages I added</li>
                    <li>It's really easy to add react to an existing webpage, so I did.</li>
                    <li>I wanted to make the front end rather interactive since it's basically pure javascript so hopefully some of that's noticeable.</li>
                </ul>
            </li>
            <li>two new pages <ul>
                    <li>marketplace <ul>
                            <li>Lists marketplace items with sort options on the left (title is the default so don't select that one as it will do nothing at first) and delete buttons on the items that you have posted but not on other peoples items.</li>
                            <li>The delete button changes to a waring text when clicked once, and actually initiates the deletion on the second click. The warning times out after 3 seconds. While waiting for the delete route to complete. The button is disabled.</li>

                        </ul>
                    </li>
                    <li>sell <ul>
                            <li>Presents a form for posting new items to the marketplace</li>
                            <li>The preview at the bottom updates in real time to show you what the post will look like</li>
                            <li>Presents route errors in an alert box if any occur (this includes formatting errors like if the user leaves the title field blank)</li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>css<ul>
                   <li>The look I was going for was "classic macOs".</li>
                   <li>I tried to make the site more responsive to screen size.</li>
                   <li>Marketplace is responsive to screen width, try resizing to something like the width of a phone screen</li>
                </ul>
            </li>
        </ul>
    </li>

</ul>

<?php


echo <<<_END
    </div><br>
_END;

require_once 'footer.php';
?>