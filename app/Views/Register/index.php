<div class="container">
    <?php if (!empty($errors))
        foreach ($errors as $error)
            echo '<div class="col"><div class="alert alert-danger">' . $error . '</div></div>';
    ?>
    <form name="registerForm" action="index.php?controller=register&action=register" method="post" onsubmit="return validateRegisterForm()">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" maxlength="35" minlength="2" required />
            <div id="firstNameFeedback" class="invalid-feedback" style="display:none;">
              First name must be between 2 and 35 characters in length.
            </div>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" maxlength="35" minlength="2" required />
            <div id="lastNameFeedback" class="invalid-feedback" style="display:none;">
              Last name must be between 2 and 35 characters in length.
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required />
            <div id="emailFeedback" class="invalid-feedback" style="display:none;">
              Email address is not valid.
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" minlength="8" required />
            <div id="passwordFeedback" class="invalid-feedback" style="display:none;">
              Password must be at least 8 characters long.
            </div>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" minlength="8" required />
            <div id="confirmPasswordFeedback" class="invalid-feedback" style="display:none;">
              Entered passwords do not match.
            </div>
        </div>
        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6LfG23UUAAAAAHesMKbBefbJr4Kv8_PXknxN2AUR"></div>
            <div id="recaptchaFeedback" class="invalid-feedback" style="display:none;">
              Please verify that you are not a robot.
            </div>
        </div>
        <button id="submit" type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="public/js/validator.js"></script>
