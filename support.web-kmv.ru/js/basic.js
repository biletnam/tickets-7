/*
 * SimpleModal Basic Modal Dialog
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */

jQuery(function ($) {
    // Load dialog on page load
    //$('#basic-modal-content').modal();

    $('.beclient-me').click(function (e) {
        $('.register-me').modal();

        return false;
    });

    // Load dialog on click
    $('#basic-modal .basic').click(function (e) {
        $('#basic-modal-content').modal();

        return false;
    });

    $('#commentForm').submit(function(e){
        e.preventDefault();
        self = $(this);
        var obj ={};
        obj.comment = $(this).find('[name="comment"]').val();
        obj.ticket_id = $(this).find('[name="ticket_id"]').val();
        obj._token = $(this).find('[name="_token"]').val();
        obj._method = "post";
        if (obj.comment.trim().length==0) return alert('Введите комментраий');
        jQuery.ajax({
                type:"post",
                url:self.attr('href'),
                data:obj,
                success: function(data){
                    try{
                        if(data =  JSON.parse(data)){
                            /*self.html('Комментарий оставлен.');*/
                            $(".white-bock").append('<div class="section"><img alt="" src="'+$(".img_com_h").val()+'" width="65"><h5>Ваше сообщение</h5><p>'+data.comment+'</p><span class="time">'+data.created_at+'</span></div>');
                            $(".white-bock").animate({"scrollTop": $('.white-bock')[0].scrollHeight}, "slow");
                            $('.comment-error').html('Комментарий оставлен.');
                            $(".txt-are").val("");
                        }
                    }catch(ex){
                        consol.log(ex);
                    }
                }
            }
        )
    })


    $(".form-block-me form").submit(function(){ // перехватываем все при событии отправки
        var form = $(this); // запишем форму, чтобы потом не было проблем с this
        var error = false; // предварительно ошибок нет
        form.find('input, textarea').each( function(){ // пробежим по каждому полю в форме
            if ($(this).val() == '') { // если находим пустое
                alert('Заполните поле "'+$(this).attr('placeholder')+'"!'); // говорим заполняй!
                error = true; // ошибка
            }
        });
        if (!error) { // если ошибки нет
            var data = form.serialize(); // подготавливаем данные
            $.ajax({ // инициализируем ajax запрос
                type: 'GET', // отправляем в POST формате, можно GET
                url: '/base/homepagesend', // путь до обработчика, у нас он лежит в той же папке
                dataType: 'json', // ответ ждем в json формате
                data: data, // данные для отправки
                beforeSend: function(data) { // событие до отправки
                    form.find('input[type="submit"]').attr('disabled', 'disabled'); // например, отключим кнопку, чтобы не жали по 100 раз
                },
                success: function(data){ // событие после удачного обращения к серверу и получения ответа
                    alert("Сообщение отправлено");
                    console.log(data);
                    if (data['error']) { // если обработчик вернул ошибку
                        alert(data['error']); // покажем её текст
                    } else { // если все прошло ок
                        alert('Письмо отвравлено! Чекайте почту! =)'); // пишем что все ок
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) { // в случае неудачного завершения запроса к серверу
                    alert("Сообщение отправлено");
                   // alert(xhr.status); // покажем ответ сервера
                   // alert(thrownError); // и текст ошибки
                },
                complete: function(data) { // событие после любого исхода
                    form.find('input[type="submit"]').prop('disabled', false); // в любом случае включим кнопку обратно
                }

            });
        }
        return false; // вырубаем стандартную отправку формы
    });
    $('.jqte-test').jqte();
});

