<?php
include ("../db.php");
// массив для хранения ошибок
$errorContainer_SignIn = array();
// полученные данные
$arrayFields = array(
    'signIn_email' => $_POST['signIn_email'],
    'signIn_password' => $_POST['signIn_password']
);
 
// проверка всех полей на пустоту
foreach($arrayFields as $fieldName => $oneField){
    if($oneField == '' || !isset($oneField)){
        $errorContainer_SignIn[$fieldName] = 'Fill all the fields';
    }
} 

   $userCurrent = R::findOne('passenger', 'email = ?', array($_POST['signIn_email']));
    if ($userCurrent)
    {
        //логин существует 
        if (!password_verify($_POST['signIn_password'], $userCurrent->password))
        {
         $errorContainer_SignIn['signIn_password'] = 'The password is incorrect!';
        }
 
    }else
    {
        $errorContainer_SignIn['signIn_email'] = 'A user with this Email not found!';
    }
     

// делаем ответ для клиента
if(empty($errorContainer_SignIn)){
   
    $_SESSION['logged_user'] = $userCurrent;
    echo json_encode(array('result' => 'success'));
    
    
}
   else
{
    // если есть ошибки то отправляем
    echo json_encode(array('result' => 'error', 'text_error' => $errorContainer_SignIn));
}