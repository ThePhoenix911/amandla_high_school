<?php include __DIR__ . '/../../view/header_admin.php'; ?>

<div class="container waiting_list">
    <h2>Locker Payments</h2>
    <table id="waiting_table">
        <tr>
            <th>Payment ID</th>
            <th>Student Number</th>
            <th>Verified</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Outstanding Balance</th>
            <th>Temp Locker Num</th>
        </tr>

        <?php foreach($payments_results ?? [] as $payment): ?>
            <tr>
                <td><?php echo $payment['lockerPaymentID'];?></td>
                <td><?php echo $payment['studNum'];?></td>
                <td><?php echo $payment['paymentVerified'];?></td>
                <td><?php echo $payment['amount'];?></td>
                <td><?php echo $payment['paymentDate'];?></td>
                <td><?php echo $payment['outstandingBalance'];?></td>
                <td><?php echo $payment['tempLockerNum'];?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</div>

</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>
