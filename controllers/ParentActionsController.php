<?php

use JetBrains\PhpStorm\NoReturn;

class ParentActionsController
{

    // Ensure the parent is logged in
    private static function checkParentLogin(): void
    {
        if (!isset($_SESSION['parent_user_id']) || !is_numeric($_SESSION['parent_user_id'])) {
            ParentAccountController::displayLoginForm();
            exit;
        }
    }

    //Display the Parent's Home Page with the list of registered students
    public static function displayRegisteredStudents(): void{

        self::checkParentLogin();

        $user_record = StudentParentDB::getParentUserByID($_SESSION['parent_user_id']);
        if (is_array($user_record)) {
            $parent_record = StudentParentDB::getParent($user_record['parentUserEmail']);
            if (is_array($parent_record)) {
                $_SESSION['parentName'] = $parent_record['parentFName'] . ' ' . $parent_record['parentLName'];
                $_SESSION['parent_id'] = $parent_record['parentID'];
                $students = StudentDB::getStudentsByParentID($parent_record['parentID']);
            } else {
                $students = [];
            }
        } else {
            $students = [];
        }

        include(__DIR__ . '/../parent/account/parent_home.php');
        exit;

    }

    //Display the form for registering a new student
    public static function displayRegStudentForm(): void{
        self::checkParentLogin();

        if (isset($_SESSION['parent_id'])) {
            $parent_id = $_SESSION['parent_id'];
        } else {
            $user_record = StudentParentDB::getParentUserByID($_SESSION['parent_user_id']);
            if (is_array($user_record)) {
                $parent_record = StudentParentDB::getParent($user_record['parentUserEmail']);
                if (is_array($parent_record)) {
                    $_SESSION['parentName'] = $parent_record['parentFName'] . ' ' . $parent_record['parentLName'];
                    $_SESSION['parent_id'] = $parent_record['parentID'];
                    $parent_id = $parent_record['parentID'];
                }
            }
        }

        include(__DIR__ . '/../parent/actions/register_student.php');
        exit;
    }


    //Register a new student
    public static function registerStudent(): void{
        self::checkParentLogin();

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
        for ($i = 0, $iMax = count($fields_results); $i < $iMax; $i++) {
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

        self::displayRegisteredStudents();
        exit;

    }

    #[NoReturn]
    public static function cancelApplication(): void{
        self::checkParentLogin();

        //Because we've added the ON DELETE CASCADE, it will create a chain reaction whereby
        //every table removes the relevant student data - as such removing from the student table is enough
        $student_num = trim(filter_input(INPUT_POST, 'student_num'));

        $row = StudentDB::deleteStudent($student_num);

        self::displayRegisteredStudents();
        exit;

    }

    public static function displayParentHome(): void
    {
        self::displayRegisteredStudents();
    }




    //Check Parent Actions and calls the appropriate method
    public static function checkParentAction($action) {
        Switch($action) {
            case 'register_student':
                self::registerStudent();
                break;
            case 'register_student_form':
                self::displayRegStudentForm();
                break;
            case 'cancel_application':
                self::cancelApplication();
                break;
            case 'parent_logout':
                self::parentLogout();
                break;
            default:
                self::displayRegisteredStudents();
        }
        exit;
    }


}