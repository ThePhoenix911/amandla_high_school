<?php

class TempLockerDB
{


    /************************* OUTPUT DATA **************************/
    public static function getTempLockers()
    {
        $db = Database::connectToDB();

        $query = "SELECT t.tempLockerNum, t.studNum, l.lockerGrade, t.tempLockerStartDate, t.tempLockerEndDate, ls.tempLockerNum AS 'suspension_status'
                FROM templocker AS t
                INNER JOIN locker AS l ON t.lockerNum = l.lockerNum
                LEFT JOIN lockersuspension AS ls ON t.tempLockerNum = ls.tempLockerNum";

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


    public static function getTempLockerByStudNum(string $student_num)
    {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM templocker WHERE studNum = :student_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':student_num', $student_num);
            $statement->execute();
            $temp_locker = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $temp_locker;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }



    /************************* INPUT DATA **************************/
    public static function addTempLocker(String $student_num, String $locker_num): string
    {
        $db = Database::connectToDB();

        $query = 'INSERT INTO templocker (studNum, lockerNum)
                    VALUES (:student_num, :locker_num)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':student_num', intval($student_num));
            $statement->bindValue(':locker_num', intval($locker_num));
            $statement->execute();
            $temp_locker_num = $db->lastInsertId();
            $statement->closeCursor();
            return $temp_locker_num;

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public static function deleteTempLocker($student_num): String
    {
        $db = Database::connectToDB();

        $query = 'DELETE FROM templocker WHERE studNum = :stud_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':stud_num', $student_num);
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return strval($row_count);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}