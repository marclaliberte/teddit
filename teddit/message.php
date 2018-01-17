<?php
session_start();
$rootPath = $_SERVER['DOCUMENT_ROOT'];
$settingsPath = $rootPath . '/app-settings.php';
$headerPath = $rootPath . '/header.php';
$sidePath = $rootPath . '/side.php';
require($settingsPath);
$host = $_SERVER['HTTP_HOST'];

// Check if POST data submitted
if (isset($_POST['submit'])) {
    if (!empty($_POST['title']) && !empty($_POST['text']) && !empty($_POST['recipient'])) {
        // Title and Text have data, process
        $messageTitle = $_POST['title'];
        $messageText = $_POST['text'];
	$messageTo = strtolower($_POST['recipient']);
	$messageFrom = $_SESSION['username'];
        $currDate = date('Y-m-d H-i-s');

        // Connect to SQL database
        $db = new mysqli("$dbhost", "$dbuser", "$dbpass", "$dbname");

        // Check connection
        if ($db->connect_errno > 0) {
            die ('Unable to connect to database ]' . $db->connect_error . ']');
        }

        // Sanitize SQL Data
        $messageTitle = $db->real_escape_string($messageTitle);
        $messageText = $db->real_escape_string($messageText);
	$messageTo = $db->real_escape_string($messageTo);

        // Prep SQL query
        $query = "INSERT INTO messages (title,content,sender,recipient,date) VALUES('".$messageTitle."', '".$messageText."','".$messageFrom."','".$messageTo."','".$currDate."')";

        // Run the query
        if($db->query($query)) {
            // Success
            header("Location: http://$host/");
            exit;
        }
        else {
            // Fail
        }

    }
    elseif (!empty($_POST['title'])) {
        // Title has data, text must be empty
    }
    elseif (!$empty($_POST['text'])) {
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
    <h1>submit to teddit</h1>
    <form class="submit content" action="message" id="newlink" method="post">
        <div class="formtabs-content">
	    <div class="spacer">
                <div class="roundfield" id="recipient-field">
                    <span class="recipient">recipient</span>
                    <div class="roundfield-content">
                        <input type="text" name="recipient"></input>
                    </div>
                </div>
            </div>

            <div class="spacer">
                <div class="roundfield" id="title-field">
                    <span class="title">title</span>
                    <div class="roundfield-content">
                        <textarea name="title" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="spacer">
                <div class="roundfield" id="text-field">
                    <span class="title">text</span>
                    <div class="roundfield-content">
                        <div class="usertext-edit md-container" style>
                            <div class="md">
                                <textarea rows="1" cols="1" name="text" class></textarea>
                            </div>
                            <div class="bottom-area"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer">
            <button class="btn" name="submit" value="form" type="submit">send</button>
        </div>
    </form>
</div>

<div class="footer-parent"></div>
</body>
</html>

