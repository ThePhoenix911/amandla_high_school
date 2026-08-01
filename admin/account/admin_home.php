<?php include __DIR__ . '/../../view/header_admin.php'; ?>



        <div id="dropdown" >
            <button>
                <?php if(isset($admin_record['adminFName']) && isset($admin_record['adminLName'])) {
                        echo $admin_record['adminFName'] . ' ' . $admin_record['adminLName'];
                    };
                ?>
                <i class="fa fa-caret-down"></i>
            </button>
            <div id="dropdown-profile">
                <a href="?action=admin_update_form">Edit Profile</a>
                <a href="?action=admin_logout">Logout</a>
            </div>
        </div>


<!--        <iframe-->
<!--                src="http://localhost:3000/public/dashboard/7d504ffc-9824-4cf6-8a37-3efbdc6d21b6"-->
<!--                frameborder="0"-->
<!--                width="800"-->
<!--                height="600"-->
<!--                allowtransparency-->
<!--        ></iframe>-->

            <iframe src="../../mis_report.pdf" class="pdf-container">
                This browser does not support PDFs. Please download the PDF to view it:
                <a href="../../mis_report.pdf">Download PDF</a>
            </iframe>

    </div>
</main>

<?php include __DIR__ . '/../../view/footer.php'; ?>
