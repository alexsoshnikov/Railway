<?php 
require_once "db.php";

$data = $_POST;
 $header = 'Sign Up';
    if(isset($data['do_signup']))
    {
        
        $errors = array();
        if (trim($data['name']) == '')
        {
            $errors[] = 'Enter your name!' ;
        }
        
         if (trim($data['surname']) == '')
        {
            $errors[] = 'Enter your surname!' ;
        }
        
         if (trim($data['passport']) == '')
        {
            $errors[] = 'Enter your passport!' ;
        }
        
         if (trim($data['telephone']) == '')
        {
            $errors[] = 'Enter your telephone!' ;
        }
          
         if (trim($data['email']) == '')
        {
            $errors[] = 'Enter your email!' ;
        }
        
          if (trim($data['password_1']) == '' )
        {
            $errors[] = 'Enter your password!' ;
        }
           if (trim($data['password_2']) == '' )
        {
            $errors[] = 'Repeat your password!' ;
        }
        
         if ( $data['password_2'] != $data['password_1'] )
          {
           $errors[] = 'Re-password entered incorrectly!';
          }
        
        if ( empty($errors) )
        {
          $user = R::dispense('users');
          $user->name = $data['name'];
          $user->surname = $data['surname'];
          $user->passport = $data['passport']; 
          $user->telephone = $data['telephone'];
          $user->email = $data['email'];
          $user->password =password_hash($data['password'], PASSWORD_DEFAULT); 
          R::store($user);
        }
         else
        {
           
           $header = array_shift($errors);
        }
            
}

?>
    <div class="whiteBox_signUp">
        <div class="header_whiteBox_signUp ">
            <?php 
              if ($header == 'Sign Up')
              {
                  echo $header;
              }
            else {
                echo '<font color=red>'.$header.'</font>';
            }
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
                <input class="text" type="text" placeholder="Name" name="name" value="<?php echo @$data['name']; ?>">
                <br>
                <input class="text" type="text" placeholder="Surname" name="surname" value="<?php echo @$data['surname']; ?>">
                <br>
                <input class="text" type="text" placeholder="1111-111111" name="passport" value="<?php echo @$data['passport']; ?>">
                <br>
                <input class="text" type="text" placeholder="+7(900)111-11-11" name="telephone" value="<?php echo @$data['telephone']; ?>">
                <br>
                <input class="text" type="email" placeholder="Email" name="email" value="<?php echo @$data['email']; ?>">
                <br>
                <input class="text" type="Password" placeholder="Password" name="password_1">
                <br>
                <input class="text" type="Password" placeholder="Password" name="password_2">
                <div class="signUpButton">
                    <input class="submit" type="submit" value="Sign Up" name="do_signup"> </div>
            </div>
        </form>
    </div>