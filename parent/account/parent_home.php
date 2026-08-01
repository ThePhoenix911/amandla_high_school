<?php include __DIR__ . '/../../view/header_parent.php'; ?>

        <h2>Registered Students</h2>
        <table id="waiting_table">
            <tr>
                <th>Student Number</th>
                <th>Full Name</th>
                <th>Grade</th>
                <th>Parent ID</th>
                <th>Cancel Application</th>
            </tr>

            <?php foreach($students ?? [] as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['studNum'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($student['fullName'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($student['studGrade'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($student['parentID'] ?? '');?></td>
                    <td class="td_form">
                        <form action="." method="post" class="unstyle_form">
                            <input type="hidden" name="action" value="cancel_application" />
                            <input type="hidden" name="student_num" value="<?php echo htmlspecialchars($student['studNum'] ?? '');?>">
                            <button type="submit" class="btnSubmit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>
