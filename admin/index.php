<?php
require_once('../model/FieldRequirements.php');
require_once('../model/Database.php');
require_once('../model/AdminDB.php');
require_once('../model/Admin.php');
require_once('../model/StudentParentDB.php');
require_once('../model/StudentParent.php');
require_once('../model/StudentDB.php');
require_once('../model/Student.php');
require_once('../model/User.php');
require_once('../utils/Validate.php');
require_once('../model/LockerDB.php');
require_once('../model/TempLockerDB.php');
require_once('../model/YearLockerDB.php');
require_once('../model/WaitingListDB.php');
require_once('../model/LockerSuspensionDB.php');
require_once('../utils/SendMail.php');
require_once('../model/PaymentDB.php');
require_once('../admin/AccountController.php');
require_once('../admin/ActionsController.php');


session_start();




// The idea is to check if an action has been taken by the user using the GET/POST method and if not, force the user to stay in the login page
// if the value of the action variable is not empty that means the user has performed
$action = match(True) {
    //checks if the action variable is null,
    //The idea is to check if the action variable is null and if it is, don't do anything
    //if it's not null return the value positioned on the right side of the arrow
    //without the negate operation, the following two statements will not be accessed when action variable is not null
    !(is_null(filter_input(INPUT_POST, 'action'))) => filter_input(INPUT_POST,'action'),
    !(is_null(filter_input(INPUT_GET, 'action'))) => filter_input(INPUT_GET,'action'),
    default => 'admin_login_form'
};





if(isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
    //Get the Admin's data
    $admin_record = AdminDB::getAdminByID($_SESSION['user_id']);

}

$prefix = substr($action, 0, 5);

if($prefix === 'admin') {
   AccountController::checkAccountAction($action);
} else {
    //Default action
    ActionsController::checkAdminAction($action);
}