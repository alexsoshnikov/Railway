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

// функция находит где станция начала является первой по порядку прохождения станций, и возращает те двумерный массив с id маршрута, id станции и порядковым номером, который является первым 

function FistStationFrom($from){
     foreach (FindStations($from) as $idsta){
       $arrFrom[] = R::getAll( 'select * from station_route where number = 1 and id_station = ?',[$idsta -> id]);
      }  
     return Arrout($arrFrom); 
 }


//echo '<pre>'; print_r(StationToSomewhere($city_from)); echo '</pre>';
//echo '<pre>'; print_r(StationToSomewhere($city_to)); echo '</pre>';

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
           if(searchForId($route_ends["id_route"], $array_from)) { 
              $result[]= array("id_route" => $route_ends["id_route"], 
                               "start_from" => getStationStartId($route_ends["id_route"], $array_from),
                               "station_to" => $route_ends["id_station"],
                               "number_station_to" => $route_ends["number"],
                               "end_station" => LastStationRoute($route_ends["id_route"]));
            } 
      }
      return $result; 
 }


// функция проверяет находится ли станции назначения на маршруте станции начала 
 function searchForId ($route_id, $array_from) { 
           foreach ($array_from as $route_starts) { 
                if($route_starts["id_route"] == $route_id) 
                      return true;
          } 
       return false; 
} 

// функция является частью основной и находит конечную станцию на маршруте, который является правильным (правильным маршрутом я назвал маршрут где станция начала и станция назначения находятся на одном маршруте)
 function LastStationRoute($route_id){
     $arrTo[] = max(R::getAll( 'SELECT number, id_station FROM station_route where id_route = ?',[$route_id]));
     return $arrTo[0]['id_station'];
 }



// функция вовращает id станции которая является началом на маршруте 
  function getStationStartId($route_id, $array_from) { 
          foreach ($array_from as $route_starts) { 
            if($route_starts["id_route"] == $route_id) 
              return $route_starts["id_station"]; 
           } 
   } 


//
echo '<pre>'; print_r(DoNewArray(FistStationFrom($city_from), StationToSomewhere($city_to))); echo '</pre>';  
//echo '<pre>'; print_r(StationToSomewhere($city_to)); echo '</pre>';



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
    <div id="nameRoute">
        <?php echo $city_from;?> &rarr;
            <? echo $city_to;?>
    </div>
    <?php foreach ($main_arr as $way) : ?>
        <div class="route">
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
            <div class="arrow">&rArr;</div>
            <ul>
                <li>
                    <div class="timeStart">
                        <?php 
                         $time = $way['time'];
                     $hours = floor($time / 60);
                         $minutes = $time % 60;
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
            <div class="timeAll">
                <?php  echo $hours.'ч. '.$minutes.'мин'?>
            </div>
            <input class="submit" type="submit" value="Buy"> </div>
        <?php endforeach; ?>
            <div class="clr"></div>
            
         
