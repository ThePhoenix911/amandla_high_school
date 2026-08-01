<?php include __DIR__ . '/../../view/header.php'; ?>

<main>
    <form action="." method="post">
        <h2><i class="fa-solid fa-user-tie"></i>Login Admin</h2>
        <input type="hidden" name="action" value="admin_login">
        <fieldset>
            <?php if(!empty($error_message)): ?>
                <span class="error"><?php echo htmlspecialchars($error_message); ?></span>
            <?php endif; ?>

            <label for="admin_email">Email:</label>
            <input type="email" id="admin_email" name="admin_email" value="<?php if(isset($admin_email)) echo $admin_email; ?>" maxlength="255" placeholder="Email">
            <br>

            <label for="admin_password1">Password:</label>
            <div id="password_eye">
                <input type="password" id="admin_password1" name="admin_password1" placeholder="Password" value="<?php if(isset($admin_password1)) echo $admin_password1; ?>" maxlength="255">
                <i class="fas fa-eye-slash" onclick="toggle_password()"></i>
            </div>

        </fieldset>

        <input type="submit" value="Login" class="btnSubmit">
        <p>Don't have an account? <a href="?action=admin_register_form" title="Create a new Admin account">Sign Up</a></p>
        <p style="margin-top: 0.8rem;"><a href="/" title="Return to Main Page"><i class="fa-solid fa-arrow-left"></i> Back to Main Page</a></p>
    </form>

</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>