<?php include __DIR__ . '/../../view/header.php'; ?>

<main>
    <form action="." method="post">
        <h2>Register Admin</h2>
        <input type="hidden" name="action" value="admin_register">
        <fieldset>
            <span class="error"><?php if(isset($error_message)) echo $error_message; ?></span><br><br>

            <label for="admin_fName">First Name:</label>
            <input type="text" id="admin_fName" name="admin_fName" placeholder="First Name" value="<?php echo htmlspecialchars($admin_fName ?? '')?>" maxlength="60">
            <br>

            <label for="admin_lName">Last Name:</label>
            <input type="text" id="admin_lName" name="admin_lName" placeholder="Last Name" value="<?php echo htmlspecialchars($admin_lName ?? '')?>" maxlength="60">
            <br>


            <label for="admin_email">Email:</label>
            <input type="email" id="admin_email" name="admin_email" placeholder="Email" value="<?php echo htmlspecialchars($admin_email ?? '')?>" maxlength="255">
            <br>

            <label for="admin_phone">Phone:</label>
            <input type="tel" id="admin_phone" name="admin_phone" placeholder="Phone" value="<?php echo htmlspecialchars($admin_phone ?? '')?>" maxlength="10">
            <br>

            <label for="admin_password1">Password:</label>
            <div id="password_eye">
                <input type="password" id="admin_password1" name="admin_password1" placeholder="Password" value="<?php echo htmlspecialchars($admin_password1 ?? '')?>" maxlength="255">
                <i class="fas fa-eye-slash" onclick="toggle_password()"></i>
            </div>
            <br>

            <label for="admin_password2">Confirm Password:</label>
            <input type="password" id="admin_password2" name="admin_password2" placeholder="Confirm Password" value="<?php echo htmlspecialchars($admin_password2 ?? '')?>" maxlength="255">


        </fieldset>

        <input type="submit" value="Register" class="btnSubmit">
        <p>Already have an account? <a href="?action=admin_login_form" title="Login in to Admin account">Login</a></p>
        <p style="margin-top: 0.8rem;"><a href="/" title="Return to Main Page"><i class="fa-solid fa-arrow-left"></i> Back to Main Page</a></p>

    </form>
</main>


<?php include __DIR__ . '/../../view/footer.php'; ?>