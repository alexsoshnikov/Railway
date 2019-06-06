<?php 
include_once ('db.php');

class SearchRoute {
  // обобщающая функция
   public function AllCalculate($from, $to) {
      $mainArr = array();
      $mainArr = $this->RouteInfo($this->DoNewArray($this->StationToSomewhere($from) , $this->StationToSomewhere($to)));
      return $mainArr;
   }
   // получаем массив всех станций в этих городах
   public function FindStations($city) {
      $idstations = R::find('station', 'id_city = ?', array(
         R::findOne('city', 'name = ?', array(
            $city
         ))->id
      ));
      return $idstations;
   }
   // функция принимает на вход трехмерный массив и возвращает двумерный в нормальном виде(для нормальной обработки и просмотра)
   public function Arrout($arr) {
      $arrOut = array();
      foreach($arr as $subArr) {
         $arrOut = array_merge($arrOut, $subArr);
      }
      return $arrOut;
   }
   // функция находит все возможные маршруты со станцие "куда" , она может быть как концом, так и промежуточной точкой в маршруте (что тоже следует проверять..)
   public function StationToSomewhere($to) {
      foreach($this->FindStations($to) as $idsta) {
         $arrTo[] = R::getAll('select * from station_route where id_station = ?', [$idsta->id]);
      }
      return $this->Arrout($arrTo);
   }
   // ОСНОВНАЯ функция создает новый массив. Она сравнивает станции от и до по маршруту и соединяет их в один. Выводит поля - номер маршрута,
   // id станции начала, id станции до пункта назначения, порядковый номер станции назначения и конечную станцию маршрута (станции назанчения и  конечная могут не совпадать, ножно проверять)
   public function DoNewArray($array_from, $array_to) {
      $result = array();
      $number = 1;
      foreach($array_to as $route_ends) {
         foreach($array_from as $start_route) {
            if (($start_route["id_route"] == $route_ends["id_route"]) && $start_route["number"] < $route_ends["number"] && $this->TimeStart($route_ends["id_route"])) {
               $arr = null;
               $arr[] = R::getAll('SELECT * FROM schedule where id_route = ? order by start_date', [$start_route["id_route"]]);
               foreach($this->Arrout($arr) as $key) {
                  if (($this->CreateDate($key["start_date"])) == date($_SESSION['datepicker'])) {
                     $result[] = array(
                        "ID" => $number,
                        "id_route" => $route_ends["id_route"],
                        "start_from" => $start_route["id_station"],
                        "station_to" => $route_ends["id_station"],
                        "first_station" => $this->FirstStationRoute($route_ends["id_route"]) ,
                        "last_station" => $this->LastStationRoute($route_ends["id_route"]) ,
                        "start_time" => $this->CreateTime($key["start_date"]) ,
                        "train_id" => $key["id_train"],
                        "schedule_id" => $key["id"]
                     );
                     $number++;
                  }
               }
            }
         }
      }
      return $result;
   }
   public function CreateDate($date) {
      $dateCre = htmlspecialchars($date);
      $dateCre = date('m/d/Y', strtotime($dateCre));
      return $dateCre;
   }
    
   public function CreateTime($date) {
      $dateCre = htmlspecialchars($date);
      $dateCre = date('H:i', strtotime($dateCre));
      return $dateCre;
   }
    
   public function TimeStart($id_route) {
      $timeright = array();
      $arr[] = R::getAll('SELECT * FROM schedule where id_route = ?', [$id_route]);
      foreach($this->Arrout($arr) as $key) {
         if (($this->CreateDate($key["start_date"])) == date($_SESSION['datepicker'])) $timeright[] = $key["id_route"];
      }
      return $timeright;
   }
   // функция поиска начальной станции на конкретном маршруте
   public function LastStationRoute($route_id) {
      $arr[] = max(R::getAll('SELECT number, id_station FROM station_route where id_route = ?', [$route_id]));
      return $arr[0]['id_station'];
   }
    
   // функция поиска конечной станции на конкретном маршруте
   public function FirstStationRoute($route_id) {
      $arr[] = R::getAll('SELECT * FROM station_route where number = 1 and id_route = ?', [$route_id]);
      return $arr[0][0]["id_station"];
   }
    
   // функция пересчета времени в конкретном промежутке маршрута
   public function DestinationTime($distance, $weight, $traction, $maxtrain, $maxsection) {

      $a = ($traction * 1000) / ($weight * 1000) - 0.05;
      if ($maxsection != 0 && $maxsection < $maxtrain) {
         $tStart = (($maxsection * 1000) / 3600) / $a;
      }
      else {
         $tStart = (($maxtrain * 1000) / 3600) / $a;
      }
      $wayStart = ($a * (pow($tStart, 2))) / 2;
      $wayMain = ($distance * 1000) - $wayStart * 2;
      if ($wayMain < 0) {
         $wayStart = $distance * 1000 / 2;
         $tStart = sqrt($wayStart * 2 / $a);
         $resulttime = 2 * $tStart;
      }
      else {
         if ($maxsection != 0 && $maxsection < $maxtrain) {
            $tMain = $wayMain / (($maxsection * 1000) / 3600);
         }
         else {
            $tMain = $wayMain / (($maxtrain * 1000) / 3600);
         }
         $resulttime = $tMain + 2 * $tStart;
      }
      return ceil($resulttime);
   }
   // функция сложения общий массы поезда
   public function TotalWeightWagon($id_train) {
      $wagon = R::getAll('SELECT * FROM wagon where id_train = ? ', [$id_train]);
      foreach($wagon as $keys) {
         $totalWeight = $totalWeight + R::findOne('type_wagon', 'id = ?', array(
            $keys["id_type"]
         ))->weight;
      }
      return $totalWeight;
   }
    
   // функция поиска типа подвижного вагона и его данных
   public function EngineInfo($id_train) {
      $engine = R::findOne('engine', 'id = ? ', array(
         R::findOne('train', 'id = ? ', array(
            $id_train
         ))->id_engine
      ));
      $engine_info = R::findOne('type_engine', 'id = ? ', array(
         $engine->id_type
      ));
      return $engine_info;
   }
   
   public function MultMoneyDest($dest, $mult) {
      return $dest * $mult; 
   }

   // пересчет и вывод конечного массива
   public function RouteInfo($arr) {
      $res = array();
      foreach($arr as $route) {

         $totalWeight = 0;
         $routeArr = R::getAll('SELECT * FROM station_route where id_route = ? order by number', [$route["id_route"]]);
         $totalWeight = $this->TotalWeightWagon($route["train_id"]) + $this->EngineInfo($route["train_id"])->weight;
         $time = 0;
         $predtime = 0;
         $price = 0; 
         if ($route["start_from"] == $route["first_station"]) {
            $i = 0;
            do {
               $id_start = $routeArr[$i]["id_station"];
               $id_end = $routeArr[$i + 1]["id_station"];
               $distance = R::findOne('destination', 'start_station = ? and end_station = ?', array(
                  $id_start,
                  $id_end
               ));
               $time = $time + $this->DestinationTime($distance->distance, $totalWeight, $this->EngineInfo($route["train_id"])->traction_force, $this->EngineInfo($route["train_id"])->max_speed, $distance->section_speed);
               $predtime = 0;
               $price += $this->MultMoneyDest($distance->distance, $distance->price_mult); 
               $i++;
            }
            while ($id_end != $route["station_to"]);
         }
         else {
            $j = 0;
            do {
               $id_start_pred = $routeArr[$j]["id_station"];
               $id_end_pred = $routeArr[$j + 1]["id_station"];
               $distance = R::findOne('destination', 'start_station = ? and end_station = ?', array(
                  $id_start_pred,
                  $id_end_pred
               ));
               $predtime = $predtime + $this->DestinationTime($distance->distance, $totalWeight, $this->EngineInfo($route["train_id"])->traction_force, $this->EngineInfo($route["train_id"])->max_speed, $distance->section_speed);
               $j++;
            }
            while ($id_end_pred != $route["start_from"]);

            $found_key = array_search($route["start_from"], array_column($routeArr, 'id_station'));
            do {
               $id_start_pred_2 = $routeArr[$found_key]["id_station"];
               $id_end_pred_2 = $routeArr[$found_key + 1]["id_station"];
               $distance = R::findOne('destination', 'start_station = ? and end_station = ?', array(
                  $id_start_pred_2,
                  $id_end_pred_2
               ));
               $time = $time + $this->DestinationTime($distance->distance, $totalWeight, $this->EngineInfo($route["train_id"])->traction_force, $this->EngineInfo($route["train_id"])->max_speed, $distance->section_speed);
               $found_key++;
               $price += $this->MultMoneyDest($distance->distance, $distance->price_mult); 
            }
            while ($id_end_pred_2 != $route["station_to"]);
         }
         $res[] = array(
            "ID" => $route["ID"],
            "time" => ceil($time / 60) ,
            "pred_time" => ceil($predtime / 60) ,
            "station_from" => $route["start_from"],
            "station_to" => $route["station_to"],
            "first_station" => $route["first_station"],
            "last_station" => $route["last_station"],
            "start_time" => $route["start_time"],
            "train_id" => $route["train_id"],
            "route_id" => $route["id_route"], 
            "schedule" => $route["schedule_id"],
            "price" => $price
         );
      }
      return $res;
   }
}

class SearchInfo {
   // функция поиска названия поезда 
   public function TrainName($id) {
      $train = R::findOne('train', 'id = ? ', array(
         $id
      ))->name;
      return $train;
   }
    
   // функция поиска названия станций 
   public function StationName($id) {
      $station = R::findOne('station', 'id = ? ', array(
         $id
      ))->name;
      return $station;
   }
    
   // функция вычисления времени старта 
   public function ArrivalTime($pred, $start) {
      $hours_first = floor($pred / 60);
      $minutes_first = $pred % 60;
      $date_first = strtotime($start) + strtotime($hours_first . ':' . $minutes_first) - strtotime("00:00:00");
      return date('H:i', $date_first);
   }
    
   // функция вычисления времени в пути 
   public function RouteTime($time) {
      $hours = floor($time / 60);
      $minutes = $time % 60;
      return $hours . 'h. ' . $minutes . 'min';
   }
    
   // функция вычисления времени конца поездки 
   public function DepartureTime($pred, $start, $time) {
      $hours_first = floor($pred / 60);
      $minutes_first = $pred % 60;
      $date_first = strtotime($start) + strtotime($hours_first . ':' . $minutes_first) - strtotime("00:00:00");
      $hours = floor($time / 60);
      $minutes = $time % 60;
      $date = $date_first + strtotime($hours . ':' . $minutes) - strtotime("00:00:00");
      return date('H:i', $date);
   }
}

class PurchaseInfo {

   public function ArrStation($route_id) {
      return $stations = R::getAll('SELECT * FROM station_route where id_route = ? order by number', [$route_id]);
   }

   public function WagonTrain($train_id) {
      return $wagon_id  = R::getAll('SELECT * FROM wagon where id_train = ?', [$train_id]);
   }

   public function WagonTypeClass($type_id) {
      return $typename = R::findOne('type_wagon', 'id = ?' , array($type_id)); 
   }

   public function WagonTypeMult($price, $type_id) {
      $mult_type = R::findOne('type_wagon', 'id = ?' , array($type_id))->price_mult; 
      return $mult_type *= $price; 
   }

   public function WagonSeats($wagon_id) {
      return $seats_arr = R::getAll('Select * From seat where identification_number = ?', [$wagon_id]); 
   }

   public function SeatTicket($seat_id, $schedule_id) { 
      return $ticket = R::findOne('ticket', 'id_seat = ? and id_schedule = ?' , array($seat_id, $schedule_id)); 
   }

   public function TicketInfo($user_id) {
      return $ticket_info = R::getAll('SELECT * FROM ticket where id_user = ? order by id desc' , [$user_id]);
   }

   public function ScheduleInfo($schedule_id) {
      return $schedule_info = R::findOne('schedule', 'id = ?', array($schedule_id)); 
   }

   public function RouteName($route_id) {
      return $route_name = R::findOne('route', 'id = ?', array($route_id)); 
   }

}
