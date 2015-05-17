<div id="LoginPopup">
    <form method="post" id="LoginPopupForm" class="std" action="http://www.realprestashopmodules.com/en/authentication">
        <fieldset>
            <h3 id="LoginPopupTitle">Login</h3>

            <div id="LoginPopupError">
            </div>
            <p class="text">
                <label for="email">E-mail</label>
                <input type="text" id="LoginPopupEmail" name="email" value="" class="text">
            </p>

            <p class="text">
                <label for="passwd">Password</label>
                <input type="password" id="LoginPopupPasswd" name="passwd" value="" class="text">
            </p>

            {*<p class="text1">*}
            {*<label>&nbsp;</label>*}

            {*</p>*}
            <p class="submit">
                <input type="button" id="SubmitLoginPopup" name="SubmitLoginPopup" class="button submit_login_button"
                       onclick="submitLogin()" value="LOGIN"> <span class="text"><a href="/password-recovery">Forgot your
                        password?</a></span>
            </p>

            <p class="account-register-block">
            <span class="new-account-text">Don't have an account? <a href="/my-account">Create One!</a></span>
            </p>
        </fieldset>
    </form>
</div>