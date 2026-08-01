<?php

class LockerDB
{


    /************************* OUTPUT DATA **************************/

    public static function getLockersByGrade(string $lockerGrade)
    {
        $db = Database::connectToDB();

        $query = 'SELECT * FROM locker WHERE lockerGrade = :locker_grade && lockerStatus = :locker_status';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':locker_grade', $lockerGrade);
            $statement->bindValue(':locker_status', 'available');
            $statement->execute();

            //the FETCH_ASSOC ensures that the record is returned as an associative array
            //the keys are column names which will be used to access the data from each cell
            $locker_record = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $locker_record;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getAvailableLockers()
    {
        $db = Database::connectToDB();

        $query = 'SELECT * FROM locker WHERE lockerStatus = :locker_status';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':locker_status', 'available');
            $statement->execute();

            //the FETCH_ASSOC ensures that the record is returned as an associative array
            //the keys are column names which will be used to access the data from each cell
            $locker_record = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $locker_record;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }



    /************************* INPUT DATA **************************/
    public static function updateLockerStatus(String $locker_num, String $locker_status): string
    {
        $db = Database::connectToDB();

        $query = 'UPDATE locker 
                    SET lockerStatus = :locker_status 
                    WHERE lockerNum = :locker_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':locker_status', $locker_status);
            $statement->bindValue(':locker_num', intval($locker_num));
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return strval($row_count);

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }
}