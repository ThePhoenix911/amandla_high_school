<?php include __DIR__ . '/../../view/header_admin.php'; ?>

<div class="container waiting_list">
    <h2>Suspended Lockers</h2>

    <table id="waiting_table">
        <tr>
            <th>Student Number</th>
            <th>Full Name</th>
            <th>Suspension ID</th>
            <th>Date</th>
            <th>Reason</th>
            <th>Temporary Locker</th>
            <th>Remove</th>
        </tr>

        <?php foreach($suspended_lockers ?? [] as $locker): ?>
            <tr>
                <td><?php echo $locker['studNum'];?></td>
                <td><?php echo $locker['fullName'];?></td>
                <td><?php echo $locker['suspensionID'];?></td>
                <td><?php echo $locker['suspensionDate'];?></td>
                <td><?php echo $locker['suspensionReason'];?></td>
                <td><?php echo $locker['tempLockerNum'];?></td>
                <td class="td_form">
                    <form action="." method="post" class="unstyle_form">
                        <input type="hidden" name="action" value="unsuspend_temp_locker">
                        <input type="hidden" name="student_num" value="<?php echo $locker['studNum'];?>">
                        <input type="hidden" name="locker_num" value="<?php echo $locker['tempLockerNum'];?>">
                        <button type="submit" class="btnSubmit">Remove</button>
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>
</div>

</div>

</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>
