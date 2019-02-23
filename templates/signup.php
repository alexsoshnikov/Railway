
<?php 

require_once "db.php";

?>
    <div class="whiteBox_signUp">

       
        <div id="successRegistrationMain">
            <div class="successRegistration">Вы успешно зарегистрированны!</div>
            <div id="signinAfterUp"><a href="index.php?page=signin">SIGN IN</a></div>
        </div>

       
        <div class="header_whiteBox_signUp" id="header_whiteBox_signUp_id">Sign Up</div>
        <div class="listSignUp">
            <ul>
                <li >Name:</li>
                <li>Surname:</li>
                <li>Passport:</li>
                <li>Telephone:</li>
                <li>Email:</li>
                <li>Password:</li>
                <li>Repeat Password:</li>
            </ul>
        </div>
        <form id="form_signUp" action="index.php?page=signup" method="POST">
            <div class="signUp">
                <input class="text" type="text" placeholder="Name" id="signUp_name" name="name" >
                <br>
                <input class="text" type="text" placeholder="Surname" id="signUp_surname" name="surname" >
                <br>
                <input class="text" type="text" placeholder="1111-111111" id="signUp_passport" name="passport">
                <br>
                <input class="text" type="text" placeholder="+7(900)111-11-11" name="telephone" id="signUp_telephone">
                <br>
                <input class="text" type="email" placeholder="Email" name="email" id="signUp_email" >
                <br>
                <input class="text" type="Password" placeholder="Password" id="signUp_password" name="password_1">
                <br>
                <input class="text" type="Password" placeholder="Password" name="password_2"
                id="signUp_password_2">
                
                <div class="signUpButton">
                    <input class="submit" type="submit" value="Sign Up" name="do_signup" id="do_signupButton"> </div>
            </div>
        </form>
    </div>
    
   



<!--
        <div class="successRegistrationMain">
            <div class="successRegistration">Вы успешно зарегистрированны!</div>
            <div id="signinAfterUp"><a href="index.php?page=signin">SIGN IN</a></div>
        </div>
-->


<!--
// $header = 'Sign Up';
//    if(isset($_POST['do_signup']))
//    {
//        
//        
//        // создание массива в котором хранятся ошибки 
//        // проверка боксов на пустые значения 
//        $errors = array();
//        if (trim($_POST['name']) == '')
//        {
//            $errors[] = 'Enter your name!' ;
//        }
//        
//         if (trim($_POST['surname']) == '')
//        {
//            $errors[] = 'Enter your surname!' ;
//        }
//        
//         if (trim($_POST['passport']) == '')
//        {
//            $errors[] = 'Enter your passport!' ;
//        }
//        
//         if (trim($_POST['telephone']) == '')
//        {
//            $errors[] = 'Enter your telephone!' ;
//        }
//          
//         if (trim($_POST['email']) == '')
//        {
//            $errors[] = 'Enter your email!' ;
//        }
//        
//          if (trim($_POST['password_1']) == '' )
//        {
//            $errors[] = 'Enter your password!' ;
//        }
//           if (trim($_POST['password_2']) == '' )
//        {
//            $errors[] = 'Repeat your password!' ;
//        }
//        
//          if ( $_POST['password_2'] != $_POST['password_1'] )
//        {
//           $errors[] = 'Re-password entered incorrectly!';
//        }
//          //проверка паспорта 
//          if ( R::count('users', "passport = ?", array($_POST['passport'])) > 0)
//        {
//           $errors[] = 'A user with this passport already exists!';
//        }
//        //проверка телефона 
//           if ( R::count('users', "telephone = ?", array($_POST['telephone'])) > 0)
//        {
//           $errors[] = 'A user with this telephone already exists!';
//        }
//        //проверка мейла 
//        if ( R::count('users', "email = ?", array($_POST['email'])) > 0)
//        {
//           $errors[] = 'A user with this Email already exists!';
//        }
//        
//        if ( empty($errors) )
//        { 
//        //заргужаем данные в бд в случае успеха 
//          $user = R::dispense('users');
//          $user->name = $_POST['name'];
//          $user->surname = $_POST['surname'];
//          $user->passport = $_POST['passport']; 
//          $user->telephone = $_POST['telephone'];
//          $user->email = $_POST['email'];
//          $user->password = password_hash($_POST['password_1'], PASSWORD_DEFAULT);
//          R::store($user);
//            
//               // успешно зарегистрирован
//            
//        }
//         else
//        {
//              //выводим ошибки регистрации
//           $header = array_shift($errors);
//        }
//            
//}-->
