<?php 

// на вход получаем два имени станций откуда и куда
$city_from = $_SESSION['from'];  
$city_to = $_SESSION['to'];   


// получаем массив всех станций в этих городах 
function FindStations($city){
    $idstations = R::find('station', 'city_id = ?', array(R::findOne('city', 'name = ?', array($city))->id));
    return $idstations;
}

// функция принимает на вход трехмерный массив и возвращает двумерный в нормальном виде(для нормальной обработки и просмотра)
function Arrout($arr){
        $arrOut = array();
           foreach($arr as $subArr){
             $arrOut = array_merge($arrOut,$subArr);
    }
     return $arrOut;
}


// функция находит все возможные маршруты со станцие "куда" , она может быть как концом, так и промежуточной точкой в маршруте (что тоже следует проверять..)
function StationToSomewhere($to){
    foreach (FindStations($to) as $idsta){
       $arrTo[] = R::getAll( 'select * from station_route where id_station = ?',[$idsta -> id]);
    }
    return Arrout($arrTo);
}



// ОСНОВНАЯ функция создает новый массив. Она сравнивает станции от и до по маршруту и соединяет их в один. Выводит поля - номер маршрута, 
// id станции начала, id станции до пункта назначения, порядковый номер станции назначения и конечную станцию маршрута (станции назанчения и  конечная могут не совпадать, ножно проверять)
 function DoNewArray ($array_from, $array_to) { 
     $result = array(); 
      foreach ($array_to as $route_ends) { 
               foreach($array_from as $start_route ){
                   if(($start_route["id_route"] == $route_ends["id_route"]) && $start_route["number"] < $route_ends["number"] && TimeStart($route_ends["id_route"])) {
                        $result[]= array("id_route" => $route_ends["id_route"], 
                               "start_from" => $start_route["id_station"],
                               "station_to" => $route_ends["id_station"],
                               "first_station" => FirstStationRoute($route_ends["id_route"]), 
                               "last_station" => LastStationRoute($route_ends["id_route"]));
                   }
               }
               
            
      }
      return $result; 
 }

 
function CreateDate($date){
    $dateCre = htmlspecialchars($date);
    $dateCre = date('m/d/Y', strtotime($dateCre));
    return $dateCre; 
}


function TimeStart ($id_route) {
    $timeright = array();
    $arr[] =  R::getAll( 'SELECT * FROM schedule where id_route = ?',[$id_route]);
    foreach(Arrout($arr) as $key) {
        if((CreateDate($key["time_start"])) == date($_SESSION['datepicker']))
            $timeright[] = $key["id_route"];
 
    }
    return $timeright; 
}




// функция является частью основной и находит конечную станцию на маршруте, который является правильным (правильным маршрутом я назвал маршрут где станция начала и станция назначения находятся на одном маршруте)
 function LastStationRoute($route_id){
     $arr[] = max(R::getAll( 'SELECT number, id_station FROM station_route where id_route = ?',[$route_id]));
     return $arr[0]['id_station'];
 }

 function FirstStationRoute($route_id){
     $arr[] = R::getAll( 'SELECT * FROM station_route where number = 1 and id_route = ?',[$route_id]);
     return $arr[0][0]["id_station"];
 }



echo '<pre>'; print_r(DoNewArray(StationToSomewhere ($city_from), StationToSomewhere($city_to) )); echo '</pre>';




$main_arr = [
    [
        'id'=>1, 
        'station_start' => 'Курский вокзал',
        'station_end'=> 'Рязань-1',
        'time_start' => '18:34',
        'time'=> 184,
         'train'=>'2321'  
    ],
       [
           'id'=> 2, 
        'station_start' => 'Москвоский вокзал',
        'station_end'=> 'Тула-2',
        'time_start' => '12:00',
        'time'=> 500,
         'train'=>'271'  
    ],
       [
         'id'=> 3, 
        'station_start' => 'Белорусский вокзал',
        'station_end'=> 'Сочи',
        'time_start' => '14:45',
        'time'=> 1300,
         'train'=>'111'
    ],
    
    
];

?>
    <div id="nameRoute"> <?php echo $city_from;?> &rarr;
            <? echo $city_to;?> </div>
    <?php foreach ($main_arr as $way) : ?>
        <div class="route">
            <div class="routemain"> Москва &rarr; рязань </div>
            <div class="train">
                <?php echo $way['train']?>
            </div>
            <ul>
                <li>
                    <div class="timeStart">
                        <?php echo $way['time_start']?>
                    </div>
                </li>
                <li>
                    <div class="stationStart">
                        <?php echo $way['station_start']?>
                    </div>
                </li>
            </ul>
            <ul class="centertime">
                <li>
                    <div class="arrow">&rArr;</div>
                </li>
                <li>
                    <div class="timeAll">
                        <?php 
                      $time = $way['time'];
                     $hours = floor($time / 60);
                         $minutes = $time % 60; 
                  echo $hours.'ч. '.$minutes.'мин'?>
                    </div>
                </li>
            </ul>
            <ul>
                <li>
                    <div class="timeStart">
                        <?php 
                          $date = strtotime($way['time_start']) + strtotime($hours.':'.$minutes) - strtotime("00:00:00"); 
                           echo date('H:i',$date);
                 
                         ?>
                    </div>
                </li>
                <li>
                    <div class="stationStart" id="endstat">
                        <?php echo $way['station_end']?>
                    </div>
                </li>
            </ul>
            <input class="submit" type="submit" value="Buy"> </div>
        <?php endforeach; ?>
            <div class="clr"></div>
