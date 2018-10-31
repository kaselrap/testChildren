(function ($){
    var dataTime1 = $('body').data('timer-first'),
        dataTime2 = $('body').data('timer-second'),
        lang = $('body').data('lang'),
        dataObject = $('body').data('object'),
        dataAction = $('body').data('action'),
        dataObjectId = $('body').data('object-id'),
        dataActionId = $('body').data('action-id'),
        dataAge = $('body').data('age');

    $(window).on('load', function() {
        $("#preload").animate({
            opacity:'0',
        },1000);
        setTimeout(function(){
            $("#preload").css("display","none");
        },1000);
    });

    var $gender = $('select#gender').val();
    $(document).on('change', 'select#gender', function () {
        $gender = $(this).find('option:selected').val();
    });

    function changeSelectAge () {
        $(document).on('change', 'select#age', function () {
            var val = $(this).find('option:selected').val();
            window.location = "/?age="+val;
        });
    }
    changeSelectAge();
    function langshooce(lang){

        $.getJSON('languages/'+lang+'.json', function(data) {
            $.each(data, function(key, val) {
                if(key == 'Next')
                    $('.nextPage').text(val);
                if(key=='Thanks')
                    $('.succes p').text(val);
                if(key=='selectAge')
                    $('#selectAge').text(val);
                if(key=='now')
                    $('#now').text(val);
                if(key=='Thanks')
                    $('#Thanks').text(val);
                if(key=='reload')
                    $('#reload').text(val);
            });
        });
    }



    let flagExit = 0,flagQestion = 0, timerOne, timerTwo;
    function remove(){
        flagQestion = 0;
        $('.question-block').empty();
        $('.question-block').append('<p><input class="'+flagQestion+'" type="text"></p>');
        $('.how-to-fix-main').empty();
    }

    function exitBlock(){
        $('.age').css('display','none');
        $('.limitations').css('display','none');
        $('.theTask').css('display','none');
        $('.how-to-fix').css('display','none');
    }

    function save(id) {
        let array = {};
        array['problem'] =[];
        array['id'] = id;
        array['gender'] = $gender;
        array['age'] = dataAge;
        $('.how-to-fix-block').each(function() {
            let problemName = $(this).find('.quest').text(),
                listProblem = [];
            $(this).find('.how-to-fix-block-list p').each(function() {
                listProblem.push(
                    {
                        answer: $(this).find('input').val(),

                    }
                );
            });
            array['problem'].push(
                {
                    problemName: problemName,
                    problemList: listProblem
                }
            );
        });

        $.ajax({
            type: "post",
            url: "/save-problem.php",
            data: array
        });
    }
    function nextPage(x) {
        clearTime();
        flagExit++;
        if(flagExit>=7) {
            save(dataActionId);
            exitBlock();
            $('.succes').css('display','block');
        }else {

            if(flagExit==5) {
                $('.question').text(dataAction);
                save(dataObjectId);
                remove();

            }
            if(flagExit==2) {
                $.getJSON('languages/'+lang+'.json', function(data) {
                    $.each(data, function(key, val) {
                        if(key=='Describe1')
                            $('#Describe').text(val);
                        if(key=='shortcomings1')
                            $('#shortcomings').text(val);
                    });
                });
            }
            if(flagExit==5) {
                $.getJSON('languages/'+lang+'.json', function(data) {
                    $.each(data, function(key, val) {
                        if(key=='Describe2')
                            $('#Describe').text(val);
                        if(key=='shortcomings2')
                            $('#shortcomings').text(val);
                    });
                });
            }


            if(flagExit==2||flagExit==5) {

                timer(dataTime1 * 1000);
                $('.plus').css('display','block');
            }
            if(flagExit==3||flagExit==6) {

                timer(dataTime2 * 1000);
            }


            let href = $(x).attr('href');
            exitBlock();

            $('.'+href).css('display','block');
        }
    }

    function clearTime() {
        clearInterval(timerOne);
        clearTimeout(timerTwo);
    }

    function timer(time){
        $('.timer').empty;
        let timer =time/1000,seconds=Math.floor( timer%60),minutes=Math.floor((timer/60)%60);
        if(seconds>9)
            $('.timer').text(minutes+"."+seconds);
        else
            $('.timer').text(minutes+".0"+seconds);
        timerOne = setInterval(function(){
            timer--;
            seconds =Math.floor( timer%60);
            minutes = Math.floor((timer/60)%60);
            if(seconds>9)
                $('.timer').text(minutes+"."+seconds);
            else
                $('.timer').text(minutes+".0"+seconds);
            if(timer<=0) {
                clearTime();
            }
        },1000);
        timerTwo = setTimeout(function(){
            $('.plus-how-to-fix').remove();
            $('.plus').css('display','none');
        },time-1);
    };
    $('.nextPage').on('click',function(){
        nextPage(this);
    });

    $('.plus').on('click', function(){
        var flagBrea=1;
        $('.question-block p input').each(function(index){
            if($(this).val()=='')
                flagBrea=0;
        });
        if(flagBrea)
        {
            flagQestion++;
            $('.question-block').append('<p><input class="'+flagQestion+'" type="text"></p>');
        }
    });

    $(document).on('click','.plus-how-to-fix', function(){
        var flagBrea=1;
        $(this).siblings('.how-to-fix-block-list').children().children('input').each(function(index){
            if($(this).val()=='')
                flagBrea=0;
        });
        if(flagBrea)
        {
            $(this).siblings('.how-to-fix-block-list').append('<p><input type="text"></p>');
        }
    });


    $('button[href=how-to-fix]').on('click', function(){
        for(let i = 0;i <= flagQestion; i++) {
            let question ='';
            question = $('.question-block input[class='+i+']').val();
            if(question!='')
            {
                $('.how-to-fix-main').append('<div class="how-to-fix-block"><p  class="'+i+' quest">'+question+'</p><div class="how-to-fix-block-list" id="list'+i+'"><p><input type="text"></p></div><button class="plus-how-to-fix">+</button></div>');
            }
        }
    });
    $('#reload').on('click', function(){
        location.reload();
    });
    langshooce(lang);
})(jQuery);
