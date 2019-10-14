<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"])){
    header("Location: gamepage.php?game=$_POST[game]");
    exit();
}

$user = $_POST["user"];
$game = $_POST["game"];

#INVENTORY INFORMATION
$query = "SELECT * FROM db_outlive.inventory where game = $game and user = $user";
$result = mysqli_query($connection, $query);
$inventory = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>
<head>

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
<body class="background" style="background-color:#11121a">


        <div id = "header">
            <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#080d1b;position: fixed;top: 0;width: 100%;">
                <a href="#" style="color:#f1f0ea;font-size:4vh;margin-right:15px;text-decoration:none;" id="LogoName">Outlive Manual</a>

                <button class="navbar-toggler" style="background-color:#e7ecef;" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="SpanButton">
                    <span class="navbar-toggler-icon" style="height: 7vh;"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="#builds" style="color:#e7ecef;">Builds<span class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#house" style="color:#e7ecef;">House Updates<span class="sr-only">(current)</span></a>
                        </li>
                        <?php

                        echo '<li class="nav-item">
                                    <a class="nav-link" href="gamepage.php?game=' . $game . '" style="color:#e7ecef;">Back To Game<span class="sr-only">(current)</span></a>
                                </li>';


                        ?>
                        

                    </ul>

                </div>
            </nav>

	        <div id="builds" class="container" style="padding-top:15vh; color:#f1f0ea; background-color:#11121a;">
            <?php       
               echo '
                <center>
                    <h1>Builds</h1>
                </center>
                <h3 style="padding-top:30px;">Stove</h3>
                <p>A improvised stove that can cook improved food with basic ingredients using burning wood</p>
                <p>How To Make it:</p>';

                $quant = 1;
                if ($inventory["tools"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
                }

                $quant = 40;
                if ($inventory["woods"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
                }

                $quant = 75;
                if ($inventory["scraps"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Metal Scraps</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Metal Scraps</p>';
                }

                $quant = 16;
                if ($inventory["pipes"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
                }
                
                echo'
                <h3 style="padding-top:30px;">Bed</h3>
                <p>A basic bed to keep you of the ground, sleep in one can be really comfortable and restful</p>
                <p>How To Make it:</p>';

                $quant = 1;
                if ($inventory["tools"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
                }

                $quant = 80;
                if ($inventory["woods"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
                }

                $quant = 60;
                if ($inventory["nails"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Nails</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Nails</p>';
                }

                echo'
                <h3 style="padding-top:30px;">Workbench</h3>
                <p>Cant do much widauth one, some things need more tools</p>
                <p>How To Make it:</p>';
                $quant = 1;
                if ($inventory["tools"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
                }

                $quant = 60;
                if ($inventory["woods"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
                }

                $quant = 30;
                if ($inventory["nails"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Nails</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Nails</p>';
                }

                $quant = 40;
                if ($inventory["scraps"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Metal Scraps</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Metal Scraps</p>';
                }

                echo'
                <h3 style="padding-top:30px;">Chair</h3>
                <p>Not very comfortable but still good to rest during the days activities</p>
                <p>How To Make it:</p>';
                $quant = 1;
                if ($inventory["tools"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
                }

                $quant = 40;
                if ($inventory["woods"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
                }

                $quant = 30;
                if ($inventory["nails"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Nails</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Nails</p>';
                }

                echo'
                <h3 style="padding-top:30px;">Water Collector</h3>
                <p>Dont waste any rain day, every drop matters</p>
                <p>How To Make it:</p>';
                $quant = 1;
                if ($inventory["tools"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
                }

                $quant = 60;
                if ($inventory["woods"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
                }

                $quant = 50;
                if ($inventory["scraps"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Metal Scraps</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Metal Scraps</p>';
                }

                $quant = 25;
                if ($inventory["pipes"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
                }

                echo'
                <h3 style="padding-top:30px;">Farm</h3>
                <p>with some effort the results can meet your need, seeds are needed nothing comes out of nowhere</p>
                <p>How To Make it:</p>';
                $quant = 1;
                if ($inventory["tools"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
                }

                $quant = 65;
                if ($inventory["woods"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
                }

                $quant = 22;
                if ($inventory["nails"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Nails</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Nails</p>';
                }

                $quant = 12;
                if ($inventory["pipes"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
                }

                $quant = 1;
                if ($inventory["fertilizers"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Fertilizer</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Fertilizer</p>';
                }

            ?>
				

			</div>

            <div id="house" class="container" style="padding-top:15vh; color:#f1f0ea; background-color:#11121a;">
            <?php
               
               echo '
                <center>
                    <h1>House Updates</h1>
                </center>
                <center>
                    <p>The house updates will give you a aditional build space for each level</p>
                </center>
                <h3 style="padding-top:30px;">Level 1 Update</h3>';

                $quant = 1;
                if ($inventory["tools"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
                }

                $quant = 50;
                if ($inventory["woods"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
                }

                $quant = 40;
                if ($inventory["scraps"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Metal Scraps</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Metal Scraps</p>';
                }

                $quant = 20;
                if ($inventory["pipes"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
                }

                $quant = 5;
                if ($inventory["gears"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Gears</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Gears</p>';
                }




                echo '<h3 style="padding-top:30px;">Level 2 Update</h3>';

                $quant = 1;
                if ($inventory["tools"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
                }

                $quant = 100;
                if ($inventory["woods"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
                }

                $quant = 70;
                if ($inventory["scraps"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Metal Scraps</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Metal Scraps</p>';
                }

                $quant = 30;
                if ($inventory["pipes"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
                }

                $quant = 8;
                if ($inventory["gears"]>=$quant) {
                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Gears</p>';
                }else{
                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Gears</p>';
                }

            ?>
                

            </div>

        </div>
    </body>
</html>
