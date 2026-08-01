<?php include __DIR__ . '/../../view/header_admin.php'; ?>
<?php include __DIR__ . '/../../view/form_step_indicators.php'; ?>


        <!--        Student Registration Form-->
        <form action="." method="post" id="register_student">
            <h2>Register Student</h2>
            <input type="hidden" name="action" value="register_student">
            <fieldset>
                <?php if(!empty($error_message)): ?>
                    <span class="error"><?php echo htmlspecialchars($error_message); ?></span>
                <?php endif; ?>

                <label for="student_parent_id">Parent's ID Number:</label>
                <input type="text" id="student_parent_id" name="student_parent_id" placeholder="ID Number" value="<?php echo htmlspecialchars($student_parent_id ?? '')?>" maxlength="13">
                <br>

                <label for="student_num">Student Number:</label>
                <input type="text" id="student_num" name="student_num" placeholder="Student Number" value="<?php echo htmlspecialchars($student_num ?? '')?>" maxlength="6">
                <br>

                <label for="student_fName">First Name:</label>
                <input type="text" id="student_fName" name="student_fName" placeholder="First Name" value="<?php echo htmlspecialchars($student_fName ?? '')?>" maxlength="60">
                <br>

                <label for="student_lName">Last Name:</label>
                <input type="text" id="student_lName" name="student_lName" placeholder="Last Name" value="<?php echo htmlspecialchars($student_lName ?? '')?>" maxlength="60">
                <br>

                <label for="student_grade">Grade:</label>
                <input type="text" id="student_grade" name="student_grade" placeholder="Grade 8" value="<?php echo htmlspecialchars($student_grade ?? '')?>" maxlength="8">
                <br>

            </fieldset>
            <input type="submit" value="Register" class="btnSubmit">

        </form>

        </div>
    </div>

</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>
