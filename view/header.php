<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amandla High School</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="/style.css">

<!-- Icons -->
 <script src="https://kit.fontawesome.com/19f2702713.js" crossorigin="anonymous"></script>


    <!-- Favicon -->
    <link rel="shortcut icon" href="/images/a-solid-full.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/a-solid-full.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/a-solid-full.png">
    <link rel="icon" sizes="192x192" href="/images/a-solid-full.png">

    <!-- Theme Initialization -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('mandla_theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
</head>
<body>
   <header>
        <h1>
            <a href="/" title="Amandla High School - Return to Main Page">Amandla High School</a>
        </h1>
        <div class="header_controls">
            <button id="theme_toggle" class="theme_toggle" title="Toggle Light/Dark Theme" aria-label="Toggle Light/Dark Theme">
                <i class="fa-solid fa-moon"></i>
            </button>
            <?php if(!empty($_SESSION['adminName'])): ?>
                <div id="dropdown">
                    <button type="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-circle-user"></i>
                        <span><?php echo htmlspecialchars($_SESSION['adminName']); ?></span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div id="dropdown-profile">
                        <a href="?action=admin_logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </div>
            <?php elseif(!empty($_SESSION['parentName']) || !empty($parent_record['parentFName'])): ?>
                <div id="dropdown">
                    <button type="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-circle-user"></i>
                        <span>
                            <?php 
                                if(!empty($_SESSION['parentName'])) {
                                    echo htmlspecialchars($_SESSION['parentName']);
                                } else {
                                    echo htmlspecialchars($parent_record['parentFName'] . ' ' . $parent_record['parentLName']);
                                }
                            ?>
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div id="dropdown-profile">
                        <a href="?action=parent_logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
   </header>