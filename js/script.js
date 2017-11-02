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
//            if(key=='Choose')
//                $('#agee').text(val);
             if(key=='selectAge')
                $('#selectAge').text(val);
             if(key=='Describe')
                $('#Describe').text(val);
             if(key=='shortcomings')
                $('#shortcomings').text(val);
            if(key=='Thanks')
                $('#Thanks').text(val);
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
    $('.how-to-fix').css('display','none'); 
}

function save(id) {
    let array = {};
    array['action'] ={};
    array['id'] = id;
    array['age'] = dataAge;
    for(let i = 0; i<=flagQestion; i++) {

        array['action'][$('.how-to-fix-block p[class='+i+']').text()] = {} ; 

        $('#list'+i+' p input').each(function(index){
            array['action'][$('.how-to-fix-block p[class='+i+']').text()]['resh'+index] =  $(this).val();

        });
    }
    // array = JSON.stringify(array);
    $.ajax({
        type: "post",
        url: "/save-problem.php",
        data: array,
        success: function (data) {
            console.log(data);
        }
    });
}
function nextPage(x) {
    clearTime();
    flagExit++;
    if(flagExit>=5) {
        save(dataActionId);
        exitBlock();
        $('.succes').css('display','block');
    }else {

        if(flagExit==3) {
            $('.question').text(dataAction);
            save(dataObjectId);
            remove();

        }


        if(flagExit==1||flagExit==3) {
            timer(dataTime1 * 1000);
            $('.plus').css('display','block');
        }
        if(flagExit==2||flagExit==4)
            timer(dataTime2 * 1000);

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
    let timer =time/1000;
    $('.timer').text(timer);
    timerOne = setInterval(function(){
        timer--;
        $('.timer').text(timer);
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
langshooce(lang);