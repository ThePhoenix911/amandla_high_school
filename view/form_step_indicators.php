<!--        Indicates which form elements group is being viewed -->
<div id="form_indicators">
    <div class="form_group_indicator">
        <a href=".?action=register_parent_form">
            <span class="stage <?php if(in_array($action?? '', ['view_registration_forms', 'register_parent_form'])) echo 'active';?>" id="stage1">1</span>
        </a>
        <p>Register Parent</p>
    </div>
    <div class="form_group_indicator">
        <a href=".?action=register_student_form">
            <span class="stage <?php if(isset($action)) echo $action == 'register_student_form'? 'active': '' ;?>" id="stage2">2</span>
        </a>
        <p>Register Student</p>
    </div>
    <div class="form_group_indicator">
        <a href=".?action=book_student_form">
            <span class="stage <?php if(in_array($action?? '', ['book_student_form', 'link_student'])) echo 'active';?>" id="stage3">3</span>
        </a>
        <p>Book Locker</p>
    </div>
</div>