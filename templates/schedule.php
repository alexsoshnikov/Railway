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
     $number = 1;        
      foreach ($array_to as $route_ends) { 
               foreach($array_from as $start_route ){
                   if(($start_route["id_route"] == $route_ends["id_route"]) && $start_route["number"] < $route_ends["number"] && TimeStart($route_ends["id_route"]) ) { 
                         $arr = null; 
                         $arr[] =  R::getAll( 'SELECT * FROM schedule where id_route = ? order by time_start',[$start_route["id_route"]]);
                         foreach(Arrout($arr) as $key) {
                               if((CreateDate($key["time_start"])) == date($_SESSION['datepicker']))
                               {
                                        $result[]= array( "ID" => $number, 
                                       "id_route" => $route_ends["id_route"], 
                                        "start_from" => $start_route["id_station"],
                                        "station_to" => $route_ends["id_station"],
                                        "first_station" => FirstStationRoute($route_ends["id_route"]), 
                                        "last_station" => LastStationRoute($route_ends["id_route"]), 
                                        "start_time" => CreateTime($key["time_start"]),
                                        "train_id" => $key["id_train"]);
                                  $number++; 
                               }
 
                        }
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

 
function CreateTime($date){
    $dateCre = htmlspecialchars($date);
    $dateCre = date('H:i', strtotime($dateCre));
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



function DestinationTime($distance, $weight, $traction, $maxtrain, $maxsection) {
  
    $a = ($traction*1000)/ ($weight*1000) - 0.05; 

    if($maxsection != 0 && $maxsection < $maxtrain) {
        $tStart = (($maxsection * 1000) / 3600) / $a; 
    }
    else {
       $tStart = (($maxtrain * 1000) / 3600) / $a; 
    }
    
    $wayStart = ($a * (pow($tStart, 2)))/2;
    $wayMain = ($distance * 1000) - $wayStart * 2;
    
    if($wayMain < 0) {
        $wayStart = $distance * 1000 / 2;
        $tStart = sqrt($wayStart*2 / $a);
        $resulttime = 2 * $tStart;
    }
    else {
        
         if($maxsection != 0 && $maxsection < $maxtrain) {
          $tMain = $wayMain / (($maxsection * 1000) / 3600); 
         }
         else {
            $tMain = $wayMain / (($maxtrain * 1000) / 3600); 
         }
        $resulttime = $tMain + 2 * $tStart; 
    }
    
    return ceil($resulttime); 
} 


function TotalWeightWagon ($id_train) {
     $wagon = R::getAll( 'SELECT * FROM wagon where train_id = ? ',[$id_train]);
           foreach ($wagon as $keys) { 
              $totalWeight = $totalWeight + R::findOne( 'type_wagon', 'id = ?', array($keys["type_wagon_id"]))->weight;
             }
    return $totalWeight; 
}


function EngineInfo ($id_train) {
       $engine = R::findOne('engine', 'id = ? ', array(R::findOne('train', 'id = ? ', array($id_train))->engine_id)); 
       $engine_info = R::findOne('type_engine', 'id = ? ', array($engine->type_engine_id));  
    return $engine_info; 
}

function StationName($id) {
    $station = R::findOne('station', 'id = ? ', array($id))->name;  
    return $station; 
}

function TrainName($id) {
    $train = R::findOne('train', 'id = ? ', array($id))->name;  
    return $train; 
}

function RouteInfo($arr) {
    $res = array(); 
    foreach($arr as $route) {
         $totalWeight = 0; 
         $routeArr = R::getAll( 'SELECT * FROM station_route where id_route = ? order by number',[$route["id_route"]]);
         $totalWeight = TotalWeightWagon($route["train_id"]) + EngineInfo($route["train_id"])-> weight; 
         $time = 0;
         $predtime =0; 
         if ($route["start_from"] == $route["first_station"]){
              $i = 0; 
            do {
                
                  $id_start = $routeArr[$i]["id_station"];
                  $id_end = $routeArr[$i+1]["id_station"];
                  $distance = R::findOne('destination', 'start_station = ? and end_station = ?', array($id_start, $id_end));
                  $time = $time + DestinationTime($distance->distance,$totalWeight, EngineInfo($route["train_id"])-> traction_force, EngineInfo($route["train_id"])-> max_speed, $distance->section_speed);
                
             $i++;
             $predtime = 0;
            } while ($id_end != $route["station_to"]);
        }
        else {
             $j = 0; 
            do {
                 
                  $id_start_pred = $routeArr[$j]["id_station"];
                  $id_end_pred = $routeArr[$j+1]["id_station"];
                  $distance = R::findOne('destination', 'start_station = ? and end_station = ?', array($id_start_pred, $id_end_pred));
                  $predtime = $predtime + DestinationTime($distance->distance,$totalWeight, EngineInfo($route["train_id"])-> traction_force, EngineInfo($route["train_id"])-> max_speed, $distance->section_speed);
                
             $i++;
            } while ($id_end_pred != $route["start_from"]);
            
            $found_key = array_search($route["start_from"], array_column($routeArr, 'id_station'));
             do {
                
                  $id_start_pred = $routeArr[$found_key]["id_station"];
                  $id_end_pred = $routeArr[$found_key+1]["id_station"];
                  $distance = R::findOne('destination', 'start_station = ? and end_station = ?', array($id_start_pred, $id_end_pred));
                  $time = $time + DestinationTime($distance->distance,$totalWeight, EngineInfo($route["train_id"])-> traction_force, EngineInfo($route["train_id"])-> max_speed, $distance->section_speed);
                 
             $found_key++;
            } while ($id_end_pred != $route["station_to"]);
            
        }
        
         $res[] = array("ID" => $route["ID"], 
                        "time" => ceil($time/60), 
                        "pred_time" => ceil($predtime/60),
                        "station_from" => $route["start_from"],
                        "station_to" => $route["station_to"], 
                        "first_station"  => $route["first_station"], 
                        "last_station" => $route["last_station"],
                        "start_time" => $route["start_time"],
                        "train_id" => $route["train_id"]);  
    }
    
    return $res;
}

$mainArr = RouteInfo(DoNewArray(StationToSomewhere($city_from), StationToSomewhere($city_to)));


?>
        

        <div id="nameRoute">
        <?php echo $city_from;?> &rarr;
            <? echo $city_to;?>
    </div>
    <?php foreach ($mainArr as $way) : ?>
        <div class="route">
            <div class="routemain">
                <?php echo StationName($way['first_station'])?> &rarr;
                    <?php echo StationName($way['last_station'])?>
            </div>
            <div class="train">
                <?php echo TrainName($way['train_id'])?>
            </div>
            <ul>
                <li>
                    <div class="timeStart">
                        <?php 
                            $time_first = $way['pred_time']; 
                            $hours_first = floor($time_first / 60);
                         $minutes_first = $time_first % 60; 
                          $date_first = strtotime($way['start_time']) + strtotime($hours_first.':'.$minutes_first) - strtotime("00:00:00"); 
                           echo date('H:i',$date_first);
                         ?>
                    </div>
                </li>
                <li>
                    <div class="stationStart">
                        <?php echo StationName($way['station_from'])?>
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
                          $date = $date_first + strtotime($hours.':'.$minutes) - strtotime("00:00:00"); 
                           echo date('H:i',$date);
                         ?>
                    </div>
                </li>
                <li>
                    <div class="stationStart" id="endstat">
                        <?php echo StationName($way['station_to'])?>
                    </div>
                </li>
            </ul>
            <input class="submit" type="submit" value="Buy"> </div>
        <?php endforeach; ?>
            <div class="clr"></div>