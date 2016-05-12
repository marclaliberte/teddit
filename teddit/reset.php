<?php
require('app-settings.php');
$host = $_SERVER['HTTP_HOST'];

// Connect to MYSQL
$db = new mysqli("$dbhost", "$dbuser", "$dbpass", "$dbname");
//$db_v = new mysqli("$dbhost", "$dbuser", "$dbpass", "$dbname_v");

if ($db->connect_errno > 0) {
    die ('Unable to connect to database [' . $db->connect_error . ']');
}

// Prep drop query
$sqlDropQuery = "DROP TABLE posts";
$sqlDropQuery_v = "DROP TABLE users";

if($result = $db->query($sqlDropQuery)) {
    //success
}
else {
    // fail
}

//if($result = $db_v->query($sqlDropQuery_v)) {
    //success
//}
//else {
    // fail
//}


$sqlCreateQuery =
"CREATE TABLE IF NOT EXISTS posts
(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    title VARCHAR(128),
    content VARCHAR(2048),
    user VARCHAR(32),
    date DATETIME
)";

//$sqlCreateQuery_v = 
//"CREATE TABLE IF NOT EXISTS users
//(
//    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
//    username VARCHAR(32) NOT NULL,
//    password VARCHAR(256) NOT NULL
//)";

if ($result = $db->query($sqlCreateQuery)) {
    //success
}
else {
    //fail
}

//if ($result = $db_v->query($sqlCreateQuery_v)) {
    //success
//}
//else {
    //fail
//}


// Add posts
$post1 = "INSERT INTO posts (title,content,user) VALUES('Ted is the greatest!', 'Don\'t you all agree? Ted is awesome!', 'TedForPresident')";

$post2 = "INSERT INTO posts (title,content,user) VALUES('How about that Ted guy?', 'Can\'t get enough of that Ted!', 'Xx_Ted_xX')";

$post3 = "INSERT INTO posts (title,content,user) VALUES('Has Ted Gone Missing?', 'Where in the world is Ted?', 'TedTedTed')";

if ($result1 = $db->query($post1)) {
    //success
}
else {
    //fail
}

if ($result2 = $db->query($post2)) {
    //success
}
else {
    //fail
}

if ($result3 = $db->query($post3)) {
    //success
}
else {
    //fail
}


$db->close();

header("Location: http://$host/");
exit;

?>
