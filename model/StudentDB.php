<?php

class StudentDB
{


    //OUTPUT DATA

    public static function getStudent(string $studentNum)
    {
        $db = Database::connectToDB();

        $query = 'SELECT * FROM student WHERE studNum = :stud_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':stud_num', $studentNum);
            $statement->execute();

            //the FETCH_ASSOC ensures that the record is returned as an associative array
            //the keys are column names which will be used to access the data from each cell
            $student_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $student_record;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getStudentsByParentID(string $parentID)
    {
        $db = Database::connectToDB();
        $query = "SELECT studNum, CONCAT(studFName, ' ', studLName) AS fullName, studGrade, parentID
                    FROM student 
                    WHERE parentID = :parent_id";

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':parent_id', $parentID);
            $statement->execute();
            $students_record = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $students_record;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //INPUT DATA
    public static function addStudent(Student $student): string
    {
        $db = Database::connectToDB();

        $query = 'INSERT INTO student (studNum, studFName, studLName, studGrade, parentID)
                    VALUES (:stud_num, :stud_fName, :stud_lName, :stud_grade, :parent_id)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':stud_num', $student->getStudentNum());
            $statement->bindValue(':stud_fName', $student->getStudentFName());
            $statement->bindValue(':stud_lName', $student->getStudentLName());
            $statement->bindValue(':stud_grade', $student->getStudentGrade());
            $statement->bindValue(':parent_id', $student->getParentID());
            $statement->execute();
            $statement->closeCursor();

            return $student->getStudentNum();

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public static function updateStudent(Student $student): string
    {
        $db = Database::connectToDB();
        $query = 'UPDATE student
                    SET 
                        studFName = :stud_fName, 
                        studLName = :stud_lName, 
                        studGrade = :stud_grade,
                        parentID = :parent_id
                    WHERE studNum = :stud_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':stud_num', $student->getStudentNum());
            $statement->bindValue(':stud_fName', $student->getStudentFName());
            $statement->bindValue(':stud_lName', $student->getStudentLName());
            $statement->bindValue(':stud_grade', $student->getStudentGrade());
            $statement->bindValue(':parent_id', $student->getParentID());
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return strval($row_count);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function deleteStudent(String $student_num): int|string
    {
        $db = Database::connectToDB();

        $query = 'DELETE FROM student WHERE studNum = :stud_num';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':stud_num', $student_num);
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();

            return $row_count;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}