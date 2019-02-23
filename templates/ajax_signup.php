<?php

// массив для хранения ошибок
$errorContainer = array();
// полученные данные
$arrayFields = array(
    'signUp_name' => $_POST['signUp_name'],
    'signUp_surname' => $_POST['signUp_surname'],
    'signUp_passport' => $_POST['signUp_passport'],
    'signUp_telephone' => $_POST['signUp_telephone'],
    'signUp_email' => $_POST['signUp_email'],
    'signUp_password' => $_POST['signUp_password'],
    'signUp_password_2' => $_POST['signUp_password_2']
);
 
// проверка всех полей на пустоту
foreach($arrayFields as $fieldName => $oneField){
    if($oneField == '' || !isset($oneField)){
        $errorContainer[$fieldName] = 'Fill all the fields';
    }
} 
 
      // сравнение введенных паролей
        if($arrayFields['signUp_password'] != $arrayFields['signUp_password_2'])
        {
             $errorContainer['signUp_password_2'] = 'Re-password entered incorrectly!';
        }

       //проверка паспорта 
//          if ( R::count('users', "passport = ?", array($_POST['signUp_passport'])) > 0)
//        {
//           $errorContainer['signUp_passport'] = 'A user with this passport already exists!';
//        }
//        //проверка телефона 
//           if ( R::count('users', "telephone = ?", array($_POST['signUp_telephone'])) > 0)
//        {
//           $errorContainer['signUp_telephone'] = 'A user with this telephone already exists!';
//        }
//        //проверка мейла 
//        if ( R::count('users', "email = ?", array($_POST['signUp_email'])) > 0)
//        {
//           $errorContainer['signUp_email'] = 'A user with this Email already exists!';
//        }


// делаем ответ для клиента
if(empty($errorContainer)){
   
    echo json_encode(array('result' => 'success'));
    
    // заргужаем данные в бд в случае успеха 

//          $user = R::dispense('users');
//          $user->name = $_POST['signUp_name'];
//          $user->surname = $_POST['signUp_surname'];
//          $user->passport = $_POST['signUp_passport']; 
//          $user->telephone = $_POST['signUp_telephone'];
//          $user->email = $_POST['signUp_email'];
//          $user->password = password_hash($_POST['signUp_password'], PASSWORD_DEFAULT);
//          R::store($user);


    
}
   else
{
    // если есть ошибки то отправляем
    echo json_encode(array('result' => 'error', 'text_error' => $errorContainer));
}