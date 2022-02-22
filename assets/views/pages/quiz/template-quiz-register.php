<form data-ajax-form data-action="aenea_quiz">
    <div data-form-msg></div>

    <input type="hidden" name="subaction" value="register" />

    <div class="formControl half">
        <label for="first">First Name:</label>
        <div class="formInput">
            <input type="text" name="first_name" id="first" placeholder="First Name" required pattern="[a-zA-Z0-9]+" tabindex="1">
        </div>
    </div>

    <div class="formControl half last">
        <label for="Last">Last Name:</label>
        <div class="formInput">
            <input type="text" name="last_name" id="last" placeholder="Last Name" required pattern="[a-zA-Z0-9]+" tabindex="2">
        </div>
    </div>

    <div class="formControl">
        <label for="email">Email Address:</label>
        <div class="formInput">
            <input type="email" name="email" id="email" placeholder="example.email@site.com" required tabindex="3">
        </div>
    </div>

    <div class="formControl half">
        <label for="login-password">Password:</label>
        <div class="formInput formInputPasswordWithView">
            <input type="password" name="password" id="login-password" required tabindex="5">
            <a href="" data-view-password="login-password">
                <i class="fa fa-fw fa-eye"></i>
            </a>
        </div>
    </div>

    <div class="formControl half last">
        <label for="password-confirm">Password:</label>
        <div class="formInput formInputPasswordWithView">
            <input type="password" name="confirm" id="password-confirm" tabindex="6">
            <a href="" data-view-password="password-confirm">
                <i class="fa fa-fw fa-eye"></i>
            </a>
        </div>
    </div>

    <div class="formControl formControlCheckbox">
         <label for="register_newsletter">
            <div><input type="checkbox" name="newsletter_signup" id="register_newsletter" tabindex="7"></div>
            <div>Please sign me up for Lattice Climbers’ newsletter!</div>
        </label>
    </div>

    <div class="formControl formControlCheckbox">
         <label for="age_certification">
            <div><input type="checkbox" name="age_certification" id="age_certification" required tabindex="8"></div>
            <div>I certify that I am age 18 or over. If I am between the ages of 13-17, I am using this website with parental or guardian permission.</div>
        </label>
    </div>

    <div class="submitButton">
        <button type="submit" class="btn btn-primary btn-small" data-submit>Submit</button>
    </div>
</form>