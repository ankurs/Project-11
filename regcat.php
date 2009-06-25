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

$goBack = "<a href='regcat.php?id={$_GET['id']}'>Back</a>";
$r = new Registeration();
if (True)//TODO check everything here
{
    //$level = $r->checkAuth($_COOKIE['user'],$_COOKIE['key']) ; --CKECK
    if ($level != "error")
    {    $c = new Catagory();
        if (isset($_GET['id']))
            $c->setId($_GET['id']);
            if (isset($_COOKIE['user'])) // for undefined $_COOKIE['user'] warnings
            {
                $cookieUser = $_COOKIE['user'];
            }
            else
            {
                $cookieUser='';
            }
        if (($c->hasPermission($cookieUser)) or ($level=="admin"))
        {
            if (isset($_POST['reg']))
            {
                $r= new Registeration();
                $c = new Catagory();
                $delInfo = $r->getDelInfo($_POST['delno']);
                if ($delInfo)
                {
                    echo "<form method='POST'><center><table>";
                    echo "<tr><td>Del no</td><td> {$delInfo['delno']}</td></tr><tr><td>Name</td><td> {$delInfo['name']}</td></tr><tr><td>College</td><td> {$delInfo['cllg']}</td></tr><tr><td>Phone</td><td> {$delInfo['phone']}</td></tr><tr><td>Select Event</td></tr><tr><td><input type='hidden' name='delno' value='{$delInfo['delno']}' />";
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
                    echo "Sorry Wrong Delegate Number<br>".$goBack;
                }
            }
            else if (isset($_POST['eventreg']))
            {
                $e= new Event();
                if (isset($_POST['event']) and isset($_POST['delno']))
                {
                    $e->setId($_POST['event']);
                    $result = $e->addUser($_POST['delno']);
                    if ($result)
                    {
                        if ($result == "regDone")
                        {
                            echo "Already Registered<br>".$goBack;
                        }
                        else
                        {
                            echo "Done<br>".$goBack;
                        }
                    }
                }
                else
                {
                    echo "Wrong Event Please Check your entries<br>".$goBack;
                }
            }
            else
            {

                $catInfo = $c->getInfo($_GET['id']);
                echo "Welcome to <b>{$catInfo['name']}</b> Registeration<br><br>";
                echo "<form method='POST'>Enter the Deligate Number<br><input type='text' name='delno' /><br><input type='submit' name='reg' value='Register' /></form>";
            }
        }    
        else
        {
            echo "You do not have Privlage to access this resource<br>";
        }
    }
    else
    {
        echo "You do not have Privlage to access this resource<br>";
    }

}

?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
