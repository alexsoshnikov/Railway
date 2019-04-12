<?php 
include("app/classes_search.php");
// на вход получаем два имени станций откуда и куда
$city_from = $_SESSION['from'];  
$city_to = $_SESSION['to'];   

$search = new SearchRoute(); 
$information = new SearchInfo();

?>
<section class="main-content-routes">
    <span class="routes-title"><?php echo $city_from;?> &rarr; <?php echo $city_to;?></span>
     
    <?php foreach ($search -> AllCalculate($city_from, $city_to) as $way) : ?>
    <article class="routes-list">
        <span class="list-train"><?php echo $information ->TrainName($way['train_id'])?></span>
        <div class="list-arrival"> 
            <span class="list-stations first"> <?php echo $information -> StationName($way['first_station'])?> </span> 
            <span class="arrival-time"><?php echo $information -> ArrivalTime($way['pred_time'], $way['start_time'])?></span> 
            <span class="arrival-station"><?php echo $information -> StationName($way['station_from'])?></span> 
        </div>
        <div class="list-route-time">
            <div class="route-arrow"></div>
            <span class="route-time"><?php echo $information -> RouteTime($way['time']) ?></span> 
        </div>
        <div class="list-departure"> 
            <span class="list-stations last"><?php echo $information -> StationName($way['last_station'])?></span> 
            <span class="departure-time"><?php echo $information -> DepartureTime($way['pred_time'], $way['start_time'], $way['time'])?></span> 
            <span class="departure-station"><?php echo $information -> StationName($way['station_to'])?></span> 
        </div>
        <button class="list-button-buy">buy</button>
    </article>
    <?php endforeach; ?>
    <div class="clr"></div>
</section>