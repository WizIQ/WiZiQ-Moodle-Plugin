<head>
<style>
.m_12b585858{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
text-decoration:none;
font-weight:bold;
color:#585858;
padding-right:10px;
}
.Layer1 {
	position:absolute;
	width:36px;
	height:21px;
	z-index:1;
	left: 333px;
	top: 143px;
}
.button{
       font-family:Arial;
	   font-size:11px;
	   color:#333333;
	   background-color:#999999;
	   font-weight:bold;
	   border:#FFFFFF 1px solid;
	   cursor:pointer;
	   height:40px;
}
.perror{
    border:1px solid #FF0000;
	font-family:Arial, Helvetica, sans-serif;

	font-weight:normal;
	color:#FF0000;
}
.error{
      border:#FF0000 1px;
	font-family:Arial, Helvetica, sans-serif;

	font-weight:normal;
	color:#FF0000;
}
.ulink{text-decoration:underline; font-weight:bold; font-size:12px}
.ulink:hover{text-decoration:none;font-weight:bold;font-size:12px}
.dv100{width:100%; float:left}
.dur_txt{ border-right:solid 1px #ddd;float:left; width:100px;padding-right:25px;font-size:12px }
.type_txt{float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px }
.rec_txt{float:left; width:190px;margin-left:20px;font-size:12px   }
.b_txt{font-weight:bold;}
.formdv{float:left; margin-top:40px; width:530px; padding-bottom:20px; font-size:12px}
.form_left{width:90px; float:left; font-weight:bold;margin-top:5px }
.form_right{width:430px; float:right; color:#666666}
.m_textinput{
font-family:Arial, Helvetica, sans-serif;
font-size:13px;
text-decoration: none;
font-weight:normal;
color:#666666;
height:25px;
border-style:solid;
border-width:1px;
border-color:#CCCCCC;
width:270px;
padding-top:3px;
}
.uploadingdiv{border:solid 10px #ccc; background-color:#fff; padding:10px;}

</style>
<script type="text/javascript" language="javascript" src="http://org.wiziq.com/Common/JS/ModalPopup.js"></script>
<script language="javascript" src="http://org.wiziq.com/Common/JS/jquery.js" type="text/javascript"></script>

 <link href="http://org.wiziq.com/Common/CSS/ModalPopup.css" rel="stylesheet" type="text/css" />
  <link href="http://org.wiziq.com/Common/CSS/thickbox.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" language="javascript">
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
		w.opener=window;
		w.focus();
		return false;
    }
function setValue(value)
{
//alert(value);
if(value=="Enter Class")
{
//document.view.action='add_attende.php?eventid=3&id=3&SessionCode=';
//alert();
var sess=document.getElementById('SessionCode').value;

//alert('dd='+sess);
window.open('add_attende.php?SessionCode='+sess);
return false;
}
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

// $Id: view.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
/**
 * This page prints a particular instance of wizq
 *
 * @wiziq
 * @version $Id: view.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
 * @package wizq
 **/

/// (Replace wizq with the name of your module)
 if(!empty($_REQUEST['str']))
 $str=$_REQUEST['str'];
 if(!empty($_REQUEST['date']))
$date=$_REQUEST['date'];

/*
$day=$_REQUEST['day'];
//echo "day".$day;
$month=$_REQUEST['month'];
//echo "month".$month;
$year=$_REQUEST['year'];
//echo "year".$year;
*/
    	require_once("../../config.php");
    	require_once("lib.php");
      	require_once($CFG->dirroot.'/course/lib.php');
    	require_once($CFG->dirroot.'/calendar/lib.php');
		require_once("wiziqconf.php");
		require_once("RoleView.php");
		$content = file_get_contents($ConfigFile);
	if ($content !== false) {
	   // do something with the content
	 // echo "file is read",$content;
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
	$prsenterentry=$PresenterEntryBeforeTime->item(0)->nodeValue;
	$privatechat=$PrivateChat->item(0)->nodeValue;
	$recordingcredit=$RecordingCreditLimit->item(0)->nodeValue;
	$concurrsession=$ConcurrentSessions->item(0)->nodeValue;
	$creditpending=$RecordingCreditPending->item(0)->nodeValue;
	$subscription_url=$subscription_url->item(0)->nodeValue;
    $buynow_url=$buynow_url->item(0)->nodeValue;
    $Package_info_message=$Package_info_message->item(0)->nodeValue;
    $pricing_url=$pricing_url->item(0)->nodeValue;
$view = optional_param('view', 'upcoming', PARAM_ALPHA);
    $day  = optional_param('cal_d', 0, PARAM_INT);
    $mon  = optional_param('cal_m', 0, PARAM_INT);
    $yr   = optional_param('cal_y', 0, PARAM_INT);

    $id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
    $a  = optional_param('a', 0, PARAM_INT);  // wizq ID
	$instance = optional_param('instance', 0, PARAM_INT);
	if($instance!=0)
	{
		$modquery="SELECT id FROM ".$CFG->prefix."modules where name='wiziq'";
$modresult=mysql_query($modquery);
$modresult=mysql_fetch_array($modresult);
$moduleid=$modresult['id'];
   	$query=mysql_query("select id from ".$CFG->prefix."course_modules where module=".$moduleid." and instance=".$instance);
	   $r=mysql_fetch_array($query);
	   $id=$r['id'];

	}

	if ($id) {
        if (! $cm = get_record("course_modules", "id", $id)) {
            error("Course Module ID was incorrect");
        }

        if (! $course = get_record("course", "id", $cm->course)) {
            error("Course is misconfigured");
        }

        if (! $wiziq = get_record("wiziq", "id", $cm->instance)) {
            error("Course module is incorrect");
        }

    } else {
        if (! $wiziq = get_record("wiziq", "id", $a)) {
            error("Course module is incorrect");
        }
        if (! $course = get_record("course", "id", $wiziq->course)) {
            error("Course is misconfigured");
        }
        if (! $cm = get_coursemodule_from_instance("wiziq", $wiziq->id, $course->id)) {
            error("Course Module ID was incorrect");
        }
    }

    require_login($COURSE->id);

    add_to_log($course->id, "wiziq", "view", "view.php?id=$cm->id", "$wiziq->id");
 // Initialize the session variables
    calendar_session_vars();

    //add_to_log($course->id, "course", "view", "view.php?id=$course->id", "$course->id");
    $now = usergetdate(time());
    $pagetitle = '';

    $nav = calendar_get_link_tag(get_string('calendar', 'calendar'), CALENDAR_URL.'view.php?view=upcoming&amp;course='.$courseid.'&amp;', $now['mday'], $now['mon'], $now['year']);


    if(!checkdate($mon, $day, $yr)) {
        $day = intval($now['mday']);
        $mon = intval($now['mon']);
        $yr = intval($now['year']);
    }
    $time = make_timestamp($yr, $mon, $day);
switch($view) {
        case 'day':
            $nav .= ' -> '.userdate($time, get_string('strftimedate'));
            $pagetitle = get_string('dayview', 'calendar');
        break;
        case 'month':
            $nav .= ' -> '.userdate($time, get_string('strftimemonthyear'));
            $pagetitle = get_string('detailedmonthview', 'calendar');
        break;
        case 'upcoming':
            $pagetitle = get_string('upcomingevents', 'calendar');
        break;
    }

    // If a course has been supplied in the URL, change the filters to show that one
    if (!empty($courseid)) {
        if ($course = get_record('course', 'id', $courseid)) {
            if ($course->id == SITEID) {
                // If coming from the home page, show all courses
                $SESSION->cal_courses_shown = calendar_get_default_courses(true);
                calendar_set_referring_course(0);

            } else {
                // Otherwise show just this one
                $SESSION->cal_courses_shown = $course->id;
                calendar_set_referring_course($SESSION->cal_courses_shown);
            }
        }
    } else {
        $course = null;
    }

    if (empty($USER->id) or isguest()) {
        $defaultcourses = calendar_get_default_courses();
        calendar_set_filters($courses, $groups, $users, $defaultcourses, $defaultcourses);

    } else {
        calendar_set_filters($courses, $groups, $users);
    }

    // Let's see if we are supposed to provide a referring course link
    // but NOT for the "main page" course
    if ($SESSION->cal_course_referer != SITEID &&
       ($shortname = get_field('course', 'shortname', 'id', $SESSION->cal_course_referer)) !== false) {
        // If we know about the referring course, show a return link and ALSO require login!
        require_login();
        $nav = '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$SESSION->cal_course_referer.'">'.$shortname.'</a> -> '.$nav;
        if (empty($course)) {
            $course = get_record('course', 'id', $SESSION->cal_course_referer); // Useful to have around
        }
    }

    $strcalendar = get_string('calendar', 'calendar');
    $prefsbutton = calendar_preferences_button();

/// Print the page header

    if ($course->category) {
        $navigation = "<a href=\"../../course/view.php?id=$course->id\">$course->shortname</a> ->";
    } else {
        $navigation = '';
    }

    $strwiziqs = get_string("modulenameplural", "wiziq");
    $strwiziq  = get_string("WiZiQ", "wiziq");

    print_header("$course->shortname: $wiziq->name", "$course->fullname",
                 "$navigation <a href=index.php?id=$course->id>$strwiziqs</a> -> $wiziq->name",
                  "", "", true,
                  navmenu($course, $cm));

    echo calendar_overlib_html();
     // Layout the whole page as three big columns.
    echo '<table id="calendar" style="height:100%;">';
    echo '<tr>';

    // START: Main column

    /// Print the main part of the pageecho $user;
 echo '<td class="maincalendar">';
    echo '<div class="heightcontainer">';

$usr = $USER->username;
$email = $USER->email;
$times=$wiziq->wdate;
$timezone=$wiziq->timezone;
//$wtime=$wiziq->wtime;
//$id=$USER->id;
//echo $times;
//aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
//make_timestamp(2009,8,15,03 , 00);//("15/8/2009 03:00:00 PM");

//echo "function get mini".calendar_get_mini($courses, $groups, $users, $cal_month = false, $cal_year = false);
//echo "calender add event metadata".calendar_add_event_metadata($event);
//echo "calender print event".calendar_print_event($event);
//echo "calender get event".calendar_get_events($tstart, $tend, $users, $groups, $courses, $withduration=true, $ignorehidden=true);

//echo "<br>calender day representation".calendar_day_representation($times, $now = false, $usecommonwords = true);
//echo "<br>calender time representation".calendar_time_representation($times);
//$wdate=calendar_day_representation($times, $now = false, $usecommonwords = true);
 $wtime=calendar_time_representation($times);

//$t= make_timestamp(2010, 01, 30, 15, 00);

//echo  $time=userdate($t,'',$USER->timezone);
//echo "calender format event".calendar_format_event_time($event, $now, $morehref, $usecommonwords = true, $showtime=0);
//1264707000
$udate=usergetdate($times);
//print_r($udate);
 $m=$udate['mon'];
 $y=$udate['year'];
 $d=$udate['mday'];
$wdate=$m."/".$d."/".$y;
//make_timestamp($year, $month, $day, $hh1, $mm1);
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

$ptani=dst_offset_on($times, $USER->timezone) ;

if ($CFG->forcetimezone != 99)
 {
     $tmzone=$CFG->forcetimezone;

 }
 else
 $tmzone=$USER->timezone;
if(!is_numeric($tmzone))
{
	if ($CFG->forcetimezone != 99)
 	{
 		$timezone=$CFG->forcetimezone;
 	}
	else
	$timezone=$USER->timezone;
	 $tmzone=get_user_timezone_offset($tmzone);
}
else
{
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
$timezone="GMT-06:00";

  }
}
}

	$f=$wiziq->statusrecording;
	if($f==1)
	{
		$status="Yes";
	}
	if($f==0)
	{
		$status="No";
	}

// $query="select * from ".$CFG->prefix."role_assignments where userid =".$USER->id;

if($USER->id==2)
{
$role=1;
}
else
{
$query="select ra.roleid from ".$CFG->prefix."context,".$CFG->prefix."role_assignments ra where ".$CFG->prefix."context.id=ra.contextid and ra.userid=".$USER->id." and (".$CFG->prefix."context.instanceid=".$course->id ." or ".$CFG->prefix."context.instanceid=". 0 .")";

$rows=array();
$query1=mysql_query($query);

$i=0;
while($rows=mysql_fetch_array($query1))
{
$resultant[$i]=$rows['roleid'];
$i++;
}

sort($resultant);
$role=$resultant[0];
}
//echo "role is".$role."hghg";
$insescod=$wiziq->insescod;
$qry=mysql_query("select id,timezone from ".$CFG->prefix."wiziq where insescod=".$insescod);
$rs1 = mysql_fetch_array($qry);
$eventid=$rs1['id'];

//checking if admin allow attendee or student to record class

$qry=mysql_query("select eventtype,userid from ".$CFG->prefix."event where instance=".$wiziq->id." and name like '%mod/wiziq/icon.gif%'");
$rs = mysql_fetch_array($qry);
$eventtype=$rs['eventtype'];
if($eventtype=="user")
$_eventType="User Event";

else if($eventtype=="site")
$_eventType="Site Event";

else if($eventtype=="course")
$_eventType="Course Event";

else if($eventtype=="group")
$_eventType="Group Event";

$eventuserid=$rs['userid'];


$f=$wiziq->statusrecording;
if($USER->id==1)
{
$role='6';
}

echo '<table width="100%">';
if($role==1 || $role==2 || $role==3 )
{
echo '<tr><td valign="top" align="left">
<span style="margin-top:-0px; float:left">';include("sideblock.php");
echo '</span>
</td>';
}
echo '<td align="left" style="width:650px">';
$classRoleView=new ClassView_Role();
$classRoleView->_className=$wiziq->name;
$classRoleView->_classType=$_eventType;
$classRoleView->_classDate=$wdate;
$classRoleView->_classTime=$wtime;
$classRoleView->_classTimeZone=$timezone;
$classRoleView->_classDuration=$wiziq->wdur;
$classRoleView->_classAudioVideo=$wiziq->wtype;
$classRoleView->_classStatus=$status;
$classRoleView->_classPresenterLink=$wiziq->url;
$classRoleView->_classAttendeeLink=$wiziq->attendeeurl;
$classRoleView->_classRecordingLink=$wiziq->recordingurl;
$classRoleView->_eventUserID=$eventuserid;
$classRoleView->_roleID=$role;
$classRoleView->_udate=$udate;
$classRoleView->_todayDate=$todaydate;
$classRoleView->_timeCheck=$timecheck;
$classRoleView->_sessionCode=$insescod;
$classRoleView->_eventID=$eventid;
$classRoleView->_ID=$id;
$classRoleView->_courseID=$COURSE->id;
$classRoleView->_userID=$USER->id;
if(($wiziq->oldclasses)!=1)// check for old classes
{
if($eventtype=='site')
{

switch($role)
{
case('6'):// Role 6 is for guest
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('4'): // non-editing teacher
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('5'):// Role 5 is for student
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('2'):// Role 2 is fcourse creator
{
echo '<div>';
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
case('3'): // Role 5 is for Teacher
{
echo '<div>';
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
case('1'):
{
echo '<div>';
$classRoleView->AdminRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
}
}
else if($eventtype=='course')
{
switch($role)
{
case('6'):// Role 6 is for guest
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('4'): // non-editing teacher
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('5'):// Role 5 is for student
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

 case('2'):// Role 2 is fcourse creator
{
echo '<div>';
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;

}
case('3'): // Role 5 is for Teacher
{
echo '<div>';
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
case('1'):
{
echo '<div>';
$classRoleView->AdminRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
}
}
else if($eventtype=='group')
{

$grpflag=1;
$grpquery=mysql_query("select groupid,userid from ".$CFG->prefix."groups_members where groupid in(select groupid from ".$CFG->prefix."event where instance=".$wiziq->id.")");
$i=1;
while($grpresult=mysql_fetch_array($grpquery))
{
	$grpary[$i]=$grpresult['userid'];
	$i++;
}

	  foreach($grpary as $grpuserid)
		  {

if(($grpuserid==$USER->id || $USER->id==2 || $eventuserid==$USER->id )&& $grpflag==1 )
{
	$grpflag=0;
	switch($role)
{
case('6'):// Role 6 is for guest
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('4'): // non-editing teacher
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('5'):// Role 5 is for student
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

 case('2'):// Role 2 is fcourse creator
{
echo '<div>';
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;

}
case('3'): // Role 5 is for Teacher
{
echo '<div>';
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
case('1'):
{
echo '<div>';
$classRoleView->AdminRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
}
}

}
if($grpflag==1 )
{
?>
<div><strong><center><font color="red"><p>You are not authorized to view this class.</p></font></center></strong><br><br>
<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a></div>
<?php
}
}
else if($eventtype=='user')
{

if($USER->id==$eventuserid || $USER->id==2)
{
switch($role)
{
case('6'):// Role 6 is for guest
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('4'): // Role 4 non-editing teacher
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

case('5'):// Role 5 is for student
{
echo '<div>';
$classRoleView->StudentRole();
echo '</div>';
break;
}

 case('2'):// Role 2 is for course creator
{
echo '<div>';
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;

}
case('3'): // Role 5 is for Teacher
{
echo '<div>';
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
case('1'):
{
echo '<div>';
$classRoleView->AdminRole();
$classRoleView->iFrameLoad();
echo '</div>';
break;
}
}
}
else
{
?>
<br /><br />
<div><strong><center><font color="red"><p>You are not authorized to view this class.</p></font></center></strong>
<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a></div>
<?php
}
}
}
else if(($wiziq->oldclasses)==1)
{
if($role=='6')// Role 6 is for guest
{
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view" >
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">

      <tr>
        <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>

      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.'&nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>';
            if($f==1)
			{
		   echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			}
			echo '<tr>
                <td colspan="2" align="center" valign="top" ><a href="javascript:void(0);"
			 onclick="return openDetails(\''.$wiziq->attendeeurl.'\');">Click here to enter class</a></td>
              </tr>
    </table></td>
  </tr>

  </form>
</table>';
}

if($role=='2') // Role 2 is for course creator
{
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view"  action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	<tr>
			<td colspan="2" align="center" valign="top" class="contact_bold"><h2 style="width:300px; float:left; margin-left:20px">'.$str.'</h2></td>
	</tr>
      <tr>
       <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>

      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>

              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.' &nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">';
			if($creditpending>0)
			{

				echo '<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
					  <input id="rdtypeno" name="chkRecording" type="radio" value="no" />No';
			}
			else if($creditpending==0)
			{
				echo '<input id="rdtypeyes" name="chkRecording" type="radio"  disabled="disabled"/>Yes
				<input id="rdtypeno" name="chkRecording" type="radio"  disabled="disabled"/>No';
			}
			 echo '</td>
              </tr>

			   <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Attendee URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->attendeeurl.' "  size="35px"/></td>
              </tr>';
			  if(strtolower($status)=="yes")
			  {
			  echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			  }

               echo '
      <td colspan="2" align="center" valign="top" class="contact_bold"><a href="javascript:void(0);"
			 onclick="return openDetails(\''.$wiziq->url.'\');">Click here to enter class</a></td>
      </tr>';
  if($creditpending>0)
			{
echo  '<tr><td colspan="2" align="center" valign="top" ><input type="submit" name="update" value="Update Class" id="name"/><input type="hidden" value="'.$eventid.'" name="eventid"/><input type="hidden" id="old" name="old" value="oldclass"/></td>
      </tr>';
			}

	  echo '

    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
	   <script language="javascript" type="text/javascript">
		var chk = "'.strtolower($status).'";
		if(chk == "no")
		{
			document.getElementById("rdtypeno").checked = "true";
		}
		else
		{
				document.getElementById("rdtypeyes").checked = "true";
		}
		</script>;

	  </td></tr>
  </form>
</table>';
?>

<div style="width:550px; float:left; margin-left:20px">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:80%;height:100px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php
}


if($role=='5')// Role 5 is for student
{

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view" >
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">

      <tr>
       <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>

      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.'&nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>';
            if($f==1)
			{
		   echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			}
			echo '<tr>
                <td colspan="2" align="center" valign="top" ><a href="javascript:void(0);"
			 onclick="return openDetails(\''.$wiziq->attendeeurl.'\');">Click here to enter class</a></td>
              </tr>
    </table></td>
  </tr>

  </form>
</table>';
}


if($role=='3') // Role 3 is for Teacher
{

    echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view"  action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	<tr>
			<td colspan="2" align="center" valign="top" class="contact_bold"><h2 style="width:300px; float:left; margin-left:20px">'.$str.'</h2></td>
	</tr>
      <tr>
        <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>

      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>

              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.' &nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">';
			if($creditpending>0)
			{

				echo '<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
					  <input id="rdtypeno" name="chkRecording" type="radio" value="no" />No';
			}
			else if($creditpending==0)
			{
				echo '<input id="rdtypeyes" name="chkRecording" type="radio"  disabled="disabled"/>Yes
				<input id="rdtypeno" name="chkRecording" type="radio"  disabled="disabled"/>No';
			}
			 echo '</td>
              </tr>

			   <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Attendee URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->attendeeurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			  if(strtolower($status)=="yes")
			  {
			  echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			  }

               echo '
      <td colspan="2" align="center" valign="top" class="contact_bold"><a href="javascript:void(0);"
			 onclick="return openDetails(\''.$wiziq->url.'\');">Click here to enter class</a></td>
      </tr>';
  if($creditpending>0)
			{
echo  '<tr><td colspan="2" align="center" valign="top" ><input type="submit" name="update" value="Update Class" id="name"/><input type="hidden" value="'.$eventid.'" name="eventid"/><input type="hidden" id="old" name="old" value="oldclass"/></td>
      </tr>';
			}

	  echo '

    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
	   <script language="javascript" type="text/javascript">
		var chk = "'.strtolower($status).'";
		if(chk == "no")
		{
			document.getElementById("rdtypeno").checked = "true";
		}
		else
		{
				document.getElementById("rdtypeyes").checked = "true";
		}
		</script>;

	  </td></tr>
  </form>
</table>';
?>
<div style="width:550px; float:left; margin-left:20px">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:80%;height:100px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php

}

if($role=='4') // non-editing teacher
{
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view" >
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">

      <tr>
        <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>

      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.'&nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>';
            if($f==1)
			{
		   echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			}
			echo '<tr>
                <td colspan="2" align="center" valign="top" ><a href="javascript:void(0);"
			 onclick="return openDetails(\''.$wiziq->attendeeurl.'\');">Click here to enter class</a></td>
              </tr>
    </table></td>
  </tr>

  </form>
</table>';
}

if($role=='1')
{

	 echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view"  action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	<tr>
			<td colspan="2" align="center" valign="top" class="contact_bold"><h2 style="width:300px; float:left; margin-left:20px">'.$str.'</h2></td>
	</tr>
      <tr>
        <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>

      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>

              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.' &nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">';
			if($creditpending>0)
			{

				echo '<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
				<input id="rdtypeno" name="chkRecording" type="radio" value="no" />No';
			}
			else if($creditpending==0)
			{
				echo '<input id="rdtypeyes" name="chkRecording" type="radio"  disabled="disabled"/>Yes
				<input id="rdtypeno" name="chkRecording" type="radio"  disabled="disabled"/>No';
			}
			 echo '</td>
              </tr>
             <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Presenter Link</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value="'.$wiziq->url.'"  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>

			    <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Attendee URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->attendeeurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			  if(strtolower($status)=="yes")
			  {
			  echo '<tr>

                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording Link</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value="'.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>

			  </tr>';
			  }

               echo '<tr>
        <td colspan="3" align="left" valign="top" ></td>
        </tr>
           <tr>
             <td colspan="2" align="center" valign="top" class="contact_bold"><a href="javascript:void(0);"
			 onclick="return openDetails(\''.$wiziq->url.'\');">Click here to enter class</a></td>
      </tr>
	  <tr><td></td></tr>';
  if($creditpending>0)
			{
echo  '<tr><td colspan="2" align="center" valign="top" ><input type="submit" name="update" value="Update Class" id="name"/><input type="hidden" value="'.$eventid.'" name="eventid"/><input type="hidden" id="old" name="old" value="oldclass"/></td>
      </tr>';
			}

	  echo '
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr><tr><td>
	   <script language="javascript" type="text/javascript">

		var chk = "'.strtolower($status).'";

		if(chk == "no")
		{
			document.getElementById("rdtypeno").checked = "true";
		}
		else
		{
				document.getElementById("rdtypeyes").checked = "true";
		}

		</script>

	  </td></tr>
  </form>

</table>';
?>
<div style="width:550px; float:left; margin-left:20px">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:80%;height:100px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php

}
}
echo '</td>
</tr>
</table>';
 echo '</div>';
    echo '</td>';

    // START: Last column (3-month display)

    $defaultcourses = calendar_get_default_courses();
    calendar_set_filters($courses, $groups, $users, $defaultcourses, $defaultcourses);

    // when adding an event you can not be a guest, so I think it's reasonalbe to ignore defaultcourses
    // MDL-10353
    calendar_set_filters($courses, $groups, $users);
    list($prevmon, $prevyr) = calendar_sub_month($mon, $yr);
    list($nextmon, $nextyr) = calendar_add_month($mon, $yr);

    echo '<td class="sidecalendar">';
    echo '<div class="sideblock">';
    echo '<div class="header">'.get_string('monthlyview', 'calendar').'</div>';
    echo '<div class="minicalendarblock minicalendartop">';
    echo calendar_top_controls('display', array('id' => $urlcourse, 'm' => $prevmon, 'y' => $prevyr));
    echo calendar_get_mini($courses, $groups, $users, $prevmon, $prevyr);
    echo '</div><div class="minicalendarblock">';
    echo calendar_top_controls('display', array('id' => $urlcourse, 'm' => $mon, 'y' => $yr));
    echo calendar_get_mini($courses, $groups, $users, $mon, $yr);
    echo '</div><div class="minicalendarblock">';
    echo calendar_top_controls('display', array('id' => $urlcourse, 'm' => $nextmon, 'y' => $nextyr));
    echo calendar_get_mini($courses, $groups, $users, $nextmon, $nextyr);
    echo '</div>';
    echo '</div>';

    echo '</td>';
    echo '</tr></table>';
	/*echo '<script language="javascript" type="text/javascript">

var chk = "'.$status.'";

if(chk == "unchecked")
{

	document.getElementById("rdtypeyes").checked = "false";
	document.getElementById("rdtypeno").checked = "true";
}
else
{
	document.getElementById("rdtypeyes").checked = "true";

}

</script>';*/

/// Finish the page
    print_footer($course);

	function validate_form(&$form, &$err) {

    $form->name = trim($form->name);
    $form->description = trim($form->description);

    if(empty($form->name)) {
        $err['name'] = get_string('errornoeventname', 'calendar');
    }
/* Allow events without a description
    if(empty($form->description)) {
        $err['description'] = get_string('errornodescription', 'calendar');
    }
*/
    if(!checkdate($form->startmon, $form->startday, $form->startyr)) {
        $err['timestart'] = get_string('errorinvaliddate', 'calendar');
    }
    if($form->duration == 2 and !checkdate($form->endmon, $form->endday, $form->endyr)) {
        $err['timeduration'] = get_string('errorinvaliddate', 'calendar');
    }
    if($form->duration == 2 and !($form->minutes > 0 and $form->minutes < 1000)) {
        $err['minutes'] = get_string('errorinvalidminutes', 'calendar');
    }
    if (!empty($form->repeat) and !($form->repeats > 1 and $form->repeats < 100)) {
        $err['repeats'] = get_string('errorinvalidrepeats', 'calendar');
    }
    if(!empty($form->courseid)) {
        // Timestamps must be >= course startdate
        $course = get_record('course', 'id', $form->courseid);
        if($course === false) {
            error('Event belongs to invalid course');
        }
        else if($form->timestart < $course->startdate) {
            $err['timestart'] = get_string('errorbeforecoursestart', 'calendar');
        }
    }
}

function calendar_add_event_allowed($event) {
    global $USER;

    // can not be using guest account
    if (empty($USER->id) or $USER->username == 'guest') {
        return false;
    }

    $sitecontext = get_context_instance(CONTEXT_SYSTEM);
    // if user has manageentries at site level, always return true
    if (has_capability('moodle/calendar:manageentries', $sitecontext)) {
        return true;
    }

    switch ($event->type) {
        case 'course':
            return has_capability('moodle/calendar:manageentries', get_context_instance(CONTEXT_COURSE, $event->courseid));

        case 'group':
            // Allow users to add/edit group events if:
            // 1) They have manageentries (= entries for whole course)
            // 2) They have managegroupentries AND are in the group
            $group = get_record('groups', 'id', $event->groupid);
            return $group && (
                has_capability('moodle/calendar:manageentries', get_context_instance(CONTEXT_COURSE, $group->courseid)) ||
                (has_capability('moodle/calendar:managegroupentries', get_context_instance(CONTEXT_COURSE, $group->courseid))
                    && groups_is_member($event->groupid)));

        case 'user':
            if ($event->userid == $USER->id) {
                return (has_capability('moodle/calendar:manageownentries', $sitecontext));
            }
            //there is no 'break;' intentionally

        case 'site':
            return has_capability('moodle/calendar:manageentries', get_context_instance(CONTEXT_COURSE, SITEID));

        default:
            return false;
    }
}

?>
</body>