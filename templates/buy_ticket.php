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
                <div>
                    <section class="type-wagon-top-info">
                        <article class="wagon-name">
                            <p>Wagon ID:</p>
                            <span>1212-333</span>
                        </article>
                        <article class="wagon-type">
                            <p>Wagon type:</p>
                            <span>Class-1</span>
                        </article>
                        <article class="wagon-price">
                            <p>Price:</p>
                            <span>1000 Rub</span>
                        </article>
                    </section>
                    <section class="type-wagon-seats">
                        <form class="form-seats" action="#">
                            <div class="list-of-seats seats-grid-20">
                                <div class="seat-id" data-value="1"><span>1</span></div>
                                <div class="seat-id" data-value="2"><span>2</span></div>
                                <div class="seat-id" data-value="3"><span>3</span></div>
                                <div class="seat-id" data-value="4"><span>4</span></div>
                                <div class="seat-id" data-value="5"><span>5</span></div>
                                <div class="seat-id" data-value="6"><span>6</span></div>
                                <div class="seat-id" data-value="7"><span>7</span></div>
                                <div class="seat-id" data-value="8"><span>8</span></div>
                                <div class="seat-id" data-value="9"><span>9</span></div>
                                <div class="seat-id" data-value="10"><span>10</span></div>
                                <div class="seat-id" data-value="11"><span>11</span></div>
                                <div class="seat-id" data-value="12"><span>12</span></div>
                                <div class="seat-id" data-value="13"><span>13</span></div>
                                <div class="seat-id" data-value="14"><span>14</span></div>
                                <div class="seat-id" data-value="15"><span>15</span></div>
                                <div class="seat-id" data-value="16"><span>16</span></div>
                                <div class="seat-id" data-value="17"><span>17</span></div>
                                <div class="seat-id" data-value="18"><span>18</span></div>
                                <div class="seat-id" data-value="19"><span>19</span></div>
                                <div class="seat-id" data-value="20"><span>20</span></div>
                            </div>
                            <div class="selected-seats-buy">
                                <h3>Selected Seat: <span id="selected-seat"></span></h3>
                                <input type="submit" class="submit-buy" value="buy">
                            </div>
                        </form>
                    </section>
                </div>
                <div>132312312312</div>
            </div>
            <script>
                $('.single-slide').slick({});
            </script>
        </div>
    </div>
</section>