<?php

class YearLockerDB
{


    /************************* OUTPUT DATA **************************/
    public static function getYearLockers()
    {
        $db = Database::connectToDB();

        $query = 'SELECT * FROM yearlocker';

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

    public static function getYearLockerByStudNum(string $student_num)
    {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM yearlocker WHERE studNum = :student_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':student_num', $student_num);
            $statement->execute();
            $locker = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $locker;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }



    /************************* INPUT DATA **************************/
    public static function addYearLocker(String $student_num, $temp_locker_num): string
    {
        $db = Database::connectToDB();

        $query = 'INSERT INTO yearlocker (yearLockerAssignedDate, studNum, tempLockerNum) 
                    VALUES (NOW(), :student_num, :locker_num)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':student_num', $student_num);
            $statement->bindValue(':locker_num', intval($temp_locker_num));
            $statement->execute();
            $locker_num = $db->lastInsertId();
            $statement->closeCursor();
            return strval($locker_num);

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public static function deleteYearLocker($student_num): String
    {
        $db = Database::connectToDB();

        $query = 'DELETE FROM yearlocker WHERE studNum = :student_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':student_num', $student_num);
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return strval($row_count);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}