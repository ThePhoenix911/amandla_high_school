<?php

class StudentParentDB
{

    /***************** PARENT *****************/

    //OUTPUT DATA
    public static function getParent(String $email) {
        $db = Database::connectToDB();

        $query = 'SELECT * FROM parent WHERE parentEmail = :email';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->execute();

            //the FETCH_ASSOC ensures that the record is returned as an associative array
            //the keys are column names which will be used to access the data from each cell
            $parent_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $parent_record;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function getParentByID(String $parentID)
    {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM parent WHERE parentID = :parent_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':parent_id', $parentID);
            $statement->execute();
            $parent_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $parent_record;

        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function getParentByPhone(String $parentPhoneNum)
    {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM parent WHERE parentPhoneNum = :parent_phone';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':parent_phone', $parentPhoneNum);
            $statement->execute();

            $parent_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $parent_record;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    //INPUT DATA
    public static function addParent(StudentParent $parent): string
    {
        $db = Database::connectToDB();

        $query = 'INSERT INTO parent (parentID, parentTitle, parentFName, parentLName, parentEmail, 
                    parentHouseNum, parentStreetName, parentCity, parentPostalCode, parentPhoneNum)
                    VALUES (:parent_id, :parent_title, :parent_fName, :parent_lName, :parent_email, 
                            :parent_house, :parent_street, :parent_city, :parent_postal, :parent_phone)';


        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':parent_id', $parent->getparentID());
            $statement->bindValue(':parent_title', $parent->getParentTitle());
            $statement->bindValue(':parent_fName', $parent->getparentFName());
            $statement->bindValue(':parent_lName', $parent->getparentLName());
            $statement->bindValue(':parent_email', $parent->getparentEmail());
            $statement->bindValue(':parent_house', $parent->getParentHouse());
            $statement->bindValue(':parent_street', $parent->getParentStreet());
            $statement->bindValue(':parent_city', $parent->getparentCity());
            $statement->bindValue(':parent_postal', $parent->getParentPostal());
            $statement->bindValue(':parent_phone', $parent->getparentPhone());
            $statement->execute();
            $statement->closeCursor();

            return $parent->getParentID();

        }catch (PDOException $e){
            return $e->getMessage();
        }

    }

    public static function updateParent(StudentParent $parent): string
    {
        $db = Database::connectToDB();
        $query = 'UPDATE parent
                    SET 
                        parentTitle = :parent_title, 
                        parentFName = :parent_fName, 
                        parentLName = :parent_lName, 
                        parentEmail = :parent_email,
                        parentHouseNum = :parent_house, 
                        parentStreetName = :parent_street, 
                        parentCity = :parent_city, 
                        parentPostalCode = :parent_postal, 
                        parentPhoneNum = :parent_phone
                    WHERE parentID = :parent_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':parent_id', $parent->getparentID());
            $statement->bindValue(':parent_title', $parent->getParentTitle());
            $statement->bindValue(':parent_fName', $parent->getparentFName());
            $statement->bindValue(':parent_lName', $parent->getparentLName());
            $statement->bindValue(':parent_email', $parent->getparentEmail());
            $statement->bindValue(':parent_house', $parent->getParentHouse());
            $statement->bindValue(':parent_street', $parent->getParentStreet());
            $statement->bindValue(':parent_city', $parent->getparentCity());
            $statement->bindValue(':parent_postal', $parent->getParentPostal());
            $statement->bindValue(':parent_phone', $parent->getparentPhone());
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return strval($row_count);
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function deleteParent(StudentParent $parent): int|string
    {
        $db = Database::connectToDB();

        $query = 'DELETE FROM parent WHERE parentID = :parent_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':parent_id', $parent->getparentID());
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();

            return $row_count;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }



    /***************** PARENT USER *****************/

    //OUTPUT DATA
    public static function getParentUser(String $user_email) {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM parentuser WHERE parentUserEmail = :email';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':email', $user_email);
            $statement->execute();
            $user_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $user_record;

        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function getParentUserByID(Int $user_id) {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM parentuser WHERE parentUserID = :user_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $user_id);
            $statement->execute();

            $user_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $user_record;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }


    //INPUT DATA
    public static function addParentUser(User $user): string
    {
        $db = Database::connectToDB();
        $hash = password_hash($user->getUserPassword(), PASSWORD_DEFAULT);

        $query = 'INSERT INTO parentuser (parentUserEmail, parentUserPassword) VALUES (:email, :password)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':email', $user->getUserEmail());
            $statement->bindValue(':password', $hash);
            $statement->execute();

            //returns the id of the last inserted row or false
            $parentUserID = $db->lastInsertId();
            $statement->closeCursor();
            return $parentUserID;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function updateParentUserPassword(User $user): Int {
        $db = Database::connectToDB();

        $hash = password_hash($user->getUserPassword(), PASSWORD_DEFAULT);
        $query = 'UPDATE parentuser
                    SET parentUserPassword = :password 
                        WHERE parentUserEmail = :email';


        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':password', $hash);
            $statement->bindValue(':email', $user->getUserEmail());
            $statement->execute();

            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return $row_count;
        }catch (PDOException $e){
            return $e->getMessage();
        }

    }

    public static function deleteParentUser(User $user): string
    {
        $db = Database::connectToDB();

        $query = 'DELETE FROM parentuser WHERE parentUserEmail = :user_email';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':user_email', $user->getUserEmail());
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();

            return $row_count;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }


}