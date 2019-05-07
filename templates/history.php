<section class="main-content-history">
    <span class="history-title"><?php 
       if(!empty($tickets -> TicketInfo($_SESSION['logged_user']->id)))
           echo "Travel history"; 
       else 
           echo "No travel history!";?>
    </span>
       <?php foreach ($tickets -> TicketInfo($_SESSION['logged_user']->id) as $key) : ?>
       <article class="routes-list">
           <span class="list-route"><?php echo $tickets -> RouteName($tickets -> ScheduleInfo($key['id_schedule'])->id_route)->name ?></span>
               <div class="list-arrival"> 
                   <div class="ticket-id">
                      <p>ID Ticket: </p>
                      <span><?php echo $key['id']; ?></span>
                   </div> 
                    <div class="time-start">
                        <p>Time Start:</p>
                        <span><?php echo $search -> CreateDate($tickets -> ScheduleInfo($key['id_schedule'])->start_date) ?></span>
                        <span><?php echo $search -> CreateTime($tickets -> ScheduleInfo($key['id_schedule'])->start_date) ?></span>
                    </div>
                    <div class="price">
                       <p>Price: </p>
                       <span><?php echo $key['price']; ?> Rub</span>
                    </div> 
                    <div class="status">
                       <?php if ($tickets -> ScheduleInfo($key['id_schedule'])->start_date > date("Y-m-d H:i:s")) : ?> 
                         <span  style="color: #19ff19" >active</span>
                       <?php else: ?> 
                         <span style="color: red">not active</span>
                       <?php endif ?> 
                    </div> 
                 </div>
         </article>
         <?php endforeach; ?>
    <div class="clr"></div>
</section>