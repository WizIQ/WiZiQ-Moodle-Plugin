<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<script type='text/javascript'>window.onerror = handleError; function handleError(){return true;}</script>
<style>
.uploadingdiv{border:solid 10px #ccc; background-color:#fff; padding:10px;}
.ulink{text-decoration:underline;  font-size:12px}
.ulink:hover{text-decoration:none;font-size:12px}
</style>
<script type="text/javascript" language="javascript" src="http://org.wiziq.com/Common/JS/ModalPopup.js"></script>
<script language="javascript" src="http://org.wiziq.com/Common/JS/jquery.js" type="text/javascript"></script>

 <link href="http://org.wiziq.com/Common/CSS/ModalPopup.css" rel="stylesheet" type="text/css" />
  <link href="http://org.wiziq.com/Common/CSS/thickbox.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function PopUp(code)
{

	document.getElementById("divmodal").style.display="block";
	document.getElementById("divmodal").style.visibility="visible";
	document.getElementById("ifrmDownload").src = "downloadrec.php?SessionCode="+code+"&amp;keepThis=true&TB_iframe=true&height=250&width=400";
PopupShow('divmodal','modalBackground');
return true;
}
 function openDetails(Url)
    {

        var scheight=screen.height;
        var scwidth=screen.width;
        var w=window.open(Url, null, "left=0,top=0,resize=0, height="+scheight+", width="+scwidth);
		w.focus();
		return false;
    }
</script>
</head>
<body>
<div id="divmodal"  class="modalWindow" style="display: none; width: 500px;">
    <div id="dvMod1" class="uploadingdiv" style="height:200px">
       <div id="close1" style="float:right;"><a id="A1" href="javascript:PopupClose();" >Close</a></div>
          <iframe id="ifrmDownload" width="470px" height="190px" frameborder="0" scrolling="no" style="font-family:Arial; font-size:12px; color:#444" ></iframe>

    </div>
 </div>
<img id="modalBackground" class="modalBackground" width="100%" style="display: none; z-index: 3; left: -6px; top: 120px; height: 94%;" alt=""  />

<?php
 require_once("../../config.php");
 require_once("lib.php");
 include("paging.php");
 require_once($CFG->dirroot .'/course/lib.php');
 require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
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
 $limit=10;
 if($_REQUEST['course']<>"")
 {
$courseid=$_REQUEST['course'];
 }
 else
 {
	$courseid=$_REQUEST['id'];
 }
 require_login();

    $sectionreturn = optional_param('sr', '', PARAM_INT);
    $add           = optional_param('add','', PARAM_ALPHA);
    $type          = optional_param('type', '', PARAM_ALPHA);
    $indent        = optional_param('indent', 0, PARAM_INT);
    $update        = optional_param('update', 0, PARAM_INT);
    $hide          = optional_param('hide', 0, PARAM_INT);
    $show          = optional_param('show', 0, PARAM_INT);
    $copy          = optional_param('copy', 0, PARAM_INT);
    $moveto        = optional_param('moveto', 0, PARAM_INT);
    $movetosection = optional_param('movetosection', 0, PARAM_INT);
    $delete        = optional_param('delete', 0, PARAM_INT);
    $course        = optional_param('course', 0, PARAM_INT);
    $groupmode     = optional_param('groupmode', -1, PARAM_INT);
    $duplicate     = optional_param('duplicate', 0, PARAM_INT);
    $cancel        = optional_param('cancel', 0, PARAM_BOOL);
    $cancelcopy    = optional_param('cancelcopy', 0, PARAM_BOOL);
	$urlcourse = optional_param('course', 0, PARAM_INT);
    if (empty($SITE)) {
        redirect($CFG->wwwroot .'/'. $CFG->admin .'/index.php');
    }

    // Bounds for block widths
    // more flexible for theme designers taken from theme config.php
    $lmin = (empty($THEME->block_l_min_width)) ? 100 : $THEME->block_l_min_width;
    $lmax = (empty($THEME->block_l_max_width)) ? 210 : $THEME->block_l_max_width;
    $rmin = (empty($THEME->block_r_min_width)) ? 100 : $THEME->block_r_min_width;
    $rmax = (empty($THEME->block_r_max_width)) ? 210 : $THEME->block_r_max_width;

    define('BLOCK_L_MIN_WIDTH', $lmin);
    define('BLOCK_L_MAX_WIDTH', $lmax);
    define('BLOCK_R_MIN_WIDTH', $rmin);
    define('BLOCK_R_MAX_WIDTH', $rmax);
	$strwiziq  = get_string("WiZiQ", "wiziq");
$strwiziqs = get_string("modulenameplural", "wiziq");
calendar_session_vars();
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
$navlinks[] = array('name' => 'WiZiQ Classes', 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);

print_header($SITE->shortname.':'.$strwiziqs,$strwiziqs,$navigation, $wiziq->name,"", true,"",user_login_string($site));
	print_simple_box_start('center', '', '', 5, 'generalbox', $module->name);
/*print_header($SITE->fullname, $SITE->fullname, 'home', '',
                 <meta name="description" content="'. s(strip_tags($SITE->summary)) .'" />',
                 true, '', user_login_string($SITE).$langmenu);*/

$timezones = get_list_of_timezones();


         if ($CFG->forcetimezone != 99)

            {
                $tmzone=$CFG->forcetimezone;
            }
            else {
                $tmzone=$USER->timezone;
            	}

 if(!is_numeric($tmzone))
{
	if ($CFG->forcetimezone != 99)
 	{
 		$timezone=$CFG->forcetimezone;
 	}
	else
	$timezone=$USER->timezone;
}
else
{
// check timezone
switch($tmzone)
{
case("-13.0"):
{
$timezone="GMT-13";
break;
}

case("-12.5"):
{
$timezone="GMT-12.5";
break;
}
case("-12.0"):
{
$timezone="GMT-12";
break;
}

case("-11.5"):
{
$timezone="GMT-11.5";
break;
}

case("-11.0"):
{
$timezone="GMT-11";
break;
}
case("-10.5"):
{
$timezone="GMT-10.5";
break;
}
case("-10.0"):
{
$timezone="GMT-10";
break;
}

case("-9.5"):
{
$timezone="GMT-9.5";
break;
}

case("-9.0"):
{
$timezone="GMT-9";
break;
}

case("-8.5"):
{
$timezone="GMT-8.5";
break;
}

case("-8.0"):
{
$timezone="GMT-8";
break;
}
case("-7.5"):
{
$timezone="GMT-7.5";
break;
}

case("-7.0"):
{
$timezone="GMT-7";
break;
}

case("-6.5"):
{
$timezone="GMT-6.5";
break;
}
case("-6.0"):
{
$timezone="GMT-6";
break;
}
case("-5.5"):
{
$timezone="GMT-5.5";
break;
}
case("-5.0"):
{
$timezone="GMT-5";
break;
}
case("-4.5"):
{
$timezone="GMT-4.5";
break;
}
case("-4.0"):
{
$timezone="GMT-4";
break;
}
case("-3.5"):
{
$timezone="GMT-3.5";
break;
}
case("-3.0"):
{
$timezone="GMT-3";
break;
}
case("-2.5"):
{
$timezone="GMT-2.5";
break;
}
case("-2.0"):
{
$timezone="GMT-2";
break;
}
case("-1.5"):
{
$timezone="GMT-1.5";
break;
}
case("-1.0"):
{
$timezone="GMT-1";
break;
}
case("-0.5"):
{
$timezone="GMT-0.5";
break;
}
case("0.0"):
{
$timezone="GMT";
break;
}
case("0.5"):
{
$timezone="GMT+0.5";
break;
}
case("1.0"):
{
$timezone="GMT+1";
break;
}
case("1.5"):
{
$timezone="GMT+1.5";
break;
}
case("2.0"):
{
$timezone="GMT+2";
break;
}
case("2.5"):
{
$timezone="GMT+2.5";
break;
}
case("3.0"):
{
$timezone="GMT+3";
break;
}
case("3.5"):
{
$timezone="GMT+3.5";
break;
}
case("4.0"):
{
$timezone="GMT+4";
break;
}
case("4.5"):
{
$timezone="GMT+4.5";
break;
}
case("5.0"):
{
$timezone="GMT+5";
break;
}
case("5.5"):
{
$timezone="GMT+5.5";
break;
}
case("6.0"):
{
$timezone="GMT+6";
break;
}
case("6.5"):
{
$timezone="GMT+6.5";
break;
}
case("7.0"):
{
$timezone="GMT+7";
break;
}
case("7.5"):
{
$timezone="GMT+7.5";
break;
}
case("8.0"):
{
$timezone="GMT+8";
break;
}
case("8.5"):
{
$timezone="GMT+8.5";
break;
}
case("9.0"):
{
$timezone="GMT+9";
break;
}
case("9.5"):
{
$timezone="GMT+9.5";
break;
}
case("10.0"):
{
$timezone="GMT+10";
break;
}
case("10.5"):
{
$timezone="GMT+10.5";
break;
}
case("11.0"):
{
$timezone="GMT+11";
break;
}
case("11.5"):
{
$timezone="GMT+11.5";
break;
}
case("12.0"):
{
$timezone="GMT+12";
break;
}
case("12.5"):
{
$timezone="GMT+12.5";
break;
}
case("13.0"):
{
$timezone="GMT+13";
break;
}
default:
  {
$timezone="GMT-6.0";
  }
}
}
$modquery="SELECT id FROM ".$CFG->prefix."modules where name='wiziq'";
$modresult=mysql_query($modquery);
$modresult=mysql_fetch_array($modresult);
$moduleid=$modresult['id'];
$query="SELECT * FROM ".$CFG->prefix."wiziq where id in (select distinct e.instance from ".$CFG->prefix."event e,".$CFG->prefix."course_modules cm WHERE e.instance=cm.instance AND cm.course=".$courseid." AND cm.module=".$moduleid." AND e.name like '%mod/wiziq/icon.gif%') UNION SELECT *  FROM ".$CFG->prefix."wiziq WHERE oldclasses =1 ORDER BY insescod DESC ";
$query=paging_1($query,"","0%",$courseid);
 $result=mysql_query($query) or die("sql failed gettin session code");
  $resultset=$result;
$szXMLNode="";
$sessiontype=array();
$sessioncodeArray=array();
while($rn=mysql_fetch_array($resultset))
{
	$code=$rn['insescod'];
	$szXMLNode=$szXMLNode."<table><sessioncode>".$code."</sessioncode></table>";
}

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
				'szXMLNode'=>'<newdataset>'.$szXMLNode.'</newdataset>',
				   );
  $resultanttt=do_post_request($WebServiceUrl.'moodle/class/GetSessionsStatus',http_build_query($person, '', '&'));

	try
	{
	 $objDOM = new DOMDocument();
 	 $objDOM->loadXML($resultanttt);
  //make sure path is correct
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
$Table= $objDOM->getElementsByTagName("table");
$length =$Table->length;
$i=1;
foreach( $Table as $value )
  {

	  $j=1;
$test = $value->getElementsByTagName("sessioncode");
 $SessionCode= $test->item(0)->nodeValue;
$sessiontype[$i][$j]=$SessionCode;
$sessioncodeArray[$i]=$SessionCode;
$test1 = $value->getElementsByTagName("type");
 $type= $test1->item(0)->nodeValue;
$sessiontype[$i][$j+1]=$type;
$test2=$value->getElementsByTagName("status");
 $status=$test2->item(0)->nodeValue;
$sessiontype[$i][$j+2]=$status;

$test3=$value->getElementsByTagName("isaglivesummarygenerated");
 $IsaGLiveSummaryGenerated=$test3->item(0)->nodeValue;
$sessiontype[$i][$j+3]=$IsaGLiveSummaryGenerated;

 $test4=$value->getElementsByTagName("movestatus");
 $MoveStatus=$test4->item(0)->nodeValue;
$sessiontype[$i][$j+4]=$MoveStatus;

$i++;
}

$_SESSION['SessionCode']=$sessioncodeArray;
//print_r($sessioncodeArray);

?>
<table><tr><td width="180px" align="left" valign="top">
<?php
include("sideblock.php");
?>
</td><td width="800px">

<table border="0" cellpadding="5px" cellspacing="5px" width="100%" >
 <tr><td height="30">

 <strong>WiZiQ Classes</strong>
           <font size="1px">
              <p align="right">*Class Date & Time is shown in your Time Zone (<?php echo $timezone ?>)</p>
           </font></td></tr>
  <tr>
    <td align="center" >
    <table width="100%" border="1" cellpadding="5px"   cellspacing="5px" align="center" bordercolor="#efefef" >

        <tr height="30px" style="background-color:#efefef;">
          <td align="left" style="font-size:14px;padding-left:10px;"><strong>Class Name </strong></td>
          <td  align="left" style="padding-left:10px;font-size:14px"><strong>Date & Time </strong></td>
          <td  align="left" style="padding-left:10px;font-size:14px"><strong>Status</strong></td>
          <td align="left" style="padding-left:0px;font-size:14px"><strong>Manage</strong></td>
          <td align="left" style="padding-left:10px;font-size:14px"><strong>Actions</strong></td>
        </tr>

        <?php
$query="select * from ".$CFG->prefix."wiziq where id in (select distinct e.instance from ".$CFG->prefix."event e,".$CFG->prefix."course_modules cm where e.instance=cm.instance and cm.course=".$courseid." AND cm.module=".$moduleid." and e.name like '%mod/wiziq/icon.gif%' ) UNION SELECT * FROM ".$CFG->prefix."wiziq WHERE oldclasses =1 ORDER BY insescod DESC ";

$query=paging_1($query,"","0%",$courseid);
 $result=mysql_query($query);

while($r=mysql_fetch_array($result))
{
	$code=$r['insescod'];
	$recordingurl=$r['recordingurl'];
 $wizid=$r['id'];
$query1="select e.id as eid,e.eventtype as eventtype,cm.id as cmid,e.instance as einst,cm.instance as cminst,e.userid as eventuserid from ".$CFG->prefix."event e,".$CFG->prefix."course_modules cm where e.instance=".$wizid." and cm.instance=".$wizid;
$result1=mysql_query($query1);
$r1=mysql_fetch_array($result1);
 $eventtype=$r1['eventtype'];
 if($eventtype=="user")
$_eventType="User Event";

else if($eventtype=="site")
$_eventType="Site Event";

else if($eventtype=="course")
$_eventType="Course Event";

else if($eventtype=="group")
$_eventType="Group Event";

	$name=$r['name'];
	 $eid=$r1['eid'];

	 $id=$r['id'];
	$times=$r['wdate'];
	$instance=$r1['einst'];
	$einst=$r1['einst'];
	$eventuserid=$r1['eventuserid'];

	 $udate=usergetdate($times);

 $m=$udate['mon'];
 $y=$udate['year'];
 $d=$udate['mday'];
$wdate=$m."/".$d."/".$y;
$timecheck=0;
$todaydate=usergetdate(time());

if($udate['year'] < $todaydate['year'])
{

 $timecheck=1;

}
else if($udate['year'] == $todaydate['year'])
{
 if( $udate['yday'] < $todaydate['yday'])
 {
	// echo $udate['yday'];
  $timecheck=1;
 }
 else if( $udate['mon'] < $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
	// echo $udate['mon'];
  $timecheck=1;
 }
 else if($udate['hours'] < $todaydate['hours'] && $udate['mon'] <= $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
	 //echo $udate['hours'];
  $timecheck=1;
 }
 else if( $udate['minutes'] < $todaydate['minutes'] && $udate['hours'] <= $todaydate['hours'] && $udate['mon'] <= $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
	// echo $udate['minutes']."gfg".$todaydate['minutes'];
  $timecheck=1;
 }
}
$wtime=calendar_time_representation($times);/////////////////////////////
//setcookie("SessionCode", $code, time()+3600);
//$output=encrypt($code,"Auth@Moo(*)");

	 $cmid=$r1['cmid'];
	 //$wdate=date('d M Y h:i:s A ', $wdate);
	 $type=$r['statusrecording'];
	// http://localhost/moodle/mod/wiziq/view.php?id=9

	$query2="select course from ".$CFG->prefix."course_modules where id=".$cmid;
	$result2=mysql_query($query2);
	$r2=mysql_fetch_array($result2);
	$courseid=$r2['course'];
	if($eventtype=="user" && $r['oldclasses']!=1)
	{
	?>
        <tr height="30px">
          <td align="left" style="padding-left:10px; font-size:12px"><a href="view.php?id=<?php echo $cmid; ?>&type=<?php echo $type; ?>"><?php echo $name;?></a></td>
          <TD align="left" style="padding-left:10px; font-size:12px"><?php echo $wdate.", ".$wtime;?></TD>

          <td align="left" style="padding-left:5px; font-size:12px"><?php $i=1;

		  foreach($sessiontype as $code1)
		  {
			  $j=1;

			  if(current($code1)==$code)
			  {
				  //$val=strtoupper($sessiontype[$i][$j+1]);

			  if($sessiontype[$i][$j+1]==="D")
			  echo "Done";
			  else if($sessiontype[$i][$j+1]==="E")
			  echo "Expired";
			  else if($sessiontype[$i][$j+1]==="S")
			  echo "Scheduled";
			  }
			  $i++;
		  }
			   ?></td><td align="center"><?php if($timecheck==0 && ($eventuserid==$USER->id  || $USER->id==2 )){ ?><a href="edit_view.php?id=<?php echo $cmid; ?>&type=<?php echo $type ?>&eventtype=<?php echo $_eventType; ?>"><?php echo "<img
                  src=\" ".$CFG->pixpath."/t/edit.gif\" alt=\" ".get_string('tt_editevent', 'calendar')."\"
                 title=\" ".get_string('tt_editevent', 'calendar')." \"  />" ?></a> &nbsp;<a href="delete_session.php?id=<?php echo $courseid;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq&aid=<?php echo $id;?>&eid=<?php echo $eid; ?>&type=0&inst=<?php echo $cmid;?>&course=<?php echo $urlcourse; ?>"><?php echo "<img
                  src=\" ".$CFG->pixpath."/t/delete.gif\" alt=\" ".get_string('tt_deleteevent', 'calendar')."\"
                 title=\" ".get_string('tt_deleteevent', 'calendar')." \"  />" ?></a> <?php } ?></td><td width="40%"><table cellspacing="10px" cellpadding="10px" width="100%"><tr>
                 <?php
			   if(($eventuserid==$USER->id  || $USER->id==2 ))
			   {
			   $i=1;
		  		foreach($sessiontype as $code1)
		 		 {
					 $j=1;
			  //echo "[".$i."]";
					  if(current($code1)==$code)
					  {
				//print_r($sessiontype[$i][$i+2]);
			 		   if($sessiontype[$i][$j+2]==1)
			 		  {
echo '<td style="padding-left:3px; font-size:12px; border-right:solid 1px #efefef" width="30%"><a onclick="return openDetails(\''.$CFG->wwwroot.'/mod/wiziq/viewrecording.php?s='.encrypt($code,"Auth@Moo(*)").'\');" href="javascript:void(0);" class="ulink">View Recording</a></td>';
			 }

				      }

			  		$i++;
		 		 }
			   }

			   if(($eventuserid==$USER->id  || $USER->id==2 ))
			   {
			   $i=1;
		  foreach($sessiontype as $code1)
		  {
			 $j=1;
			  //echo "[".$i."]";
			  if(current($code1)==$code)
			  {
				//print_r($sessiontype[$i][$i+2]);
			  if($sessiontype[$i][$j+4]==2)
			  echo '<td style="padding-left:5px; font-size:12px; border-right:solid 1px #efefef" width="37%"><a onclick="return PopUp(\''.$code.'\');" href="javascript:void(0);" class="ulink">Download Recording</a></td>';

			  }

			  $i++;
		  }
			   }
			   if(($eventuserid==$USER->id  || $USER->id==2 ))
			   {
			   $i=1;
		  foreach($sessiontype as $code1)
		  {
			 $j=1;
			  //echo "[".$i."]";
			  if(current($code1)==$code)
			  {
				//print_r($sessiontype[$i][$i+2]);
			 if($sessiontype[$i][$j+3]==1)
			  echo '<td style="padding-left:3px; font-size:12px" width="35%"><a  href="attendancereport.php?courseid='.$courseid.'&SessionCode='.$code.'" class="ulink">Attendance Report</a></td>';

			  }

			  $i++;
		  }
			   }?></tr></table></td>
        </tr>
<?php
	}
else if($eventtype=="group" && $r['oldclasses']!=1)
{
	$grpflag=1;
$grpquery=mysql_query("select groupid,userid from ".$CFG->prefix."groups_members where groupid in(select groupid from ".$CFG->prefix."event where instance=".$id.")");
$while=1;
while($grpresult=mysql_fetch_array($grpquery))
{
	$grpary[$while]=$grpresult['userid'];
	$while++;
}
 foreach($grpary as $grpuserid)
		  {

if(($grpuserid==$USER->id || $USER->id==2 || $eventuserid==$USER->id )&& $grpflag==1 )
{
	$grpflag=0;

   ?>     <tr height="30px">
          <td align="left" style="padding-left:10px; font-size:12px"><a href="view.php?id=<?php echo $cmid; ?>&type=<?php echo $type; ?>"><?php echo $name;?></a></td>
          <TD align="left" style="padding-left:10px; font-size:12px"><?php echo $wdate.", ".$wtime;?></TD>

          <td align="left" style="padding-left:5px; font-size:12px"><?php $i=1;

		  foreach($sessiontype as $code1)
		  {
			  $j=1;

			  if(current($code1)==$code)
			  {
				  //$val=strtoupper($sessiontype[$i][$j+1]);

			  if($sessiontype[$i][$j+1]==="D")
			  echo "Done";
			  else if($sessiontype[$i][$j+1]==="E")
			  echo "Expired";
			  else if($sessiontype[$i][$j+1]==="S")
			  echo "Scheduled";
			  }
			  $i++;
		  }
			   ?></td><td align="center"><?php if($timecheck==0 && ($eventuserid==$USER->id  || $USER->id==2 )){ ?><a href="edit_view.php?id=<?php echo $cmid; ?>&type=<?php echo $type ?>&eventtype=<?php echo $_eventType; ?>"><?php echo "<img
                  src=\" ".$CFG->pixpath."/t/edit.gif\" alt=\" ".get_string('tt_editevent', 'calendar')."\"
                 title=\" ".get_string('tt_editevent', 'calendar')." \"  />" ?></a> &nbsp;<a href="delete_session.php?id=<?php echo $courseid;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq&aid=<?php echo $id;?>&eid=<?php echo $eid; ?>&type=0&inst=<?php echo $cmid;?>&course=<?php echo $urlcourse; ?>"><?php echo "<img
                  src=\" ".$CFG->pixpath."/t/delete.gif\" alt=\" ".get_string('tt_deleteevent', 'calendar')."\"
                 title=\" ".get_string('tt_deleteevent', 'calendar')." \"  />" ?></a> <?php } ?></td><td width="40%"><table cellspacing="10px" cellpadding="10px" width="100%"><tr><td style="padding-left:5px; font-size:12px; border-right:solid 1px #efefef" width="37%"><?php

			   $i=1;
		  foreach($sessiontype as $code1)
		  {
			 $j=1;

			  if(current($code1)==$code)
			  {

			 if($sessiontype[$i][$j+2]==1)
			  echo '<td style="padding-left:5px; font-size:12px; border-right:solid 1px #efefef" width="30%"><a onclick="return openDetails(\''.$CFG->wwwroot.'/mod/wiziq/viewrecording.php?s='.encrypt($code,"Auth@Moo(*)").'\');" href="javascript:void(0);" class="ulink">View Recording</a></td>';
			  }

			  $i++;
		  }

			   $i=1;
		  foreach($sessiontype as $code1)
		  {
			 $j=1;
			  if(current($code1)==$code)
			  {
		 if($sessiontype[$i][$j+4]==2)

			echo '</td><td style="padding-left:3px; font-size:12px;border-right:solid 1px #efefef" width="37%"><a onclick="return PopUp(\''.$code.'\');" href="javascript:void(0);" class="ulink">Download Recording</a></td>';


			  }

			  $i++;
		  }

			   $i=1;
		  foreach($sessiontype as $code1)
		  {
			 $j=1;
			  if(current($code1)==$code)
			  {
			 if($sessiontype[$i][$j+3]==1)
			  echo '<td style="padding-left:3px; font-size:12px" width="35%"><a  href="attendancereport.php?courseid='.$courseid.'&SessionCode='.$code.'" class="ulink">Attendance Report</a></td>';

			  }

			  $i++;
		  }
			   ?></td></tr></table></td>
        </tr>

<?php
}
}
}
if($r['oldclasses']==1)
{
$cmid=$r1['cmid'];
	?>
<tr>
 <td style="padding-left:10px; padding-top:5px; font-size:12px"><a href="view.php?id=<?php echo $cmid; ?>&type=<?php echo $type; ?>"><?php echo $name;?></a></td>
 <TD style="padding-left:10px; padding-top:5px; font-size:12px"><?php echo $wdate." , ".$wtime;?></TD>
 <td style="padding-left:10px; font-size:12px"><?php $i=1;

		  foreach($sessiontype as $code1)
		  {
			  $j=1;

			  if(current($code1)==$code)
			  {
				  //$val=strtoupper($sessiontype[$i][$j+1]);

			  if($sessiontype[$i][$j+1]==="D")
			  echo "Done";
			  else if($sessiontype[$i][$j+1]==="E")
			  echo "Expired";
			  else if($sessiontype[$i][$j+1]==="S")
			  echo "Scheduled";
			  }
			  $i++;
		  }

		   if($_REQUEST['course']<>"")
 {
$courseid=$_REQUEST['course'];
 }
 else
 {
	$courseid=$_REQUEST['id'];
 }
			   ?></td>
 <td align="center"><a href="delete_session.php?id=<?php echo $courseid;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq&aid=<?php echo $id;?>&eid=<?php echo $eid; ?>&type=0&inst=<?php echo $cmid;?>&course=<?php echo $urlcourse; ?>"><?php echo "<img
                  src=\" ".$CFG->pixpath."/t/delete.gif\" alt=\" ".get_string('tt_deleteevent', 'calendar')."\"
                 title=\" ".get_string('tt_deleteevent', 'calendar')." \"  />" ?></a></td><td></td> </tr>
<?php
}
else if($eventtype!="group" && $eventtype!="user" )
{
?>
        <tr height="30px">
          <td align="left" style="padding-left:10px; font-size:12px"><a href="view.php?id=<?php echo $cmid; ?>&type=<?php echo $type; ?>"><?php echo $name;?></a></td>
          <TD align="left" style="padding-left:10px; font-size:12px"><?php echo $wdate.", ".$wtime;?></TD>

          <td align="left" style="padding-left:5px; font-size:12px"><?php $i=1;

		  foreach($sessiontype as $code1)
		  {
			  $j=1;

			  if(current($code1)==$code)
			  {
				  //$val=strtoupper($sessiontype[$i][$j+1]);

			  if($sessiontype[$i][$j+1]==="D")
			  echo "Done";
			  else if($sessiontype[$i][$j+1]==="E")
			  echo "Expired";
			  else if($sessiontype[$i][$j+1]==="S")
			  echo "Scheduled";
			  }
			  $i++;
		  }
			   ?></td><td align="center"><?php if($timecheck==0 && ($eventuserid==$USER->id  || $USER->id==2 )){ ?><a href="edit_view.php?id=<?php echo $cmid; ?>&type=<?php echo $type ?>&eventtype=<?php echo $_eventType; ?>"><?php echo "<img
                  src=\" ".$CFG->pixpath."/t/edit.gif\" alt=\" ".get_string('tt_editevent', 'calendar')."\"
                 title=\" ".get_string('tt_editevent', 'calendar')." \"  />" ?></a> &nbsp;<a href="delete_session.php?id=<?php echo $courseid;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq&aid=<?php echo $id;?>&eid=<?php echo $eid; ?>&type=0&inst=<?php echo $cmid;?>&course=<?php echo $urlcourse; ?>"><?php echo "<img
                  src=\" ".$CFG->pixpath."/t/delete.gif\" alt=\" ".get_string('tt_deleteevent', 'calendar')."\"
                 title=\" ".get_string('tt_deleteevent', 'calendar')." \"  />" ?></a> <?php } ?></td><td ><table cellspacing="0px" cellpadding="0px" width="100%"><tr>
                 <?php

			   $i=1;
		  foreach($sessiontype as $code1)
		  {
			 $j=1;

			  if(current($code1)==$code)
			  {

			 if($sessiontype[$i][$j+2]==1)
			  echo '<td style="padding-left:5px; font-size:12px; border-right:solid 1px #efefef" width="30%"><a onclick="return openDetails(\''.$CFG->wwwroot.'/mod/wiziq/viewrecording.php?s='.encrypt($code,"Auth@Moo(*)").'\');" href="javascript:void(0);" class="ulink">View Recording</a></td>';
			  }

			  $i++;
		  }

			   $i=1;
		  foreach($sessiontype as $code1)
		  {
			 $j=1;
			  if(current($code1)==$code)
			  {
		 if($sessiontype[$i][$j+4]==2)

			echo '</td><td style="padding-left:3px; font-size:12px;border-right:solid 1px #efefef" width="37%"><a onclick="return PopUp(\''.$code.'\');" href="javascript:void(0);" class="ulink">Download Recording</a></td>';


			  }

			  $i++;
		  }

			   $i=1;
		  foreach($sessiontype as $code1)
		  {
			 $j=1;
			  if(current($code1)==$code)
			  {
			 if($sessiontype[$i][$j+3]==1)
			  echo '<td style="padding-left:3px; font-size:12px" width="35%"><a  href="attendancereport.php?courseid='.$courseid.'&SessionCode='.$code.'" class="ulink">Attendance Report</a></td>';

			  }

			  $i++;
		  }
			   ?></tr></table></td>
        </tr>


<?php
}

}
?>
<Tr>
          <td colspan="5" align="right"><input type="button" class="txtbox" name="Cancel" value="Go Back" onClick="javascript:location.href='<?php echo $CFG->wwwroot .'/index.php' ?>'"></td></tr><tr><td colspan="5" align="right">
            <?php
$str="";
paging_2($str,"0%",$courseid);
?></td>
        </Tr>
      </table></td>
  </tr></table>
</td></tr></table>
<?php
function encrypt($string, $key) {
$result = '';
for($i=0; $i<strlen($string); $i++) {
$char = substr($string, $i, 1);
$keychar = substr($key, ($i % strlen($key))-1, 1);
$char = chr(ord($char)+ord($keychar));
$result.=$char;
}

return base64_encode($result);
}


print_footer();
?>
</body>