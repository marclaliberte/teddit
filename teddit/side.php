<div class="side">
    <div class="spacer">
        <form id="search" action="/">
            <input name="q" placeholder="search" tabindex="20" type="text"></input>
        </form>
    </div>
    <div class="spacer">
<?php
if (!isset($_SESSION['username'])) {
?>
        <form id="login_login-main" class="login-form login-form-side" method="post" action="/login">
            <input name="user" placeholder="username" maxlength="20" tabindex="1" type="text"></input>
            <input name="password" placeholder="password" tabindex="1" type="password"></input>
            <div id="remember-me">
                <input id="rem-login-main" name="rem" tabindex="1" type="checkbox"></input>
                <label for="rem-login-main">remember me</label>
                <a class="recover-password" href="/password">reset password</a>
            </div>
            <div class="submit">
                <button class="btn" type="submit" name="submit" tabindex="1">login</button>
            </div>
            <div class="clear"></div>
        </form>
<?php
}
?>
    </div>
    <div class="spacer">
        <div class="sidebox submit submit-link">
            <div class="morelink">
                <a href="/submit">Submit a new text post</a>
                <div class="nub"></div>
            </div>
        </div>
    </div>
    <div class="spacer">
        <div class="sidebox submit submit-link">
            <div class="morelink">
                <a href="/message">Send a private message</a>
                <div class="nub"></div>
            </div>
        </div>
    </div>
    <div class="spacer">
        <div class="sidebox submit submit-link">
            <div class="morelink">
                <a href="/reset">Reset the database</a>
                <div class="nub"></div>
            </div>
        </div>
    </div>
</div>
