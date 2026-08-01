<?php include __DIR__ . '/../../view/header.php'; ?>

    <main>
        <!--        Parent Registration Form-->
        <form action="." method="post" id="parent_register">
            <!--            Each elements group will be viewed sequentially -->
            <h2>Register Parent</h2>
            <input type="hidden" name="action" value="parent_register">

            <fieldset>
                <?php if(!empty($error_message)): ?>
                    <span id="parent_error" class="error"><?php echo htmlspecialchars($error_message); ?></span>
                <?php endif; ?>

                <label for="parent_id">ID Number:</label>
                <input type="text" id="parent_id" name="parent_id" placeholder="ID Number" value="<?php echo htmlspecialchars($parent_id ?? '')?>" maxlength="13">
                <br>

                <label for="parent_title">Title:</label>
                <input type="text" id="parent_title" name="parent_title" placeholder="Mr/Mrs/Ms" value="<?php echo htmlspecialchars($parent_title ?? '')?>" maxlength="8">
                <br>

                <label for="parent_fName">First Name:</label>
                <input type="text" id="parent_fName" name="parent_fName" placeholder="First Name" value="<?php echo htmlspecialchars($parent_fName ?? '')?>" maxlength="60">
                <br>

                <label for="parent_lName">Last Name:</label>
                <input type="text" id="parent_lName" name="parent_lName" placeholder="Last Name" value="<?php echo htmlspecialchars($parent_lName ?? '')?>" maxlength="60">
                <br>


                <label for="parent_email">Email:</label>
                <input type="email" id="parent_email" name="parent_email" placeholder="Email" value="<?php echo htmlspecialchars($parent_email ?? '')?>" maxlength="255">
                <br>

                <label for="parent_house">House Number:</label>
                <input type="text" id="parent_house" name="parent_house" placeholder="House Number" value="<?php echo htmlspecialchars($parent_house ?? '')?>" maxlength="10">
                <br>

                <label for="parent_street">Street Name:</label>
                <input type="text" id="parent_street" name="parent_street" placeholder="Street Name" value="<?php echo htmlspecialchars($parent_street ?? '')?>" maxlength="60">
                <br>

                <label for="parent_city">City:</label>
                <input type="text" id="parent_city" name="parent_city" placeholder="City" value="<?php echo htmlspecialchars($parent_city ?? '')?>" maxlength="60">
                <br>

                <label for="parent_postal">Postal Code:</label>
                <input type="text" id="parent_postal" name="parent_postal" placeholder="Postal Code" value="<?php echo htmlspecialchars($parent_postal ?? '')?>" maxlength="10">
                <br>

                <label for="parent_phone">Phone:</label>
                <input type="tel" id="parent_phone" name="parent_phone" placeholder="0798654321" value="<?php echo htmlspecialchars($parent_phone ?? '')?>" maxlength="10">
                <br>

                <label for="parent_password1">Password:</label>
                <div id="password_eye">
                    <input type="password" id="parent_password1" name="parent_password1" placeholder="Password" value="<?php echo htmlspecialchars($parent_password1 ?? '')?>" maxlength="255">
                    <i class="fas fa-eye-slash" onclick="toggle_password()"></i>
                </div>
                <br>

                <label for="parent_password2">Confirm Password:</label>
                <input type="password" id="parent_password2" name="parent_password2" placeholder="Confirm Password" value="<?php echo htmlspecialchars($parent_password2 ?? '')?>" maxlength="255">


            </fieldset>

            <input type="submit" value="Register" class="btnSubmit">
            <p>Already have an account? <a href="?action=parent_login_form" title="Login in to Admin account">Login</a></p>
            <p style="margin-top: 0.8rem;"><a href="/" title="Return to Main Page"><i class="fa-solid fa-arrow-left"></i> Back to Main Page</a></p>

        </form>

    </main>
<?php include __DIR__ . '/../../view/footer.php'; ?>
