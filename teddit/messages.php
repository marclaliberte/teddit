<?php
session_start();
$rootPath = $_SERVER['DOCUMENT_ROOT'];
$settingsPath = $rootPath . '/app-settings.php';
$headerPath = $rootPath . '/header.php';
$sidePath = $rootPath . '/side.php';
require($settingsPath);

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

    $recipient = strtolower($_SESSION['username']);

    $db = new mysqli("$dbhost", "$dbuser", "$dbpass", "$dbname");

    if ($db->connect_errno > 0) {
        die ('Unable to connect to database [' . $db->connect_Error . ']');
    }

    $postRows = [];

    $queryPosts = "SELECT id,title,sender FROM messages WHERE recipient='".$recipient."' ORDER BY id DESC";

    $result = $db->query($queryPosts);
    if ($result->num_rows == 0) {
        // No content
    }
    else {
        while ($row = $result->fetch_assoc()) {
            $postRows[] = $row;
        }
    }
    $db->close();


?>
<a name="content"></a>
<div class="content">
    <div class="spacer">
        <div id="siteTable" class="sitetable linklisting">

<?php
for ($i = 0; $i < count($postRows); $i++) {
$postTitle = $postRows[$i]['title'];
$postUser = $postRows[$i]['sender'];
$postId = $postRows[$i]['id'];

?>
            <div id="thing_<?php echo "$postId" ?>" class="odd link self">
                <div class="entry unvoted">
                    <p class="title">
                        <a class="title" href="/view_message/message_<?php echo "$postId" ?>" tabindex="1"><?php echo "$postTitle" ?></a>
                    </p>
                    <p class="tagline">sent by <?php echo "$postUser" ?></p>
                    <ul class="flat-list buttons">
                    </ul>
                </div>
                <div class="child"></div>
                <div class="clearleft"></div>
            </div>
            <div class="clearleft"></div>
<?php
}
?>

        </div>
    </div>
</div>

<div class="footer-parent"></div>
</body>
</html>
