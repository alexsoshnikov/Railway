<?php 
 
?>
    <div class="whiteBox_signUp">
        <div class="listSignUp">
            <ul>
                <li>Name:</li>
                <li>Surname:</li>
                <li>Passport:</li>
                <li>Telephone:</li>
                <li>Email:</li>
                <li>Password:</li>
                <li>Repeat Password:</li>
            </ul>
        </div>
        <form action="index.php?page=signup" method="POST">
            <div class="signUp">
                <input class="text" id="suka" type="text" placeholder="Name" name="name" >
                <br>
                <input class="text" type="text" placeholder="Surname" name="surname" >
                <br>
                <input class="text" type="text" placeholder="1111-111111" name="passport" >
                <br>
                <input class="text" type="text" placeholder="+7(900)111-11-11" name="telephone" >
                <br>
                <input class="text" type="email" placeholder="Email" name="email" >
                <br>
                <input class="text" type="Password" placeholder="Password" name="password_1" >
                <br>
                <input class="text" type="Password" placeholder="Password" name="password_2" > 
                <div class="signUpButton">
                    <input class="submit" type="submit" value="Sign Up" name="do_signup" > </div>
            </div>
        </form>
    </div>