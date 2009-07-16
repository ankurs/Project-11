<html>
<head>
<title>TechTatva 09</title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='../js/jq.js' type='text/javascript'></script>
<script src='function.js' type='text/javascript' ></script>
</head>
<body>
<?php include "../header.php"; ?>

<div id="sidebar">
<a href="../index.php">Main</a><br>
<?php
include_once "../class.inc.php";
if (isset($_GET['eid']))
{
    $cbt = new CBT();
    $eventid = $cbt->clean($_GET['eid']);
    echo '<script type="text/javascript">
    var MAXNUM =',$cbt->totalQuestions($eventid),';
    </script>';

    for($i=1;$i<=$cbt->totalQuestions($eventid);$i++)
    {
        echo '<a href="#" onclick="qShow(',$i,')" class="ql-',$i,'">',$i,'</a><br>';
    }
    echo '<a href="#" onclick="qShow(',$i+1,')" class="ql-',$i+1,'">Finish</a><br>';
    echo '<br></div>'; // sidebar

    echo '<div id="center"><form method="POST">';
    $i=1;
    foreach($cbt->getQuestions(6) as $ques)
    {
        echo '<center><div id="',$i,'" class ="question" ><div id="wrap"><b>Q ',$i,') </b><br>';
        echo $ques['question'],'<br>';
        echo '<center><table>';
        echo '<tr><td><input type="radio" name="opt-',"{$ques['qid']}",'" value="1" /></td><td>',$ques['opt1'],'</td></tr>';
        echo '<tr><td><input type="radio" name="opt-',"{$ques['qid']}",'" value="2" /></td><td>',$ques['opt2'],'</td></tr>';
        echo '<tr><td><input type="radio" name="opt-',"{$ques['qid']}",'" value="3" /></td><td>',$ques['opt3'],'</td></tr>';
        echo '<tr><td><input type="radio" name="opt-',"{$ques['qid']}",'" value="4" /></td><td>',$ques['opt4'],'</td></tr>';
        echo '</table></center><input type="hidden" name="',$i,'" value="',$ques['qid'],'" />';
        echo '</div><a href="#" onclick="optionClear(\'',$i,'\')">Reset</a><br>';
        echo '<br>Mark For Review<br><a href="#" onclick="qMarkRed(',$i,')">Red</a>
        <a href="#" onclick="qMarkGreen(',$i,')">Green</a>
        <a href="#" onclick="qMarkBlue(',$i,')">Blue</a>
        <a href="#" onclick="qMarkClear(',$i,')">Clear</a>
        <br><br>
        <a href="#" onclick="qPrev()">Prev</a>
        <a href="#" onclick="qNext()">Next</a>
        </div></center>';
        $i+=1;
    }   
    echo '<center><div id="',$i+1,'" class ="question" ><b>if you are ready to submit your answers press Done<br>Your answers will be submitted and scores will be displayed instantly<br>Once the answers are submitted they CAN NOT be reverted back</b><br>
        <input type="submit" name="done" value="Done" /></form></div>
        <br><br>';

}
else
{
    echo '</div><center><b>Sorry Wrong Event</b></center>';
}
?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
