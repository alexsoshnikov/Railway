<div class="whiteBox_signUp">
    <div id="successRegistrationMain">
        <div class="successRegistration">Вы успешно зарегистрированны!</div>
        <div id="signinAfterUp"><a href="index.php?page=signin">SIGN IN</a></div>
    </div>
    <div class="header_whiteBox_signUp" id="header_whiteBox_signUp_id">Sign Up</div>
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
    <form id="form_signUp" action="index.php?page=signup" method="POST">
        <div class="signUp">
            <input class="text" type="text" placeholder="Name" id="signUp_name" >
            <br>
            <input class="text" type="text" placeholder="Surname" id="signUp_surname" >
            <br>
            <input class="text" type="text" placeholder="1111-111111" id="signUp_passport">
            <br>
            <input class="text" type="text" placeholder="+7(900)111-11-11" id="signUp_telephone">
            <br>
            <input class="text" type="email" placeholder="Email" id="signUp_email">
            <br>
            <input class="text" type="Password" placeholder="Password" id="signUp_password">
            <br>
            <input class="text" type="Password" placeholder="Password" id="signUp_password_2">
            <div class="signUpButton">
                <input class="submit" type="submit" value="Sign Up" name="do_signup" id="do_signupButton"> </div>
        </div>
    </form>
</div>

