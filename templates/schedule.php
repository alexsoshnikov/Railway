<?php
    $city_from = $_SESSION['from'];
    $city_to = $_SESSION['to']; 

$idstationsfrom = R::find('station', 'city_id = ?', array(R::findOne('city', 'name = ?', array($city_from))->id));
$idstationsto = R::find('station', 'city_id = ?', array(R::findOne('city', 'name = ?', array($city_to))->id));
     


 foreach ($idstationsfrom as $idsta){
       $bs[] = R::getAll( 'select * from station_route where number = 1 and id_station = ?',[$idsta -> id]); 
 }
 foreach ($idstationsto as $idsta){
       $as[] = R::getAll( 'select * from station_route where number = 3 and id_station = ?',[$idsta -> id]); 
 }

 

//$arrTwo = array();
//
//foreach ($bs as $keys => $names) { 
//  foreach ($names as $key => $name) {
//    foreach ($name as $ke => $as){
//          $arrTwo[$ke][] = $as;
//        continue;
//    }
//  }
//}
//
//$route_arr = $arrTwo['id_route']; 


//
//echo '<pre>'; print_r($bs); echo '</pre>';
//echo '<pre>'; print_r($as); echo '</pre>';


$main_arr = [
    [
        'station_start' => 'Курский вокзал',
        'station_end'=> 'Рязань-1',
        'time_start' => '18:34',
        'time'=> 184,
         'train'=>'2321'  
    ],
       [
        'station_start' => 'Москвоский вокзал',
        'station_end'=> 'Тула-2',
        'time_start' => '12:00',
        'time'=> 500,
         'train'=>'271'  
    ],
       [
        'station_start' => 'Белорусский вокзал',
        'station_end'=> 'Сочи',
        'time_start' => '14:45',
        'time'=> 1200,
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