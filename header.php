<head>
    <title>
        <?PHP echo($title) ?>
    </title>
    <link rel="stylesheet" href="css/basestyle.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/strength.css"><script
			  src="https://code.jquery.com/jquery-3.3.1.js"
			  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
			  crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/strength.js"></script>
</head>
<body>
    <nav id="page-navigation">
        <?PHP
            session_start();

            // Menu to be displayed to authed users
            function echoNav(){
                // Need to decide what to put in nav
                echo("<a href='index.php'><li>Home</li></a>");
                echo("<a href='search.php'><li>Search</li></a>");
                echo("<a href='account.php'><li>Account</li></a>");
                echo("<a href='logout.php'><li>Logout</li></a>");
            }

            // Menu to be displayed to unauthed users
            function echoLogInMenu(){
                echo("<a href='login.php'><li>Login</li></a>");
                echo("<a href='account.php'><li>Register</li></a>");
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