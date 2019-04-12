<?php 
include_once ('db.php');

class SearchRoute {
  // обобщающая функция
   public function AllCalculate($from, $to)

   {
      $mainArr = array();
      $mainArr = $this->RouteInfo($this->DoNewArray($this->StationToSomewhere($from) , $this->StationToSomewhere($to)));
      return $mainArr;
   }
   // получаем массив всех станций в этих городах
   public function FindStations($city)

   {
      $idstations = R::find('station', 'city_id = ?', array(
         R::findOne('city', 'name = ?', array(
            $city
         ))->id
      ));
      return $idstations;
   }
   // функция принимает на вход трехмерный массив и возвращает двумерный в нормальном виде(для нормальной обработки и просмотра)
   public function Arrout($arr)

   {
      $arrOut = array();
      foreach($arr as $subArr) {
         $arrOut = array_merge($arrOut, $subArr);
      }
      return $arrOut;
   }
   // функция находит все возможные маршруты со станцие "куда" , она может быть как концом, так и промежуточной точкой в маршруте (что тоже следует проверять..)
   public function StationToSomewhere($to)

   {
      foreach($this->FindStations($to) as $idsta) {
         $arrTo[] = R::getAll('select * from station_route where id_station = ?', [$idsta->id]);
      }
      return $this->Arrout($arrTo);
   }
   // ОСНОВНАЯ функция создает новый массив. Она сравнивает станции от и до по маршруту и соединяет их в один. Выводит поля - номер маршрута,
   // id станции начала, id станции до пункта назначения, порядковый номер станции назначения и конечную станцию маршрута (станции назанчения и  конечная могут не совпадать, ножно проверять)
   public function DoNewArray($array_from, $array_to)

   {
      $result = array();
      $number = 1;
      foreach($array_to as $route_ends) {
         foreach($array_from as $start_route) {
            if (($start_route["id_route"] == $route_ends["id_route"]) && $start_route["number"] < $route_ends["number"] && $this->TimeStart($route_ends["id_route"])) {
               $arr = null;
               $arr[] = R::getAll('SELECT * FROM schedule where id_route = ? order by time_start', [$start_route["id_route"]]);
               foreach($this->Arrout($arr) as $key) {
                  if (($this->CreateDate($key["time_start"])) == date($_SESSION['datepicker'])) {
                     $result[] = array(
                        "ID" => $number,
                        "id_route" => $route_ends["id_route"],
                        "start_from" => $start_route["id_station"],
                        "station_to" => $route_ends["id_station"],
                        "first_station" => $this->FirstStationRoute($route_ends["id_route"]) ,
                        "last_station" => $this->LastStationRoute($route_ends["id_route"]) ,
                        "start_time" => $this->CreateTime($key["time_start"]) ,
                        "train_id" => $key["id_train"]
                     );
                     $number++;
                  }
               }
            }
         }
      }
      return $result;
   }
   public function CreateDate($date)

   {
      $dateCre = htmlspecialchars($date);
      $dateCre = date('m/d/Y', strtotime($dateCre));
      return $dateCre;
   }
   public function CreateTime($date)

   {
      $dateCre = htmlspecialchars($date);
      $dateCre = date('H:i', strtotime($dateCre));
      return $dateCre;
   }
   public function TimeStart($id_route)

   {
      $timeright = array();
      $arr[] = R::getAll('SELECT * FROM schedule where id_route = ?', [$id_route]);
      foreach($this->Arrout($arr) as $key) {
         if (($this->CreateDate($key["time_start"])) == date($_SESSION['datepicker'])) $timeright[] = $key["id_route"];
      }
      return $timeright;
   }
   // функция поиска начальной станции на конкретном маршруте
   public function LastStationRoute($route_id)

   {
      $arr[] = max(R::getAll('SELECT number, id_station FROM station_route where id_route = ?', [$route_id]));
      return $arr[0]['id_station'];
   }
   // функция поиска конечной станции на конкретном маршруте
   public function FirstStationRoute($route_id)

   {
      $arr[] = R::getAll('SELECT * FROM station_route where number = 1 and id_route = ?', [$route_id]);
      return $arr[0][0]["id_station"];
   }
   // функция пересчета времени в конкретном промежутке маршрута
   public function DestinationTime($distance, $weight, $traction, $maxtrain, $maxsection)

   {
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
   public function TotalWeightWagon($id_train)

   {
      $wagon = R::getAll('SELECT * FROM wagon where train_id = ? ', [$id_train]);
      foreach($wagon as $keys) {
         $totalWeight = $totalWeight + R::findOne('type_wagon', 'id = ?', array(
            $keys["type_wagon_id"]
         ))->weight;
      }
      return $totalWeight;
   }
   // функция поиска типа подвижного вагона и его данных
   public function EngineInfo($id_train)

   {
      $engine = R::findOne('engine', 'id = ? ', array(
         R::findOne('train', 'id = ? ', array(
            $id_train
         ))->engine_id
      ));
      $engine_info = R::findOne('type_engine', 'id = ? ', array(
         $engine->type_engine_id
      ));
      return $engine_info;
   }
   // пересчет и вывод конечного массива
   public function RouteInfo($arr)

   {
      $res = array();
      foreach($arr as $route) {
         $totalWeight = 0;
         $routeArr = R::getAll('SELECT * FROM station_route where id_route = ? order by number', [$route["id_route"]]);
         $totalWeight = $this->TotalWeightWagon($route["train_id"]) + $this->EngineInfo($route["train_id"])->weight;
         $time = 0;
         $predtime = 0;
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
               $i++;
               $predtime = 0;
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
               $i++;
            }
            while ($id_end_pred != $route["start_from"]);
            $found_key = array_search($route["start_from"], array_column($routeArr, 'id_station'));
            do {
               $id_start_pred = $routeArr[$found_key]["id_station"];
               $id_end_pred = $routeArr[$found_key + 1]["id_station"];
               $distance = R::findOne('destination', 'start_station = ? and end_station = ?', array(
                  $id_start_pred,
                  $id_end_pred
               ));
               $time = $time + $this->DestinationTime($distance->distance, $totalWeight, $this->EngineInfo($route["train_id"])->traction_force, $this->EngineInfo($route["train_id"])->max_speed, $distance->section_speed);
               $found_key++;
            }
            while ($id_end_pred != $route["station_to"]);
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
            "train_id" => $route["train_id"]
         );
      }
      return $res;
   }
}

class SearchInfo {
   // функция поиска названия поезда 
   public function TrainName($id)

   {
      $train = R::findOne('train', 'id = ? ', array(
         $id
      ))->name;
      return $train;
   }
   // функция поиска названия станций 
   public function StationName($id)

   {
      $station = R::findOne('station', 'id = ? ', array(
         $id
      ))->name;
      return $station;
   }
   // функция вычисления времени старта 
   public function ArrivalTime($pred, $start)

   {
      $hours_first = floor($pred / 60);
      $minutes_first = $pred % 60;
      $date_first = strtotime($start) + strtotime($hours_first . ':' . $minutes_first) - strtotime("00:00:00");
      return date('H:i', $date_first);
   }
   // функция вычисления времени в пути 
   public function RouteTime($time)

   {
      $hours = floor($time / 60);
      $minutes = $time % 60;
      return $hours . 'h. ' . $minutes . 'min';
   }
   // функция вычисления времени конца поездки 
   public function DepartureTime($pred, $start, $time)

   {
      $hours_first = floor($pred / 60);
      $minutes_first = $pred % 60;
      $date_first = strtotime($start) + strtotime($hours_first . ':' . $minutes_first) - strtotime("00:00:00");
      $hours = floor($time / 60);
      $minutes = $time % 60;
      $date = $date_first + strtotime($hours . ':' . $minutes) - strtotime("00:00:00");
      return date('H:i', $date);
   }
}
