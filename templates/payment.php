<!--
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
-->
<section class="main-content-payment"> <span class="payment-title">Payment</span>
    <div class="unite-payment">
        <div class="card-paypal">
            <div class="card-wrapper"></div> <img src="img/PayPal.png" alt="pay" width="150">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum blanditiis, numquam error distinctio optio rerum.</p>
        </div>
        <form id="form_payment" class="form-payment" action="index.php?page=payment" method="POST">
            <label>
                <input type="text" id="number" placeholder="Card Number" name="number" class="text"><span>Card Number</span> </label>
            <label>
                <input type="text" id="name" placeholder="Full Name" name="name" class="text"><span>Full Name</span> </label>
            <div class="cvc-expiry">
                <label>
                    <input type="text" id="expiry" placeholder="Expiry" name="expiry" class="text"><span>Expiry</span> </label>
                <label>
                    <input type="text" id="cvc" placeholder="CVC" name="cvc" class="text"><span>CVC</span> </label>
            </div>
            <label>
                <input type="text" id="money" placeholder="Payment" name="money" class="text"><span>Payment</span> </label>
            <input class="submit" type="submit" value="push" name="do_payment"> </form>
        <script>
            $(function () {
                $('#form_payment').card({
                    container: '.card-wrapper'
                });
            });
        </script>
    </div>
</section>