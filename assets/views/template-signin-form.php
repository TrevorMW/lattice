<div class="loginForm">

    <div class="loginFormHeadings">

    </div>

    <form data-ajax-form data-action="user_login">
        <div data-form-msg></div>

        <div class="formControl">
            <label for="user">Username:</label>
            <div class="formInput">
                <input type="text" name="username" id="user">
            </div>
        </div>
        <div class="formControl">
            <label for="login-password">Password:</label>
            <div class="formInput formInputPasswordWithView">
                <input type="password" name="password" id="login-password">
                <a href="" data-view-password="login-password">
                    <i class="fa fa-fw fa-eye"></i>
                </a>
            </div>
        </div>

        <div class="formControl">
            <a data-forgot-password>Forgot Password?</a>
        </div>
        
        <div class="submitBtnWrap">
            <button type="submit" class="btn btn-primary" data-submit>Sign In</button>
        </div>
    </form>
</div>