<html>
<head>
<title><?php include_once "config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='js/jq.js' type='text/javascript'></script>
<script src='js/function.js' type='text/javascript' ></script>
</head>
<body>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<div id="center">
<?php
if ($level != 'error')
{
    if(isset($_GET['cid']) or isset($_GET['mainreg']) or isset($_GET['eid']))
    {
        if (isset($_GET['cid']))
        {
            $c = new Catagory();
            $c->setId($_GET['cid']);
            $events = $c->getEvents(); 
            if ($events)
            {
                foreach ( $events as $event)
                {
             	    echo '<a href="details.php?eid=',$event['eventid'],'">',ucwords($event['name']),'</a><br>';          
                }
            }
            else
            {
                echo 'Sorry no Events assigned';
            }
        }
        else if (isset($_GET['mainreg']))
        {
            if (isset($_GET['order']))
            {
                $order = $_GET['order'];
            }
            else
            {
                $order = NULL;
            }
            $v = new View();
            $regInfo = $v->getRegInfo($order);
            echo '<h3>Main Registeration Details</h3>';
            echo '<center><table>';
            echo "<tr><td>Sr No.</td><td><a href='details.php?mainreg=1&order=delno'>Del No.</a></td><td><a href='details.php?mainreg=1&order=regno'>Reg No.</a></td><td><a href='details.php?mainreg=1&order=name'>Name</a></td><td><a href='details.php?mainreg=1&order=sem'>Sem</a></td><td><a href='details.php?mainreg=1&order=college'>College</a></td><td><a href='details.php?mainreg=1&order=phone'>Phone</a></td></tr>";
            $num =1;
            foreach ($regInfo as $reg)
            {
                if ($num%2 ==1)
                {
                    $class ='odd';
                }
                else
                {
                    $class = 'even';
                }
                echo "<tr id ='{$class}' ><td> {$num} </td><td> {$reg['delno']} </td><td> {$reg['regno']} </td><td> {$reg['name']} </td><td> {$reg['sem']} </td><td> {$reg['cllg']} </td><td> {$reg['phone']} </td></tr>";
                $num+=1;
            }
            echo '</table></center><br><br><br><br>';
        }
        else if(isset($_GET['eid']))
        {
            if (isset($_GET['order']))
            {
                $order = $_GET['order'];
            }
            else
            {
                $order = NULL;
            }
            $v = new View();
            $regInfo = $v->eventRegInfo($_GET['eid'],$order);
            $e = new Event();
            $eventInfo = $e->getInfo($_GET['eid']);
            if ($eventInfo)
            {
                if (!$e->isTeamEvent($_GET['eid']))
                {
                    echo '<h3>',ucwords($eventInfo['name']),' Registeration Details</h3>';
                    echo '<center><table>';
                    echo "<tr><td>Sr No.</td><td><a href='details.php?eid={$_GET['eid']}&order=delno'>Del No.</a></td><td><a href='details.php?eid={$_GET['eid']}&order=regno'>Reg No.</a></td><td><a href='details.php?eid={$_GET['eid']}&order=name'>Name</a></td><td><a href='details.php?eid={$_GET['eid']}&order=sem'>Sem</a></td><td><a href='details.php?eid={$_GET['eid']}&order=college'>College</a></td><td><a href='details.php?eid={$_GET['eid']}&order=phone'>Phone</a></td></tr>";
                    $num =1;
                    foreach ($regInfo as $reg)
                    {
                        if ($num%2 ==1)
                        {
                            $class ='odd';
                        }
                        else
                        {
                            $class = 'even';
                        }
                        echo "<tr id ='{$class}'><td> {$num} </td><td> {$reg['delno']} </td><td> {$reg['regno']} </td><td> {$reg['name']} </td><td> {$reg['sem']} </td><td> {$reg['cllg']} </td><td> {$reg['phone']} </td></tr>";
                        $num+=1;
                    }
                    echo '</table></center><br><br><br><br>';
                }
                else
                {
                    $t = new Team();
                    $teams = $t->assignedToEvent($_GET['eid']);
                    if ($teams)
                    {
                        echo '<h3>',ucwords($eventInfo['name']),' Registeration Details</h3>';
                        echo '<center><table>';
                        echo "<tr><td>Sr No.</td><td>Team No.</td><td>Del No.</td><td>Reg No.</td><td>Name</td><td>Sem</td><td>College</td><td>Phone</td></tr>";
                        $num =1;
                        foreach ($teams as $team)
                        {
                            if ($num%2 ==1)
                            {
                                $class ='odd';
                            }
                            else
                            {
                                $class = 'even';
                            }                         
                            foreach ($t->getMembers($team) as $reg)
                            {
                                echo "<tr id ='{$class}' ><td> {$num} </td><td> {$team} </td><td> {$reg['delno']} </td><td> {$reg['regno']} </td><td> {$reg['name']} </td><td> {$reg['sem']} </td><td> {$reg['cllg']} </td><td> {$reg['phone']} </td></tr>";
                            }
                            $num+=1;
                        }
                        echo '</table></center><br><br><br><br>';
                    }
                }
            }
            else
            {
                echo 'Sorry wrong event';
            }
        }
    }
    else
    {
        $c = new Catagory();
        echo '<h3>Registeration Details</h3>';
        echo '<a href="details.php?mainreg=1">Main Regiestration</a><br>';
        foreach ($c->getList() as $cat)
        {
        	echo '<a href="details.php?cid=',$cat['catid'],'">',ucwords($cat['name']),'</a><br>';
        }
    }
}
else
{
    echo 'Sorry you need to be logged in to access this information';
}
?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
