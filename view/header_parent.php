<?php include __DIR__ . '/header.php'; ?>

<main>
    <div id="nav">
        <a class="nav_item <?php if(in_array($action?? '', ['parent_home', 'parent_login', 'view_students'])) echo 'active_tab';?>" href="?action=view_students"><i class="fa-solid fa-users"></i> View Students</a>
        <a class="nav_item <?php if(in_array($action?? '', ['register_student_form', 'book_student_form', 'link_student']))
            echo 'active_tab';?>" href="?action=register_student_form"><i class="fa-solid fa-user-plus"></i> Register Student
        </a>
    </div>

    <!-- Displays the form and it's navigation routes -->
    <div class="container">

