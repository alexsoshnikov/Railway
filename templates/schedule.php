<?php
//include "../../classes/app.php"; 


$city_from = $_SESSION['from'];
$city_to = $_SESSION['to']; 


 function Arrout($arr){
        $arrOut = array();
           foreach($arr as $subArr){
             $arrOut = array_merge($arrOut,$subArr);
    };
     return $arrOut;
  }


function FindStations($city){
    $idstations = R::find('station', 'city_id = ?', array(R::findOne('city', 'name = ?', array($city))->id));
    return $idstations;
}


foreach (FindStations($city_from) as $idsta){
       $arrOne[] = R::getAll( 'select * from station_route where number = 1 and id_station = ?',[$idsta -> id]);
 };

for($i =1; $i <= max(R::getCol( 'SELECT id_route FROM station_route')); $i++){
     $arrTwo[] = max(R::getAll( 'SELECT number, id_route, id_station FROM station_route where id_route = ?',[$i]));
}

function DoNewArray ($array_ends, $array_starts) { 
$result = array(); 
      foreach ($array_ends as $route_ends) { 
           if(searchForId($route_ends["id_route"], $array_starts)) { 
              $result[]= array("id_route" => $route_ends["id_route"], 
                                "start_station" => getStationById($route_ends["id_route"], $array_starts),
                                 "end_station" => $route_ends["id_station"]); 
        } 
  } 
    return $result;
} 

function searchForId ($route_id, $array_starts) { 
           foreach ($array_starts as $route_starts) { 
                if($route_starts["id_route"] == $route_id) 
                      return true; 
          } 
      return false; 
} 

function getStationById($route_id, $array_starts) { 
          foreach ($array_starts as $route_starts) { 
            if($route_starts["id_route"] == $route_id) 
              return $route_starts["id_station"]; 
           } 
} 




echo '<pre>'; print_r(DoNewArray($arrTwo, Arrout($arrOne))); echo '</pre>';

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