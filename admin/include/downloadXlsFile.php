<?php 
include '../../functions.php';

//will work if the link is set in the indx.php page
if(isset($_GET['name']))
{
    error_reporting(0);
    $name=$_GET['name']; //to rename the file
    // header("Pragma: public");
    // header('Content-Disposition: attachment; filename='.$name.'.xls'); 
    // header('Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
    // header('Content-Type: application/x-msexcel; charset=utf-8; format=attachment;');
    $msg="";
    $var="";
    //write your query  
    echo "<style>table {
        border-collapse: collapse;
    }
    
    table, th, td {
        border: 1px solid black;
    } </style>";    
    echo 
    "
    <table>
        <thead>
            <tr>
                <th>Type question</th>
                <th>Question - En</th>
                <th>Question - Rus</th>
                <th>Question - De</th>
                <th>Question - Es</th>
                <th>Question - It</th>
                <th>Gender</th>
                <th>Problems</th>
            </tr>
        </thead> 
        <tbody>
    ";
    $problems =R::findAll('problems');
    foreach ($problems as $problem) {
        $object = getQuestionById((int)$problem->id_question);
        echo "<tr>";
        echo "<td>" . $object->type . "</td>";
        $object = json_decode($object->question, 1);
        foreach ($object as $key => $value) {    
            echo "<td>" . $value . "</td>";
        }
        echo "<td>" . $problem->gender . "</td>";
        $problema = json_decode( $problem->problem);
        foreach ($problema as $item) {
            echo "<tr>";
            echo "<td width='180px'>Problem name: ". $item->problemName ."</td>";
            foreach ($item->problemList as $answer) {
                echo "<td width='180px'>Decision of problem: ". $answer->answer ."</td>";
            }
            echo "</tr>";
        }
        echo "</tr>";
    }
    
    echo "</tbody></table>";
}
?>
