<?php

use JetBrains\PhpStorm\NoReturn;

class ParentAccountController
{

    public static function displayLoginForm(): void
    {
        include(__DIR__ . '/../parent/account/parent_login.php');

    }

    public static function displayRegisterForm(): void
    {
        include(__DIR__ . '/../parent/account/parent_register.php');

    }


    public static function parentLogin(): void{

        /*****************************************  GET THE Parent's DATA  *******************************************/

        $parent_email = trim(filter_input(INPUT_POST,'parent_email'));
        $parent_password1 = trim(filter_input(INPUT_POST,'parent_password1'));


        /**************************************** VALIDATE THE Admin's DATA  *****************************************/

        //Create a 2D ARRAY that will hold the results of validating each input field
        $fields_results = [];

        //Pass the validation status of each field into the 2D Array
        // field_results[0] = ['error_message' => "$message_name is required", 'field_name' => "$field_name"]
        $fields_results[0] = Validate::validateEmailField('parent_email', $parent_email);
        $fields_results[1] = Validate::validateTextField('parent_password1', $parent_password1, 'Password', 8, 256, ['password'=>true]);


        /*************************** CHECK EACH INPUT FOR ERRORS AND RETURN THEM IF FOUND  **************************/

        for ($i = 0, $iMax = count($fields_results); $i < $iMax; $i++) {
            if(!empty($fields_results[$i]['error_message'])) {
                $error_message = $fields_results[$i]['error_message'];
                $f_name = $fields_results[$i]['field_name'];
                include(__DIR__ . '/../parent/account/parent_login.php');
                return;
            }
        }


        //Fetching data from db and comparing
        $user_record = StudentParentDB::getParentUser($parent_email);


        if(!is_array($user_record)) {
            $error_message = 'The Parent User Account does not exist';
            include(__DIR__ . '/../parent/account/parent_login.php');
            return;
        }


        $password_match = password_verify($parent_password1, $user_record['parentUserPassword']);
        if(!$password_match) {
            $error_message = 'Password is incorrect';
            include(__DIR__ . '/../parent/account/parent_login.php');
            return;
        }


        //the idea is to change directions so that anyone who's following you fails to find you
        session_regenerate_id(true);


        $_SESSION['parent_user_id'] = $user_record['parentUserID'];
        $parent_record = StudentParentDB::getParent($parent_email);
        if (is_array($parent_record)) {
            $_SESSION['parentName'] = $parent_record['parentFName'] . ' ' . $parent_record['parentLName'];
            $_SESSION['parent_id'] = $parent_record['parentID'];
            $students = StudentDB::getStudentsByParentID($parent_record['parentID']);
        } else {
            $students = [];
        }

        include(__DIR__ . '/../parent/account/parent_home.php');
        exit;


    }

    public static function parentRegister(): void
    {
        /*****************************************  GET THE Parent's DATA  *******************************************/

        $parent_id = trim(filter_input(INPUT_POST, 'parent_id'));
        $parent_title = trim(filter_input(INPUT_POST, 'parent_title'));
        $parent_fName = trim(filter_input(INPUT_POST, 'parent_fName'));
        $parent_lName = trim(filter_input(INPUT_POST, 'parent_lName'));
        $parent_email = trim(filter_input(INPUT_POST, 'parent_email'));
        $parent_house = trim(filter_input(INPUT_POST, 'parent_house'));
        $parent_street = trim(filter_input(INPUT_POST, 'parent_street'));
        $parent_city = trim(filter_input(INPUT_POST, 'parent_city'));
        $parent_postal = trim(filter_input(INPUT_POST, 'parent_postal'));
        $parent_phone = trim(filter_input(INPUT_POST, 'parent_phone'));
        $parent_password1 = trim(filter_input(INPUT_POST, 'parent_password1'));
        $parent_password2 = trim(filter_input(INPUT_POST, 'parent_password2'));

        //Capitalise the first letter of each word for data consistency
        $parent_title = ucwords($parent_title);
        $parent_fName = ucwords($parent_fName);
        $parent_lName = ucwords($parent_lName);
        $parent_street = ucwords($parent_street);
        $parent_city = ucwords($parent_city);



        /**************************************** VALIDATE THE Admin's DATA  *****************************************/

        //Create a 2D ARRAY that will hold the results of validating each input field
        $fields_results = [];

        //Pass the validation status of each field into the 2D Array
        // field_results[0] = ['error_message' => "$message_name is required", 'field_name' => "$field_name"]
        $fields_results[0] = Validate::validateTextField('parent_id', $parent_id, 'ID Number', 13, 14, ['digit'=>true, 'id_number'=>true]);
        $fields_results[1] = Validate::validateTextField('parent_title', $parent_title, 'Title',2, 9, []);
        $fields_results[2] = Validate::validateTextField('parent_fName', $parent_fName, 'First Name', 2, 256, []);
        $fields_results[3] = Validate::validateTextField('parent_lName', $parent_lName,'Last Name', 2, 256, []);
        $fields_results[4] = Validate::validateEmailField('parent_email', $parent_email);
        $fields_results[5] = Validate::validateTextField('parent_house', $parent_house,'House Number', 1, 10, ['digit'=>true]);
        $fields_results[6] = Validate::validateTextField('parent_street', $parent_street,'Street Name', 2, 60, []);
        $fields_results[7] = Validate::validateTextField('parent_city', $parent_city,'City', 2, 60, []);
        $fields_results[8] = Validate::validateTextField('parent_postal', $parent_postal,'Postal Code', 2, 60, ['digit'=>true]);
        $fields_results[9] = Validate::validateTextField('parent_phone', $parent_phone,'Phone Number', 10, 11, ['digit'=>true, 'phone_number'=>true]);
        $fields_results[10] = Validate::validateTextField('parent_password1', $parent_password1, 'Password', 8, 256, ['password'=>true]);



        /*************************** CHECK EACH INPUT FOR ERRORS AND RETURN THEM IF FOUND  **************************/

        for ($i = 0, $iMax = count($fields_results); $i < $iMax; $i++) {
            if(!empty($fields_results[$i]['error_message'])) {
                $error_message = $fields_results[$i]['error_message'];
                $f_name = $fields_results[$i]['field_name'];
                include(__DIR__ . '/../parent/account/parent_register.php');
                exit;
            }
        }


        /******************************** CHECK FOR AN EXISTING RECORD WITH THE SAME DATA  *******************************/

        //Returns a Record of existing data in an Associative Array or False (if there's no match)
        $id_exists = StudentParentDB::getParentByID($parent_id); //returns false if there's no duplicate
        $email_exists = StudentParentDB::getParent($parent_email); //returns false if there's no duplicate
        $phone_exists = StudentParentDB::getParentByPhone($parent_phone); //returns false if there's no duplicate



        //If record already exists, return the error message
        if($id_exists) {
            $error_message = 'ID Number already exists';
            include(__DIR__ . '/../parent/account/parent_register.php');
            exit;
        }

        if($email_exists) {
            $error_message = 'Email already exists';
            include(__DIR__ . '/../parent/account/parent_register.php');
            exit;
        }

        if($phone_exists) {
            $error_message = 'Phone Number already exists';
            include(__DIR__ . '/../parent/account/parent_register.php');
            exit;
        }

        if(!FieldRequirements::isFieldMatch($parent_password1, $parent_password2)) {
            $error_message = 'Both passwords must match';
            include(__DIR__ . '/../parent/account/parent_register.php');
            exit;
        }



        //Insert Data
        $parent = new StudentParent($parent_id, $parent_title, $parent_fName, $parent_lName, $parent_email,
            $parent_house, $parent_street, $parent_city, $parent_postal, $parent_phone);

        //Creates a User object for the Parent
        $parentUser = new User($parent_email, $parent_password1);

        //Insert data to the Database
        //Starts with registering the parent
        $parent_result = StudentParentDB::addParent($parent);



        //Checks if the parent's registration was a success before creating a user account for them
        //if the returned result from adding the parent is numeric that means the parent id was returned
        //if not, it's probably an error message
        if(!is_numeric($parent_result)) {
            //Parent registration failed return to page and display error message
            $error_message = 'Error (Failed to register Parent): ' . $parent_result;
            $action = 'register_parent_form';
            include(__DIR__ . '/../parent/account/parent_register.php');
            exit;

        }else {

            //Parent registered successfully - Create a user account for him/her
            $parent_user_result = StudentParentDB::addParentUser($parentUser);

            //Checks if the user account was created successfully
            //If not, remove the parent from the database and display an error message
            if(!is_numeric($parent_user_result)) {
                $result = StudentParentDB::deleteParentUser($parentUser);
                $error_message = 'Error (Failed to create Parent User Account): ' . $parent_user_result;
                $action = 'register_parent_form';
                include(__DIR__ . '/../parent/account/parent_register.php');
                exit;
            }
        }

        $_SESSION['parent_user_id'] = $parent_user_result;
        $_SESSION['parentName'] = $parent_fName . ' ' . $parent_lName;
        $_SESSION['parent_id'] = $parent_id;
        $parent_record = StudentParentDB::getParent($parent_email);
        $students = [];
        include(__DIR__ . '/../parent/account/parent_home.php');
        exit;

    }

    #[NoReturn]
    public static function parentLogout(): void
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        include(__DIR__ . '/../parent/account/parent_login.php');
        exit;

    }



    //Check Admin Actions and calls the appropriate method
    #[NoReturn]
    public static function checkAccountAction($action) {
        Switch($action) {
            case 'parent_login':
                self::parentLogin();
                break;

            case 'parent_logout':
                self::parentLogout();
                break;

            case 'parent_register_form':
                self::displayRegisterForm();
                break;

            case 'parent_register':
                self::parentRegister();
                break;

            default:
                self::displayLoginForm();
                break;
        }
        exit;
    }


}
