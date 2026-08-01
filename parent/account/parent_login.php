<?php include __DIR__ . '/../../view/header.php'; ?>

    <main>
        <form action="." method="post">
            <h2><i class="fa-solid fa-user"></i>Login Parent</h2>
            <input type="hidden" name="action" value="parent_login">
            <fieldset>
                <span class="error"><?php if(isset($error_message)) echo $error_message; ?></span><br><br>

                <label for="parent_email">Email:</label>
                <input type="email" id="parent_email" name="parent_email" value="<?php echo htmlspecialchars($parent_email ?? '')?>" maxlength="255" placeholder="Email">
                <br>

                <label for="parent_password1">Password:</label>
                <div id="password_eye">
                    <input type="password" id="parent_password1" name="parent_password1" placeholder="Password" value="<?php echo htmlspecialchars($parent_password1 ?? '')?>" maxlength="255">
                    <i class="fas fa-eye-slash" onclick="toggle_password()"></i>
                </div>

            </fieldset>

            <input type="submit" value="Login" class="btnSubmit">
            <p>Don't have an account? <a href="?action=parent_register_form" title="Create a new Admin account">Sign Up</a></p>
            <p style="margin-top: 0.8rem;"><a href="/" title="Return to Main Page"><i class="fa-solid fa-arrow-left"></i> Back to Main Page</a></p>
        </form>

    </main>

<?php include __DIR__ . '/../../view/footer.php'; ?>