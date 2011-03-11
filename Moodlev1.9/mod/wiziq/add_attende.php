<body>

<?php

require_once("../../config.php");
    	require_once("lib.php");
      	require_once($CFG->dirroot.'/course/lib.php');
    	require_once($CFG->dirroot.'/calendar/lib.php');
		require_once("wiziqconf.php");
		$content = file_get_contents($ConfigFile);
	if ($content !== false) {
	   // do something with the content
	   //echo "file is read",$content;
	} else {
	   // an error happened
	   echo "XML file is not read";
	   exit;
	}


	//exit;
	try
	{
	  $objDOM = new DOMDocument();
	  $objDOM->loadXML($content); 
	  
	}
	catch(Exception $e)
	{
			
		echo $e->getMessage();
	}
	$UserName=$objDOM->getElementsByTagName("UserName");
	$Password=$objDOM->getElementsByTagName("Password");
	$MaxDurationPerSession = $objDOM->getElementsByTagName("MaxDurationPerSession");
	$MaxUsersPerSession = $objDOM->getElementsByTagName("MaxUsersPerSession");
	$PresenterEntryBeforeTime = $objDOM->getElementsByTagName("PresenterEntryBeforeTime");
	$PrivateChat = $objDOM->getElementsByTagName("PrivateChat");
	$RecordingCreditLimit = $objDOM->getElementsByTagName("RecordingCreditLimit");
	$ConcurrentSessions = $objDOM->getElementsByTagName("ConcurrentSessions");	
	$RecordingCreditPending=$objDOM->getElementsByTagName("RecordingCreditPending");
	$subscription_url=$objDOM->getElementsByTagName("subscription_url");
    $buynow_url=$objDOM->getElementsByTagName("buynow_url");
    $Package_info_message=$objDOM->getElementsByTagName("Package_info_message");
    $pricing_url=$objDOM->getElementsByTagName("pricing_url");
	
	$username=$UserName->item(0)->nodeValue;
	$password=$Password->item(0)->nodeValue;
	$maxdur=$MaxDurationPerSession->item(0)->nodeValue;
	$maxuser=$MaxUsersPerSession->item(0)->nodeValue;
	$prsenterentry=$PresenterEntryBeforeTime->item(0)->nodeValue;
	$privatechat=$PrivateChat->item(0)->nodeValue;
	$recordingcredit=$RecordingCreditLimit->item(0)->nodeValue;
	$concurrsession=$ConcurrentSessions->item(0)->nodeValue;
	$creditpending=$RecordingCreditPending->item(0)->nodeValue;
	$subscription_url=$subscription_url->item(0)->nodeValue;
    $buynow_url=$buynow_url->item(0)->nodeValue;
    $Package_info_message=$Package_info_message->item(0)->nodeValue;
    $pricing_url=$pricing_url->item(0)->nodeValue;
$SessionCode=$_REQUEST['SessionCode'];
/*$qry=mysql_query("select * from ".$CFG->prefix."wiziq where insescod=$SessionCode");
$rs1 = mysql_fetch_array($qry);
$eventname=$rs1['name'];	
$wdur=$rs1['wdur'];
$dbtimezone=$rs1['timezone'];
$wtype=$rs1['wtype'];
$recordingtype=$rs1['statusrecording'];	
$times=$rs1['wdate'];
$tmzone=$USER->timezone;
if(!is_numeric($tmzone))
{
	$tmzone=get_user_timezone_offset($tmzone);
}

switch($tmzone)
{
	
case("-13.0"):
{
$timezone="GMT-13:00";
break;
}

case("-12.5"):
{
$timezone="GMT-12:30";
break;
}
case("-12.0"):
{
$timezone="GMT-12:00";
break;
}

case("-11.5"):
{
$timezone="GMT-11:30";
break;
}

case("-11.0"):
{
$timezone="GMT-11:00";
break;
}
case("-10.5"):
{
$timezone="GMT-10:30";

break;
}
case("-10.0"):
{
$timezone="GMT-10:00";
break;
}

case("-9.5"):
{
$timezone="GMT-09:30";
break;
}

case("-9.0"):
{
$timezone="GMT-09:00";
break;
}

case("-8.5"):
{
$timezone="GMT-08:30";
break;
}

case("-8.0"):
{
$timezone="GMT-08:00";
break;
}
case("-7.5"):
{
$timezone="GMT-07:30";
break;
}

case("-7.0"):
{
$timezone="GMT-07:00";
break;
}

case("-6.5"):
{
$timezone="GMT-06:30";
break;
}
case("-6.0"):
{
$timezone="GMT-06:00";
break;
}
case("-5.5"):
{
$timezone="GMT-05:30";
break;
}
case("-5.0"):
{
$timezone="GMT-05:00";
break;
}
case("-4.5"):
{
$timezone="GMT-04:30";
break;
}
case("-4.0"):
{
$timezone="GMT-04:00";
break;
}
case("-3.5"):
{
$timezone="GMT-03:30";
break;
}
case("-3.0"):
{
$timezone="GMT-03:00";
break;
}
case("-2.5"):
{
$timezone="GMT-02:30";
break;
}
case("-2.0"):
{
$timezone="GMT-02:00";
break;
}
case("-1.5"):
{
$timezone="GMT-01:30";
break;
}
case("-1.0"):
{
$timezone="GMT-01:00";
break;
}
case("-0.5"):
{
$timezone="GMT-00:30";
break;
}
case("0.0"):
{
$timezone="GMT";
break;
}
case("0.5"):
{
$timezone="GMT+00:30";
break;
}
case("1.0"):
{
$timezone="GMT+01:00";
break;
}
case("1.5"):
{
$timezone="GMT+01:30";
break;
}
case("2.0"):
{
$timezone="GMT+02:00";
break;
}
case("2.5"):
{
$timezone="GMT+02:30";

break;
}
case("3.0"):
{
$timezone="GMT+03:00";
break;
}
case("3.5"):
{
$timezone="GMT+03:30";
break;
}
case("4.0"):
{
$timezone="GMT+04:00";
break;
}
case("4.5"):
{
$timezone="GMT+04:30";
break;
}
case("5.0"):
{
$timezone="GMT+05:00";
break;
}
case("5.5"):
{
$timezone="GMT+05:30";
break;
}
case("6.0"):
{
$timezone="GMT+06:00";
break;
}
case("6.5"):
{
$timezone="GMT+06:30";
break;
}
case("7.0"):
{
$timezone="GMT+07:00";
break;
}
case("7.5"):
{
$timezone="GMT+07:30";

break;
}
case("8.0"):
{
$timezone="GMT+08:00";

break;
}
case("8.5"):
{
$timezone="GMT+08:30";

break;
}
case("9.0"):
{
$timezone="GMT+09:00";

break;
}
case("9.5"):
{
$timezone="GMT+09:30";

break;
}
case("10.0"):
{
$timezone="GMT+10:00";

break;
}
case("10.5"):
{
$timezone="GMT+10:30";

break;
}
case("11.0"):
{
$timezone="GMT+11:00";

break;
}
case("11.5"):
{
$timezone="GMT+11:30";

break;
}
case("12.0"):
{
$timezone="GMT+12:00";

break;
}
case("12.5"):
{
$timezone="GMT+12:30";

break;
}
case("13.0"):
{
$timezone="GMT+13:00";

break;
}
default:
  {
$timezone="GMT+05:30";

  }
}

if($dbtimezone!==$timezone)
{
if($recordingtype==1)
	{
		$type="Yes";
	}
	if($recordingtype==0)
	{
		$type="No";
	}
	$udate=usergetdate($times);
	 $wtime=calendar_time_representation($times);
	 $substring=substr($wtime,0,2);
	if($substring<10)
	{
	 $string=substr($substring,1);	
	 $reststring=substr($wtime,2);
	 $wtime=$string.$reststring;
	}
	
 $m=$udate['mon'];
 $y=$udate['year'];
 $d=$udate['mday'];
$wdate=$m."/".$d."/".$y;
	//$time=$hh.":".$mm." ".$ampm; 
	
$xyz=$wdate." ".$wtime;
 $datetime=strtoupper($xyz);

function do_post_request($url, $data, $optional_headers = null)
  {
	  
$params = array('http' => array(
                  'method' => 'POST',
                  'content' => $data
               ));
     if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
     }
     $ctx = stream_context_create($params);
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
     }
     $response = @stream_get_contents($fp);
     if ($response === false) {
        throw new Exception("Problem reading data from $url, $php_errormsg");
     }
	 //print_r($response);
     return $response;
  }	
  
  
 
$person = array(
				
		'CustomerKey'=>$customer_key,
		'SessionCode'=>$SessionCode,
		'EventName' => $eventname,
	 	'DateTime' => $datetime,
	    'TimeZone' => $timezone,		
	    'Duration' => $wdur,
		'RecodingReplay'=>$type,
		'audio' => $wtype
		
	);

$result=do_post_request($WebServiceUrl.'moodle/class/modify',http_build_query($person, '', '&'));
try
	  {
	    $objDOM = new DOMDocument();
	    $objDOM->loadXML($result); 
	  }
	catch(Exception $e)
	  {
		echo $e->getMessage();
	  }
 	
	 $Status=$objDOM->getElementsByTagName("Status");
	 $Status=$Status->item(0)->nodeValue;
	 $message=$objDOM->getElementsByTagName("message");
	 $message=$message->item(0)->nodeValue;
	 if($Status=="True")
		{	
		$wdate=make_timestamp($y, $m, $udate['mday'], $udate['hours'], $udate['minutes']);
			$query="update ".$CFG->prefix."wiziq set wtime='".$wtime."',wdate='".$wdate."',timezone='".$timezone."' where insescod=".$SessionCode;
echo $query;
$result=mysql_query($query) or die("sql query for updation failed");
		}
		
	else
{
?>

<br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="5"><strong><img src="icon.gif" hspace="10" height="16" width="16" border="0" alt="" />Error In Updating WiZiQ Live Class</strong></font></p>
    <?php
	echo '<strong>Message:</strong> cannot update!!! ' ;//.$e->getMessage();
	print_header("WizIQ class", "");
    
	print_simple_box_start('center', '100%');

    
    echo '<strong><center><font color="red">'.$message.'</font></center></strong><br><br>';
echo'<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a>';
    print_simple_box_end();
    print_footer($course);   
	exit;
}	
 
}*/
 $qry=mysql_query("select * from ".$CFG->prefix."wiziq_attendee_info where userid=".$USER->id." and insescod=".$SessionCode) or die("query fail");

$rs=mysql_fetch_array($qry);

 $presenterURL=$rs['attendeeurl'];
$screenName=$rs['username'];
if($rs==null || $rs=="")
{
	
	$screenName = $USER->username;
	$person=array(
				  //'userCredentials'=>array(
										   //'AppUserName'=>$username,
										  // 'AppPassword'=>$password
										  // ),
				  'CustomerKey'=>$customer_key,
				  'AttendeeListXML'=>'<AddAttendeeToSession><SessionCode>'.$SessionCode.'</SessionCode><Attendee> <ID>'.$USER->id.'</ID><ScreenName>'.$screenName.'</ScreenName></Attendee></AddAttendeeToSession>'
				  );
	/*try
  {
	$client = new SoapClient($agserver);
	$info = $client->AddAttendeeToSession($person);
  }
catch(Exception $e)
  {
    echo '<strong>Message:</strong> ' .$e->getMessage();
  }
$attendeURL=$info->AddAttendeeToSessionResult;
echo "result is".$attendeURL;*/
function do_post_request($url, $data, $optional_headers = null)
  {
	  
$params = array('http' => array(
                  'method' => 'POST',
                  'content' => $data
               ));
     if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
     }
     $ctx = stream_context_create($params);
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
     }
     $response = @stream_get_contents($fp);
     if ($response === false) {
        throw new Exception("Problem reading data from $url, $php_errormsg");
     }
	 //print_r($response);
     return $response;
  }
 $attendeURL=do_post_request($WebServiceUrl.'moodle/class/addattendees',http_build_query($person, '', '&'));

try
{
  $objDOM = new DOMDocument();
  $objDOM->loadXML($attendeURL); 
}
catch(Exception $e)
{
	echo $e->getMessage();
}
//$parent=$objDOM->getElementsByTagName("AddAttendeeToSession");
//$child=$parent->getElementsByTagName("Attendees");

$status = $objDOM->getElementsByTagName("status");
$status= $status->item(0)->nodeValue;
$message = $objDOM->getElementsByTagName("message");
$message= $message->item(0)->nodeValue;
if($status=="true")
{
$gchild=$objDOM->getElementsByTagName("Attendee");
$presenterURL=$gchild->item(0)->getAttribute('Url');	
}
}
if($presenterURL!="" || !empty($presenterURL))
{
	echo '<script language="javascript" type="text/javascript">
	window.location = \''.$presenterURL.'\';
	</script>';


//redirect("view.php?id=".$_REQUEST['id']);

}
else
{
	$strwiziq  = get_string("WiZiQ", "wiziq");
$strwiziqs = get_string("modulenameplural", "wiziq");
$navlinks = array();
$navlinks[] = array('name' => 'WiZiQ Classes', 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);
	
print_header($SITE->shortname.':'.$strwiziqs,$strwiziqs,$navigation, $wiziq->name,"", true,"",user_login_string($site));
	print_simple_box_start('center', '', '', 5, 'generalbox', $module->name);
?>
    <br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="5"><strong><img src="icon.gif" hspace="10" height="16" width="16" border="0" alt="" />Error In Entering WiZiQ Live Class</strong></font></p>
    <?php
	
	print_header("WizIQ class", "");
    
	print_simple_box_start('center', '100%');

    
    echo '<strong><center><font color="red">'.$message.'</font></center></strong><br><br>';
//echo'<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a>';
    print_simple_box_end();
    print_footer($course);  	
}
?>

</body>