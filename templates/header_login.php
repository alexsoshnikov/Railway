<!--
<a href="index.php">
    <div class="logo"></div>
</a>
<a href="index.php">
    <div class="companyName">Railway company</div>
</a>
<div class="userCurrent">
    <ul>
        <li>
            <div class="userimg"></div>
            <div class="nameuser">
                <?php echo $_SESSION['logged_user']->name; ?>&nbsp; </div>
            <div class="surnameuser">
                <?php echo $_SESSION['logged_user']->surname;?>
            </div>
            <div class="balance">
                <h5>Баланс:&nbsp;<?php 
            echo R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id))->balance;
            ?> ₽</h5> </div>
        </li>
        <li>
            <a href="index.php?page=payment">
                <div class="money"></div>
            </a>
        </li>
        <li>
            <a href="../templates/logout.php">
                <div class="logoutimg"></div>
            </a>
        </li>
    </ul>
</div>
-->
<div class="user-menu">
    <div class="user-nb">
        <h2 class="user-name">Ivan Ivanov</h2>
        <h5 class="user-balance">Balance: 1000</h5></div>
    <button class="user-button add-payment"></button>
    <button class="user-button history-routes"></button>
    <button class="user-button logout"></button>
</div>