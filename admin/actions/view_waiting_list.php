<?php include __DIR__ . '/../../view/header_admin.php'; ?>

    <div class="container waiting_list">
        <h2>Locker Waiting List</h2>
        <table id="waiting_table">
            <tr>
                <th>Waiting Number</th>
                <th>Student Number</th>
                <th>Student Grade</th>
                <th>Date</th>
                <th>Remove From List</th>
            </tr>

                <?php foreach($waiting_list?? [] as $list): ?>
                    <tr>
                        <td><?php echo $list['waitingNum'];?></td>
                        <td><?php echo $list['studNum'];?></td>
                        <td><?php echo $list['studGrade'];?></td>
                        <td><?php echo $list['waitingDate'];?></td>
                        <td class="td_form">
                            <form action="." method="post" class="unstyle_form">
                                <input type="hidden" name="action" value="remove_from_waiting_list" />
                                <input type="hidden" name="waiting_num" value="<?php echo $list['waitingNum'];?>">
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
