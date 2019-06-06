<?php
include ("../db.php");
// массив для хранения ошибок
$errorContainer_payment = array();
// полученные данные
$arrayFields = array(
    'number' => $_POST['number'],
    'name' => $_POST['name'],
    'expiry' => $_POST['expiry'],
    'cvc' => $_POST['cvc'],
    'money' => $_POST['money']
);

 
// проверка всех полей на пустоту
foreach($arrayFields as $fieldName => $oneField){
    if($oneField == '' || !isset($oneField)){
        $errorContainer_payment[$fieldName] = 'Fill all the fields';
    }
} 
 

// делаем ответ для клиента
if(empty($errorContainer_payment)){
       // заргужаем данные в бд в случае успеха 
    echo json_encode(array('result' => 'success'));
    
          $payment = R::dispense('payment');
          $payment->id_user = $_SESSION['logged_user']->id; 
          $payment->money = $_POST['money'];
          $payment->card = $_POST['number'];
          R::store($payment); 
}
   else
{
    // если есть ошибки то отправляемc
    echo json_encode(array('result' => 'error', 'text_error' => $errorContainer_payment));
}