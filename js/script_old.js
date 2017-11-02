var dataTime = $('body').data('timer-for-question'),
    lang = $('body').data('lang'),
    dataObject = $('body').data('object'),
    dataAction = $('body').data('action');

$(window).on('load', function() {
    $("#preload").animate({
        opacity:'0',   
    },1000); 
    setTimeout(function(){
        $("#preload").css("display","none");
    },1000);
});


//    $("#").on("click", function(){
//        let lang = $("#").attr('id');
//        langshooce(lang);
//    });

function langshooce(lang){
    $.getJSON('languages/'+lang+'.json', function(data) {
        $.each(data, function(key, val) {
            if(key == 'Next') 
                $('.nextPage').text(val);
            if(key=='Thanks')
                $('.succes p').text(val);
             if(key=='Choose')
                $('#age').text(val);
        });
    });
} 
langshooce(lang);
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

function nextPage(x) {
    clearTime();
    flagExit++;
    if(flagExit>=5) {
        exitBlock();
        $('.succes').css('display','block');
    }else {

        if(flagExit==3) {
            $('.question').text(dataAction);
            
            remove(); 
        }

        if(flagExit==1||flagExit==3) {
            timer(dataTime * 1000);
            $('.plus').css('display','block');
        }


        if(flagExit==2||flagExit==4)
            timer(dataTime * 1000);

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
    flagQestion++;
    $('.question-block').append('<p><input class="'+flagQestion+'" type="text"></p>'); 
});

$(document).on('click','.plus-how-to-fix', function(){
    $(this).siblings('.how-to-fix-block-list').append('<p><input type="text"></p>'); 
});

$('button[href=how-to-fix]').on('click', function(){
    for(let i = 0;i <= flagQestion; i++) {
        let question ='';
        question = $('.question-block input[class='+i+']').val();
        $('.how-to-fix-main').append('<div class="how-to-fix-block"><p class="'+i+'">'+question+'</p><div class="how-to-fix-block-list"><p><input type="text"></p></div><button class="plus-how-to-fix">+</button></div>');
    }
});
