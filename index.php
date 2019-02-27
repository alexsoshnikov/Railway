<?php 
require "db.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="main.js"></script>
        <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <title>Railway Company</title>
    </head>

    <body>
        <div class="wrapper">
            <div class="header">
               <?php 
                 if(!isset($_SESSION['logged_user'])) {
                  if (!isset($page) || $page == 'signin' || $page == 'signup') {
                          require('templates/header_logout.php'); } 
                 }
                 else {
                      require('templates/header_login.php');
                 }
                 
                ?>
            </div>
            <div class="main">
                <?php 
                $page = $_GET['page'];

                      if (!isset($page)) {
                          require('templates/main.php');
                      } elseif ($page == 'signin') {
                          require('templates/signin.php');
                      } elseif ($page == 'signup') {
                          require('templates/signup.php');
                     } elseif ($page == 'payment') {
                          require('templates/payment.php');
                     } 
            ?>
            </div>
            <div class="footer">
                <div class="contact">
                    <ul>
                        <li><a href="#">Company Information </a> </li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Reviews</a></li>
                        <li><a href="#">Terms of service</a></li>
                    </ul>
                </div>
                <div class="copyright">
                    <h6>&copy; COPYRIGHT - RAILWAY COMPANY 2019. ALL RIGHTS RESERVED.</h6> </div>
            </div>
        </div>
    </body>

    </html>