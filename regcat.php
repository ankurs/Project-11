<html>
<head>
<title><?php include "config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='js/jq.js' type='text/javascript'></script>
<script src='js/function.js' type='text/javascript' ></script>
</head>
<body>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<div id="center">
<?php

$goBack = "<a href='reg.php'>Back</a>";
$r = new Registeration();
if (True)//TODO check everything here
{
    $level = $r->checkAuth($_COOKIE['user'],$_COOKIE['key']);
    if ($level != "error")
    {    $c = new Catagory();
        if (isset($_GET['id']))
            $c->setId($_GET['id']);
        if (($c->hasPermission($_COOKIE['user'])) or ($level=="admin"))
        {
            if (!isset($_POST['reg']))
            {
                echo "<form method='POST'>Enter the Deligate Number<br><input type='text' name='delno' /><br><input type='submit' name='reg' value='Register' /></form>";
            }
            else
            {
                $r= new Registeration();
                $c = new Catagory();
                $delInfo = $r->getDelInfo($_POST['delno']);
                if ($delInfo)
                {
                    echo "<form method='POST' name='eventreg'><center><table>";
                    echo "<tr><td>Del no</td><td> {$delInfo['delno']}</td></tr><tr><td>Name</td><td> {$delInfo['name']}</td></tr><tr><td>College</td><td> {$delInfo['cllg']}</td></tr><tr><td>Phone</td><td> {$delInfo['phone']}</td></tr><tr><td>Select Event</td></tr><tr><td>";
                    $c->setId($_GET['id']);
                    $count =0;
                    foreach ($c->getEvents() as $event) 
                    {
                        echo "<input type='radio' name='event' value='{$event['eventid']}' \> </td><td>{$event['name']}</td></tr><tr><td>";
                    }
                        echo "</td></tr></table><input type='submit' name='eventreg' value='Register' /><input type='submit' value='Cancel' /></form></center>";
                }
                else
                {
                    echo "Sorry Wrong Delegate Number";
                }
            }
        }    
        else
        {
            echo "You do not have Privlage to access this resource<br>".$goBack;
        }
    }
    else
    {
        echo "You do not have Privlage to access this resource<br>".$goBack;
    }

}

?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
