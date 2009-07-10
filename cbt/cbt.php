<html>
<head>
<title>TechTatva 09</title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='../js/jq.js' type='text/javascript'></script>
<script src='function.js' type='text/javascript' ></script>
</head>
<body>
<?php include "../header.php"; ?>

<div id="sidebar"><center>
</center><a href="../index.php">Main</a><br>
<?php
for($i=1;$i<=20;$i++)
{
    echo '<a href="#" onclick="qShow(',$i,')" class="ql-',$i,'">',$i,'</a><br>';
}

?>
<br></div>


<div id="center">
<?php
for($i=1;$i<=20;$i++)
{
    echo '<div id="',$i,'" class ="question" >
    hello world this is jsdhfjsdh fjsdh fkdshf kjsdf<br> adhfkjadhfkdhkd<br>ajdhfajdh fdkjahfkjdhfksdhfks<br><h2>',$i,'</h2>
    <a href="#" onclick="qMarkRed(',$i,')">Red</a>
    <a href="#" onclick="qMarkGreen(',$i,')">Green</a>
    <a href="#" onclick="qMarkBlue(',$i,')">Blue</a>
    <a href="#" onclick="qMarkClear(',$i,')">Clear</a>
    <br><br>
    <a href="#" onclick="qPrev()">Prev</a>
    <a href="#" onclick="qNext()">Next</a>
    </div>';
}

?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
