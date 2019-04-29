<?php
include ("../db.php");
// массив для хранения ошибок
$errorContainer_buy = array();
// полученные данные
$arrayFields = array(
    'seats_price' => $_POST['seats_price'],
    'seats_schedule' => $_POST['seats_schedule'],
    'selected_seat' => $_POST['selected_seat']
);


// проверка всех полей на пустоту
foreach($arrayFields as $fieldName => $oneField){
    if($oneField == '' || !isset($oneField)){
        $errorContainer_buy[$fieldName] = 'Fill all the fields';
    }
} 

$type_wag = R::findOne('type_wagon', 'id = ?', array(R::findOne('wagon', 'identification_number = ?', array(R::findOne('seat', 'id = ?', array($_POST['selected_seat']))->identification_number))->id_type))->price_mult;

// делаем ответ для клиента
if(empty($errorContainer_buy)){

    echo json_encode(array('result' => 'success'));
    
    $ticket = R::dispense('ticket');
    $ticket->id_user = $_SESSION['logged_user']->id; 
    $ticket->id_seat = $_POST['selected_seat'];
    $ticket->id_schedule = $_POST['seats_schedule'];
    $ticket->price = $type_wag * $_POST['seats_price'];
    R::store($ticket); 
}
   else
{
    // если есть ошибки то отправляем
    echo json_encode(array('result' => 'error', 'text_error' => $errorContainer_buy));
}