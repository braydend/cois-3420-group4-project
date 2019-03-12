<head>
    <title>
        <?PHP echo($title) ?>
    </title>
    <link rel="stylesheet" href="css/basestyle.css" />
</head>
<body>
    <nav id="page-navigation">
        <?PHP
            session_start();

            // Menu to be displayed to authed users
            function echoNav(){
                // Need to decide what to put in nav
                echo("<li>Nav Item 1</li>");
                echo("<li>Nav Item 2</li>");
                echo("<li>Nav Item 3</li>");
                echo("<li><a href='logout.php'>Logout</a></li>");
            }

            // Menu to be displayed to unauthed users
            function echoLogInMenu(){
                echo("<li><a href='login.php'>Login</a></li>");
                echo("<li><a href='register.php'>Register</a></li>");
            }

            // To display to the users where they are on the site
            function echoBreadcrumbs($title){
                // Need to add logic to change this dynamically
                // Maybe use $title?
                echo("<span>You are on " . $title . "</span>");
            }

            // Logic controlling which menu to display based
            // on whether or not the user is logged in
            echoBreadcrumbs($title);
            echo("<ul>");
            if(isset($_SESSION['userid'])){
                echoNav();
            }else{
                echoLogInMenu();
            }
            echo("</ul>");
        ?>
    </nav>