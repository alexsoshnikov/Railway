<?php 
require "db.php";
include("app/classes_search.php");
// на вход получаем два имени станций откуда и куда
$city_from = $_SESSION['from'];  
$city_to = $_SESSION['to'];   

$search = new SearchRoute(); 
$information = new SearchInfo();
$tickets = new PurchaseInfo();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="shortcut icon" href="img/train.ico" type="image/x-icon">
        <link rel="stylesheet" href="style/normalize.css">
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="main.js"></script>
        <link href="style/datepicker.min.css" rel="stylesheet" type="text/css">
        <script src="js/datepicker.min.js"></script>
        <script src="js/i18n/datepicker.en.js"></script>
        <script src="js/jquery.card.js"></script>
        <link rel="stylesheet" type="text/css" href="js/slick-1.8.1/slick/slick.css" />
        <link rel="stylesheet" type="text/css" href="js/slick-1.8.1/slick/slick-theme.css" />
        <script type="text/javascript" src="js/slick-1.8.1/slick/slick.min.js"></script>
        <meta charset="UTF-8">
        <title>Railway company</title>
    </head>

    <body>
        <div class="container">
            <header class="main-header">
                <div class="logo-name">
                    <div class="main-header-logo">
                        <svg height="60" id="Layer_1" -0 viewBox="0 0 800 800" width="60" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g>
                                <path d="M663.054,133.557c0.132-0.073,0.772-0.248,0.904-0.285c3.336-1.034,6.076-3.541,7.591-6.709   c1.53-3.17,1.72-6.819,0.51-10.127l-5.085-13.981c-2.463-6.775-9.951-10.272-16.728-7.81L12.03,326.94   c-6.775,2.47-10.272,9.96-7.81,16.735l5.084,13.952c1.195,3.293,3.832,5.894,7.023,7.351c3.118,1.421,6.804,1.486,10.039,0.313   c10.739-4.021,23.241,1.508,27.248,12.517c3.978,10.928-1.675,23.052-11.977,26.826c-0.307,0.087-0.904,0.276-1.195,0.385   c-6.775,2.464-10.273,9.953-7.81,16.729l8.859,24.325c1.209,3.33,3.73,6.025,6.964,7.468c3.089,1.378,6.601,1.486,9.763,0.335   c0.248-0.088,0.452-0.168,0.86-0.35c10.855-3.759,22.789,1.895,26.723,12.722c3.978,10.927-1.676,23.059-11.977,26.831   c-0.306,0.081-0.888,0.27-1.195,0.379c-6.775,2.471-10.271,9.959-7.81,16.735l8.058,22.126c2.463,6.775,10.52,10.047,17.295,7.583   c10.929-3.978,23.051,1.668,27.029,12.597c3.978,10.928-1.676,23.059-11.977,26.832c-0.321,0.087-0.904,0.27-1.195,0.378   c-6.775,2.472-10.272,9.96-7.81,16.736l8.859,24.318c2.463,6.775,10.506,10.039,17.281,7.576   c10.927-3.978,23.051,1.668,27.029,12.604c3.978,10.928-1.675,23.058-11.978,26.824c-0.305,0.087-0.903,0.278-1.194,0.387   c-6.775,2.463-10.272,9.951-7.81,16.728l4.619,12.668c2.463,6.77,9.952,10.273,16.728,7.804l638.217-232.296   c6.775-2.463,10.271-9.96,7.81-16.734l-4.634-12.698c-1.21-3.321-3.716-6.018-6.951-7.461c-3.088-1.377-6.6-1.493-9.776-0.341   c-0.292,0.101-0.933,0.386-1.195,0.51c-10.928,3.978-23.065-1.676-27.043-12.604c-3.979-10.929,1.676-23.051,12.473-26.986h0.014   c0.146-0.044,0.803-0.241,0.948-0.292c3.293-1.107,6.134-3.519,7.692-6.695c1.546-3.183,1.735-6.855,0.525-10.177l-8.874-24.385   c-1.209-3.33-3.715-6.025-6.936-7.461c-3.104-1.384-6.615-1.5-9.792-0.35c-0.276,0.102-0.946,0.394-1.194,0.503   c-10.928,3.978-23.065-1.675-27.043-12.604c-3.978-10.92,1.675-23.043,12.589-27.013c0.188-0.008,0.655-0.196,0.743-0.226   c3.482-1.129,6.193-3.49,7.766-6.681c1.574-3.191,1.778-6.885,0.555-10.229l-8.073-22.199c-1.208-3.308-3.701-5.989-6.906-7.438   c-3.205-1.443-6.877-1.552-10.141-0.255l-0.89,0.394c-10.927,3.978-23.052-1.675-27.029-12.604   c-3.977-10.928,1.677-23.051,12.459-26.978c0-0.008,0-0.008,0-0.008c0.13-0.036,0.743-0.218,0.858-0.254   c3.514-1.072,6.208-3.49,7.782-6.681c1.559-3.19,1.763-6.885,0.554-10.229l-8.889-24.392c-1.21-3.323-3.716-6.019-6.95-7.454   c-3.089-1.384-6.6-1.5-9.777-0.349c-0.292,0.102-0.918,0.386-1.194,0.503c-10.929,3.977-23.066-1.668-27.044-12.597   C646.443,149.671,652.082,137.549,663.054,133.557z M674.827,200.356l0.904,2.514c-17.341,11.89-25.18,34.438-17.661,55.084   c7.504,20.647,28.021,32.886,48.944,30.847l0.115,0.328c-17.338,11.883-25.178,34.438-17.674,55.078   c7.519,20.646,28.02,32.886,48.944,30.846l0.917,2.513c-14.265,9.777-21.943,26.789-20.078,44.013l-94.433,34.363   c-6.775,2.471-10.273,9.96-7.81,16.735c2.462,6.775,9.966,10.265,16.741,7.803l95.263-34.678   c4.969,6.272,11.409,11.104,18.622,14.155L171.581,669.617c5.755-11.271,7.008-24.807,2.346-37.606   c-7.388-20.291-27.321-32.464-48.186-30.797l-1.079-2.972c16.917-11.991,24.494-34.271,17.077-54.677   c-7.388-20.29-27.335-32.45-48.186-30.796l-0.292-0.779c16.931-11.992,24.508-34.271,17.077-54.677   c-7.431-20.406-27.553-32.596-48.215-30.905l-1.049-2.863c16.916-11.984,24.508-34.263,17.078-54.67   c-4.911-13.5-15.388-23.401-27.889-28.063l422.714-153.86l9.164,25.178c2.464,6.768,9.968,10.265,16.729,7.803   c6.775-2.463,10.271-9.96,7.81-16.735l-9.164-25.17l131.689-47.931c-3.262,5.741-5.303,12.152-5.944,18.79l-102.534,37.323   c-6.775,2.462-10.273,9.959-7.81,16.735c2.463,6.775,9.966,10.264,16.741,7.802l98.688-35.924   C637.22,192.175,655.797,202.215,674.827,200.356z" />
                                <path d="M551.981,365.815c-6.776,2.469-10.273,9.959-7.81,16.734l12.151,33.36   c2.462,6.775,9.952,10.272,16.728,7.803c6.775-2.463,10.271-9.952,7.794-16.728l-12.137-33.36   C566.245,366.85,558.757,363.353,551.981,365.815z" />
                                <path d="M527.443,298.411c-6.774,2.469-10.271,9.959-7.81,16.734l12.151,33.36   c2.463,6.775,9.952,10.272,16.728,7.804c6.776-2.464,10.272-9.953,7.811-16.728l-12.151-33.36   C541.708,299.445,534.219,295.948,527.443,298.411z" />
                                <path d="M502.833,230.809c-6.774,2.463-10.257,9.96-7.794,16.735l12.137,33.36   c2.462,6.775,9.967,10.265,16.727,7.803c6.775-2.462,10.272-9.959,7.81-16.734l-12.151-33.36   C517.099,231.836,509.608,228.347,502.833,230.809z" />
                                <path d="M183.529,423.071l-58.852,21.419c-6.775,2.463-10.272,9.96-7.795,16.735   c2.462,6.769,9.951,10.265,16.727,7.803l17.136-6.244l21.798,59.858c2.463,6.774,9.952,10.271,16.727,7.802   c6.776-2.463,10.273-9.96,7.81-16.734l-21.798-59.857l17.164-6.243c6.776-2.471,10.273-9.96,7.81-16.735   C197.793,424.1,190.289,420.608,183.529,423.071z" />
                                <path d="M285,445.947c3.177-4.647,4.736-9.187,5.376-13.15c1.792-11.036-2.812-22.22-12.065-29.198   c-13.871-10.426-41.307-0.926-56.417,5.667c-0.117,0.044-0.204,0.124-0.306,0.168c-0.219,0.064-0.438,0.087-0.656,0.167   c-6.775,2.47-10.257,9.96-7.794,16.734l26.198,71.994c2.462,6.776,9.966,10.273,16.727,7.804c6.775-2.463,10.272-9.96,7.81-16.735   l-8.247-22.635c3.147-1.254,6.047-2.558,8.67-3.912l29.738,23.575c3.687,2.914,8.466,3.533,12.575,2.032   c2.199-0.794,4.21-2.192,5.756-4.159c4.488-5.653,3.54-13.864-2.128-18.338L285,445.947z M242.059,429.468   c8.991-3.06,17.616-4.96,21.158-4.458c0.684,0.706,1.646,2.004,1.398,3.592c-0.554,3.365-5.654,8.743-17.878,13.718   L242.059,429.468z" />
                                <path d="M343.006,373.749c-3.687-4.007-9.442-5.216-14.513-3.257c-5.042,2.04-8.291,6.994-8.145,12.437   l2.069,80.781c0.189,7.205,6.178,12.901,13.39,12.72c7.241-0.182,12.91-6.177,12.72-13.39l-0.16-5.88l26.927-9.799l5.187,5.646   c3.686,3.993,9.267,5.174,14.075,3.425c1.574-0.568,3.075-1.457,4.372-2.659c5.305-4.889,5.654-13.149,0.758-18.455   L343.006,373.749z M347.669,429.629l-0.32-12.618l8.771,9.536L347.669,429.629z" />
                                <path d="M394.383,346.604c-6.761,2.47-10.258,9.966-7.795,16.734l26.154,71.85   c2.462,6.775,9.952,10.271,16.727,7.803c6.775-2.463,10.273-9.959,7.81-16.734l-26.154-71.85   C408.662,347.638,401.158,344.141,394.383,346.604z" />
                                <path d="M488.364,312.129c-6.775,2.47-10.272,9.959-7.81,16.735l13.128,36.069l-49.424-31.239   c-1.166-0.737-2.404-1.203-3.673-1.53c-0.275-0.087-0.566-0.167-0.858-0.233c-0.248-0.043-0.511-0.08-0.758-0.109   c-2.128-0.343-4.342-0.219-6.498,0.568c-6.776,2.462-10.272,9.959-7.81,16.735l26.284,72.22c2.477,6.776,9.967,10.265,16.742,7.804   c6.775-2.471,10.258-9.96,7.796-16.736l-13.274-36.485l49.847,31.51c3.482,2.201,7.722,2.586,11.452,1.231   c1.312-0.481,2.579-1.181,3.716-2.099c4.343-3.512,5.988-9.384,4.08-14.637l-26.212-72.002   C502.629,313.156,495.14,309.667,488.364,312.129z" /> </g>
                        </svg>
                    </div>
                    <h1 class="main-header-name"><a href="index.php">Railway Company</a></h1> </div>
                <?php 
                 if(!isset($_SESSION['logged_user'])) {
                  if (!isset($page) || $page == 'signin' || $page == 'signup') {
                          require('templates/header_logout.php'); } 
                 }
                 else {
                      require('templates/header_login.php');
                 }
                 
                ?>
            </header>
            <main class="main-content">
                <?php 
                $page = $_GET['page'];

                      if (!isset($page)) {
                          require('templates/main.php');
                      } elseif ($page == 'signin') {
                          require('templates/signin.php');
                      } elseif ($page == 'signup') {
                          require('templates/signup.php');
                     } elseif($page == 'history') {
                          require('templates/history.php');
                     } elseif ($page == 'payment') {
                          require('templates/payment.php');
                     } elseif ($page == 'schedule') {
                          require('templates/schedule.php');
                     } elseif ($page == 'purchase') {
                         $id = $_GET['id'];
                         $purchase = [];
                         foreach ($search -> AllCalculate($city_from, $city_to) as $key) {
                            if($key['ID'] == $id ){
                                 $purchase = $key;
                                 break; 
                               }
                           }
                         require('templates/buy_ticket.php');
                     }
            ?>
            </main>
            <footer class="main-footer">
                <section class="main-footer-toy-train">
                    <div class="toy-train">
                        <div class="engine">
                            <div class="window">
                                <div class="engine-main">
                                    <div class="smokes"> <span></span> </div>
                                </div>
                            </div>
                            <div class="engine-body">
                                <div class="wheels">
                                    <div class="big-wheel"></div>
                                    <div class="normal-wheel"></div>
                                </div>
                            </div>
                        </div>
                        <div class="locomotive">
                            <div class="trash"></div>
                            <div class="wheels">
                                <div class="normal-wheel"></div>
                                <div class="normal-wheel"></div>
                            </div>
                        </div>
                        <div class="tracks"> <span></span> <span></span> </div>
                    </div>
                </section>
                <section class="main-footer-social"> <a href="#" class="social-button facebook"><i class="fa fa-facebook"></i></a><a href="#" class="social-button twitter"><i class="fa fa-twitter"></i></a><a href="#" class="social-button google"><i class="fa fa-google"></i></a></section>
                <section class="main-footer-copyright"> <span>&copy; copyright - railway company 2019.</span> <span>all rights reserved.</span>
                    <h6><a href="#">private policy</a> / <a href="#">terms of service</a></h6> </section>
            </footer>
        </div>
    </body>

    </html>