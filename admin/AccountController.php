<?php

class AccountController
{

    public static function displayLoginForm(): void
    {
        include('account/admin_login.php');

    }

    public static function displayRegisterForm(): void
    {
        include('account/admin_register.php');

    }

    public static function displayAdminHome(): void
    {
        $admin_record = AdminDB::getAdminByID($_SESSION['user_id']); //place it outside
        $view_report = 'view_report';
        include('account/admin_home.php');

    }

    public static function adminLogin(): void
    {
        /*****************************************  GET THE Admin's DATA  *******************************************/

        $admin_email = trim(filter_input(INPUT_POST, 'admin_email'));
        $admin_password1 = trim(filter_input(INPUT_POST, 'admin_password1'));


        /**************************************** VALIDATE THE Admin's DATA  *****************************************/

        //Create a 2D ARRAY that will hold the results of validating each input field
        $fields_results = [];

        //Pass the validation status of each field into the 2D Array
        // field_results[0] = ['error_message' => "$message_name is required", 'field_name' => "$field_name"]
        $fields_results[0] = Validate::validateTextField('admin_password1', $admin_password1, 'Password', 1, 256, []);
        $fields_results[1] = Validate::validateEmailField('admin_email', $admin_email);


        /*************************** CHECK EACH INPUT FOR ERRORS AND RETURN THEM IF FOUND  **************************/

        foreach ($fields_results as $i => $iValue) {
            if (!empty($iValue['error_message'])) {
                $error_message = $fields_results[$i]['error_message'];
                $f_name = $fields_results[$i]['field_name'];
                include('account/admin_login.php');
                return;
            }
        }


        //Fetching data from db and comparing
        $user_record = AdminDB::getAdminUser($admin_email);


        if (!is_array($user_record)) {
            $error_message = 'The admin does not exist';
            include('account/admin_login.php');
            return;
        }

        $password_match = password_verify($admin_password1, $user_record['adminUserPassword']);
        if (!$password_match) {
            $error_message = 'Password is incorrect';
            include('account/admin_login.php');
            return;
        }

        //the idea is to change directions so that anyone who's following you fails to find you
        session_regenerate_id(true);


        $_SESSION['user_id'] = $user_record['adminUserID'];
        $admin_record = AdminDB::getAdmin($admin_email);
        $view_report = 'view_report';
        include('account/admin_home.php');

    }

    public static function adminRegister(): void
    {
            /*****************************************  GET THE Admin's DATA  *******************************************/

            $admin_fName = trim(filter_input(INPUT_POST, 'admin_fName'));
            $admin_lName = trim(filter_input(INPUT_POST, 'admin_lName'));
            $admin_email = trim(filter_input(INPUT_POST, 'admin_email'));
            $admin_phone = trim(filter_input(INPUT_POST, 'admin_phone'));
            $admin_password1 = trim(filter_input(INPUT_POST, 'admin_password1'));
            $admin_password2 = trim(filter_input(INPUT_POST, 'admin_password2'));

            //Capitalise the first letter of each word for data consistency
            $admin_fName = ucwords($admin_fName);
            $admin_lName = ucwords($admin_lName);


            /**************************************** VALIDATE THE Admin's DATA  *****************************************/

            //Create a 2D ARRAY that will hold the results of validating each input field
            $fields_results = [];

            //Pass the validation status of each field into the 2D Array
            // field_results[0] = ['error_message' => "$message_name is required", 'field_name' => "$field_name"]
            $fields_results[0] = Validate::validateTextField('admin_fName', $admin_fName, 'First Name', 2, 256, []);
            $fields_results[1] = Validate::validateTextField('admin_lName', $admin_lName,'Last Name', 2, 256, []);
            $fields_results[2] = Validate::validateEmailField('admin_email', $admin_email);
            $fields_results[3] = Validate::validateTextField('admin_phone', $admin_phone,'Phone Number', 10, 11, ['digit'=>true, 'phone_number'=>true]);
            $fields_results[4] = Validate::validateTextField('admin_password1', $admin_password1, 'Password', 8, 256, ['password'=>true]);

            /*************************** CHECK EACH INPUT FOR ERRORS AND RETURN THEM IF FOUND  **************************/

        foreach ($fields_results as $i => $iValue) {
            if(!empty($iValue['error_message'])) {
                $error_message = $fields_results[$i]['error_message'];
                $f_name = $fields_results[$i]['field_name'];
                include('account/admin_register.php');
                return;
            }
        }

        if(!FieldRequirements::isFieldMatch($admin_password1, $admin_password2)) {
                $error_message = 'Both passwords must match';
                include('account/admin_register.php');
                return;
            }


            $admin = new Admin($admin_fName, $admin_lName, $admin_email, $admin_phone);
            $adminUser = new User($admin_email, $admin_password1);

            $admin_id = AdminDB::addAdmin($admin);
            $user_id = AdminDB::addAdminUser($adminUser);

            if(is_numeric($user_id)) {
                $_SESSION['user_id'] = $user_id;
            }
            $record = AdminDB::getAdminByID((int)$admin_id);
            $user_record = AdminDB::getAdminUserByID((int)$user_id);
            include('account/admin_home.php');

    }

    public static function adminLogout(): void
    {
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        // Redirect to login page
        header("Location: ./?action=admin_login_form");
        exit;
    }



    //Check Admin Actions and calls the appropriate method
    public static function checkAccountAction($action) {
        Switch($action) {
            case 'admin_login':
                self::adminLogin();
                break;

            case 'admin_logout':
                self::adminLogout();
                break;

            case 'admin_login_form':
                self::displayLoginForm();
                break;

            case 'admin_register_form':
                self::displayRegisterForm();
                break;

            case 'admin_register':
                self::adminRegister();
                break;

            case 'view_report':
                ActionsController::viewReport();
                break;

            default:
                break;
        }
        exit;
    }


}
