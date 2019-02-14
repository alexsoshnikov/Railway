<?php 
require "db.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <script src="js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <title>Railway Company</title>
    </head>

    <body>
        <div class="wrapper">
            <div class="header">
                <a href="index.php">
                    <div class="logo"></div>
                </a>
                <a href="index.php">
                    <div class="companyName">Railway company</div>
                </a>
                <ul class="menu">
                    <li><a href="index.php?page=signin">SIGN IN</a></li>
                    <li><a href="index.php?page=signup">SIGN UP</a></li>
                </ul>
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