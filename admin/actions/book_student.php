<?php include __DIR__ . '/../../view/header_admin.php'; ?>
<?php include __DIR__ . '/../../view/form_step_indicators.php'; ?>

<?php if(!isset($_SESSION['stud_num'])): ?>
    <form action="." method="post" id="link_student">
        <input type="hidden" name="action" value="link_student">
        <h2>Link Student to Booking Process</h2>
        <div id="link_student_header">
            <div>
                <label for="link_student_num">Student Number:</label>
                <span class="error"><?php if(isset($error_message)) echo $error_message; ?></span>
            </div>
            <input type="text" id="link_student_num" name="link_student_num" placeholder="Student Number" value="<?php echo htmlspecialchars($link_student_num ?? '')?>" maxlength="6">
        </div>
        <br>
        <input type="submit" value="Link Student" class="btnSubmit">
    </form>

<?php endif;?>

<?php if(isset($_SESSION['stud_num'])): ?>
    <h2>Student Booking Details</h2>
    <br>
    <div id="stud_details">
        <p>Student Number: <?php echo htmlspecialchars($student_num ?? '');?></p>
        <p>Student Full Name: <?php echo htmlspecialchars($student_fName ?? '');?></p>
        <p>Grade: <?php echo htmlspecialchars(substr($student_grade ?? '', 5));?></p>
        <p>Has Locker: <?php echo htmlspecialchars($has_locker ?? '');?></p>
        <p>On Waiting List: <?php echo htmlspecialchars($on_waiting_list ?? '');?></p>
    </div>

    <div id="locker">

        <?php if(isset($lockers) && count($lockers) > 0): ?>
            <h2>Available Grade <?php echo htmlspecialchars(substr($student_grade ?? '', 5));?> Lockers</h2>

            <table>
                <tr>
                    <th>Locker ID</th>
                    <th>Grade</th>
                    <th>Temporarily</th>
                </tr>
                <?php foreach($lockers as $locker): ?>
                    <tr>
                        <td><?php echo $locker['lockerNum'];?></td>
                        <td><?php echo $locker['lockerGrade'];?></td>
                        <td class="td_form">
                            <form action="." method="post" class="unstyle_form">
                                <input type="hidden" name="action" value="assign_temp_locker">
                                <input type="hidden" name="locker_num" value="<?php echo $locker['lockerNum'];?>">

                                <button type="submit" class="btnSubmit <?php if($has_locker == 'Yes') echo 'disable_btn'; ?>">Assign Locker</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <div id="waiting_list">
                <h2>Grade <?php echo substr($student_grade ?? '', 5) ?> lockers are fully booked</h2>
                <form action="." method="post">
                    <input type="hidden" name="action" value="place_on_waiting_list">
                    <label for="submit">Place Student on waiting list</label>
                    <input type="submit" value="Place Student" class="btnSubmit">
                    <span class="error"><?php if(isset($error_message)) echo $error_message; ?></span>
                </form>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>

</div>
</div>

</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>
