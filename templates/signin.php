<?php 
require_once "db.php";

$header = 'Sign Up';
if ( isset($_POST['do_signin']) )
{
    $errors = array();
   $userCurrent = R::findOne('users', 'email = ?', array($_POST['email']));
    if ($userCurrent)
    {
        //логин существует 
    
        if (password_verify($_POST['password'], $userCurrent->password))
        {
            //если пароль совпадает, то нужно авторизовать пользователя
            $_SESSION['logged_user'] = $userCurrent;
            $header = 'rrrrr';
        }else
        {
            $errors[] = 'The password is incorrect!';
        }
 
    }else
    {
        $errors[] = 'A user with this Email not found!';
    }
     
    if ( ! empty($errors) )
    {
        //выводим ошибки авторизации
        $header = array_shift($errors);
    }
 
}


?>
   
   
   <div class="whiteBox_signIn">
    <div class="header_whiteBox"><?php 
              if ($header == 'Sign Up')
              {  echo $header;}
              else
              {   echo '<font color=red>'.$header.'</font>';  }
            ?></div>
    <form action="index.php?page=signin" method="POST" >
        <div class="signIn">
            <input class="text" type="Email" placeholder="Email" name="email">
            <input class="text" type="Password" placeholder="Password" name="password"> </div>
        <div class="searchButton">
            <input class="submit" type="submit" value="Sign In" name="do_signin"> </div>
    </form>
</div>