<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
$settingsPath = $rootPath . '/app-settings.php';
$headerPath = $rootPath . '/header.php';
$sidePath = $rootPath . '/side.php';
require($settingsPath);
$host = $_SERVER['HTTP_HOST'];

// Check if POST data submitted
if (isset($_POST['submit'])) {
    if (!empty($_POST['title']) && !empty(['text'])) {
        // Title and Text have data, process
        $submitTitle = $_POST['title'];
        $submitText = $_POST['text'];
        $currDate = date('Y-m-d H-i-s');

        // Connect to SQL database
        $db = new mysqli("$dbhost", "$dbuser", "$dbpass", "$dbname");

        // Check connection
        if ($db->connect_errno > 0) {
            die ('Unable to connect to database ]' . $db->connect_error . ']');
        }

        // Sanitize SQL Data
        $submitTitle = $db->real_escape_string($submitTitle);
        $submitText = $db->real_escape_string($submitText);

        // Prep SQL query
        $query = "INSERT INTO posts (title,content,user,date) VALUES('".$submitTitle."', '".$submitText."','anonymous','".$currDate."')";

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
    <form class="submit content" action="submit" id="newlink" method="post">
        <div class="formtabs-content">
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
            <button class="btn" name="submit" value="form" type="submit">submit</button>
        </div>
    </form>
</div>

<div class="footer-parent"></div>
</body>
</html>

