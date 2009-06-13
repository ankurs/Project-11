<?php

class Project11
{
	// common for all child classes
	private  $host=""; // Database Host
	private  $dbname=""; // Database Name
	private  $dbuser="";  // Database User
	private  $dbpass=""; // Database Password
	protected  $SALT = ""; // Salt to be added to password before taking sha1

	protected  $con = NULL; // connection object
	protected $logintime =1800; // time after which the user has to re login 

	// different for different child classes 
	protected $id = NULL; // for object id
	protected $table = NULL; // used by child classes for selecting table

	function __construct()
	{
		/* constructor just creates a connection to the database */
		$this->con = mysql_connect($this->host,$this->dbuser,$this->dbpass) or die("Error: Could not connect to database server!!!");
		mysql_select_db($this->dbname,$this->con);
	}

	protected function clean($value)
	{
		/* short for mysql_real_escape_string(), can do more here if needed */
		return mysql_real_escape_string($value);
	}

	public function getList()
	{
		/* returns array (nested) of all items of particular type from the database */
		$ret = array();
		$res = mysql_query("select * from {$this->table}",$this->con);
		while($row=mysql_fetch_array($res))
		{
			$ret[] = $row;
		}
		return $ret;
	}

	public function getId()
	{
		/* returns the id for the object */
		return $this->id;
	}

	public function setId($val)
	{
		/* sets the id for the object without any check 
			!!!USE CAREFULLY!!!
		*/
		$this->id = $this->clean($val);
	}

	public  function login($uname,$pass)
	{
		/* checking user for correct password returns
			array (<level>,<key>)  -  if password is correct
			array (error)                  -  if wrong password or user does not exist
		*/
		$uname = $this->clean($uname);
		$row=mysql_fetch_row(mysql_query("select password,level from heads where username='{$uname}'",$this->con));
		if ($row)
		{
			if ($row[0] == sha1($pass+$this->SALT))
			{
				$tval = time();
				$key = sha1($this->SALT+$tval);
				$res=mysql_query("update heads set passkey ='{$key}', reset='{$tval}' where username='{$uname}'",$this->con) or die (mysql_error());
				$ret = array();
				$ret[] = $row[1];
				$ret[] = $key;
				return $ret;
			}
		}
		return array("error");
	}
	public  function checkAuth($uname,$key)
	{
		/* checking user for correct passkey returns
			<level>  -  if passkey is correct
			error    -  if wrong passkey or user does not exist
		*/
		$uname = $this->clean($uname);
		$row=mysql_fetch_row(mysql_query("select passkey,reset,level from heads where username='{$uname}'",$this->con));
		if ($row)
		{
			if ($row[0] == $key)
			{
				$tval = time();
				if (($row[1] +$this->logintime) > $tval)
				{
					return $row[2];
				}
			}
		}
		return "error";
	}
}

class Head extends Project11
{
	private $level = NULL;
	function __construct($uname=NULL)
	{
		/* if head parameter is passed it will try to select the head */
		parent::__construct();
		$this->table="heads";
		if ($uname)
		{
			$this->select($uname);
		}
	}

	public function add($uname,$pass,$name,$phone,$level)
	{
		/* adds a head to the database and returns
			exists       - when username exists
			<errorcode>  - when an error
			done         - when user was added */
		$uname = strtolower($this->clean($uname)); //we convert the username to lowercase
		$name = ucwords($this->clean($name));// capitalise first letter of every word
		$pass = sha1($this->clean($pass) + $this->SALT); // taking sha1 with a salt for password
		$phone = $this->clean($phone);
		$level = strtolower($this->clean($level));
		$res = mysql_query("insert into {$this->table}(username,password,name,level,phone) values('{$uname}','{$pass}','{$name}','{$level}','{$phone}')",$this->con);
		$err = mysql_errno($this->con);
		if ($err == 1062)
		{
			return "exists";
		}
		else if ($err == 0)
		{
			return "done";
		}
		else
		{
			return $err;
		}
	}

	public function rem($uname)
	{
		/* Deletes a head from database */
		/* TODO - remove everything user related with user removal */
		$uname=strtolower($this->clean($uname));
		$res = mysql_query("delete from {$this->table} where username='{$uname}' limit 1",$this->con);
		if (mysql_affected_rows())
		{
			return "done";
		}
		else
		{
			return "error";
		}
	}	

	public function getLevel()
	{
		return $this->level;
	}

	public function select($uname)
	{
		/* checks if the username exists and sets the id accordingly,
			returns- True or False */
		$uname=$this->clean($uname);
		$row=mysql_fetch_row(mysql_query("select userid,level from {$this->table} where username='{$uname}'",$this->con));
		if ($row)
		{
			$this->id = $row[0];
			$this->level = $row[1];
			return True;
		}
		else
		{
			$this->id=NULL;
			$this->level=NULL;
			return False;
		}
	}	

	public function getinfo($hid)
	{
		/* returns array(<all info>) for the given headid */
		$hid=$this->clean($hid);
		$row=mysql_fetch_array(mysql_query("select * from {$this->table} where userid='{$hid}'",$this->con));
		if ($row)
		{
			return $row;
		}
		else
		{
			return False;
		}

	}

	public function changePass($old,$new)
	{
		/* allows the head to change the password, returns
			error  -  on error
			done   -  when done
		*/
		$old=sha1($this->clean($old) + $this->SALT);
		$new=sha1($this->clean($new) + $this->SALT);
		mysql_query("update heads set password='{$new}' where userid='{$this->id}' and password ='{$old}' limit 1",$this->con);
		if (mysql_affected_rows())
		{
			return "done";
		}
		else
		{
			return "error";
		}
	}

	public function resetPass($new)
	{
		/* resets the password for select head, retunrns
			done  -  when done
			error -  on error
		*/
	}
}

class Catagory extends Project11
{
	function __construct($catname=NULL)
	{
		/* if catagory parameter is passed it will try to select the catagory */
		parent::__construct();
		$this->table="catagory";
		if ($catname)
		{
			$this->select($catname);
		}

	}

	public function rem($catname)
	{
		/* Deletes a catagory from database */
		/* TODO - remove everything catagory related  with removal of catagory */
		$catname=strtolower($this->clean($catname));
		$res = mysql_query("delete from {$this->table} where name like '{$catname}' limit 1",$this->con);
		if (mysql_affected_rows())
		{
			return "done";
		}
		else
		{
			return "error";
		}
	}

	public function add($catname,$info)
	{
		/* adds a catagory to the database and returns
			exists       - when username exists
			<errorcode>  - when an error
			done         - when user was added */
		$catname = strtolower($this->clean($catname)); //we convert the catname to lowercase
		$info=$this->clean($info);
		$res = mysql_query("insert into {$this->table}(name,info) values('{$catname}','{$info}')",$this->con);
		$err = mysql_errno($this->con);
		if ($err == 1062)
		{
			return "exists";
		}
		else if ($err == 0)
		{
			return "done";
		}
		else
		{
			return $err;
		}
	}

	public function select($catname)
	{
		/* checks if the catagory exists and sets the id accordingly,
			returns- True ot False */
		$catname=$this->clean($catname);
		$row=mysql_fetch_row(mysql_query("select catid from {$this->table} where name='{$catname}'",$this->con));
		if ($row)
		{
			$this->id = $row[0];
			return True;
		}
		else
		{
			$this->id=NULL;
			return False;
		}
	}

	public function getInfo($catid)
	{
		/* returns array(name,info) for the given ($catid) catagory */
		$catid = $this->clean($catid);
		$row=mysql_fetch_array(mysql_query("select name,info from {$this->table} where catid ='{$catid}'",$this->con));
		if ($row)
		{
			return $row;
		}
		else
		{
			return NULL;
		}
	}

	public function addEvent($eid)
	{
		/* add the given event ($eid) to the selected catagory, returns
			event error  -  when event id not exists / not set
			cat error    -  when catagory not exists / not set
			done         -  when sucess
			error        -  on any other error
			assigned     -  when event is already assigned
		*/
		if ($eid)
		{
			if ($this->id)
			{
				$row = mysql_fetch_row(mysql_query("select * from cat_event where eventid = '{$eid}'",$this->con));
				if (!$row)
				{
					$res = mysql_query("insert into cat_event(eventid,catid) values('{$eid}','{$this->id}')",$this->con);
					if (mysql_affected_rows())
					{
						return "done";
					}
					else
					{
						return "error";
					}
				}
				else
				{
					return "assigned";
				}
			}
			else
			{
				return "cat error";
			}
		}
		else
		{
			return "event error";
		}
	}

	public function remEvent($eid)
	{
		/* removes the given event ($eid) from the selected catagory, returns
			event error  -  when event id not exists / not set
			cat error    -  when catagory not exists / not set
			done         -  when sucess
			error        -  on any other error
			not assigned -  when event is not assigned to this catagory
		*/
		if ($eid)
		{
			if ($this->id)
			{
				$row = mysql_fetch_row(mysql_query("select id from cat_event where eventid = '{$eid}' and catid='{$this->id}'",$this->con));
				if ($row)
				{
					$res = mysql_query("delete from cat_event where id = '{$row[0]}' limit 1",$this->con);
					if (mysql_affected_rows())
					{
						return "done";
					}
					else
					{
						return "error";
					}
				}
				else
				{
					return "not assigned";
				}
			}
			else
			{
				return "cat error";
			}
		}
		else
		{
			return "event error";
		}
	}

	public function getEvents()
	{
		/* returns array (nested) of all events of the selected catagory */
		$ret = array();
		$res = mysql_query("select * from events where eventid in (select eventid from cat_event where catid ='{$this->id}')",$this->con);
		while($row=mysql_fetch_array($res))
		{
			$ret[] = $row;
		}
		return $ret;
	}

	public function addHead($hid)
	{
		/* add the given head ($hid) to the selected catagory, returns
			head error  -  when head id not exists / not set
			cat error    -  when catagory not exists / not set
			done         -  when sucess
			error        -  on any other error
			assigned     -  when event is already assigned
		*/
		if ($hid)
		{
			if ($this->id)
			{
				$row = mysql_fetch_row(mysql_query("select * from cat_head where userid = '{$hid}'",$this->con));
				if (!$row)
				{
					$res = mysql_query("insert into cat_head(userid,catid) values('{$hid}','{$this->id}')",$this->con);
					if (mysql_affected_rows())
					{
						return "done";
					}
					else
					{
						return "error";
					}
				}
				else
				{
					return "assigned";
				}
			}
			else
			{
				return "cat error";
			}
		}
		else
		{
			return "head error";
		}
	}

	public function remHead($hid)
	{
		/* removes the given head ($hid) from the selected catagory, returns
			head error  -  when head id not exists / not set
			cat error    -  when catagory not exists / not set
			done         -  when sucess
			error        -  on any other error
			not assigned -  when event is not assigned to this catagory
		*/
		if ($hid)
		{
			if ($this->id)
			{
				$row = mysql_fetch_row(mysql_query("select id from cat_head where userid = '{$hid}' and catid='{$this->id}'",$this->con));
				if ($row)
				{
					$res = mysql_query("delete from cat_head where id = '{$row[0]}' limit 1",$this->con);
					if (mysql_affected_rows())
					{
						return "done";
					}
					else
					{
						return "error";
					}
				}
				else
				{
					return "not assigned";
				}
			}
			else
			{
				return "cat error";
			}
		}
		else
		{
			return "head error";
		}
	}

	public function getHeads()
	{
		/* returns array (nested) of all heads of the selected catagory */
		$ret = array();
		$res = mysql_query("select * from heads where userid in (select userid from cat_head where catid ='{$this->id}')",$this->con);
		while($row=mysql_fetch_array($res))
		{
			$ret[] = $row;
		}
		return $ret;
	}
	public function hasPermission($username)
	{
		/* checks if the user ($username) has access to the catagory, returns
			True - if user has access
			False - if no access
			TODO - find a better way to do this..
			CHECK - is it working for all condictions??
		*/
		$query="select username from heads where userid in (select userid from event_head where eventid in (select eventid from cat_event where catid='{$this->id}')) or userid in (select userid from event_org where eventid in (select eventid from cat_event where catid='{$this->id}')) or userid in (select userid from event_vol where eventid in (select eventid from cat_event where catid='{$this->id}'))"; // thats one big query
		$res = mysql_query($query,$this->con) or die (mysql_error());// checking for ehead, org or vol
		while($result=mysql_fetch_row($res))
		{
			if ($result[0] == $username)
				return True;
		}
		//checking for chead
		$res=mysql_query("select username from heads where userid in (select userid from cat_head where catid='{$this->id}')",$this->con);
		while ($result=mysql_fetch_row($res))
		{
			if ($result[0] == $username)
				return True;
		}
		return False;

	}
}

class Event extends Project11
{
	function __construct($event=NULL)
	{
		/* if event parameter is passed it will try to select the event */
		parent::__construct();
		$this->table="events";
		if ($event)
		{
			$this->select($event);
		}

	}

	public function rem($event)
	{
		/* Deletes a event from database */
		/* TODO - remove everything event related with removal of event */
		$event=strtolower($this->clean($event));
		$res = mysql_query("delete from {$this->table} where name = '{$event}' limit 1",$this->con);
		if (mysql_affected_rows())
		{
			return "done";
		}
		else
		{
			return "error";
		}
	}

	public function add($name,$team,$info)
	{
		/* adds a event to the database and returns
			exists       - when username exists
			<errorcode>  - when an error
			done         - when user was added */
		$name = strtolower($this->clean($name)); //we convert the username to lowercase
		$team = $this->clean($team);
		$info = $this->clean($info);
		$res = mysql_query("insert into {$this->table}(name,team,info) values('{$name}','{$team}','{$info}')",$this->con);
		$err = mysql_errno($this->con);
		if ($err == 1062)
		{
			return "exists";
		}
		else if ($err == 0)
		{
			return "done";
		}
		else
		{
			return $err;
		}
	}

	public function select($event)
	{
		/* checks if the event exists and sets the id accordingly,
			returns- True ot False */
		$row=mysql_fetch_row(mysql_query("select eventid from {$this->table} where name='{$this->clean($event)}'",$this->con));
		if ($row)
		{
			$this->id = $row[0];
			return True;
		}
		else
		{
			$this->id=NULL;
			return False;
		}
	}

	public function addHead($hid,$type="head")
	{
		/* add the given head ($hid) to the selected event, 
			depending on the values of $type (head,org,vol) event head, organiser or volunter is assigned
			returns
			event error  -  when event id not exists / not set
			head error   -  when head not exists / not set
			done         -  when sucess
			error        -  on any other error
			assigned     -  when event is already assigned
		*/
		if ($hid)
		{
			$type=$this->clean($type);
			if ($type=="head" or $type=="org" or $type=="vol")
			{
				if ($this->id)
				{
					$row = mysql_fetch_row(mysql_query("select * from event_{$type} where userid = '{$hid}'",$this->con));
					if (!$row)
					{
						$res = mysql_query("insert into event_{$type}(userid,eventid) values('{$hid}','{$this->id}')",$this->con);
						if (mysql_affected_rows())
						{
							return "done";
						}
						else
						{
							return "error";
						}
					}
					else
					{
						return "assigned";
					}
				}
				else
				{
					return "event error";
				}
			}
			else
			{
				return NULL;
			}
		}
		else
		{
			return "head error";
		}
	}

	public function remHead($hid)
	{
		/* removes the given head ($hid) from the selected event, 
			depending on the values of $type (head,org,vol) event head, organiser or volunter is removed
			returns
			event error  -  when event id not exists / not set
			head error   -  head catagory not exists / not set
			done         -  when sucess
			error        -  on any other error
			not assigned -  when event is not assigned to this catagory
		*/
		if ($hid)
		{
			$type=$this->clean($type);
			if ($type=="head" or $type=="org" or $type=="vol")
			{
				if ($this->id)
				{
					$row = mysql_fetch_row(mysql_query("select id from event_{$type} where userid = '{$hid}' and eventid='{$this->id}'",$this->con));
					if ($row)
					{
						$res = mysql_query("delete from event_{$type} where id = '{$row[0]}' limit 1",$this->con);
						if (mysql_affected_rows())
						{
							return "done";
						}
						else
						{
							return "error";
						}
					}
					else
					{
						return "not assigned";
					}
				}
				else
				{
					return "event error";
				}
			}
			else
			{
				return NULL;
			}
		}
		else
		{
			return "head error";
		}
	}

	public function getHeads($type="head")
	{
		/* returns array (nested) of all heads of the selected event
		   depending on the values of $type (head,org,vol) event head, organiser or volunter is selected
		*/
		$ret = array();
		$type=$this->clean($type);
		if ($type=="head" or $type=="org" or $type=="vol")
		{
			$res = mysql_query("select * from heads where userid in (select userid from event_{$type} where eventid ='{$this->id}')",$this->con);
			while($row=mysql_fetch_array($res))
			{
				$ret[] = $row;
			}
			return $ret;
		}
		else
		{
			return NULL;
		}
	}

	public function addUser($delno)
	{
		/* adds the given delegate number to the particular event, returns
			done	- on sucess
			error	- on error
			NULL	- when value not set
		*/
		if ($delno and $this->id)
		{
			$delno=$this->clean($delno);
			mysql_query("insert into reg_info(delno,eventid) values ('{$delno}','{$this->id}')",$this->con);
			if (mysql_affected_rows())
			{
				return "done";
			}
			else
			{
				return "error";
			}
		}
		else
		{
			return NULL;
		}
	}

}

class Registeration extends Project11
{
	function __construct()
	{
		parent::__construct(); // is there a need to initialize something else - CHECK
	}

	public function getInfo($regno)
	{
		/* takes registration number as input and gives the information about the person, returns
			array (<user info>)  - when user exists
			NULL                 - when regno not found
		*/
		$regno = $this->clean($regno);
		$res = mysql_query("select * from student where reg = '{$regno}'",$this->con);
		$row = mysql_fetch_array($res);
		if ($row)
		{
			return $row;
		}
		return NULL;
	}

	public function reg ($regno,$phone)
	{
		/* registers the person into the main table, returns
			array(<del no>)   -  when sucessful
			array(reg,<del no>) -  when person already registered
			array(error)      -  on error
		   only for people in the database
		   TODO - can it be done in some better way?
		*/
		$regno = $this->clean($regno);
		$phone = $this->clean($phone);
		$cllg = "MIT MANIPAL"; // change if you are not in mit,manipal - CHECK
		$res = mysql_query("select reg,name,sem from student where reg='{$regno}' and reg not in (select regno from reg_user)",$this->con) or die(mysql_error());
		$row=mysql_fetch_row($res);
		if ($row)
		{
			$row[1]=ucwords(strtolower($row[1]));//making first letter of each word capital, to make names proper
			mysql_query("insert into reg_user(regno,name,sem,cllg,phone) values ('{$row[0]}','{$row[1]}','{$row[2]}','{$cllg}','{$phone}')",$this->con);
			$res = mysql_query("select delno from reg_user where regno='{$row[0]}' and name='{$row[1]}' and  sem ='{$row[2]}' and cllg='{$cllg}' and phone = '{$phone}'",$this->con);
			$row=mysql_fetch_row($res);
			if ($row)
			{
				return array($row[0]);
			}
			else
			{
				return array("error");
			}
		}
		else
		{
			$res = mysql_query("select delno from reg_user where regno = '{$regno}'",$this->con);
			$row=mysql_fetch_row($res);
			$ret = array("reg");
			$ret[] = $row[0];
			return $ret;
		}
	}

	public function regOut($name,$sem,$cllg,$phone,$regno=NULL)
	{	
		/* registers the person into the main table, returns
			array(<del no>)   -  when sucessful
			array(reg,<del no>) -  when person already registered
			array(error)      -  on error
		   only for people not in database -> outstation
		   in student of this cllg then set $regno to their reg no
		   TODO - can it be done in some better way?
		*/
		$name=ucwords(strtolower($this->clean($name)));
		$sem=$this->clean($sem);
		$cllg=$this->clean($cllg);
		$phone=$this->clean($phone);
		if ($regno !=NULL) // handel the non existant reg number in database case
		{
			$regno = $this->clean($regno);
			$res = mysql_query("select delno from reg_user where regno = '{$regno}'",$this->con);
			$row=mysql_fetch_row($res);
			if ($row)
			{
				$ret= array("reg");
				$ret[] = $reg[0];// if it exists return the delno
				return $ret;
			}
		}
		else
		{
			$regno = "OUT"; // set person as OUT STATION
		}
		mysql_query("insert into reg_user(regno,name,sem,cllg,phone) values ('{$regno}','{$name}','{$sem}','{$cllg}','{$phone}')",$this->con);
		$res = mysql_query("select delno from reg_user where regno='{$regno}' and name='{$name}' and  sem ='{$sem}' and cllg='{$cllg}' and phone = '{$phone}'",$this->con);
		$row=mysql_fetch_row($res);
		if ($row)
		{
			return array($row[0]);
		}
		else
		{
			return array("error");
		}
	}
}

?>