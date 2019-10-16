<!DOCTYPE html>
<html>
    <head id="config">

        <title>OUTLIVE</title>

        <meta charset = "utf-8">                
        <meta content="width=device-width, initial-scale=1">

        <link rel = stylesheet type = text/css href = style.css>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <style type="text/css">
            p, a{
                margin:0px;
                padding:0px;
            }
            body{
                color: #f1f0ea;
            }
            html {
                font-size: 3vh;
            }

            @font-face{
                font-family: 'pixel';
                src: url('font/pixel1.ttf');
            }

            a, h1, h2, h3, p, li, button, label
            {
                font-family: 'pixel', Arial;
                font-style: normal;
                font-weight: 100;
                text-decoration: none;
            }
        </style>


    </head>

    <!-- 
    #f1f0ea - base white
    #11121a - base black
    #0b1428 - blue black
    #f2cd5d - carton yellow
    #8fcb9b - Green
    #ef3e36 - Red
     -->

     <!-- 
    32 by 32 pixel art
    scale to 1920x1024
     -->
    <body class="background" style="background-color:#11121a">


        <div id = "header">
            <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#080d1b;">
                <a href="index.php" style="color:#f1f0ea;font-size:4vh;margin-right:15px;text-decoration:none;" id="LogoName">Outlive</a>

                <button class="navbar-toggler" style="background-color:#e7ecef;" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="SpanButton">
                    <span class="navbar-toggler-icon" style="height: 7vh;"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item active">
                            <a class="nav-link" href="index.php" style="color:#e7ecef;">Home<span class="sr-only">(current)</span></a>
                        </li>

                        <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                            
                        }if(isset($_SESSION['username'])) {
                            if(!$_SESSION['username']){
                                echo '<li class="nav-item">
                                    <a class="nav-link" href="registerpage.php" style="color:#e7ecef;">Register</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="loginpage.php" style="color:#e7ecef;">Login</a>
                                </li>';
                            }else{
                                echo '<li class="nav-item">
                                    <a class="nav-link" href="userpage.php" style="color:#e7ecef;">Play</a>
                                </li>';
                                
                            }
                        }else{
                                echo '<li class="nav-item">
                                <a class="nav-link" href="registerpage.php" style="color:#e7ecef;">Register</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="loginpage.php" style="color:#e7ecef;">Login</a>
                            </li>';
                        }
                        
                        ?>

                    </ul>

                    <li class="nav-item">
                        <small>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">flaticon</a></small>
                    </li>

                </div>
            </nav>
        </div>
    </body>
</html>