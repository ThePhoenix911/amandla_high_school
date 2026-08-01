<?php include __DIR__ . '/header.php'; ?>

<main id="wrapper">
    <div id="nav">
        <a class="nav_item <?php if(in_array($action?? '', ['admin_login', 'view_report'])) echo 'active_tab';?>" href="?action=view_report">View MIS Report</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'view_temp_lockers'? 'active_tab': '' ;?>" href="?action=view_temp_lockers">View Temporary Lockers</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'view_waiting_list'? 'active_tab': '' ;?>" href="?action=view_waiting_list">View Waiting List</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'view_locker_suspension'? 'active_tab': '' ;?>" href="?action=view_locker_suspension">View Suspended Lockers</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'view_payments'? 'active_tab': '' ;?>" href="?action=view_payments">View Payments</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'add_payment'? 'active_tab': '' ;?>" href="?action=add_payment">Register Payments</a>
        <a class="nav_item <?php if(in_array($action?? '', ['view_registration_forms', 'register_parent_form', 'register_student_form', 'book_student_form', 'link_student']))
            echo 'active_tab';?>" href="?action=view_registration_forms">Register Student
        </a>

    </div>


    <div id="dropdown" >
        <button>
            <?php
                if(isset($_SESSION['adminName'])) {
                    echo $_SESSION['adminName'];
                }
            ?>
            <i class="fa fa-caret-down"></i>
        </button>
        <div id="dropdown-profile">
            <a href="?action=admin_logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Displays the form and it's navigation routes -->
    <div class="container">

