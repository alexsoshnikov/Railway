//$( document ).ready(function(){
//	  $( "#do_signupButton" ).click(function(){ 
//          alert('asdasd');
//	  });
//	});

$(document).ready(function () {
    $('#form_signUp').submit(function () {
        //убираем класс ошибок с инпутов
        $('input').each(function () {
            $(this).removeClass('error_input');
        });
        // получение данных из полей
        var signUp_name = $('#signUp_name').val();
        var signUp_surname = $('#signUp_surname').val();
        var signUp_passport = $('#signUp_passport').val();
        var signUp_telephone = $('#signUp_telephone').val();
        var signUp_email = $('#signUp_email').val();
        var signUp_password = $('#signUp_password').val();
        var signUp_password_2 = $('#signUp_password_2').val();
        $.ajax({
            // метод отправки 
            type: "POST", // путь до скрипта-обработчика
            url: "templates/ajax_signup.php", // какие данные будут переданы
            data: {
                'signUp_name': signUp_name
                , 'signUp_surname': signUp_surname
                , 'signUp_passport': signUp_passport
                , 'signUp_telephone': signUp_telephone
                , 'signUp_email': signUp_email
                , 'signUp_password': signUp_password
                , 'signUp_password_2': signUp_password_2
            }, // тип передачи данных
            dataType: "json", // действие, при ответе с сервера
            success: function (data) {
                // в случае, когда пришло success. Отработало без ошибок
                if (data.result == 'success') {
                     $('.whiteBox_signUp >').hide();
                     $('#successRegistrationMain').show();
                    // в случае ошибок в форме
                }
                else {
                    // перебираем массив с ошибками
                    for (var errorField in data.text_error) {
                        $('#signUp_password').val('');
                        $('#signUp_password_2').val('');
                        $('#header_whiteBox_signUp_id').text(data.text_error[errorField]).css('color', 'red');
                        $('#' + errorField).addClass('error_input');
                    }
                }
            }
        });
        // останавливаем сабмит, чтоб не перезагружалась страница
        return false;
    });
});