<?php include __DIR__ . '/view/header.php'; ?>

    <main id="home">
        <div class="hero_section">
            <span class="hero_badge"><i class="fa-solid fa-graduation-cap"></i> Portal Gateway</span>
            <h2>Welcome to Amandla High School</h2>
            <p class="hero_subtitle">Please choose your portal to access locker management, student registrations, and records.</p>
        </div>

        <div id="wrapper">
            <a href=".?action=admin_login_form" id="open_admin_page" class="portal_card admin_card">
                <div class="card_icon_wrap">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <span>Admin Page</span>
                <p class="card_desc">Manage lockers, payments, and view school reports</p>
                <div class="card_btn_cue">Enter Portal <i class="fa-solid fa-arrow-right"></i></div>
            </a>
            
            <a href=".?action=parent_login_form" id="open_parent_page" class="portal_card parent_card">
                <div class="card_icon_wrap">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span>Parent Page</span>
                <p class="card_desc">Register students, view assigned lockers, and status</p>
                <div class="card_btn_cue">Enter Portal <i class="fa-solid fa-arrow-right"></i></div>
            </a>
        </div>
    </main>

<?php include __DIR__ . '/view/footer.php'; ?>