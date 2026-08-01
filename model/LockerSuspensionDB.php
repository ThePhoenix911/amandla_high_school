<?php

class LockerSuspensionDB
{


    /************************* OUTPUT DATA **************************/
    public static function getSuspendedLockers()
    {
        $db = Database::connectToDB();

        $query = "SELECT  s.studNum, CONCAT(s.studFName, ' ', s.studLName) AS fullName, ls.* 
                    FROM lockersuspension AS ls
                    INNER JOIN templocker AS t
                        ON ls.tempLockerNum = t.tempLockerNum
                    INNER JOIN student AS s
                        ON t.studNum = s.studNum";

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

    public static function getSuspensionStatus()
    {
        $db = Database::connectToDB();

        $query = "SELECT t.tempLockerNum AS 'temp_lockernum', l.tempLockerNum AS 'sus_lockernum'
                    FROM templocker AS t
                    LEFT JOIN lockersuspension AS l 
                        ON t.tempLockerNum = l.tempLockerNum
                    ORDER BY t.tempLockerNum";

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
    public static function addLockerSuspension(String $suspension_reason, String $temp_locker_num): string
    {
        $db = Database::connectToDB();

        $query = 'INSERT INTO lockersuspension (suspensionReason, tempLockerNum)
                    VALUES (:reason, :locker_num)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':reason', $suspension_reason);
            $statement->bindValue(':locker_num', intval($temp_locker_num));
            $statement->execute();
            $temp_locker_num = $db->lastInsertId();;
            $statement->closeCursor();
            return $temp_locker_num;

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public static function removeLockerSuspension($temp_locker_num): String
    {
        $db = Database::connectToDB();

        $query = 'DELETE FROM lockersuspension WHERE tempLockerNum = :temp_locker_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':temp_locker_num', $temp_locker_num);
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return strval($row_count);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}