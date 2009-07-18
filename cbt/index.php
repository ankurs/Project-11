<html>
<head>
<title><?php include_once "../config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='../js/jq.js' type='text/javascript'></script>
<script src='function.js' type='text/javascript' ></script>
</head>
<body>
<?php include "../header.php"; ?>
<?php include "sidebar.php"; ?>
<div id="center">
<?php
if (isset($_POST['login']) and isset($_POST['delno']) and isset($_POST['event']))
{
    $r = new Registeration();
    $delInfo = $r->getDelInfo($_POST['delno']);
    if ($delInfo)
    {
        echo "<form method='POST'><center><table>";
        echo "<tr><td>Del no</td><td> {$delInfo['delno']}</td></tr><tr><td>Reg No.</td><td>{$delInfo['regno']}</td></tr><tr><td>Name</td><td> {$delInfo['name']}</td></tr><tr><td>College</td><td> {$delInfo['cllg']}</td></tr><tr><td>Phone</td><td> {$delInfo['phone']}</td></tr></table><input type='hidden' name='delno' value='{$delInfo['delno']}' /><input type='hidden' name='event' value='{$_POST['event']}' />";
        echo '<br>Please check the above information<br>if it is not you press cancel and login with correct credentials<br>Enter the event password<br><input type="text" name="eventpass" /><br><input type="submit" name="confirm" value="Confirm"/><input type="submit" name="cancel" value="Cancel" />';
        echo '</center></form>';
    }
    else
    {
        echo 'Sorry Wrong Deligate Number<br><a href="">Back</a>';
    }
}
else
{
    echo '<h3>Welcome to Computer Based Test</h3>Select the Event to continue<br>';
    $cbt = new CBT();
    $events = $cbt->getEvents();
    if ($events)
    {
        echo '<br><form method ="POST">';
        foreach($events as $event)
        {
            echo '<input type="radio" name="event" value="',$event['eventid'],'" />',$event['name'],'<br>';
        }
        echo '<br>Deligate Number<br><input type="text" name="delno" /><br>Deligate Password<br><input type="password" name="delpass" /><br><br><input type="submit" name="login" value="Login" /></form>';
    }
}
?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
