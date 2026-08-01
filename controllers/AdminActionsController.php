<?php

class AdminActionsController
{
    private static function checkAdminLogin(): void
    {
        if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
            AdminAccountController::displayLoginForm();
            exit;
        }
    }

    //Getters for various admin actions

    public static function viewReport(): void
    {
        self::checkAdminLogin();
        $action = 'view_report'; // Fixes CSS
        include(__DIR__ . '/../admin/account/admin_home.php');
        exit;
    }

    public static function view_registration_forms(): void
    {
        self::checkAdminLogin();
        $action = 'view_registration_forms'; // Fixes CSS
        self::displayRegParentForm();
        exit;
    }

    public static function viewWaitingList(): void
    {
        self::checkAdminLogin();


        //Get the list of lockers available and categorize them by grade
        $available_lockers = LockerDB::getAvailableLockers();

        $grade_8_locker = 0;
        $grade_9_locker = 0;
        $grade_10_locker = 0;
        $grade_11_locker = 0;
        $grade_12_locker = 0;

        foreach ($available_lockers as $locker) {
            switch($locker['lockerGrade']) {
                case 'Grade 8':
                    $grade_8_locker++;
                    break;

                case 'Grade 9':
                    $grade_9_locker++;
                    break;

                case 'Grade 10':
                    $grade_10_locker++;
                    break;

                case 'Grade 11':
                    $grade_11_locker++;
                    break;

                case 'Grade 12':
                    $grade_12_locker++;
                    break;
            }
        }

        //Get the list of all student placed on the waiting list with the grades visible
        $waiting_list = WaitingListDB::getListWithGrades();

        $action = 'view_waiting_list'; // Fixes CSS
        include(__DIR__ . '/../admin/actions/view_waiting_list.php');
        exit;

    }

    public static function viewTempLockers(): void
    {
        self::checkAdminLogin();

        //Get the list of lockers available and categorize them by grade
        $available_lockers = LockerDB::getAvailableLockers();

        $grade_8_locker = 0;
        $grade_9_locker = 0;
        $grade_10_locker = 0;
        $grade_11_locker = 0;
        $grade_12_locker = 0;

        if(!$available_lockers) {
            $available_lockers = [];
            self::viewWaitingList();
            exit;
        }

        foreach ($available_lockers as $locker) {
            switch($locker['lockerGrade']) {
                case 'Grade 8':
                    $grade_8_locker++;
                    break;

                case 'Grade 9':
                    $grade_9_locker++;
                    break;

                case 'Grade 10':
                    $grade_10_locker++;
                    break;

                case 'Grade 11':
                    $grade_11_locker++;
                    break;

                case 'Grade 12':
                    $grade_12_locker++;
                    break;
            }
        }

        //Get the lockers
        $temp_lockers = TempLockerDB::getTempLockers();

        $action = 'view_temp_lockers'; // Fixes CSS
        include(__DIR__ . '/../admin/actions/view_temp_lockers.php');
        exit;

    }

    public static function viewLockerSuspension(): void
    {
        self::checkAdminLogin();

        $suspended_lockers = LockerSuspensionDB::getSuspendedLockers();
        $action = 'view_locker_suspension'; // Fixes CSS
        include(__DIR__ . '/../admin/actions/view_locker_suspension.php');
        exit;
    }

    public static function viewPayments(): void
    {
        self::checkAdminLogin();

        // 1. Fetch Data (Move logic from actions/index.php if needed)
        $payments_results = PaymentDB::getLockerPayments();

        // 2. Set Active Tab
        $action = 'view_payments';

        // 3. Include View directly (NO REDIRECTS)
        include(__DIR__ . '/../admin/actions/view_payments.php');
        exit;
    }



    //Display Forms
    public static function displayRegParentForm(): void
    {
        self::checkAdminLogin();
        $action = 'register_parent_form'; // Fixes CSS
        include(__DIR__ . '/../admin/actions/register_parent.php');
        exit;
    }

    public static function displayRegStudentForm(): void
    {
        self::checkAdminLogin();
        $action = 'register_student_form'; // Fixes CSS
        include(__DIR__ . '/../admin/actions/register_student.php');
        exit;
    }

    public static function displayStudentForm(): void
    {
        self::checkAdminLogin();
        self::displayRegStudentForm();
        exit;
    }

    public static function displayBookStudentForm(): void
    {
        self::checkAdminLogin();
        $action = 'book_student_form'; // Fixes CSS
        include(__DIR__ . '/../admin/actions/book_student.php');
        exit;
    }





    //Insert Actions
    public static function addPayment(): void
    {
        self::checkAdminLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_stud_num'])) {
            $pay_stud_num = trim(filter_input(INPUT_POST, 'pay_stud_num'));
            $pay_verified = trim(filter_input(INPUT_POST, 'pay_verified'));
            $pay_amount = trim(filter_input(INPUT_POST, 'pay_amount'));
            $pay_date = trim(filter_input(INPUT_POST, 'pay_date'));
            $pay_balance = trim(filter_input(INPUT_POST, 'pay_balance'));
            $pay_locker = trim(filter_input(INPUT_POST, 'pay_locker'));

            if (empty($pay_stud_num) || empty($pay_amount) || empty($pay_locker)) {
                $error_message = 'Please fill in all required payment fields.';
                $action = 'add_payment';
                include(__DIR__ . '/../admin/actions/add_payment.php');
                exit;
            }

            if (empty($pay_date)) {
                $pay_date = date('Y-m-d H:i:s');
            }

            $result = PaymentDB::addLockerPayment($pay_stud_num, $pay_verified ?: '1', $pay_amount, $pay_date, $pay_balance ?: '0.00', $pay_locker);
            if (!is_numeric($result)) {
                $error_message = 'Error recording payment: ' . $result;
                $action = 'add_payment';
                include(__DIR__ . '/../admin/actions/add_payment.php');
                exit;
            }

            self::viewPayments();
            exit;
        }

        $action = 'add_payment'; // Fixes CSS
        include(__DIR__ . '/../admin/actions/add_payment.php');
        exit;
    }

    public static function registerParent(): void
    {
        self::checkAdminLogin();
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
        $fields_results[1] = Validate::validateTextField('parent_title', $parent_title, 'Title',2, 8, []);
        $fields_results[2] = Validate::validateTextField('parent_fName', $parent_fName, 'First Name', 2, 255, []);
        $fields_results[3] = Validate::validateTextField('parent_lName', $parent_lName,'Last Name', 2, 255, []);
        $fields_results[4] = Validate::validateEmailField('parent_email', $parent_email);
        $fields_results[5] = Validate::validateTextField('parent_house', $parent_house,'House Number', 1, 10, ['digit'=>true]);
        $fields_results[6] = Validate::validateTextField('parent_street', $parent_street,'Street Name', 2, 60, []);
        $fields_results[7] = Validate::validateTextField('parent_city', $parent_city,'City', 2, 60, []);
        $fields_results[8] = Validate::validateTextField('parent_postal', $parent_postal,'Postal Code', 2, 60, ['digit'=>true]);
        $fields_results[9] = Validate::validateTextField('parent_phone', $parent_phone,'Phone Number', 10, 11, ['digit'=>true, 'phone_number'=>true]);



        /*************************** CHECK EACH INPUT FOR ERRORS AND RETURN THEM IF FOUND  **************************/

        for ($i = 0; $i < count($fields_results); $i++) {
            if(!empty($fields_results[$i]['error_message'])) {
                $error_message = $fields_results[$i]['error_message'];
                $f_name = $fields_results[$i]['field_name'];
                self::displayRegParentForm();
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
            self::displayRegParentForm();
            exit;
        }

        if($email_exists) {
            $error_message = 'Email already exists';
            self::displayRegParentForm();
            exit;
        }

        if($phone_exists) {
            $error_message = 'Phone Number already exists';
            self::displayRegParentForm();
            exit;
        }


        //Insert Data
        $parent = new StudentParent($parent_id, $parent_title, $parent_fName, $parent_lName, $parent_email,
            $parent_house, $parent_street, $parent_city, $parent_postal, $parent_phone);

        //Create a strong random user password - the password will be unknown to everyone including the admin
        //Generate random strings of type binary - random_bytes()
        //Convert binary data into strings that look like hexadecimal - bin2hex()
        $password = bin2hex(random_bytes(20));
        $password = password_hash($password, PASSWORD_DEFAULT);

        //Creates a User object for the Parent
        $parentUser = new User($parent_email, $password);

        //Insert data to the Database
        //Starts with registering the parent
        $parent_result = StudentParentDB::addParent($parent);



        //Checks if the parent's registration was a success before creating a user account for them
        //if the returned result from adding the parent is numeric that means the parent id was returned
        //if not, it's probably an error message
        if(!is_numeric($parent_result)) {
            //Parent registration failed return to page and display error message
            $error_message = 'Error (Failed to register Parent): ' . $parent_result;
            self::displayRegParentForm();
            exit;

        }else {

            //Parent registered successfully - Create a user account for him/her
            $parent_user_result = StudentParentDB::addParentUser($parentUser);

            //Checks if the user account was created successfully
            //If not, remove the parent from the database and display an error message
            if(!is_numeric($parent_user_result)) {
                $result = StudentParentDB::deleteParentUser($parentUser);
                $error_message = 'Error (Failed to create Parent User Account): ' . $parent_user_result;
                self::displayRegParentForm();
                exit;
            }
        }

        self::displayRegStudentForm();
        exit;

    }

    public static function registerStudent(): void{
        self::checkAdminLogin();

        unset($_SESSION['stud_num']);
        /*****************************************  GET THE Student's DATA  *******************************************/
        $student_parent_id = trim(filter_input(INPUT_POST, 'student_parent_id'));
        $student_num = trim(filter_input(INPUT_POST, 'student_num'));
        $student_fName = trim(filter_input(INPUT_POST, 'student_fName'));
        $student_lName = trim(filter_input(INPUT_POST, 'student_lName'));
        $student_grade = trim(filter_input(INPUT_POST, 'student_grade'));

        //Capitalise the first letter of each word for data consistency
        $student_fName = ucwords($student_fName);
        $student_lName = ucwords($student_lName);
        $student_grade = ucwords($student_grade);


        /**************************************** VALIDATE THE Student's DATA  *****************************************/
        //Create a 2D ARRAY that will hold the results of validating each input field
        $fields_results = [];

        //Pass the validation status of each field into the 2D Array
        // field_results[0] = ['error_message' => "$message_name is required", 'field_name' => "$field_name"]
        $fields_results[0] = Validate::validateTextField('student_parent_id', $student_parent_id, "Parent's ID Number", 13, 14, ['digit'=>true, 'student_parent_id'=>true]);
        $fields_results[1] = Validate::validateTextField('student_num', $student_num, 'Student Number',6, 7, ['digit'=>true]);
        $fields_results[2] = Validate::validateTextField('student_fName', $student_fName, 'First Name', 2, 61, []);
        $fields_results[3] = Validate::validateTextField('student_lName', $student_lName,'Last Name', 2, 61, []);
        $fields_results[4] = Validate::validateTextField('student_grade', $student_grade,'Grade', 7, 9, []);




        /*************************** CHECK EACH INPUT FOR ERRORS AND RETURN THEM IF FOUND  **************************/
        for ($i = 0; $i < count($fields_results); $i++) {
            if(!empty($fields_results[$i]['error_message'])) {
                $error_message = $fields_results[$i]['error_message'];
                $f_name = $fields_results[$i]['field_name'];
                self::displayRegStudentForm();
                exit;
            }
        }


        /******************************** CHECK FOR AN EXISTING RECORD WITH THE SAME DATA  *******************************/
        //Returns a Record of existing data in an Associative Array or False (if there's no match)
        $student_num_exists = StudentDB::getStudent($student_num); //returns false if there's no duplicate

        //Check if the parent exists before adding the student
        $parent_id_exists = StudentParentDB::getParentByID($student_parent_id); //returns false if there's no duplicate

        //If student record already exists, return the error message
        if($student_num_exists) {
            $error_message = 'Student Number already exists';
            self::displayRegStudentForm();
            exit;
        }
        if(!$parent_id_exists) {
            $error_message = 'Parent ID Number does not exist';
            self::displayRegStudentForm();
            exit;
        }


        /******************************** INSERT THE DATA INTO THE DATABASE  *******************************/

        //Creates a student object and passes it to the Database
        $student = new Student($student_parent_id, $student_num, $student_fName, $student_lName, $student_grade);

        //Insert data to the Database
        $student_result = StudentDB::addStudent($student);


        //If the student's registration was successful, the returned result should be a student number
        //and if not, then the registration failed
        if(!is_numeric($student_result)) {
            //Parent registration failed return to page and display error message
            $error_message = 'Error (Failed to register Student): ' . $student_result;
            self::displayRegStudentForm();
            exit;
        }

        self::displayBookStudentForm();
        exit;

    }

    public static function linkStudent(): void
    {
        self::checkAdminLogin();

        /*****************************************  GET THE Student's DATA  *******************************************/
        $link_student_num = trim(filter_input(INPUT_POST, 'link_student_num'));


        /**************************************** VALIDATE THE Student's DATA  *****************************************/
        //Create a 2D ARRAY that will hold the results of validating each input field
        $fields_results = [];

        //Pass the validation status of each field into the 2D Array
        // field_results[0] = ['error_message' => "$message_name is required", 'field_name' => "$field_name"]
        $fields_results = Validate::validateTextField('student_num', $link_student_num, 'Student Number',6, 7, ['digit'=>true]);


        /*************************** CHECK THE INPUT FOR ERRORS AND RETURN THEM IF FOUND  **************************/
        if(!empty($fields_results['error_message'])) {
            $error_message = $fields_results['error_message'];
            $f_name = $fields_results['field_name'];
            self::displayBookStudentForm();
            exit;
        }


        /******************************** CHECK FOR AN EXISTING RECORD WITH THE SAME DATA  *******************************/
        //Returns a Record of existing data in an Associative Array or False (if there's no match)
        $student_num_exists = StudentDB::getStudent($link_student_num); //returns false if there's no duplicate

        //If student record doesn't exist, return the error message
        if(!$student_num_exists) {
            $error_message = "Student Number Doesn't Exists";
            self::displayBookStudentForm();
            exit;
        }


        /******************************** GET THE STUDENT RECORD DATA FROM THE DATABASE  *******************************/
        //Since, we've already retrieved the student record, we'll access the variable containing it to access the data
        $student_num = $student_num_exists['studNum'];
        $student_fName = $student_num_exists['studFName'] . ' ' . $student_num_exists['studLName'];
        $student_grade = $student_num_exists['studGrade'];

        $_SESSION['stud_num'] = $student_num;


        /***************** GET DATA AND CHECK IF THE STUDENT IS ON A WAITING LIST OR HAS TEMP LOCKER ****************/
        //check if there's any available lockers for a specific grade
        $lockers = LockerDB::getLockersByGrade($student_grade);


        //Check if there's student was already assigned a temp locker
        $temp_locker = TempLockerDB::getTempLockerByStudNum($student_num);

        //Check if the student was already assigned a year locker
        $year_locker = YearLockerDB::getYearLockerByStudNum($student_num);

        //Check if the student is on waiting list
        $waiting_list = WaitingListDB::getListByStudNum($student_num);


        $has_locker = 'No';

        //If there's no available lockers send an empty array to signal that
        if(!$lockers) { $lockers = []; }

        //If the student has been already assigned a locker, say Yes!
        if($temp_locker) { $has_locker = 'Yes'; }

        if($year_locker) { $has_locker = 'Yes'; }


        $on_waiting_list = 'No';

        //If the student has already been added on the waiting list, say Yes!
        if($waiting_list) { $on_waiting_list = 'Yes'; }

        //Should there be an error that prevents the Admin from placing a student on a temp locker
        //The student details must still appear
        $_SESSION['has_locker'] = $has_locker;
        $_SESSION['on_waiting_list'] = $on_waiting_list;

        include(__DIR__ . '/../admin/actions/book_student.php');
        exit;

    }

    public static function placeOnWaitingList(): void{
        self::checkAdminLogin();


        /**************************************** VALIDATE THE Student's DATA  *****************************************/
        //Since we are not retrieving any user input, no validation is necessary


        /******************************** INSERT THE DATA INTO THE DATABASE  *******************************/
        //Before inserting data, check if the user has already been placed on the waiting list
        $waiting_list_exists = WaitingListDB::getListByStudNum($_SESSION['stud_num']);

        if($waiting_list_exists) {
            $error_message = 'Student already placed on waiting list';
            self::displayBookStudentForm();
            exit;
        }

        //Insert data to the Database
        $placement_result = WaitingListDB::addToList($_SESSION['stud_num']);

        //If the student's waiting list placement was successful, the returned result should be a waiting list number
        //and if not, then the waiting list placement failed
        if(!is_numeric($placement_result)) {
            //Parent registration failed return to page and display error message
            $error_message = 'Error: (Failed to place Student on waiting list) - ' . $placement_result;
            self::displayRegStudentForm();
            include(__DIR__ . '/../admin/actions/register_student.php');
            exit;
        }

        /******************************** SEND AN EMAIL NOTIFICATION TO PARENT  *******************************/
        //Get the student's data and use it to retrieve parent's name and email
        $student = StudentDB::getStudent($_SESSION['stud_num']);


        $parent_id = $student['parentID'];

        //Get parent data
        $parent = StudentParentDB::getParentByID($parent_id);

        $stud_label = is_array($student) ? ($student['studFName'] . ' ' . $student['studLName'] . ' (' . $student['studNum'] . ')') : $_SESSION['stud_num'];
        $subject = "$stud_label: Locker Application Unsuccessful";
        $message = "Dear Parent.
                    Unfortunately, the lockers are currently fully booked and as such the student has been placed on waiting list and will be assigned a temporary locker
                    as soon as the locker space is available.\r\n
                    We'll notify you by email should there be an available space.";


        $response = SendMail::sendEmail('mabaso.menzi911@gmail.com', 'dyondzo.curfew@gmail.com', 'Dyondzo', $subject, $message);

        /******************************** REDIRECT TO THE VIEW WAITING LIST PAGE  *******************************/
        //At this stage this means the student has been placed on the waiting list
        //Redirect the admin to the view waiting list page to confirm if it was a success

        //Get the list of all student placed on the waiting list with the grades visible
        $waiting_list = WaitingListDB::getListWithGrades();
        if(!$waiting_list) { $waiting_list = []; }


        unset($_SESSION['stud_num']);
        self::viewWaitingList();
        exit;

    }

    public static function removeFromWaitingList(): void
    {
        self::checkAdminLogin();

        //Get the waiting list number
        $waiting_num = trim(filter_input(INPUT_POST, 'waiting_num'));
        WaitingListDB::removeFromList($waiting_num);
        self::viewWaitingList();
        exit;


    }

    public static function assignTempLocker(): void{
        self::checkAdminLogin();

        /***************************************  GET THE Student and Locker  *****************************************/
        $locker_num = trim(filter_input(INPUT_POST, 'locker_num'));
        $student_num = $_SESSION['stud_num'];


        //since there was no direct user input, validate is unnecessary

        /*********************************  INSERT DATA INTO THE TEMP LOCKER TABLE  ***********************************/
        $temp_locker_result = TempLockerDB::addTempLocker($student_num, $locker_num);

        //If the temporary locker assignment was successful, the returned result should be a temp locker number
        //and if not, then the assignment failed
        if(!is_numeric($temp_locker_result)) {
            //Parent registration failed return to page and display error message
            $error_message = 'Error: Failed to assign the locker - ' . $temp_locker_result;

            //Returns a Record of existing data in an Associative Array or False (if there's no match)
            $student = StudentDB::getStudent($student_num); //returns false if there's no duplicate


            $has_locker = $_SESSION['has_locker'];
            $on_waiting_list = $_SESSION['on_waiting_list'];


            $student_num = $student['studNum'];
            $student_fName = $student['studFName'] . ' ' . $student['studLName'];
            $student_grade = $student['studGrade'];

            self::displayBookStudentForm();
            exit;
        }


        /************************* UPDATE LOCKER STATUS TO BOOKED **************************/
        $row_count = LockerDB::updateLockerStatus($locker_num, 'booked');


        //Since we only have access to two email addresses, we'll set them to static
//        $admin_email = $admin_record['adminEmail'];
//        $parent_email = $parent['parentEmail'];
//        $parent_fName = $parent['parentFName'] . ' ' . $parent['parentLName'];
        $subject = "$student_num: Locker Application Successful";
        $message = "Dear Parent.
                    Congratulations, the student ($student_num) has been assigned a temporary locker.\r\n
                    The Student has 30 days to pay the locker fee of R100, failure to pay results in locker suspension.\r\n
                    Please use the student number as reference when paying.\r\n
                    Reply to this email with proof of payment, when done.\r\n";


        $response = SendMail::sendEmail('mabaso.menzi911@gmail.com', 'dyondzo.curfew@gmail.com', 'Dyondzo', $subject, $message);



        /************************** REDIRECT TO THE VIEW THE ASSIGNED TEMPORARY LOCKERS PAGE **************************/
        self::viewTempLockers();
        exit;

    }

    public static function suspendTempLocker(): void{
        self::checkAdminLogin();

        $locker_num = trim(filter_input(INPUT_POST, 'temp_locker_num'));
        $student_num = trim(filter_input(INPUT_POST, 'student_num'));

//        echo 'student number: ' . $student_num;
        //Since we only have access to two email addresses, we'll set them to static
//        $admin_email = $admin_record['adminEmail'];
//        $parent_email = $parent['parentEmail'];
//        $parent_fName = $parent['parentFName'] . ' ' . $parent['parentLName'];
        $subject = "$student_num: Locker Suspended";
        $message = "Dear Parent.
                    The student's locker has been suspend until locker fee of R100 is paid.\r\n
                    Please use the student number as reference when paying and
                    reply to this email with proof of payment, when done.\r\n";


        $response = SendMail::sendEmail('mabaso.menzi911@gmail.com', 'dyondzo.curfew@gmail.com', 'Dyondzo', $subject, $message);


        $result = LockerSuspensionDB::addLockerSuspension('Free-Trail Expired', $locker_num);
        self::viewTempLockers();
        exit;

    }

    public static function unsuspendTempLocker(): void{
        self::checkAdminLogin();

        $locker_num = trim(filter_input(INPUT_POST, 'locker_num'));

        $result = LockerSuspensionDB::removeLockerSuspension($locker_num);

        self::viewLockerSuspension();
        exit;

    }




    //Check Admin Actions and calls the appropriate method
    public static function checkAdminAction($action) {
        Switch($action) {
            case 'view_registration_forms':
                self::view_registration_forms();
                break;
            case 'view_waiting_list':
                self::viewWaitingList();
                break;
            case 'view_temp_lockers':
                self::viewTempLockers();
                break;
            case 'view_locker_suspension':
                self::viewLockerSuspension();
                break;
            case 'view_payments':
                self::viewPayments();
                break;

            case 'add_payment':
                self::addPayment();
                break;

            case 'register_parent_form':
                self::displayRegParentForm();
                break;
            case 'register_student_form':
                self::displayRegStudentForm();
                break;
            case 'book_student_form':
                self::displayBookStudentForm();
                break;
            case 'register_parent':
                self::registerParent();
                break;
            case 'register_student':
                self::registerStudent();
                break;
            case 'link_student':
                self::linkStudent();
                break;
            case 'place_on_waiting_list':
                self::placeOnWaitingList();
                break;
            case 'remove_from_waiting_list':
                self::removeFromWaitingList();
                break;
            case 'assign_temp_locker':
                self::assignTempLocker();
                break;
            case 'suspend_temp_locker':
                self::suspendTempLocker();
                break;
            case 'unsuspend_temp_locker':
                self::unsuspendTempLocker();
                break;
            default:
                self::viewReport();
                break;
        }
        exit;
    }


}