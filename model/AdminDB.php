<?php

class AdminDB {

    /***************** ADMIN *****************/

    //OUTPUT DATA
    public static function getAdmin(String $email) {
        $db = Database::connectToDB();

        $query = 'SELECT * FROM admin WHERE adminEmail = :email';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->execute();

            //the FETCH_ASSOC ensures that the record is returned as an associative array
            //the keys are column names which will be used to access the data from each cell
            $admin_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $admin_record;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function getAdminByID(Int $adminID) {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM admin WHERE adminID = :admin_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':admin_id', $adminID);
            $statement->execute();

            $admin_record = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $admin_record;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    //INPUT DATA
    public static function addAdmin(Admin $admin) {
        $db = Database::connectToDB();

        $query = 'INSERT INTO admin (adminFName, adminLName, adminEmail, adminPhoneNum)
                    VALUES (:admin_fName, :admin_lName, :admin_email, :admin_Phone)';


        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':admin_fName', $admin->getAdminFName());
            $statement->bindValue(':admin_lName', $admin->getAdminLName());
            $statement->bindValue(':admin_email', $admin->getAdminEmail());
            $statement->bindValue(':admin_Phone', $admin->getAdminPhoneNum());
            $statement->execute();

            $adminID = $db->lastInsertId();
            $statement->closeCursor();
            return $adminID;
        }catch (PDOException $e){
            return $e->getMessage();
        }

    }

    public static function updateAdmin(Admin $admin) {
        $db = Database::connectToDB();
        $query = 'UPDATE admin
                    SET adminFName = :admin_fName, 
                        adminLName = :admin_lName, 
                        adminEmail = :admin_email,
                        adminPhone = :admin_phone';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':admin_fName', $admin->getAdminFName());
            $statement->bindValue(':admin_lName', $admin->getAdminLName());
            $statement->bindValue(':admin_email', $admin->getAdminEmail());
            $statement->bindValue(':admin_phone', $admin->getAdminPhoneNum());
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function deleteAdminByID(Int $admin_id) {
        $db = Database::connectToDB();
        $query = 'DELETE FROM admin WHERE adminID = :admin_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':admin_id', $admin_id);
            $statement->execute();
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return $row_count;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }



    /***************** USER ADMIN *****************/

    //OUTPUT DATA
    public static function getAdminUser(String $user_email) {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM adminuser WHERE adminUserEmail = :email';

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

    public static function getAdminUserByID(Int $user_id) {
        $db = Database::connectToDB();
        $query = 'SELECT * FROM adminuser WHERE adminUserID = :user_id';

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
    public static function addAdminUser(User $user): false|string
    {
        $db = Database::connectToDB();
        $hash = password_hash($user->getUserPassword(), PASSWORD_DEFAULT);

        $query = 'INSERT INTO adminuser (adminUserEmail, adminUserPassword) VALUES (:email, :password)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':email', $user->getUserEmail());
            $statement->bindValue(':password', $hash);
            $statement->execute();

            //returns the id of the last inserted row
            $adminUserID = $db->lastInsertId();
            $statement->closeCursor();
            return $adminUserID;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function updateAminUserPassword(User $user): Int {
        $db = Database::connectToDB();

        $hash = password_hash($user->getUserPassword(), PASSWORD_DEFAULT);
        $query = 'UPDATE adminuser
                    SET adminUserPassword = :password 
                        WHERE adminUserEmail = :email';

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




}

?>