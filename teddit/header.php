<div id="header" role="banner">
    <div id="header-bottom-left">
        <a href="/" id="header-img" class="default-header" title>teddit.com</a>
&nbsp;
        <ul class="tabmenu">
            <li class="selected"><a class="choice">hot</a></li>
            <li><a class="choice">new</a></li>
            <li><a class="choice">rising</a></li>
        </ul>
    </div>
    <div id="header-bottom-right">
<?php
if (isset($_SESSION['username'])) {
echo("Logged in as ".$_SESSION['username']." <a href='/logout'>Logout</a>");

}else {
?>
        Want to join? Log in or sign up in seconds.
<?php
}
?>
    </div>
</div>
