$(document).ready(function () {
    function changeCount(first = null, second = null){
        var countActive = $(first).text();
        countActive = Number(countActive) - 1;
        $(first).text(countActive);
        var countTrash = $(second).text();
        countTrash = Number(countTrash) + 1;
        $(second).text(countTrash);
    }
    function taskAdd() {
        $('.add').on('click', function (e) {
            e.preventDefault();
            var type = $(this).parent().find('.deactivate-all').data('type');
            var age = $('body').data('age');
            $('.container--add').find('option').attr('selected', false);
            $('.container--add').find('option[value=' + type + ']').attr('selected', true);
            $('.container--add').find('option[value=' + age + ']').attr('selected', true);
            $('html').css({'overflow':'hidden'});
            $('.container--add').css({'display':'flex'});
            $('.container--add .overlay').fadeIn(300, function () {
                $('.container--add .task--add').fadeIn(300);
            });
        });
        $('.overlay,.close').on('click', function (e) {
            e.preventDefault();
            $('html').css({'overflow':'visible'});
            $('.container--add .task--add').fadeOut(300, function () {
                $('.container--add .overlay').fadeOut(300, function () {
                    $('.container--add').css({'display':'none'});
                });
            });
        });
        $('#form--add').submit(function () {
            $.ajax({
                type: "POST",
                url: "/admin/include/createQuestion.php",
                data: $(this).serialize(),
                success: function (data) {
                    window.location = window.location;
                   $('.container--add .task--add').fadeOut(300, function () {
                        $('.container--add .overlay').fadeOut(300, function () {
                            $('.container--add').css({'display':'none'});
                            $('#form--add input').val('');
                        });
                    });
                }
            });
            return false;
        });
    }
    function updateSettings() {
        $('input[name=login], input[name=password], input[name=time1], input[name=time2]').keyup(function (e) {
            var $login,
                $password,
                $timer1,
                $timer2;
            $login = $('input[name=login]').val();
            $password = $('input[name=password]').val();
            $timer1 = $('input[name=time1]').val();
            $timer2 = $('input[name=time2]').val();
           $.ajax({
                type: 'POST',
                url: '/admin/include/updateSettings.php',
                data: {'login' : $login, 'password' : $password, 'timer1' : $timer1, 'timer2' : $timer2 }
           });
        });
    }
    function dropdownSettings () {
        $(document).on('click', 'a.settings.button, .add', function (e) {
            e.preventDefault();
            var bool = ( $('#settings').hasClass('active') ) ? 1 : 0;
            if ( $(this).hasClass('add') ) {
                bool = 1;
            }
            ( bool == 0 ) ? $('#settings').slideDown() : $('#settings').slideUp();
            ( bool == 0 ) ? $('#settings').addClass('active') : $('#settings').removeClass('active');
        });
    }
    function removeQuestion () {
        $(document).on('click', '.remove', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '/admin/include/removeQuestion.php',
                data: {'id': id},
                success: function (data) {
                    console.log(data);
                    $('a[data-id='+ id +']').parent().parent().remove();
                }
            });
        });
    }
    function changeTranslation () {
        $('.edit').on('click', function (e) {
            e.preventDefault();
            $('html').css({'overflow':'hidden'});
            $('.container--edit').css({'display':'flex'});
            $('.container--edit .overlay').fadeIn(300, function () {
                $('.container--edit .task--edit').fadeIn(300);
            });
            var id = $(this).data('id');
            var lang = [],
                typeLang = '';
                $(this).parent().siblings().each(function () {
                    typeLang = $(this).data('lang');
                    if( typeLang == undefined ) {}
                    else {
                        lang[typeLang] = $(this).text();
                        $('input[lang='+typeLang+']').val(lang[typeLang]);
                    }
                });
                $('#form--edit input[name=id]').val(id);

        });
        $('.overlay,.close').on('click', function (e) {
            e.preventDefault();
            $('html').css({'overflow':'visible'});
            $('.container--edit .task--edit').fadeOut(300, function () {
                $('.container--edit .overlay').fadeOut(300, function () {
                    $('.container--edit').css({'display':'none'});
                });
            });
        });

        $('#form--edit').submit(function () {
            $.ajax({
                type: "POST",
                url: "/admin/include/updateQuestion.php",
                data: $(this).serialize(),
                success: function (data) {
                   $('.container--edit .task--edit').fadeOut(300, function () {
                        $('.container--edit .overlay').fadeOut(300, function () {
                            $('.container--edit').css({'display':'none'});
                            $('#form--edit div').remove();
                            $('#form--edit input').val('');
                        });
                    });
                   location.href = '/admin/';
                }
            });
            return false;
        });
    }
    function changeSelectAge () {
        $(document).on('change', 'select#ageS', function () {
            var val = $(this).find('option:selected').val();
            window.location = "/admin/?age="+val;
        });
    }
    function selectQuestionForChildren() {
        $(document).on('click', '.checkbox', function (e) {
            e.preventDefault();
            $(this).parent().parent().siblings().children().find('.checkbox').attr('id', 'deactivated');
            $(this).parent().parent().siblings().children().find('.checkbox').removeClass('fa-check').addClass('fa-times');
            $(this).attr('id', 'activated');
            $(this).removeClass('fa-times').addClass('fa-check');
            var id = $(this).data('id');
            var checked = 1;
            var age = $('body').data('age');
            var type = $(this).parent().parent().attr('class');
            $.ajax({
                type: 'POST',
                url: '/admin/include/activeQuestion.php',
                data: {'id': id, 'checked': checked, 'age': age, 'type': type},
                success: function(data) {
                    console.log(data);
                }
            });
        });
    }
    function deactivateAll() {
        $(document).on('click', '.deactivate-all', function (e) {
            e.preventDefault();
            var age = $('body').data('age');
            var type = $(this).data('type');
            $(this).siblings().find('.checkbox').attr('id', 'deactivated');
            $(this).siblings().find('.checkbox').removeClass('fa-check').addClass('fa-times').css('color: red');
            $.ajax({
                type: 'POST',
                url: '/admin/include/deactivateAll.php',
                data: {'age': age, 'type': type},
                success: function(data) {
                    console.log(data);
                }
            });
        });
    }
     function processAjaxData(response, urlPath){
         document.getElementById("content").innerHTML = response.html;
         document.title = response.pageTitle;
         window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", urlPath);
     }
    deactivateAll();
    selectQuestionForChildren();
    changeSelectAge();
    changeTranslation();
    removeQuestion();
    dropdownSettings();
    updateSettings();
    taskAdd();
});