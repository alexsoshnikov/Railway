<?php 
require_once "db.php";

 $header = 'Sign Up';
    if(isset($_POST['do_signup']))
    {
        
        
        // создание массива в котором хранятся ошибки 
        // проверка боксов на пустые значения 
        $errors = array();
        if (trim($_POST['name']) == '')
        {
            $errors[] = 'Enter your name!' ;
        }
        
         if (trim($_POST['surname']) == '')
        {
            $errors[] = 'Enter your surname!' ;
        }
        
         if (trim($_POST['passport']) == '')
        {
            $errors[] = 'Enter your passport!' ;
        }
        
         if (trim($_POST['telephone']) == '')
        {
            $errors[] = 'Enter your telephone!' ;
        }
          
         if (trim($_POST['email']) == '')
        {
            $errors[] = 'Enter your email!' ;
        }
        
          if (trim($_POST['password_1']) == '' )
        {
            $errors[] = 'Enter your password!' ;
        }
           if (trim($_POST['password_2']) == '' )
        {
            $errors[] = 'Repeat your password!' ;
        }
        
          if ( $_POST['password_2'] != $_POST['password_1'] )
        {
           $errors[] = 'Re-password entered incorrectly!';
        }
          //проверка паспорта 
          if ( R::count('users', "passport = ?", array($_POST['passport'])) > 0)
        {
           $errors[] = 'A user with this passport already exists!';
        }
        //проверка телефона 
           if ( R::count('users', "telephone = ?", array($_POST['telephone'])) > 0)
        {
           $errors[] = 'A user with this telephone already exists!';
        }
        //проверка мейла 
        if ( R::count('users', "email = ?", array($_POST['email'])) > 0)
        {
           $errors[] = 'A user with this Email already exists!';
        }
        
        if ( empty($errors) )
        { 
        //заргужаем данные в бд в случае успеха 
          $user = R::dispense('users');
          $user->name = $_POST['name'];
          $user->surname = $_POST['surname'];
          $user->passport = $_POST['passport']; 
          $user->telephone = $_POST['telephone'];
          $user->email = $_POST['email'];
          $user->password = password_hash($_POST['password_1'], PASSWORD_DEFAULT);
          R::store($user);
            
            
            
               // успешно зарегистрирован
            
        }
         else
        {
              //выводим ошибки регистрации
           $header = array_shift($errors);
        }
            
}

?>
    <div class="whiteBox_signUp">
        <div class="header_whiteBox_signUp ">
            <?php 
              if ($header == 'Sign Up')
              {  echo $header;}
              else
              {   echo '<font color=red>'.$header.'</font>';  }
            ?></div>
        <div class="listSignUp">
            <ul>
                <li>Name:</li>
                <li>Surname:</li>
                <li>Passport:</li>
                <li>Telephone:</li>
                <li>Email:</li>
                <li>Password:</li>
                <li>Repeat Password:</li>
            </ul>
        </div>
        <form action="index.php?page=signup" method="POST">
            <div class="signUp">
                <input class="text" type="text" placeholder="Name" name="name" value="<?php echo @$_POST['name']; ?>">
                <br>
                <input class="text" type="text" placeholder="Surname" name="surname" value="<?php echo @$_POST['surname']; ?>">
                <br>
                <input class="text" type="text" placeholder="1111-111111" name="passport" value="<?php echo @$_POST['passport']; ?>">
                <br>
                <input class="text" type="text" placeholder="+7(900)111-11-11" name="telephone" value="<?php echo @$_POST['telephone']; ?>">
                <br>
                <input class="text" type="email" placeholder="Email" name="email" value="<?php echo @$_POST['email']; ?>">
                <br>
                <input class="text" type="Password" placeholder="Password" name="password_1">
                <br>
                <input class="text" type="Password" placeholder="Password" name="password_2">
                <div class="signUpButton">
                    <input class="submit" type="submit" value="Sign Up" name="do_signup"> </div>
            </div>
        </form>
    </div>