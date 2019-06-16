<!--
Pablo Sanchez
Description:
Read name as GET query parameter and finds which other singles match the given user.
Features:
Header logo, user matches, and footer notes.
-->
<?php include("top.php"); ?>

<h1>Matches for <?= $_GET["name"] ?></h1>
<div class='match'>
    <?php printMatchesFromFile(); ?>
</div>

<?php include("bottom.php"); ?>

<!-- PHP FUNCTIONS START-->
<?php

/**
 * Read the name from the page's "name" query parameter and finds which other singles match the given user.
 * Output the HTML to display the matches, in the order they were originally found in the file.
 * Each match has the image user.jpg, the person's name, and an unordered list with their gender, age, personality type,
 * and OS.
 */
function printMatchesFromFile()
{
    //$_GET and $_POST are superglobals. They do not need to be passed as a function parameter.

    // retrieves user's info from singles.txt file
    $loginUser = "";
    foreach (file("singles.txt", FILE_IGNORE_NEW_LINES) as $loginUser) {
        // "name" query parameter is used to find the remaining user info
        if ($_GET["name"] == explode(",", $loginUser)[0]) {
            break;
        }
    }

    foreach (file("singles.txt", FILE_IGNORE_NEW_LINES) as $matchUser) {
        // required conditions for a match
        if (
            // Index[0]: name.
            // Do not match user with himself/herself.
            explode(",", $matchUser)[0] != explode(",", $loginUser)[0]

            // Index[1]: gender.
            // Match with opposite gender of the given user.
            && explode(",", $matchUser)[1] != explode(",", $loginUser)[1]

            // Index[2]: user age, Index[5]: preferred min age, Index[6]: preferred max age.
            // Each person is between the other's minimum and maximum ages, inclusive.
            && explode(",", $matchUser)[2] >= explode(",", $loginUser)[5]
            && explode(",", $matchUser)[2] <= explode(",", $loginUser)[6]

            // Index[4]: operating system.
            // Match the same favorite operating system as this user
            && explode(",", $matchUser)[4] == explode(",", $loginUser)[4]

            // Index[3]: personality type.
            // Shares at least one personality type letter in common at the same index in each string.
            // For example, ISTP and ESFP have 2 in common (S, P).
            && (
                str_split(explode(",", $matchUser)[3])[0] == str_split(explode(",", $loginUser)[3])[0]
                || str_split(explode(",", $matchUser)[3])[1] == str_split(explode(",", $loginUser)[3])[1]
                || str_split(explode(",", $matchUser)[3])[2] == str_split(explode(",", $loginUser)[3])[2]
                || str_split(explode(",", $matchUser)[3])[3] == str_split(explode(",", $loginUser)[3])[3]
            )

        ) {
            //print matches HTML to web page
            ?>
            <p><img src='images/user.jpg' alt='user icon'><?= explode(",", $matchUser)[0] ?></p>
            <ul>
                <li><strong>gender:</strong><?= explode(",", $matchUser)[1] ?></li>
                <li><strong>age:</strong><?= explode(",", $matchUser)[2] ?></li>
                <li><strong>type:</strong><?= explode(",", $matchUser)[3] ?></li>
                <li><strong>OS:</strong><?= explode(",", $matchUser)[4] ?></li>
            </ul>

        <?php }
    }
}

?>
<!-- PHP FUNCTIONS END-->
