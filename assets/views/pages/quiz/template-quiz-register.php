<form data-ajax-form data-no-progress data-action="aenea_quiz">
    <div data-form-msg></div>

    <input type="hidden" name="subaction" value="register" />

    <div class="formControl half">
        <label for="first">First Name:</label>
        <div class="formInput">
            <input type="text" name="first_name" id="first" placeholder="First Name" required
                pattern="^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$" tabindex="1">
        </div>
    </div>

    <div class="formControl half last">
        <label for="Last">Last Name:</label>
        <div class="formInput">
            <input type="text" name="last_name" id="last" placeholder="Last Name" required
                pattern="^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$" tabindex="2">
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

    <div class="formControl half">
        <label for="city">City:</label>
        <div class="formInput">
            <input type="text" name="city" id="city" tabindex="7" placeholder="City">
        </div>
    </div>

    <div class="formControl half last">
        <label for="state">State:</label>
        <div class="formInput">
            <select type="text" name="state" id="state" tabindex="8">
                <option value="">State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
        </div>
    </div>

    

    <div class="formControl half">
        <label for="high_school">High School:</label>
        <div class="formInput">
            <input type="text" name="high_school" id="high_school" tabindex="9" placeholder="High School">
        </div>
    </div>

    <div class="formControl half last">
        <label for="coupon">Coupon Code: <span data-validation-msg></span></label>
        <div class="formInput formInputCouponCode">
            <i data-coupon-code-loader class="fa fa-fw fa-spin fa-spinner"></i>
            <input type="text" name="coupon" id="coupon" tabindex="" data-program-coupon-code=""
                data-program-coupon-product-id="4789"
                data-program-coupon-nonce="<?php echo wp_create_nonce('mepr_coupons'); ?>" pattern="[a-zA-Z0-9]+"
                placeholder="Coupon Code">
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
            <div>I certify that I am age 18 or over. If I am between the ages of 13-17, I am using this website with
                parental or guardian permission.</div>
        </label>
    </div>


    <div class="submitButton">
        <button type="submit" class="btn btn-primary btn-small" data-submit>Submit</button>
    </div>
</form>