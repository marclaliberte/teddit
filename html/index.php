<?php
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

    $db = new mysqli("$dbhost", "$dbuser", "$dbpass", "$dbname");

    if ($db->connect_errno > 0) {
        die ('Unable to connect to database [' . $db->connect_Error . ']');
    }

    $postRows = [];

    $queryPosts = "SELECT id,title,user FROM posts ORDER BY id DESC";

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
$postUser = $postRows[$i]['user'];
$postId = $postRows[$i]['id'];

?>
            <div id="thing_<?php echo "$postId" ?>" class="odd link self">
                <p class="parent"></p>
                <span class="rank">1</span>
                <div class="midcol unvoted">
                    <div class="arrow up"></div>
                    <div class="score unvoted">3987</div>
	            <div class="arrow down"></div>
                </div>
                <a class="thumbnail self" href="/t/teddit/comments/thing_<?php echo "$postId" ?>"></a>
                <div class="entry unvoted">
                    <p class="title">
                        <a class="title" href="/t/teddit/comments/thing_<?php echo "$postId" ?>" tabindex="1"><?php echo "$postTitle" ?></a>
                        <span class="domain">(<a href="/t/teddit/">self.Teddit</a>)</span>
                    </p>
                    <p class="tagline">submitted 8 hours ago by <?php echo "$postUser" ?> to /t/Teddit</p>
                    <ul class="flat-list buttons">
                        <li class="first">10348 comments</li>
                        <li class="share">share</li>
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
