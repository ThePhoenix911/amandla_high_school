<?php include __DIR__ . '/header.php'; ?>

<main id="wrapper">
    <div id="nav">
        <a class="nav_item <?php if(in_array($action?? '', ['admin_login', 'view_report'])) echo 'active_tab';?>" href="?action=view_report"><i class="fa-solid fa-file-lines"></i> MIS Report</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'view_temp_lockers'? 'active_tab': '' ;?>" href="?action=view_temp_lockers"><i class="fa-solid fa-boxes-stacked"></i> Temporary Lockers</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'view_waiting_list'? 'active_tab': '' ;?>" href="?action=view_waiting_list"><i class="fa-solid fa-list-ol"></i> Waiting List</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'view_locker_suspension'? 'active_tab': '' ;?>" href="?action=view_locker_suspension"><i class="fa-solid fa-ban"></i> Suspended Lockers</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'view_payments'? 'active_tab': '' ;?>" href="?action=view_payments"><i class="fa-solid fa-credit-card"></i> Payments</a>
        <a class="nav_item <?php if(isset($action)) echo $action === 'add_payment'? 'active_tab': '' ;?>" href="?action=add_payment"><i class="fa-solid fa-money-bill-transfer"></i> Add Payment</a>
        <a class="nav_item <?php if(in_array($action?? '', ['view_registration_forms', 'register_parent_form', 'register_student_form', 'book_student_form', 'link_student']))
            echo 'active_tab';?>" href="?action=view_registration_forms"><i class="fa-solid fa-user-plus"></i> Register Student
        </a>
    </div>

    <!-- Displays the form and it's navigation routes -->
    <div class="container">

