<div class="refillBox">
    <div class="card-wrapper"></div>
    <div class="main_box">
            <form id="form_payment" action="index.php?page=payment" method="POST">
    <div class="input_main">
        <input type="text" id="number" placeholder="Card Number" name="number" class="text">
        <br>
        <input type="text" id="name" placeholder="Full Name" name="name" class="text">
        <br>
        <input type="text" id="expiry" placeholder="Expiry" name="expiry" class="text">
        <input type="text" id="cvc" placeholder="CVC" name="cvc" class="text">
        <input type="text" id="money" placeholder="Payment" name="money" class="text"> </div>
    <div class="refillButton">
        <input class="submit" type="submit" value="push" name="do_payment"> </div>
            </form>
    </div>
    <div class="loadpay">
        <div class="namethanks">Thank you for payment,
            <?php echo $_SESSION['logged_user']->name?>!</div>
        <div class="load-1">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </div>
    <script src="js/jquery.card.js"></script>
    <script>
        $(function () {
            $('form').card({
                container: '.card-wrapper'
            });
        });
    </script>
</div>