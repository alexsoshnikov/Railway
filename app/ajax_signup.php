<?php
include ("../db.php");
// массив для хранения ошибок
$errorContainer_SingUp = array();
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
        $errorContainer_SingUp[$fieldName] = 'Fill all the fields';
    }
} 
 
      // сравнение введенных паролей
        if($arrayFields['signUp_password'] != $arrayFields['signUp_password_2'])
        {
             $errorContainer_SingUp['signUp_password_2'] = 'Re-password entered incorrectly!';
        }

       //проверка паспорта 
          if ( R::count('passenger', "passport = ?", array($_POST['signUp_passport'])) > 0)
        {
           $errorContainer_SingUp['signUp_passport'] = 'A user with this passport already exists!';
        }
        //проверка телефона 
           if ( R::count('passenger', "telephone = ?", array($_POST['signUp_telephone'])) > 0)
        {
           $errorContainer_SingUp['signUp_telephone'] = 'A user with this telephone already exists!';
        }
        //проверка мейла 
        if ( R::count('passenger', "email = ?", array($_POST['signUp_email'])) > 0)
        {
           $errorContainer_SingUp['signUp_email'] = 'A user with this Email already exists!';
        }


// делаем ответ для клиента
if(empty($errorContainer_SingUp)){
    echo json_encode(array('result' => 'success'));
    // заргужаем данные в бд в случае успеха 
          $passenger = R::dispense('passenger');
          $passenger->name = $_POST['signUp_name'];
          $passenger->surname = $_POST['signUp_surname'];
          $passenger->passport = $_POST['signUp_passport']; 
          $passenger->telephone = $_POST['signUp_telephone'];
          $passenger->email = $_POST['signUp_email'];
          $passenger->password = password_hash($_POST['signUp_password'], PASSWORD_DEFAULT);
          R::store($passenger);
}
 else {
    // если есть ошибки то отправляем
    echo json_encode(array('result' => 'error', 'text_error' => $errorContainer_SingUp));
}