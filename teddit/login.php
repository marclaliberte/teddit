<?php
session_start();

$rootPath = $_SERVER['DOCUMENT_ROOT'];
$settingsPath = $rootPath . '/app-settings.php';
$headerPath = $rootPath . '/header.php';
$sidePath = $rootPath . '/side.php';
require($settingsPath);
$host = $_SERVER['HTTP_HOST'];
$fmsg = '';

// Check if POST data submitted
if (isset($_POST['submit'])) {
    if (!empty($_POST['user']) && !empty(['password'])) {
        // Title and Text have data, process
	$user = $_POST['user'];
	$pass = $_POST['password'];

        // Connect to SQL database
        $db = new mysqli("$dbhost", "$dbuser", "$dbpass", "$dbname_v");

        // Check connection
        if ($db->connect_errno > 0) {
            die ('Unable to connect to database ]' . $db->connect_error . ']');
        }


        // Prep SQL query
	$query = "SELECT * FROM users WHERE user='".$user."'";
	$result = $db->query($query);
	$count = $result->num_rows;
	if ($count == 1) {
	    $_SESSION['username'] = $user;
	    $db->close();
     	    header("Location: http://$host/");
	} else {
	    $fmsg = "Invalid Login Credentials";
	}
    }
    elseif (!empty($_POST['user'])) {
	$fmsg = "Enter a username";
        // Title has data, text must be empty
    }
    elseif (!$empty($_POST['text'])) {
	$fmsg = "Enter a password";
        // Text has data, title must be empty
    }
}
?>
<html>
<head>
<title>teddit: the front page of Ted</title>
<link rel="stylesheet" type="text/css" href="/css/fixed.css">
</head>

<body>
<?php

    require($headerPath);
    require($sidePath);

?>
<a name="content"></a>
<div class="content">
    <h1>Log In</h1>
    <form class="submit content" action="login" id="newlink" method="post">
        <div class="formtabs-content">
            <div class="spacer">
                <div class="roundfield" id="title-field">
                    <span class="title">Username</span>
                    <div class="roundfield-content">
                        <input type="text" name="user"></input>
                    </div>
                </div>
            </div>
            <div class="spacer">
                <div class="roundfield" id="text-field">
                    <span class="title">Password</span>
                    <div class="roundfield-content">
                        <div class="usertext-edit md-container" style>
                            <div class="md">
				<input type="password" name="password"></input>
                            </div>
                            <div class="bottom-area">
<?php
if ($fmsg != '') {
?>
<div class="error-message">
<?php
echo $fmsg;
?>
</div>
<?php
}
?>
			    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer">
            <button class="btn" name="submit" value="form" type="submit">submit</button>
        </div>
    </form>
</div>

<div class="footer-parent"></div>
</body>
</html>

