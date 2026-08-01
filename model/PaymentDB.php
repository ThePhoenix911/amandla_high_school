<?php

class PaymentDB
{


    /************************* OUTPUT DATA **************************/
    public static function getLockerPayments()
    {
        $db = Database::connectToDB();

        $query = "SELECT * FROM lockerpayment";

        try {
            $statement = $db->prepare($query);
            $statement->execute();

            //the FETCH_ASSOC ensures that the record is returned as an associative array
            //the keys are column names which will be used to access the data from each cell
            $lockers = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $lockers;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }



    /************************* INPUT DATA **************************/
    public static function addLockerPayment(String $student_num, String $payment_verified, String $payment_amount,
                                            String $payment_date, String $outstanding_balance, String $temp_locker_num): string
    {
        $db = Database::connectToDB();

        $query = 'INSERT INTO lockerpayment (studNum, paymentVerified, amount, 
                           paymentDate, outstandingBalance, tempLockerNum)
                    VALUES (:student_num, :payment_verified, :amount, 
                            :payment_date, :outstanding_balance, :temp_locker_num)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':student_num', $student_num);
            $statement->bindValue(':payment_verified', $payment_verified ? 1 : 0, PDO::PARAM_INT);
            $statement->bindValue(':amount', $payment_amount);
            $statement->bindValue(':payment_date', $payment_date);
            $statement->bindValue(':outstanding_balance', $outstanding_balance);
            $statement->bindValue(':temp_locker_num', intval($temp_locker_num));
            $statement->execute();
            $payment_id = $db->lastInsertId();
            $statement->closeCursor();
            return strval($payment_id);

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }
}