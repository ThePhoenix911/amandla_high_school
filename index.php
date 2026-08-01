<?php
session_start();
// In Project Amandla/index.php

require_once __DIR__ . '/vendor/autoload.php'; // Ensure autoload is included

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


// The idea is to check if an action has been taken by the user using the GET/POST method and if not, force the user to stay in the login page
// if the value of the action variable is not empty that means the user has performed
$action = match(True) {
    //checks if the action variable is null,
    //The idea is to check if the action variable is null and if it is, don't do anything
    //if it's not null return the value positioned on the right side of the arrow
    //without the negate operation, the following two statements will not be accessed when action variable is not null
    !(is_null(filter_input(INPUT_POST, 'action'))) => filter_input(INPUT_POST,'action'),
    !(is_null(filter_input(INPUT_GET, 'action'))) => filter_input(INPUT_GET,'action'),
    default => 'home'
};


switch ($action) {
    case 'home':
        include("home.php");
        break;

    case 'admin_login_form':
        unset($_SESSION['user_id']);
        header('Location: ./admin/index.php?action=admin_login_form');
        exit;

    case 'parent_login_form':
        unset($_SESSION['parent_user_id']);

        header('Location: ./parent/index.php?action=parent_login_form');
        exit;

    default:
        include("home.php");
        break;
}

