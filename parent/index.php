<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require_once __DIR__ . '/../model/FieldRequirements.php';
require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../model/StudentParentDB.php';
require_once __DIR__ . '/../model/StudentParent.php';
require_once __DIR__ . '/../model/StudentDB.php';
require_once __DIR__ . '/../model/Student.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../utils/Validate.php';
require_once __DIR__ . '/../controllers/ParentAccountController.php';
require_once __DIR__ . '/../controllers/ParentActionsController.php';



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
    default => 'parent_login_form'
};

//Check if the action starts with 'parent' to route to ParentAccountController
$prefix = substr($action, 0, 6);


if($prefix === 'parent') {
    ParentAccountController::checkAccountAction($action);
} else {
    //Default action
    ParentActionsController::checkParentAction($action);
}

?>