<section class="main-content-routes">
    <span class="routes-title"><?php 
       if(!empty($search -> AllCalculate($city_from, $city_to)))
           echo $city_from. ' &rarr; '. $city_to; 
       else 
           echo "No routes found!";?>
    </span>
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
        <a href="index.php?page=purchase&id=<?php echo $way['ID'];?>" class="list-button-buy">buy</a>
    </article>
    <?php endforeach; ?>
    <div class="clr"></div>
</section>