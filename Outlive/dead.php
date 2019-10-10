<?php
include('login_veryfy.php')
?>
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
     -->

     <!-- 
    32 by 32 pixel art
    scale to 1920x1024
     -->
    <body class="background" style="background-color:#11121a">
        <div class="container">
            <center>
                <h1 class="display-1">You Died</h1>
            </center>
            <?php
                include("connect.php");
                $game = $_GET["game"];

                #PLAYER INFORMATION
                $query = "SELECT * FROM db_outlive.player WHERE game = $game";
                $result = mysqli_query($connection, $query);
                $player = mysqli_fetch_array($result);

                if($player["life"]>0){
                    header("Location: userpage.php");
                }

                $query = "SELECT * FROM db_outlive.game where id = $game";
                $result = mysqli_query($connection, $query);
                $game = mysqli_fetch_array($result);

                echo $game["story"];

            ?>
        </div>

    </body>
</html>