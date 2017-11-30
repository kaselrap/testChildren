<?php
    require 'functions.php';
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Test</title>
        <meta name="keywords" content="" />
        <link rel="shortcut icon" href="img/logo.png" type="image/png">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <?php  
        if( isset($_GET['age']) && ($_GET['age'] == '11-14' || $_GET['age'] == '15-16') ) {
            $age = $_GET['age'];
        } else {
            $age = '8-10';
        }

        $question_action = getQuestion($age, 'action');
        $question_object = getQuestion($age, 'object');
        $question_action_langs = json_decode($question_action['question']);
        $question_object_langs = json_decode($question_object['question']);
    ?>
     <body data-timer-first="<?php echo getSettings()->timer1; ?>" data-timer-second="<?php echo getSettings()->timer2; ?>" data-lang="<?php echo $lang ?>" data-object="<?php echo $question_object_langs->$lang; ?>" data-object-id="<?php echo $question_object->id; ?>" data-action-id="<?php echo $question_action->id; ?>" data-action="<?php echo $question_action_langs->$lang; ?>">
        <div id="preload"></div>
        <div class="bg"></div>
        <header>

        </header>
        <main>
          
            <div class="age">
               <h1 id="selectAge">Select your age</h1>
               <div class="select">
                <select id="age">               
                <?php
                    if ($age == '11-14') {
                        ?>
                        <option value="8-10"><a href="&age=8-10">8-10</a></option>
                        <option value="11-14" selected><a href="&age=11-14">11-14</a></option>
                        <option value="15-16"><a href="&age=15-16">15-16</a></option>
                        <?php
                    } 
                    else if($age == '15-16') {
                        ?>
                        <option value="8-10"><a href="&age=8-10">8-10</a></option>
                        <option value="11-14"><a href="&age=11-14">11-14</a></option>
                        <option value="15-16" selected><a href="&age=15-16">15-16</a></option>
                        <?php
                    } else if ( $age == '8-10' ){
                        ?>
                        <option value="8-10" selected><a href="&age=8-10">8-10</a></option>
                        <option value="11-14"><a href="&age=11-14">11-14</a></option>
                        <option value="15-16"><a href="&age=15-16">15-16</a></option>
                        <?php
                    } else {
                        ?>
                        <option selected disabled>Select your age</option>
                        <option value="8-10">8-10</option>
                        <option value="11-14">11-14</option>
                        <option value="15-16">15-16</option>
                        <?php
                    }
                ?>
                </select> 
                   <select >               
               
                        <option value="man" selected>Мужской</option>
                        <option value="girl" >Женский</option>
                       
                    
               
                </select> 
                <?php
                    if ( empty( $question_action ) || empty ( $question_object ) ) {
                        echo '<p>Тест не может быть начат. Вопросов нет!</p>';
                    } else {
                        echo '<button href="theTask" class="nextPage">Next</button>';
                    }
                ?> 
                </div>
           </div>
           <div class="theTask">
               <h1 id="now"></h1>
               <button href="limitations" class="nextPage center">Next</button>
            </div>
            <div class="limitations">
                <h1 id="Describe"></h1>
                <p class="question"><?php echo $question_object_langs->$lang;; ?></p>
                <div class="question-block">
                    <p><input class="0" type="text"></p>
                </div>
                <button class="plus">+</button>
                <button href="how-to-fix" class="nextPage bottom">Next</button>
                <p class="timer"></p>
            </div>
            
            
            <div class="how-to-fix">
                <h1 id="shortcomings"></h1>
                   <p class="question"><?php echo $question_object_langs->$lang;; ?></p>
                <div class="how-to-fix-main"></div>
                <button href="theTask" class="nextPage bottom">Next</button>
                <p class="timer"></p>
            </div>
            
           
            
            <div class="succes">
                 <h1 id="Thanks">Thanks for answers!</h1>
                  <button id="reload" class=" center"></button>
            </div>

        </main>
        <footer>

        </footer>
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>