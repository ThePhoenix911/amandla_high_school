<?php include __DIR__ . '/../../view/header_admin.php'; ?>

<!--        Parent Registration Form-->
<br><br><br><br>
<form action="." method="post" id="register_payment">
    <!--            Each elements group will be viewed sequentially -->
    <h2>Locker Payment</h2>
    <input type="hidden" name="action" value="add_payment">

    <fieldset>
        <span id="payment_error" class="error"><?php if(isset($error_message)) echo $error_message; ?></span><br><br>

        <label for="pay_stud_num">Student Number:</label>
        <input type="text" id="pay_stud_num" name="pay_stud_num" placeholder="Student Number" value="<?php echo htmlspecialchars($pay_stud_num ?? '')?>" maxlength="13">
        <br>

        <label for="pay_verified">Payment Verified:</label>
        <input type="text" id="pay_verified" name="pay_verified" placeholder="True" value="<?php echo htmlspecialchars($pay_verified ?? '')?>" maxlength="5">
        <br>

        <label for="pay_amount">Amount:</label>
        <input type="text" id="pay_amount" name="pay_amount" placeholder="Amount" value="<?php echo htmlspecialchars($pay_amount ?? '')?>" maxlength="3">
        <br>

        <label for="pay_date">Pay Date:</label>
        <input type="date" id="pay_date" name="pay_date" placeholder="Date" value="<?php echo htmlspecialchars($pay_date ?? '')?>">
        <br>


        <label for="pay_balance">Outstanding Balance:</label>
        <input type="text" id="pay_balance" name="pay_balance" placeholder="Balance" value="<?php echo htmlspecialchars($pay_balance ?? '')?>" maxlength="3">
        <br>

        <label for="pay_locker">Temp Locker Num:</label>
        <input type="text" id="pay_locker" name="pay_locker" placeholder="Locker Number" value="<?php echo htmlspecialchars($pay_locker ?? '')?>" maxlength="10">
        <br>
    </fieldset>

    <input type="submit" value="Register" class="btnSubmit">
</form>


</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>
