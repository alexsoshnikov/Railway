<section class="main-content-purchase-tickets">
    <div class="purchase-tickets-wrapper">
        <div class="full-schema-route">
            <ul>
               <?php foreach ($tickets -> ArrStation($purchase['route_id']) as $name) : ?>
                <li><?php echo $information -> StationName($name['id_station']) ?></li>
               <?php endforeach; ?>
            </ul>
        </div>
        <div class="route-info">
            <div class="main-info">
                <div class="list-arrival"> 
                    <span class="arrival-time"><?php echo $information -> ArrivalTime($purchase['pred_time'], $purchase['start_time'])?></span> 
                    <span class="arrival-station"><?php echo $information -> StationName($purchase['station_from'])?></span> 
                </div>
                <div class="list-route-time">
                    <div class="route-arrow"></div> <span class="route-time"><?php echo $information -> RouteTime($purchase['time']) ?></span>
                </div>
                <div class="list-departure"> 
                    <span class="departure-time"><?php echo $information -> DepartureTime($purchase['pred_time'], $purchase['start_time'], $purchase['time'])?></span> 
                    <span class="departure-station"><?php echo $information -> StationName($purchase['station_to'])?></span> 
                </div>
            </div>
            <div class="type-wagon single-slide">
              <?php foreach ($tickets -> WagonTrain($purchase['train_id']) as $key) : ?>
                <div>
                    <section class="type-wagon-top-info">
                        <article class="wagon-name">
                            <p>Wagon ID:</p>
                            <span><?php echo $key['identification_number'] ?></span>
                        </article>
                        <article class="wagon-type">
                            <p>Wagon type:</p>
                            <span><?php echo $tickets -> WagonTypeClass($key['id_type']) -> name?></span>
                        </article>
                        <article class="wagon-price">
                            <p>Price:</p>
                            <span><?php echo round($tickets -> WagonTypeMult($purchase['price'],$key['id_type']), 2) ?> Rub</span>
                        </article>
                    </section>
                    <section class="type-wagon-seats">
                        <form class="form-seats" action="#">
                            <div class="list-of-seats seats-grid-<?=$key['id_type'];?>">
                            <?php $seat_num = 1; ?>
                            <?php foreach ($tickets -> WagonSeats($key['identification_number']) as $seat) : ?>
                              <?php if (empty($tickets -> SeatTicket($seat['id']))) : ?> 
                                <div class="seat-id" data-value="<?php echo $seat['id']?>"><span><?php echo $seat_num++?></span></div>
                               <?php else: ?>
                               <div class="seat-id" style="background: grey;" data-value="Занят"><span><?php echo $seat_num++?></span></div>
                               <?php endif ?>
                            <?php endforeach; ?>
                            </div>
                            <div class="selected-seats-buy">
                                <h3>Selected ID:  <span id="selected-seat"></span></h3>
                                <input type="submit" class="submit-buy" value="buy">
                            </div>
                        </form>
                    </section>
                </div>
               <?php endforeach; ?>
            </div>
            <script>
                $('.single-slide').slick({});
            </script>
        </div>
    </div>
</section>