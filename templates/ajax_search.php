<?php
include ("../db.php");
// массив для хранения ошибок
$errorContainer_search = array();
// полученные данные
$arrayFields = array(
    'cityFrom' => $_POST['cityFrom'],
    'cityTo' => $_POST['cityTo'],
    'datepicker' => $_POST['datepicker']
);
 

// проверка всех полей на пустоту

          if (!R::findOne('city', "name = ?", array($_POST['cityFrom']) ))
        {
           $errorContainer_search['cityFrom'] = 'There is no such city!';
        }
          if (!R::findOne('city', "name = ?", array($_POST['cityTo'])) )
        {
           $errorContainer_search['cityTo'] = 'There is no such city!';
        }
 

// делаем ответ для клиента
if(empty($errorContainer_search)){
     
    $from = $_POST['cityFrom'];
    $to = $_POST['cityTo'];
    $time =  $_POST['datepicker']; 
    $_SESSION['from'] = $from;
    $_SESSION['to'] = $to;
    $_SESSION['datepicker'] = $time;

    echo json_encode(array('result' => 'success', 'from'=>$from, 'to'=> $to));
       

    
}
   else
{
    // если есть ошибки то отправляемc
    echo json_encode(array('result' => 'error', 'text_error' => $errorContainer_search));
}