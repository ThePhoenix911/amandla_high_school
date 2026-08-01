<?php include __DIR__ . '/../../view/header_admin.php'; ?>

<div class="container waiting_list">
    <h2>Temporary Lockers</h2>
    <div id="locker_stats">
        <h3>Available Lockers:</h3>
        <div>
            <p>Grade &nbsp;8: <span>&nbsp;<?php echo $grade_8_locker ?? '';?></span></p>
            <p>Grade &nbsp;9: <span>&nbsp;<?php echo $grade_9_locker ?? '';?></span></p>
            <p>Grade 10: <span><?php echo $grade_10_locker ?? '';?></span></p>
            <p>Grade 11: <span><?php echo $grade_11_locker ?? '';?></span></p>
            <p>Grade 12: <span><?php echo $grade_12_locker ?? '';?></span></p>
        </div>
    </div>

    <table id="waiting_table">
        <tr>
            <th>Locker Number</th>
            <th>Student Number</th>
            <th>Student Grade</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Suspend Locker</th>
            <th>Year Locker</th>
        </tr>

        <?php foreach($temp_lockers ?? [] as $locker): ?>
            <tr>
                <td><?php echo $locker['tempLockerNum'];?></td>
                <td><?php echo $locker['studNum'];?></td>
                <td><?php echo $locker['lockerGrade'];?></td>
                <td><?php echo $locker['tempLockerStartDate'];?></td>
                <td><?php echo $locker['tempLockerEndDate'];?></td>
                <td class="td_form">
                    <form action="." method="post" class="unstyle_form">
                        <input type="hidden" name="action" value="suspend_temp_locker">
                        <input type="hidden" name="student_num" value="<?php echo $locker['studNum'];?>">
                        <input type="hidden" name="temp_locker_num" value="<?php echo $locker['tempLockerNum'];?>">
                        <button type="submit" class="btnSubmit <?php echo ($locker['suspension_status'] == Null)? '': 'disable_btn'; ?>">Suspend</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</div>

</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>
