<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
$settingsPath = $rootPath . '/app-settings.php';
$headerPath = $rootPath . '/header.php';
$sidePath = $rootPath . '/side.php';
require($settingsPath);
$host = $_SERVER['HTTP_HOST'];

?>
<html>
<head>
<title>teddit: the front page of Ted</title>
<link rel="stylesheet" type="text/css" href="/css/fixed.css">
</head>

<body>
<?php
    // Check for GET request
    if (empty($_GET['id'])) {
        // Get request empty
        header("Location: http://$host/");
   }
    else {
        $postId = $_GET['id'];
        require($headerPath);
        require($sidePath);

        $db = new mysqli("$dbhost", "$dbuser", "$dbpass", "$dbname");

        if ($db->connect_errno > 0) {
            die ('Unable to connect to database [' . $db->connect_Error . ']');
        }

        $postInfo = [];

        $queryPost = "SELECT id,title,content,user FROM posts WHERE id = '".$postId."'";

        $result = $db->query($queryPost);
        if ($result->num_rows == 0) {
            // No content
        }
        else {
            $postInfo = $result->fetch_assoc();

            $postTitle = $postInfo['title'];
            $postContent = $postInfo['content'];
            $postUser = $postInfo['user'];

        }
        $db->close();

    }
?>
<a name="content"></a>
<div class="content">
    <div class="spacer">
        <div id="siteTable" class="sitetable linklisting">
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
                    <div class="expando expando-uninitialized">
                        <form action="#" class="usertext">
                        <div class="usertext-body may-blank-within md-container">
                            <div class="md">
                                <p><?php echo nl2br($postContent) ?></p>
                            </div>
                        </div>
                        </form>
                    </div>
                    <ul class="flat-list buttons">
                        <li class="first">10348 comments</li>
                        <li class="share">share</li>
                    </ul>
                </div>
                <div class="child"></div>
                <div class="clearleft"></div>
            <div class="clearleft"></div>
<?php

?>
            </div>
        </div>
        <div class="commentarea">
            <div class="panestack-title">
                <span class="title">all 0 comments</span>
            </div>
            <form action="#" class="usertext cloneable">
                <div class="usertext-edit md-container" style>
                    <div class="md">
                        <textarea rows="1" cols="1" name="text"></textarea>
                    </div>
                    <div class="bottom-area">
                        <div class="usertext-buttons">
                            <button type="submit" class="save">save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="footer-parent"></div>
</body>
</html>
