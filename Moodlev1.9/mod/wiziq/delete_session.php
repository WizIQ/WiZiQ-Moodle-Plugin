

<?php
$timestamp=strtotime(now);
	require_once("wiziqconf.php");
	$content = file_get_contents($ConfigFile."?".$timestamp);
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
	
	
	
	$maxdur=$MaxDurationPerSession->item(0)->nodeValue;
	$maxuser=$MaxUsersPerSession->item(0)->nodeValue;
	$presenterentry=$PresenterEntryBeforeTime->item(0)->nodeValue;
	$privatechat=$PrivateChat->item(0)->nodeValue;
	$recordingcredit=$RecordingCreditLimit->item(0)->nodeValue;
	$concurrsession=$ConcurrentSessions->item(0)->nodeValue;
	$creditpending=$RecordingCreditPending->item(0)->nodeValue;
	$username=$UserName->item(0)->nodeValue;
	$password=$Password->item(0)->nodeValue;
	$subscription_url=$subscription_url->item(0)->nodeValue;
    $buynow_url=$buynow_url->item(0)->nodeValue;
    $Package_info_message=$Package_info_message->item(0)->nodeValue;
    $pricing_url=$pricing_url->item(0)->nodeValue;

require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once('wiziqconf.php');
 $course = optional_param('course', 0, PARAM_INT);
    
    $urlcourse = optional_param('course', 0, PARAM_INT);
if(!$site = get_site()) {
        redirect($CFG->wwwroot.'/'.$CFG->admin.'/index.php');
    }
$strwiziq  = get_string("WiZiQ", "wiziq");
$strwiziqs = get_string("modulenameplural", "wiziq");
$navlinks = array();
$calendar_navlink = array('name' => $strwiziqs,
                          '',
                          'type' => 'misc');

    $day = intval($now['mday']);
    $mon = intval($now['mon']);
    $yr = intval($now['year']);
	if($urlcourse > 0 && record_exists('course', 'id', $urlcourse)) {
        //require_login($urlcourse, false);

        if($urlcourse == SITEID) {
            // If coming from the site page, show all courses
            $SESSION->cal_courses_shown = calendar_get_default_courses(true);
            calendar_set_referring_course(0);
        }
        else {
			
            // Otherwise show just this one
            $SESSION->cal_courses_shown = $urlcourse;
            calendar_set_referring_course($SESSION->cal_courses_shown);
        }
    }
	 require_login($course, false);
$navlinks[] = $calendar_navlink;
$navlinks[] = array('name' => 'Delete WiZiQ Class', 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);
	
	
	print_header($site->shortname.':'.$strwiziqs,$strwiziqs,$navigation, $wiziq->name,"", true,"",user_login_string($site));
	print_simple_box_start('center', '', '', 5, 'generalbox', $module->name);	
	

$aid=$_REQUEST['aid'];
$insid=$_REQUEST['insid'];
$eid=$_REQUEST['eid'];
$courseid=$_REQUEST['id'];
$type=$_REQUEST['type'];
$sessionkey=$USER->sesskey;



$q=mysql_query("select *  from ".$CFG->prefix."wiziq where id=$aid");
$r=mysql_fetch_array($q);

 $pinsescod=$r['insescod'];
 $peventname=$r['name'];
 $purl=$r['url'];
 $pattendeeurl=$r['attendeeurl'];
 $precordingurl=$r['recordingurl'];
 $previewurl=$r['reviewurl'];
 $times=$r['wdate'];
 $wtime=$r['wtime'];
 
 //*******************************************************************************
 /*$tmzone=$USER->timezone;
include("switchtime.php");
//echo "from: ".$default_timezone_gmt;



// create the DateTimeZone object for later
$dtzone = new DateTimeZone($timezone_name);
// first convert the timestamp into a string representing the local time
$time = date('r', $times);
// now create the DateTime object for this time
$dtime = new DateTime($time,$dtzone);
// convert this to the user's timezone using the DateTimeZone object
$dtime->setTimeZone($dtzone);
// print the time using your preferred format
//$time = $dtime->format('g:i A m/d/y T');
$wdate = $dtime->format('d-m-Y');*/
//*******************************************************************************
if($_REQUEST['flag']!=1)
{
include_once("confirm_delete.php");
}
$wdate=calendar_day_representation($times, $now = false, $usecommonwords = true);
//$wtime=calendar_time_representation($times);
//$date=date('d-m-Y', $date);
$date=str_replace("-","/",$wdate);
$dattime= $date." ".$wtime;
$dattime=strtoupper($dattime);
$courseid=$_REQUEST['courseid'];
if($_REQUEST['flag']==1)
{
	
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
				'lnSesCod' => $pinsescod
	        	 );	

 $result=do_post_request($WebServiceUrl.'moodle/class/delete',http_build_query($person, '', '&'));
try
	  {
	    $objDOM = new DOMDocument();
	    $objDOM->loadXML($result); 
	  }
	catch(Exception $e)
	  {
		echo $e->getMessage();
	  }
   
 	
	 $Deleted=$objDOM->getElementsByTagName("Status");
	 $Deleted=$Deleted->item(0)->nodeValue;
	$message=$objDOM->getElementsByTagName("message");
	$message=$message->item(0)->nodeValue;


if($Deleted=="true")
{

}

if( $type=='0' && $Deleted=="True")
{
	
	mysql_query("delete from ".$CFG->prefix."wiziq where id=".$aid) or die("wiziq query not working");
	
	mysql_query("delete from ".$CFG->prefix."event where id=".$eid) or die("event query not working");
	
	mysql_query("delete from ".$CFG->prefix."course_modules where id=".$insid) or die("course module query not working");
echo '<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We Are Processing Your Request. Please Wait............</strong></font></p>';
	redirect("welcome_delete.php?id=".$courseid);
	
}
else
{
print_header($SITE->fullname, $SITE->fullname, 'home', '',
                 '<meta name="description" content="'. s(strip_tags($SITE->summary)) .'" />',
                 true, '', user_login_string($SITE).$langmenu);
				//$courseid= $_REQUEST['id'];
				
?>

<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" > <br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#0066CC" size="5"><strong>The Class can not be deleted....</strong></font></p> </td>
  </tr>
  <tr>
  <td ><?php echo '<strong>Message:</strong> ' .$message?></td>
  </tr>
  <tr>
    <td align="center"> <input type="button" class="txtbox" name="Cancel" value="Go to class list" onClick="javascript:location.href='wiziq_list.php?course=<?php echo $courseid;?>'"> </td>
  </tr>
</table>
<?php
}
}
print_footer();
?>








