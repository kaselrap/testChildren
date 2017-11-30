<?php 
 //download.php page code
 //THIS PROGRAM WILL FETCH THE RESULT OF SQL QUERY AND WILL DOWNLOAD IT. (IF YOU HAVE ANY QUERY CONTACT:rahulpatel541@gmail.com)
//include the database file connection
include '../../functions.php';

//will work if the link is set in the indx.php page
if(isset($_GET['name']))
{
    $name=$_GET['name']; //to rename the file
    header('Content-Disposition: attachment; filename='.$name.'.xls'); 
    header('Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
    header('Pragma: no-cache');
    header('Content-Type: application/x-msexcel; charset=windows-1251; format=attachment;');
    $msg="";
    $var="";
    //write your query      
    $msg = 
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
        $msg .= "<tr>";
        $msg .= "<td>" . $object->type . "</td>";
        $object = json_decode($object->question);
        foreach ($object as $key => $value) {    
            $msg .= "<td>" . $value . "</td>";
        }
        $msg .= "<td>" . $problem->gender . "</td>";
        $msg .= "<td>" . $problem->problem . "</td>";
        $msg .= "<td>" . $problem->id_question . "</td>";
        $msg .= "</tr>";
    }

    $msg.="</tbody></table>";
    echo $msg;  //will print the content in the exel page
}
?>