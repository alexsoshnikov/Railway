$(document).ready(function() {
    $('.list-of-seats .seat-id').click(function() {
        $(this).parent().find('.seat-id').removeClass('selected');
        $(this).addClass('selected');
        var val = $(this).attr('data-value');
        document.getElementById('selected-seat').innerText = val;
    });
});

$(function() {
    $('input').on('change', function() {
        var input = $(this);
        if (input.val().length) {
            input.addClass('populated');
        } else {
            input.removeClass('populated');
        }
    });
    setTimeout(function() {
        $('#fname').trigger('focus');
    }, 500);
});
// регистрация пользователя
$(document).ready(function() {
    $('#form_signUp').submit(function() {
        //убираем класс ошибок с инпутов
        $('input').each(function() {
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
            url: "app/ajax_signup.php", // какие данные будут переданы
            data: {
                'signUp_name': signUp_name,
                'signUp_surname': signUp_surname,
                'signUp_passport': signUp_passport,
                'signUp_telephone': signUp_telephone,
                'signUp_email': signUp_email,
                'signUp_password': signUp_password,
                'signUp_password_2': signUp_password_2
            }, // тип передачи данных
            dataType: "json", // действие, при ответе с сервера
            success: function(data) {
                // в случае, когда пришло success. Отработало без ошибок
                if (data.result == 'success') {
                    $('.main-content-signup').hide();
                    $('.loader-css').show();
                    setTimeout('window.location = "index.php";', 1200);
                    // в случае ошибок в форме
                } else {
                    // перебираем массив с ошибками
                    $('#signUp_password').val('');
                    $('#signUp_password_2').val('');
                    for (var errorField in data.text_error) {
                        $('.signup-title').text(data.text_error[errorField]).css('color', 'red');
                        $('#' + errorField).addClass('error_input');
                    }
                }
            }
        });
        // останавливаем сабмит, чтоб не перезагружалась страница
        return false;
    });
});
// авторизация пользователя
$(document).ready(function() {
    $('#form_signIn').submit(function() {
        //убираем класс ошибок с инпутов
        $('input').each(function() {
            $(this).removeClass('error_input');
        });
        // получение данных из полей
        var signIn_email = $('#signIn_email').val();
        var signIn_password = $('#signIn_password').val();
        $.ajax({
            // метод отправки 
            type: "POST", // путь до скрипта-обработчика
            url: "app/ajax_signin.php", // какие данные будут переданы
            data: {
                'signIn_email': signIn_email,
                'signIn_password': signIn_password
            }, // тип передачи данных
            dataType: "json", // действие, при ответе с сервера
            success: function(data) {
                // в случае, когда пришло success. Отработало без ошибок
                if (data.result == 'success') {
                    $('.main-content-signin').hide();
                    $('.loader-css').show();
                    setTimeout('window.location = "index.php";', 1200);
                }
                // в случае ошибок в форме
                else {
                    // перебираем массив с ошибками
                    for (var errorField in data.text_error) {
                        $('.signin-title').text(data.text_error[errorField]).css('color', 'red');
                        $('label #' + errorField).addClass('error_input');
                    }
                }
            }
        });
        // останавливаем сабмит, чтоб не перезагружалась страница
        return false;
    });
});
// Данные оплаты 
$(document).ready(function() {
    $('#form_payment').submit(function() {
        //убираем класс ошибок с инпутов
        $('input').each(function() {
            $(this).removeClass('error_input');
        });
        // получение данных из полей
        var number = $('#number').val();
        var name = $('#name').val();
        var expiry = $('#expiry').val();
        var cvc = $('#cvc').val();
        var money = $('#money').val();
        $.ajax({
            // метод отправки 
            type: "POST", // путь до скрипта-обработчика
            url: "app/ajax_payment.php", // какие данные будут переданы
            data: {
                'number': number,
                'name': name,
                'expiry': expiry,
                'cvc': cvc,
                'money': money
            }, // тип передачи данных
            dataType: "json", // действие, при ответе с сервера
            success: function(data) {
                // в случае, когда пришло success. Отработало без ошибок
                if (data.result == 'success') {
                    $('.main-content-payment').hide();
                    $('.loader-css').show();
                    setTimeout('window.location = "index.php";', 2500);
                }
                // в случае ошибок в форме
                else {
                    // перебираем массив с ошибками
                    for (var errorField in data.text_error) {
                        $('.payment-title').text(data.text_error[errorField]).css('color', 'red');
                        $('#' + errorField).addClass('error_input');
                    }
                }
            }
        });
        // останавливаем сабмит, чтоб не перезагружалась страница
        return false;
    });
});
$(document).ready(function() {
    $('#form_search').submit(function() {
        //убираем класс ошибок с инпутов
        $('input').each(function() {
            $(this).removeClass('error_input');
        });
        // получение данных из полей
        var cityFrom = $('#cityFrom').val();
        var cityTo = $('#cityTo').val();
        var datepicker = $('#datepicker').val();
        $.ajax({
            // метод отправки 
            type: "POST", // путь до скрипта-обработчика
            url: "app/ajax_search.php", // какие данные будут переданы
            data: {
                'cityFrom': cityFrom,
                'cityTo': cityTo,
                'datepicker': datepicker
            }, // тип передачи данных
            dataType: "json", // действие, при ответе с сервера
            success: function(data) {
                // в случае, когда пришло success. Отработало без ошибок
                if (data.result == 'success') {
                    $('.main-content-search-route').hide();
                    $('.loader-css').show();
                    $('.selected-route ').show();
                    $('.station-from').text(data.from);
                    $('.station-to').text(data.to);
                    setTimeout('window.location = "index.php?page=schedule";', 2500);
                }
                // в случае ошибок в форме
                else {
                    // перебираем массив с ошибками
                    for (var errorField in data.text_error) {
                        $('#' + errorField).addClass('error_input');
                        $('.search-route-title').text(data.text_error[errorField]).css('color', 'red');
                    }
                }
            }
        });
        // останавливаем сабмит, чтоб не перезагружалась страница
        return false;
    });
});