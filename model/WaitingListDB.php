<?php

class WaitingListDB
{


    /************************* OUTPUT DATA **************************/
    public static function getList()
    {
        $db = Database::connectToDB();

        $query = 'SELECT * FROM waitinglist';

        try {
            $statement = $db->prepare($query);
            $statement->execute();

            //the FETCH_ASSOC ensures that the record is returned as an associative array
            //the keys are column names which will be used to access the data from each cell
            $list_records = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $list_records;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getListWithGrades()
    {
        $db = Database::connectToDB();

        $query = 'SELECT w.*, s.studGrade 
                    FROM waitinglist AS w
                        INNER JOIN student AS s
                            ON w.studNum = s.studNum
                    ORDER BY w.waitingNum';

        try {
            $statement = $db->prepare($query);
            $statement->execute();

            //the FETCH_ASSOC ensures that the record is returned as an associative array
            //the keys are column names which will be used to access the data from each cell
            $list_records = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $list_records;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public static function getListByStudNum(string $studNum)
    {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM waitinglist WHERE studNum = :stud_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':stud_num', $studNum);
            $statement->execute();
            $list_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $list_record;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getListByWaitingNum(string $waitingNum)
    {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM waitinglist WHERE waitingNum = :waiting_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':waiting_num', $waitingNum);
            $statement->execute();
            $list_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $list_record;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Checks the Students on the waiting list by grade
    public static function getListByGrade(string $studentGrade)
    {
        $db = Database::connectToDB();
        $query = 'SELECT w.*, s.studGrade
                  FROM waitinglist AS w
                      INNER JOIN student AS s ON w.studNum = s.studNum
                  WHERE s.studGrade = :student_grade
                  ORDER BY w.waitingNum;';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':student_grade', $studentGrade);
            $statement->execute();
            $list_record = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $list_record;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getListByStudentNum(string $studentGrade)
    {
        return self::getListByGrade($studentGrade);
    }



    /************************* INPUT DATA **************************/
    public static function addToList(String $student_num): string
    {
        $db = Database::connectToDB();

        $query = 'INSERT INTO waitinglist (studNum)
                    VALUES (:stud_num)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':stud_num', $student_num);
            $statement->execute();
            $waitingNum = $db->lastInsertId();
            $statement->closeCursor();
            return $waitingNum;

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public static function removeFromList($waiting_num): int
    {
        $db = Database::connectToDB();

        $query = 'DELETE FROM waitinglist WHERE waitingNum = :waiting_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':waiting_num', $waiting_num);
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();

            return $row_count;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}