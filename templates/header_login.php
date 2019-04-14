<div class="user-menu">
    <div class="user-nb">
        <h2 class="user-name"><?php echo $_SESSION['logged_user']->name; ?>&nbsp;<?php echo $_SESSION['logged_user']->surname;?></h2>
        <h5 class="user-balance">Balance:&nbsp; <?php 
            echo R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id))->balance;
            ?>₽</h5></div>
    <a href="index.php?page=payment" class="user-button add-payment"></a>
    <a href="#" class="user-button history-routes"></a>
    <a href="../app/logout.php" class="user-button logout"></a>
</div>