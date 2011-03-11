<head>
<style>
.m_12b585858{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
text-decoration:none;
font-weight:bold;
color:#323232;
padding-right:10px;
}
.m_12b{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
text-decoration:none;
color:#333;
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

	font-family:Arial, Helvetica, sans-serif;

	font-weight:normal;
	color:#FF0000;
}
.error{

	font-family:Arial, Helvetica, sans-serif;

	font-weight:normal;
	color:#FF0000;
}
.ulink{text-decoration:underline; font-weight:bold; font-size:12px}
.ulink:hover{text-decoration:none;font-weight:bold;font-size:12px}
.m_textinput{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
text-decoration: none;
font-weight:normal;
color:#666666;
height:20px;
border-style:solid;
border-width:1px;
border-color:#CCCCCC;
width:270px;
padding-top:3px;
}
</style>
<script language="JavaScript">
function DisableRecordClass()
{
	var status=document.getElementById("statusrecording").value;

	if(status==0)
	{
	document.getElementById("rdtypeyes").disabled="disabled";
	document.getElementById("rdtypeno").disabled="disabled";
	}
}
</script>
<script type="text/javascript" language="javascript">
 function openDetails(Url)
    {

        var scheight=screen.height;
        var scwidth=screen.width;
        var w=window.open(Url, null, "left=0,top=0,resize=0, height="+scheight+", width="+scwidth);
		w.opener=window;
		w.focus();
		return false;
    }
		// Title: Tigra Calendar
// URL: http://www.softcomplex.com/products/tigra_calendar/
// Version: 3.3 (American date format)
// Date: 09/01/2005 (mm/dd/yyyy)
// Note: Permission given to use this script in ANY kind of applications if
//    header lines are left unchanged.
// Note: Script consists of two files: calendar?.js and calendar.html

// if two digit year input dates after this year considered 20 century.
var NUM_CENTYEAR = 30;
// is time input control required by default
var BUL_TIMECOMPONENT = false;
// are year scrolling buttons required by default
var BUL_YEARSCROLL = true;

var calendars = [];
var RE_NUM = /^\-?\d+$/;

function calendar2(obj_target) {

	// assigning methods
	this.gen_date = cal_gen_date2;
	this.gen_time = cal_gen_time2;
	this.gen_tsmp = cal_gen_tsmp2;
	this.prs_date = cal_prs_date2;
	this.prs_time = cal_prs_time2;
	this.prs_tsmp = cal_prs_tsmp2;
	this.popup    = cal_popup2;

	// validate input parameters
	if (!obj_target)
		return cal_error("Error calling the calendar: no target control specified");
	if (obj_target.value == null)
		return cal_error("Error calling the calendar: parameter specified is not valid target control");
	this.target = obj_target;
	this.time_comp = BUL_TIMECOMPONENT;
	this.year_scroll = BUL_YEARSCROLL;

	// register in global collections
	this.id = calendars.length;
	calendars[this.id] = this;
}

function cal_popup2 (str_datetime) {
	if (str_datetime) {
		this.dt_current = this.prs_tsmp(str_datetime);
	}
	else {
		this.dt_current = this.prs_tsmp(this.target.value);
		this.dt_selected = this.dt_current;
	}
	if (!this.dt_current) return;

	var obj_calwindow = window.open(
		'calendar.html?datetime=' + this.dt_current.valueOf()+ '&id=' + this.id,
		'Calendar', 'width=230,height='+(this.time_comp ? 315 : 250)+
		',status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes'
	);
	obj_calwindow.opener = window;
	obj_calwindow.focus();
}

// timestamp generating function
function cal_gen_tsmp2 (dt_datetime) {
	return(this.gen_date(dt_datetime) + ' ' + this.gen_time(dt_datetime));
}

// date generating function
function cal_gen_date2 (dt_datetime) {
	return (
		(dt_datetime.getMonth() < 9 ? '0' : '') + (dt_datetime.getMonth() + 1) + "/"
		+ (dt_datetime.getDate() < 10 ? '0' : '') + dt_datetime.getDate() + "/"
		+ dt_datetime.getFullYear()
	);
}
// time generating function
function cal_gen_time2 (dt_datetime) {
	return (
		(dt_datetime.getHours() < 10 ? '0' : '') + dt_datetime.getHours() + ":"
		+ (dt_datetime.getMinutes() < 10 ? '0' : '') + (dt_datetime.getMinutes()) + ":"
		+ (dt_datetime.getSeconds() < 10 ? '0' : '') + (dt_datetime.getSeconds())
	);
}

// timestamp parsing function
function cal_prs_tsmp2 (str_datetime) {
	// if no parameter specified return current timestamp
	if (!str_datetime)
		return (new Date());

	// if positive integer treat as milliseconds from epoch
	if (RE_NUM.exec(str_datetime))
		return new Date(str_datetime);

	// else treat as date in string format
	var arr_datetime = str_datetime.split(' ');
	return this.prs_time(arr_datetime[1], this.prs_date(arr_datetime[0]));
}

// date parsing function
function cal_prs_date2 (str_date) {

	var arr_date = str_date.split('/');

	if (arr_date.length != 3) return alert ("Invalid date format: '" + str_date + "'.\nFormat accepted is dd-mm-yyyy.");
	if (!arr_date[1]) return alert ("Invalid date format: '" + str_date + "'.\nNo day of month value can be found.");
	if (!RE_NUM.exec(arr_date[1])) return alert ("Invalid day of month value: '" + arr_date[1] + "'.\nAllowed values are unsigned integers.");
	if (!arr_date[0]) return alert ("Invalid date format: '" + str_date + "'.\nNo month value can be found.");
	if (!RE_NUM.exec(arr_date[0])) return alert ("Invalid month value: '" + arr_date[0] + "'.\nAllowed values are unsigned integers.");
	if (!arr_date[2]) return alert ("Invalid date format: '" + str_date + "'.\nNo year value can be found.");
	if (!RE_NUM.exec(arr_date[2])) return alert ("Invalid year value: '" + arr_date[2] + "'.\nAllowed values are unsigned integers.");

	var dt_date = new Date();
	dt_date.setDate(1);

	if (arr_date[0] < 1 || arr_date[0] > 12) return alert ("Invalid month value: '" + arr_date[0] + "'.\nAllowed range is 01-12.");
	dt_date.setMonth(arr_date[0]-1);

	if (arr_date[2] < 100) arr_date[2] = Number(arr_date[2]) + (arr_date[2] < NUM_CENTYEAR ? 2000 : 1900);
	dt_date.setFullYear(arr_date[2]);

	var dt_numdays = new Date(arr_date[2], arr_date[0], 0);
	dt_date.setDate(arr_date[1]);
	if (dt_date.getMonth() != (arr_date[0]-1)) return alert ("Invalid day of month value: '" + arr_date[1] + "'.\nAllowed range is 01-"+dt_numdays.getDate()+".");

	return (dt_date)
}

// time parsing function
function cal_prs_time2 (str_time, dt_date) {

	if (!dt_date) return null;
	var arr_time = String(str_time ? str_time : '').split(':');

	if (!arr_time[0]) dt_date.setHours(0);
	else if (RE_NUM.exec(arr_time[0]))
		if (arr_time[0] < 24) dt_date.setHours(arr_time[0]);
		else return cal_error ("Invalid hours value: '" + arr_time[0] + "'.\nAllowed range is 00-23.");
	else return cal_error ("Invalid hours value: '" + arr_time[0] + "'.\nAllowed values are unsigned integers.");

	if (!arr_time[1]) dt_date.setMinutes(0);
	else if (RE_NUM.exec(arr_time[1]))
		if (arr_time[1] < 60) dt_date.setMinutes(arr_time[1]);
		else return cal_error ("Invalid minutes value: '" + arr_time[1] + "'.\nAllowed range is 00-59.");
	else return cal_error ("Invalid minutes value: '" + arr_time[1] + "'.\nAllowed values are unsigned integers.");

	if (!arr_time[2]) dt_date.setSeconds(0);
	else if (RE_NUM.exec(arr_time[2]))
		if (arr_time[2] < 60) dt_date.setSeconds(arr_time[2]);
		else return cal_error ("Invalid seconds value: '" + arr_time[2] + "'.\nAllowed range is 00-59.");
	else return cal_error ("Invalid seconds value: '" + arr_time[2] + "'.\nAllowed values are unsigned integers.");

	dt_date.setMilliseconds(0);
	return dt_date;
}

function cal_error (str_message) {
	alert (str_message);
	return null;
}

		//var cal2 = new calendar2(document.forms['form'].elements['id_date']);
			//	cal2.year_scroll = false;
				//cal2.time_comp = false;
					</script>
<script language = "Javascript">
/**
 * DHTML date validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */
// Declaring valid date character, minimum year and maximum year
var dtCh= "/";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   }
   return this
}

function isDate(dtStr){
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strMonth=dtStr.substring(0,pos1)
	var strDay=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		return false
	}
return true
}
String.prototype.Trim = function()
		{
		return this.replace(/(^\s*)|(\s*$)/g, "");
		}
function ValidateForm(element)
{
	var dt=element;
	var timeUser=document.getElementById('time').value;
	if(timeUser!="")
	{
		
		
		timeUser=timeUser.trim();
		var Length=timeUser.length;
		var ampm=timeUser.substring((Length-2));
		ampm=ampm.toUpperCase();
		var Time=timeUser.substring(0,(Length-2))
		var index=Time.indexOf(':');
		var hh="";
		if(index>0)
		{
		hh=Time.substring(0,index);
		if(hh<10)
		hh="0"+parseInt(hh)+Time.substring(index);
		else
		hh=parseInt(hh)+Time.substring(index);
		}
		else
		{
		if(hh<10)
		hh="0"+Time+":00"	
		else
		hh=Time+":00"	
		}
		//alert(hh);
		var UserDateTime=element.value+" "+hh+" "+ampm;
		
		var MoodleDateTime=document.getElementById('MoodleDateTime').value;
		
		var Date1 = new Date(MoodleDateTime);
		var Date2 = new Date(UserDateTime);
		//alert(Date1+">"+Date2);
		 if (Date2 < Date1)
		 {
			return false;
		 }
		
	}

	if (isDate(dt.value)==false)
	{
		dt.focus()
		return false
	}
	
   
 }

function IsValidTime(time) {
// Checks if time is in HH:MM:SS AM/PM format.
// The seconds and AM/PM are optional.
var timeStr=time.value;
var _qfMsg='';
if(timeStr=="")
{
_qfMsg ='Please enter the time ';

return qf_errorHandler(time, _qfMsg);
}
else if(timeStr != '')
{
var timePat = /^((([0-1][0-2]|[1-9]|[0-0][1-9]):([0-5][0-9]))|([0-1][0-2]|[1-9]))((am|pm)|(AM|PM)|( AM| PM)|( am| pm))$/;

var matchArray = timeStr.match(timePat);
if (matchArray == null) {
_qfMsg ='Please enter the correct format of time ';

return qf_errorHandler(time, _qfMsg);
}
else
{
	clearMessage("id_error_time");
	return true;
}

}
//hour = matchArray[1];
//minute = matchArray[2];
//
//ampm = matchArray[3];
//
//
//if (second=="") { second = null; }
//if (ampm=="") { ampm = null }
//
//if (hour < 0  || hour > 23) {
//alert("Hour must be between 1 and 12. (or 0 and 23 for military time)");
//return false;
//}
//if (hour <= 12 && ampm == null) {
//if (confirm("Please indicate am or pm")) {
//alert("You must specify am or pm.");
//return false;
//   }
//}
//if  (hour > 12 && ampm != null) {
//alert("You can't specify am or pm for military time.");
//return false;
//}
//if (minute<0 || minute > 59) {
//alert ("Minute must be between 0 and 59.");
//return false;
//}
//if (second != null && (second < 0 || second > 59)) {
//alert ("Second must be between 0 and 59.");
//return false;
//}
return true;
}


//<![CDATA[

function qf_errorHandler(element, _qfMsg) {
  div = element.parentNode;

  if (_qfMsg != '') {
    var errorSpan = document.getElementById('id_error_'+element.name);
    if (!errorSpan) {
      errorSpan = document.createElement("span");
      errorSpan.id = 'id_error_'+element.name;
      errorSpan.className = "perror";
     // element.parentNode.insertBefore(errorSpan, element.parentNode.firstChild);
	 element.parentNode.appendChild(errorSpan);

    }

    while (errorSpan.firstChild) {
      errorSpan.removeChild(errorSpan.firstChild);
    }

    errorSpan.appendChild(document.createTextNode(_qfMsg));
    errorSpan.appendChild(document.createElement("br"));

   // if (div.className.substr(div.className.length - 6, 6) != " error"
//        && div.className != "error") {
//      div.className += " perror";
//    }

    return false;
  } else {
    var errorSpan = document.getElementById('id_error_'+element.name);
    if (errorSpan) {
      errorSpan.parentNode.removeChild(errorSpan);
    }

    if (div.className.substr(div.className.length - 6, 6) == " error") {
      div.className = div.className.substr(0, div.className.length - 6);
    } else if (div.className == "error") {
      div.className = "";
    }

    return true;
  }
}


function validate_mod_wiki_mod_form_name(element) {

var _qfMsg='';
 var value = element.value;

  if (value == '') {

    	_qfMsg ='Please enter class title';
 		return qf_errorHandler(element, _qfMsg);
  }
  else if(value != ''){

		clearMessage("id_error_name");
	  	return true;
  }

}

function clearMessage(elementID)
{
	if(document.getElementById(elementID))
		document.getElementById(elementID).innerHTML="";
}

function validate_mod_wiki_mod_form_duration(element) {
var maxdur=document.getElementById('maxDuration').value;
 var _qfMsg='';
//value=document.form.duration.value;

var value=element.value;

  if (value == '') {

    _qfMsg ='Please enter duration';
 return qf_errorHandler(element, _qfMsg);
  }
else if(value != '')
{
	if (isNaN(value))
	{
		_qfMsg="Please enter duration in numeric only";
         return qf_errorHandler(element, _qfMsg);
    }
	else
	{
				if(value<30 || value >parseInt(maxdur))
				{
					_qfMsg ='Please enter duration between 30 and '+maxdur;
			 return qf_errorHandler(element, _qfMsg);
				}
				else
				{
					clearMessage("id_error_duration");
				  	return true;
				}


	}
}

}

function validate_mod_wiki_mod_form_date(element) {

var _qfMsg='';


	//var emailID=document.form.date;
	//alert(emailID.value);
	if (element.value=="")
	{
		_qfMsg ='Please enter the Date ';

 		return qf_errorHandler(element, _qfMsg);


	}
	else if(element.value != '')
	{
	if (ValidateForm(element)==false)
	{
		
		_qfMsg ='Date/time cannot be less than the current date/time ';

 		return qf_errorHandler(element, _qfMsg);
	}
	else
	{
		clearMessage("id_error_date");
	    return true;

	}
	}
}

function validate_mod_wiki_mod_form(form) {


		var isNameValid = validate_mod_wiki_mod_form_name(form.elements['name']);
  		var isDateValid = validate_mod_wiki_mod_form_date(form.elements['date']);
	    var isTimeValid = IsValidTime(form.elements['time']);
	    var isDurationValid = validate_mod_wiki_mod_form_duration(form.elements['duration']);


 	return (isNameValid && isDateValid && isTimeValid && isDurationValid);
}
//]]>
</script>
</head>

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
$eventtype=$_REQUEST['eventtype'];
$type=$_REQUEST['type'];
//echo "value is ".$type;
					 if($type=="yes"||$type==1)
					 {
						 $flag=1;
					 }
					 if($type=="no"||$type==0)
					 {
						 $flag=0;
					 }

					 //echo "value of type posted".$type;

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




$view = optional_param('view', 'upcoming', PARAM_ALPHA);
    $day  = optional_param('cal_d', 0, PARAM_INT);
    $mon  = optional_param('cal_m', 0, PARAM_INT);
    $yr   = optional_param('cal_y', 0, PARAM_INT);

    $id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
    $a  = optional_param('a', 0, PARAM_INT);  // wizq ID

    $urlcourse = optional_param('course', 0, PARAM_INT);
	$id=$_REQUEST['id'];
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

    require_login($course->id);

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
$todaydate=usergetdate(time());
  
  if($todaydate['hours']>12)
  {
  $hours=intval($todaydate['hours'])-12;
  $ampm="PM";
  }
  else
  {
  $hours=$todaydate['hours'];
  $ampm="AM";
  }
  $DatetimeUser=$todaydate['mon']."/".$todaydate['mday']."/".$todaydate['year']." ".$hours.":".$todaydate['minutes']." ".$ampm ;
echo '<input type="hidden" id="MoodleDateTime" value="'.$DatetimeUser.'" />';

$usr = $USER->username;
$email = $USER->email;
$times=$wiziq->wdate;
$timezone=$wiziq->timezone;
$id=$USER->id;

$wtime=calendar_time_representation($times);
$udate=usergetdate($times);

 $m=$udate['mon'];
 $y=$udate['year'];
 $d=$udate['mday'];
$wdate=$m."/".$d."/".$y;



list($hh, $mm, $ampm)=split('[\\:/.-]', addcslashes($wtime,'A,P'));

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
	//$tmzone=get_user_timezone_offset($tmzone);
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
$timezone="GMT-12:30";
break;
}
case("-12.0"):
{
$timezone="GMT-12";
break;
}

case("-11.5"):
{
$timezone="GMT-11:30";
break;
}

case("-11.0"):
{
$timezone="GMT-11";
break;
}
case("-10.5"):
{
$timezone="GMT-10:30";
break;
}
case("-10.0"):
{
$timezone="GMT-10";
break;
}

case("-9.5"):
{
$timezone="GMT-9:30";
break;
}

case("-9.0"):
{
$timezone="GMT-9";
break;
}

case("-8.5"):
{
$timezone="GMT-8:30";
break;
}

case("-8.0"):
{
$timezone="GMT-8";
break;
}
case("-7.5"):
{
$timezone="GMT-7:30";
break;
}

case("-7.0"):
{
$timezone="GMT-7";
break;
}

case("-6.5"):
{
$timezone="GMT-6:30";
break;
}
case("-6.0"):
{
$timezone="GMT-6";
break;
}
case("-5.5"):
{
$timezone="GMT-5:30";
break;
}
case("-5.0"):
{
$timezone="GMT-5";
break;
}
case("-4.5"):
{
$timezone="GMT-4:30";
break;
}
case("-4.0"):
{
$timezone="GMT-4";
break;
}
case("-3.5"):
{
$timezone="GMT-3:30";
break;
}
case("-3.0"):
{
$timezone="GMT-3";
break;
}
case("-2.5"):
{
$timezone="GMT-2:30";
break;
}
case("-2.0"):
{
$timezone="GMT-2";
break;
}
case("-1.5"):
{
$timezone="GMT-1:30";
break;
}
case("-1.0"):
{
$timezone="GMT-1";
break;
}
case("-0.5"):
{
$timezone="GMT-0:30";
break;
}
case("0.0"):
{
$timezone="GMT";
break;
}
case("0.5"):
{
$timezone="GMT+0:30";
break;
}
case("1.0"):
{
$timezone="GMT+1";
break;
}
case("1.5"):
{
$timezone="GMT+1:30";
break;
}
case("2.0"):
{
$timezone="GMT+2";
break;
}
case("2.5"):
{
$timezone="GMT+2:30";
break;
}
case("3.0"):
{
$timezone="GMT+3";
break;
}
case("3.5"):
{
$timezone="GMT+3:30";
break;
}
case("4.0"):
{
$timezone="GMT+4";
break;
}
case("4.5"):
{
$timezone="GMT+4:30";
break;
}
case("5.0"):
{
$timezone="GMT+5";
break;
}
case("5.5"):
{
$timezone="GMT+5:30";
break;
}
case("6.0"):
{
$timezone="GMT+6";
break;
}
case("6.5"):
{
$timezone="GMT+6:30";
break;
}
case("7.0"):
{
$timezone="GMT+7";
break;
}
case("7.5"):
{
$timezone="GMT+7:30";
break;
}
case("8.0"):
{
$timezone="GMT+8";
break;
}
case("8.5"):
{
$timezone="GMT+8:30";
break;
}
case("9.0"):
{
$timezone="GMT+9";
break;
}
case("9.5"):
{
$timezone="GMT+9:30";
break;
}
case("10.0"):
{
$timezone="GMT+10";
break;
}
case("10.5"):
{
$timezone="GMT+10:30";
break;
}
case("11.0"):
{
$timezone="GMT+11";
break;
}
case("11.5"):
{
$timezone="GMT+11:30";
break;
}
case("12.0"):
{
$timezone="GMT+12";
break;
}
case("12.5"):
{
$timezone="GMT+12:30";
break;
}
case("13.0"):
{
$timezone="GMT+13";
break;
}
default:
  {
$timezone="GMT-06:00";
  }
}
}

echo '<input type="hidden" id="statusrecording" value="'.$wiziq->statusrecording.'"/> <input type="hidden" id="maxDuration" value="'.$maxdur.'"/>';

if($flag==1)
{
	$status="checked";
}
else if($flag==0)
{
	$status="unchecked";

}
if ($flag==null)
{
	$f=$wiziq->statusrecording;
	if($f==1)
	{
		$status="checked";
	}
	if($f==0)
	{
		$status="unchecked";
	}

}
if($USER->id==2)
{
$role=1;
}
else
{
 $query="select ra.roleid from ".$CFG->prefix."context,".$CFG->prefix."role_assignments ra where ".$CFG->prefix."context.id=ra.contextid and ra.userid=".$USER->id." and (".$CFG->prefix."context.instanceid=".$COURSE->id ." or ".$CFG->prefix."context.instanceid=". 0 .")";

$rows=array();
$qq=mysql_query($query);

$i=0;
while($rows=mysql_fetch_array($qq))
{
$resultant[$i]=$rows['roleid'];
$i++;
}

sort($resultant);
 $role=$resultant[0];
}
$insescod=$wiziq->insescod;
$qry=mysql_query("select id from ".$CFG->prefix."wiziq where insescod=$insescod");
$rs = mysql_fetch_array($qry);
$eventid=$rs['id'];
//checking if admin allow attendee or student to record class
$f=$wiziq->statusrecording;
echo '<table width="100%">
<tr>
<td valign="top" align="left" >
<span style="margin-top:-0px; float:left">
';
include("sideblock.php");
echo '</span></td><td>';
if($USER->id==1)
{

$role='6';
}

if($role=='2') // course creator
{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view"  action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr><td colspan="2" valign="top" align="left" style="font-weight:bold">Edit WiZiQ Live Class</td></tr>
        <tr>
        <td width="20%" align="right" valign="middle" class="m_12b585858">Type of Event: </td>
        <td colspan="2" align="left" valign="middle" class="m_12b">'.$eventtype.'</td>
        </tr>
      <tr>
         <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Title</strong>:</td>
        <td  colspan="2" align="left" valign="middle" class="m_12b585858"><div id="id_name"><input name="name" type="text" class="m_textinput" id="name" onblur="validate_mod_wiki_mod_form_name(this)" onchange="validate_mod_wiki_mod_form_name(this)"  value="'.$wiziq->name.'" /></div>
	</td>
        </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Date</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><div id="id_date"><input name="date" type="text" class="m_textinput" id="date" value="'.$wdate.'" readonly="true"/><a href="javascript:var cal2 = new calendar2(document.view.date);cal2.popup();">&nbsp;<img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></div></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="m_12b585858"  style="padding-top:17px"><strong>Time</strong>:</td>
       <td colspan="2" align="left" valign="middle" class="m_12b585858"><div id="id_time"><input name="time" class="m_textinput" type="text" onblur="IsValidTime(this)" onchange="IsValidTime(this)" id="time" value="'.$wtime.'"/></div>e.g. 6:30am or 4 PM </td>
              </tr>

              <tr>
                <td align="right" valign="top" class="m_12b585858"  style="padding-top:17px"><strong>Duration</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><div id="id_duration"><input name="duration" class="m_textinput" type="text" onblur="validate_mod_wiki_mod_form_duration(this)" onchange="validate_mod_wiki_mod_form_duration(this)" id="duration" value="'.$wiziq->wdur.'" maxlength="3"/></div><span style="font-size:10px">(max. '.$maxdur.' mins )</span>
       </td>
              </tr>
			   <tr>
			   <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Timezone</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858">'.$timezone.'</td>
			 </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Type</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><input name="audio" type="radio" id="video" value="Video" />
		    Audio and Video <input name="audio" id="audio" type="radio" value="Audio" checked="checked"/>
		    Audio</td><td><script language="javascript" type="text/javascript">
		var chk = "'.$wiziq->wtype.'";
		if(chk == "Audio")
		{
			document.getElementById("audio").checked = "true";
		}
		else
		{
			document.getElementById("video").checked = "true";
		}

		</script></td></td>
              </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td colspan="2" align="left" valign="middle" class="m_12b585858">
			<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
					  <input id="rdtypeno" name="chkRecording" type="radio" value="no" />No
			</td>
              </tr>
      <tr><td width="20%"></td>
	  <td  colspan="2" align="left" valign="middle" ><input type="submit" name="update" value="Update" id="Update" onclick="return validate_mod_wiki_mod_form(this.form)"/><input type="hidden" value="'.$eventid.'" name="eventid"/>
	  <a href="javascript:history.go(-1)" ><span class="ulink" style="margin-left:13px">Cancel</span></a></td>
	  </tr>
    </table></td>
  </tr>
    <tr><td>
	   <script language="javascript" type="text/javascript">
		var chk = "'.$status.'";
		if(chk == "unchecked")
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
<div style="width:550px; float:left;">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:520px;height:125px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php

}

if($role=='3') // Role 3 is for Teacher
{

    echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view"  action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr><td colspan="2" valign="top" align="left" style="font-weight:bold">Edit WiZiQ Live Class</td></tr>
        <tr>
        <td width="20%" align="right" valign="middle" class="m_12b585858">Type of Event: </td>
        <td colspan="2" align="left" valign="middle" class="m_12b">'.$eventtype.'</td>
        </tr>
      <tr>
         <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Title</strong>:</td>
        <td  colspan="2" align="left" valign="middle" class="m_12b585858"><div id="id_name"><input name="name" type="text" class="m_textinput" id="name" onblur="validate_mod_wiki_mod_form_name(this)" onchange="validate_mod_wiki_mod_form_name(this)"  value="'.$wiziq->name.'" /></div></td>
        </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Date</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><div id="id_date"><input name="date" type="text" class="m_textinput" id="date" value="'.$wdate.'" readonly="true"/><a href="javascript:var cal2 = new calendar2(document.view.date);cal2.popup();">&nbsp;<img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></div></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="m_12b585858"  style="padding-top:17px"><strong>Time</strong>:</td>
       <td colspan="2" align="left" valign="middle" class="m_12b585858"><div id="id_time"><input name="time" class="m_textinput" type="text" onblur="IsValidTime(this)" onchange="IsValidTime(this)" id="time" value="'.$wtime.'"/></div>e.g. 6:30am or 4 PM </td>
              </tr>

              <tr>
                <td align="right" valign="top" class="m_12b585858"  style="padding-top:17px"><strong>Duration</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><div id="id_duration"><input name="duration" class="m_textinput" type="text" onblur="validate_mod_wiki_mod_form_duration(this)" onchange="validate_mod_wiki_mod_form_duration(this)" id="duration" value="'.$wiziq->wdur.'" maxlength="3"/></div><span style="font-size:10px">(max. '.$maxdur.' mins )</span>
       </td>
              </tr>
			   <tr>
			   <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Timezone</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858">'.$timezone.'</td>
			 </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Type</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><input name="audio" type="radio" id="video" value="Video" />
		    Audio and Video <input name="audio" id="audio" type="radio" value="Audio" checked="checked"/>
		    Audio</td><td><script language="javascript" type="text/javascript">
		var chk = "'.$wiziq->wtype.'";
		if(chk == "Audio")
		{
			document.getElementById("audio").checked = "true";
		}
		else
		{
				document.getElementById("video").checked = "true";
		}

		</script></td></td>
              </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td colspan="2" align="left" valign="middle" class="m_12b585858">
			<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
					  <input id="rdtypeno" name="chkRecording" type="radio" value="no" />No
					  </td>
              </tr>
      <tr><td width="20%"></td>
	  <td  colspan="2" align="left" valign="middle" ><input type="submit" name="update" value="Update" id="Update" onclick="return validate_mod_wiki_mod_form(this.form)"/><input type="hidden" value="'.$eventid.'" name="eventid"/>
	  <a href="javascript:history.go(-1)" ><span class="ulink" style="margin-left:13px">Cancel</span></a></td>
	  </tr>

    </table></td>
  </tr>
    <tr><td>
	   <script language="javascript" type="text/javascript">
		var chk = "'.$status.'";
		if(chk == "unchecked")
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
<div style="width:550px; float:left;">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:520px;height:125px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php

}

if($role=='1')
{

	 echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view" id="form1" action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">

      <tr><td colspan="2" valign="top" align="left" style="font-weight:bold">Edit WiZiQ Live Class</td></tr>
        <tr>
        <td width="20%" align="right" valign="middle" class="m_12b585858">Type of Event: </td>
        <td colspan="2" align="left" valign="middle" class="m_12b">'.$eventtype.'</td>
        </tr>
      <tr>
         <td width="20%" align="right" valign="middle" class="m_12b585858"><span style="font-weight:bold; font-size:14px">*</span>Title:</td>
        <td  colspan="2" align="left" valign="middle" class="m_12b585858"><input name="name" type="text" class="m_textinput" id="name"  onblur="validate_mod_wiki_mod_form_name(this)" onchange="validate_mod_wiki_mod_form_name(this)"  value="'.$wiziq->name.'" /><div id="id_name"></div>

		</td>

		</tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><span style="font-weight:bold; font-size:14px">*</span>Date:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><input name="date" type="text" class="m_textinput" id="date"  value="'.$wdate.'" readonly="true"/><a href="javascript:var cal2 = new calendar2(document.view.date);cal2.popup();">&nbsp;<img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a><div id="id_date"></div></td>
              </tr>
              <tr>
                <td width="20%"  align="right" valign="top" class="m_12b585858"  style="padding-top:17px"><span style="font-weight:bold; font-size:14px">*</span>Time:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><div>e.g. 6:30am or 4 PM</div><input name="time" class="m_textinput" type="text" onblur="IsValidTime(this)" onchange="IsValidTime(this)" id="time" value="'.$wtime.'"/><div id="id_time"> </div></td>
              </tr>

              <tr>
                <td width="20%"  align="right" valign="top" class="m_12b585858"  style="padding-top:17px"><span style="font-weight:bold; font-size:14px">*</span>Duration:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><div><span style="font-size:10px">(max. '.$maxdur.' mins )</span></div><input name="duration" class="m_textinput" type="text" onblur="validate_mod_wiki_mod_form_duration(this)" onchange="validate_mod_wiki_mod_form_duration(this)" id="duration" value="'.$wiziq->wdur.'" maxlength="3"/><div id="id_duration"></div>
       </td>
              </tr>
			   <tr>
			   <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Timezone</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858">'.$timezone.'</td>
			 </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Type</strong>:</td>
        <td colspan="2" align="left" valign="middle" class="m_12b585858"><input name="audio" type="radio" id="video" value="Video" />
		    Audio and Video <input name="audio" id="audio" type="radio" value="Audio" checked="checked"/>
		    Audio</td><td><script language="javascript" type="text/javascript">
		var chk = "'.$wiziq->wtype.'";
		if(chk == "Audio")
		{
			document.getElementById("audio").checked = "true";
		}
		else
		{
				document.getElementById("video").checked = "true";
		}

		</script></td></td>
              </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td colspan="2" align="left" valign="middle" class="m_12b585858">

				<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
				<input id="rdtypeno" name="chkRecording" type="radio" value="no" />No

			</td>
              </tr>
            <tr><td width="20%"  ></td>
	  <td  colspan="2" align="left" valign="middle" ><input type="submit" name="update" value="Update" id="Update" onclick="return validate_mod_wiki_mod_form(this.form);"/><input type="hidden" value="'.$eventid.'" name="eventid"/>
	  <a href="javascript:history.go(-1)" ><span class="ulink" style="margin-left:13px">Cancel</span></a></td>
	  </tr>
    </table></td>
  </tr>
  <tr><td>
	   <script language="javascript" type="text/javascript">
		var chk = "'.$status.'";
		if(chk == "unchecked")
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
<div style="width:550px; float:left;">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:520px;height:125px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php

}
echo '</td>
</tr>
</table>';
 echo '</div>';
    echo '</td>';

    // END: Main column
    // START: Last column (3-month display)
    echo '<td class="sidecalendar">';
    echo '<div class="header">'.get_string('monthlyview', 'calendar').'</div>';

    list($prevmon, $prevyr) = calendar_sub_month($mon, $yr);
    list($nextmon, $nextyr) = calendar_add_month($mon, $yr);
    $getvars = 'id='.$courseid.'&amp;cal_d='.$day.'&amp;cal_m='.$mon.'&amp;cal_y='.$yr; // For filtering

   echo '<div class="filters">';
    echo calendar_filter_controls($view, $getvars);
    echo '</div>';

    echo '<div class="minicalendarblock">';
    echo calendar_top_controls('display', array('id' => $courseid, 'm' => $prevmon, 'y' => $prevyr));
    echo calendar_get_mini($courses, $groups, $users, $prevmon, $prevyr);
   echo '</div><div class="minicalendarblock">';
    echo calendar_top_controls('display', array('id' => $courseid, 'm' => $mon, 'y' => $yr));
    echo calendar_get_mini($courses, $groups, $users, $mon, $yr);
   echo '</div><div class="minicalendarblock">';
    echo calendar_top_controls('display', array('id' => $courseid, 'm' => $nextmon, 'y' => $nextyr));
    echo calendar_get_mini($courses, $groups, $users, $nextmon, $nextyr);
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
?>
