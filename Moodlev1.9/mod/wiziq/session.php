<br /><br /><br /><br />

<div style="display:block" id="div123">

<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We Are Processing Your Request. Please Wait............</strong></font></p></div>


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
	


 //echo "now in the session.php".$MaxDurationPerSession->item(0)->nodeValue; 


require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
//require_once("../../lib/soap/nusoap.php");
//require_once("../../lib/soap/phpsoap.php");
//require_once("../../lib/soaplib.php");

//require_once($CFG->dirroot.'/mod/wiziq/nusoap/lib/nusoap.php');
       $name=$_POST['name'];
	   // $special = array(" ",'/','!','&','*','@','#','$','%','^','&','*','(',')','<','>','?'); 
 
       
        $name = str_replace ($special, "_", $name);

       $date=$_POST['date'];
	   $time=$_POST['time'];
	                 //$hh=$_POST['hh'];    
              //$mm=$_POST['mm'];
                          //  $ampm=$_POST['ampm'];
                     $duration=intval($_POST['duration']); 
					 
					 
                    // $timezone1=$_POST['timezone'];       
                     $audio=$_POST['audio'];
                     if($audio=="Video")
                     {
                     $waudio="Audio and Video";
					 
                     }
                     if($audio=="Audio")
                     {
                     $waudio="Audio";
					  

                     }
					  $type=$_REQUEST['type'];
				
					
					 if($type=="yes")
					 {
						 $recordingtype="yes"; 
						
					 }
					 else 
					 {
						 $recordingtype="no";
					 }
                   //$time=$hh.":".$mm.$ampm;
				  // $time=$_REQUEST['time'];
				  
				   //$hh.":".$mm." ".$ampm; 
                   //echo $time;
                    list($month, $day, $year)=split('[/.-]', $date);
                   
// check timezone
if ($CFG->forcetimezone != 99)
 {
     $tmzone=$CFG->forcetimezone;
 } 
 else
 $tmzone=$USER->timezone; 
if(!is_numeric($tmzone))
{
	$tmzone=get_user_timezone_offset($tmzone);
}

switch($tmzone)
{
	
case("-13.0"):
{
//(GMT+05:00)	
$timezone="GMT-13:00";
//$timezone_aglive = 18;
break;
}

case("-12.5"):
{
$timezone="GMT-12:50";
//$timezone_aglive = 18;
break;
}
case("-12.0"):
{
$timezone="GMT-12:00";
//$timezone_aglive = 18;
break;
}

case("-11.5"):
{
$timezone="GMT-11:50";
//$timezone_aglive = 58;
break;
}

case("-11.0"):
{
$timezone="GMT-11:00";
//$timezone_aglive = 58;
break;
}
case("-10.5"):
{
$timezone="GMT-10:50";
//$timezone_aglive = 32;

break;
}
case("-10.0"):
{
$timezone="GMT-10:00";
////$timezone_aglive = 32;
break;
}

case("-9.5"):
{
$timezone="GMT-09:50";
//$timezone_aglive = 48;
break;
}

case("-9.0"):
{
$timezone="GMT-09:00";
//$timezone_aglive = 48;
break;
}

case("-8.5"):
{
$timezone="GMT-08:50";
//$timezone_aglive = 52;
break;
}

case("-8.0"):
{
$timezone="GMT-08:00";
//$timezone_aglive = 52;
break;
}
case("-7.5"):
{
$timezone="GMT-07:50";
//$timezone_aglive = 40;
break;
}

case("-7.0"):
{
$timezone="GMT-07:00";
//$timezone_aglive = 40;
break;
}

case("-6.5"):
{
$timezone="GMT-06:50";
//$timezone_aglive = 16;
break;
}
case("-6.0"):
{
$timezone="GMT-06:00";
//$timezone_aglive = 16;
break;
}
case("-5.5"):
{
$timezone="GMT-05:50";
//$timezone_aglive = 23;
break;
}
case("-5.0"):
{
$timezone="GMT-05:00";
//$timezone_aglive = 23;
break;
}
case("-4.5"):
{
$timezone="GMT-04:50";
//$timezone_aglive = 3;
break;
}
case("-4.0"):
{
$timezone="GMT-04:00";
//$timezone_aglive = 3;
break;
}
case("-3.5"):
{
$timezone="GMT-03:50";
//$timezone_aglive = 29;
break;
}
case("-3.0"):
{
$timezone="GMT-03:00";
//$timezone_aglive = 29;
break;
}
case("-2.5"):
{
$timezone="GMT-02:50";
break;
}
case("-2.0"):
{
$timezone="GMT-02:00";
//$timezone_aglive = 39;
break;
}
case("-1.5"):
{
$timezone="GMT-01:50";
//$timezone_aglive = 6;
break;
}
case("-1.0"):
{
$timezone="GMT-01:00";
//$timezone_aglive = 6;
break;
}
case("-0.5"):
{
$timezone="GMT-00:50";
//$timezone_aglive = 28;
break;
}
case("0.0"):
{
$timezone="GMT";
//$timezone_aglive = 28;
break;
}
case("0.5"):
{
$timezone="GMT+00:50";
//$timezone_aglive = 53;
break;
}
case("1.0"):
{
$timezone="GMT+01:00";
//$timezone_aglive = 53;
break;
}
case("1.5"):
{
$timezone="GMT+01:50";
//$timezone_aglive = 35;
break;
}
case("2.0"):
{
$timezone="GMT+02:00";
//$timezone_aglive = 24;
break;
}
case("2.5"):
{
$timezone="GMT+02:50";
//$timezone_aglive = 2;

break;
}
case("3.0"):
{
$timezone="GMT+03:00";
//$timezone_aglive = 2;
break;
}
case("3.5"):
{
$timezone="GMT+03:50";
//$timezone_aglive = 34;
break;
}
case("4.0"):
{
$timezone="GMT+04:00";
//$timezone_aglive = 1;
break;
}
case("4.5"):
{
$timezone="GMT+04:50";
//$timezone_aglive = 47;
break;
}
case("5.0"):
{
$timezone="GMT+05:00";
//$timezone_aglive = 73;
break;
}
case("5.5"):
{
$timezone="GMT+05:50";
//$timezone_aglive = 33;
break;
}
case("6.0"):
{
$timezone="GMT+06:00";
//$timezone_aglive = 12;
break;
}
case("6.5"):
{
$timezone="GMT+06:50";
//$timezone_aglive = 41;
break;
}
case("7.0"):
{
$timezone="GMT+07:00";
//$timezone_aglive = 59;
break;
}
case("7.5"):
{
$timezone="GMT+07:50";
//$timezone_aglive = 17;
break;
}
case("8.0"):
{
$timezone="GMT+08:00";
//$timezone_aglive = 17;
break;
}
case("8.5"):
{
$timezone="GMT+08:50";
//$timezone_aglive = 36;
break;
}
case("9.0"):
{
$timezone="GMT+09:00";
//$timezone_aglive = 36;
break;
}
case("9.5"):
{
$timezone="GMT+09:50";
//$timezone_aglive = 10;
break;
}
case("10.0"):
{
$timezone="GMT+10:00";
//$timezone_aglive = 5;
break;
}
case("10.5"):
{
$timezone="GMT+10:50";
//$timezone_aglive = 10;
break;
}
case("11.0"):
{
$timezone="GMT+11:00";
//$timezone_aglive = 15;
break;
}
case("11.5"):
{
$timezone="GMT+11:50";
//$timezone_aglive = 26;
break;
}
case("12.0"):
{
$timezone="GMT+12:00";
//$timezone_aglive = 26;
break;
}
case("12.5"):
{
$timezone="GMT+12:50";

break;
}
case("13.0"):
{
$timezone="GMT+13:00";
//$timezone_aglive = 66;
break;
}
default:
  {
$timezone="GMT-06:00";
//$timezone_aglive = 33;
  }
}


$indexof=strrpos($time, ":");
 if($indexof>0)
 {
    
   $mm=intval(substr($time,$indexof+1,2));
 }
 else
 $mm="00";
 $hh=intval(substr($time,0,2));
 
 $ampm=substr($time,-2);

$ampm=strtolower($ampm);
 
   //checking ends here
                    
                    
                   $hh1=intval($hh);
				   
                   if($ampm=="pm") 
                   {
				   
				   if($hh1<12)
							{
							$hh1=$hh1+12;
						
						
						}
					}
					if($ampm=="am")

						{
						if($hh1==12)
						{
						$hh1=00;
						}
						}				

                 $hh2=$hh1+12;
						
						
                   $mm1=intval($mm);
				  
                   $month1=intval($month);
                   $day1=intval($day);
                   $year1=intval($year);
				   
switch($month1)
{
    case("1"):
		{
        $stringmonth = "January";
		break;
		}
    case("2"):
		{
        $stringmonth = "February";
		break;
		}
    case("3"):
		{
        $stringmonth = "March";
		break;
		}
    case("4"):
		{
        $stringmonth = "April";
		break;
		}
    case("5"):
		{
        $stringmonth = "May";
		break;
		}
    case("6"):
		{
        $stringmonth = "June";
		}
    case("7"):
		{
        $stringmonth = "July";
		break;
		}
    case("8"):
		{
        $stringmonth = "August";
		break;
		}
    case("9"):
		{
        $stringmonth = "September";
		break;
		}
    case("10"):
		{
        $stringmonth = "October";
		break;
		}
    case("11"):
		{
        $stringmonth = "November";
		break;
		}
    case("12"):
		{
        $stringmonth = "December";
		break;
		}
} 
				  
	$datestr = date('Y-m-d\TH:i:s');
	$datestring=$stringmonth.' '.$day1.', '.$year1.' '.$time;
			$usr = $USER->username;
	$email = $USER->email;
 	$fqdn=$CFG->wwwroot ; 
              $id = intval($USER->id);   
			  //preeti's code
			  $user = get_record("user", "id", $id);
			  $description=$user->description;
			  //echo $description;
			  //exit;
			  
	
$xyz=$date." ".$time;
$datetime=strtoupper($xyz);
$mm=$_REQUEST['duration'];
$maxduration=$mm-$maxdur;

if($presenterentry=="1")
	 {
			$entry="true";
	 }
     else if($presenterentry=="0")
		{
             $entry="false";
		}
if ($CFG->forcetimezone != 99)
 {
     $CountryNameTZ=$CFG->forcetimezone;
 } 
 else
 $CountryNameTZ=$USER->timezone;
 
$ScheduleNow=$_REQUEST['chkNow'];

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
  
  if($ScheduleNow=="checked")
  {
	  $person = array(
	    'TimeZone' => $timezone,
		'CountryNameTZ'=>$CountryNameTZ,
	);
	 $result=do_post_request($WebServiceUrl.'moodle/class/schedulenow',http_build_query($person, '', '&')); 
	 try
	  {
	    $objDOM = new DOMDocument();
	    $objDOM->loadXML($result); 
	  }
	catch(Exception $e)
	  {
		echo $e->getMessage();
	  }
   
 	
	 $DateNow=$objDOM->getElementsByTagName("DateNow");
	 $DateNow=$DateNow->item(0)->nodeValue;
	$TimeNow=$objDOM->getElementsByTagName("TimeNow");
	 $TimeNow=$TimeNow->item(0)->nodeValue;
	$ErrorMessage=$objDOM->getElementsByTagName("message");
	$ErrorMessage=$ErrorMessage->item(0)->nodeValue; 
	
	
 $indexof=strrpos($TimeNow, ":");
 if($indexof>0)
 {
   
  $mm=intval(substr($TimeNow,$indexof+1,2));
 }
 else
 $mm="00";
 $hh=intval(substr($TimeNow,0,2));
 
 $ampm=substr($TimeNow,-2);

$ampm=strtolower($ampm);
 
   //checking ends here
                    
                    
                   $hh1=intval($hh);
				   
                   if($ampm=="pm") 
                   {
				   
				   if($hh1<12)
							{
							$hh1=$hh1+12;
						
						
						}
					}
					if($ampm=="am")

						{
						if($hh1==12)
						{
						$hh1=00;
						}
						}				

                 $hh2=$hh1+12;
						
                   $mm1=intval($mm);
	list($month, $day, $year)=split('[/.-]', $DateNow);						
			  
                   $month1=intval($month);
                   $day1=intval($day);
                   $year1=intval($year);
$time=$TimeNow;				   
$xyz=$DateNow." ".$TimeNow;
$datetime=strtoupper($xyz);
  }
  if(empty($ScheduleNow) || (!empty($DateNow) && !empty($TimeNow)) )
  {
  $person = array(
	
		'CustomerKey'=>$customer_key,
		'EventName' => $_REQUEST['name'],
	 	'DateTime' => $datetime,
	    'TimeZone' => $timezone,
	    'Duration' => $_REQUEST['duration'],
	    'UserCode' => $id,
	    'UserName'=>$usr,
		'audio' => $audio,							
		'CountryNameTZ'=>$CountryNameTZ,
		'RecodingReplay'=>$recordingtype,
		
		
	);
	//$result=do_post_request('http://192.168.17.57/api_wiziq/moodle/api/class/schedule',http_build_query($person, '', '&'));
	 $result=do_post_request($WebServiceUrl.'moodle/class/schedule',http_build_query($person, '', '&'));

  
   try
	  {
	    $objDOM = new DOMDocument();
	    $objDOM->loadXML($result); 
	  }
	catch(Exception $e)
	  {
		echo $e->getMessage();
	  }
   
 	
	 $Code=$objDOM->getElementsByTagName("SessionCode");
	 $SessionCode=$Code->item(0)->nodeValue;
	 $PresenterUrl=$objDOM->getElementsByTagName("PresenterUrl");
	 $PresenterUrl=$PresenterUrl->item(0)->nodeValue;
	 $RecordingUrl=$objDOM->getElementsByTagName("RecordingUrl");
$RecordingUrl=$RecordingUrl->item(0)->nodeValue;
	 $CommonAttendeeUrl=$objDOM->getElementsByTagName("CommonAttendeeUrl");
	$CommonAttendeeUrl=$CommonAttendeeUrl->item(0)->nodeValue;
	 $ReviewSessionUrl=$objDOM->getElementsByTagName("ReviewSessionUrl");
	$ReviewSessionUrl=$ReviewSessionUrl->item(0)->nodeValue;
	 $AttendeeUrls=$objDOM->getElementsByTagName("AttendeeUrls");
	$AttendeeUrls=$AttendeeUrls->item(0)->nodeValue;
	$ErrorMessage=$objDOM->getElementsByTagName("message");
	$ErrorMessage=$ErrorMessage->item(0)->nodeValue;
  }
	//exit;
if($SessionCode !=-1)
{	

	$event=$_REQUEST['name'];
	$presenterurl=$PresenterUrl;
	$recodingurl=$RecordingUrl;
	$reviewurl=$ReviewSessionUrl;
	$attendeeurl=$CommonAttendeeUrl;
	
	$insescod=$SessionCode;

$res=$result1['diffgram']['NewDataSet']['Table']['SessionURL'];

require_login();

    $sectionreturn = optional_param('sr', '', PARAM_INT);
    $add           = optional_param('add','', PARAM_ALPHA);
	$modulename    = optional_param('modulename','', PARAM_ALPHA);
	$mode    	   = optional_param('mode','', PARAM_ALPHA);
    $type          = optional_param('type', '', PARAM_ALPHA);
    $indent        = optional_param('indent', 0, PARAM_INT);
    $update        = optional_param('update', 0, PARAM_INT);
    $hide          = optional_param('hide', 0, PARAM_INT);
    $show          = optional_param('show', 0, PARAM_INT);
    $copy          = optional_param('copy', 0, PARAM_INT);
    $moveto        = optional_param('moveto', 0, PARAM_INT);
    $movetosection = optional_param('movetosection', 0, PARAM_INT);
    $delete        = optional_param('delete', 0, PARAM_INT);
    $course1       = optional_param('course', 0, PARAM_INT);
    $groupmode     = optional_param('groupmode', -1, PARAM_INT);
    $duplicate     = optional_param('duplicate', 0, PARAM_INT);
    $cancel        = optional_param('cancel', 0, PARAM_BOOL);
    $cancelcopy    = optional_param('cancelcopy', 0, PARAM_BOOL);
	$eventtype	   = optional_param('eventtype','', PARAM_ALPHA);	
	
	
$groupid=explode(",",$_REQUEST['groupid']);
$courseid=$_REQUEST['courseid'];
$userid=$_REQUEST['userid'];	


    //1
    if (isset($SESSION->modform)) {   // Variables are stored in the session
  //echo "1st if";
        $mod = $SESSION->modform;
   
        unset($SESSION->modform);
    } else {
        $mod = (object)$_POST;
    }
//2
    if ($cancel) {
		//echo "in 2nd if";
        if (!empty($SESSION->returnpage)) {
            $return = $SESSION->returnpage;
            unset($SESSION->returnpage);
            redirect($return);
        } else {
			//echo "2nd if else";
            redirect("view.php?id=$mod->course#section-$sectionreturn");
        }
    }

    //check if we are adding / editing a module that has new forms using formslib
	//3
    if (!empty($add)){
		//echo "3rd if";
        $modname=$add;
		//4
        if (file_exists("../mod/$modname/mod_form.php")) {
			//echo "in 4th if";
            $id          = required_param('id', PARAM_INT);
            $section     = required_param('section', PARAM_INT);
            $type        = optional_param('type', '', PARAM_ALPHA);
            $returntomod = optional_param('return', 0, PARAM_BOOL);
			
            redirect("modedit.php?add=$add&type=$type&course=$id&section=$section&return=$returntomod");
        }
    }elseif (!empty($update)){
		//echo "4th if else";
        //5
		if (!$modname=get_field_sql("SELECT md.name
                           FROM {$CFG->prefix}course_modules cm,
                                {$CFG->prefix}modules md
                           WHERE cm.id = '$update' AND
                                 md.id = cm.module")){
			//echo "in 5th if";
            error('Invalid course module id!');
        }
        $returntomod = optional_param('return', 0, PARAM_BOOL);
		//6
        if (file_exists("../mod/$modname/mod_form.php")) {
			//echo "in 6th if";
            redirect("modedit.php?update=$update&return=$returntomod");
        }
    }
    //not adding / editing a module that has new forms using formslib
    //carry on
//7
    if (!empty($course1) and confirm_sesskey()) {    // add, delete or update form submitted
//echo "in 7th if";
//8
			
        if (empty($mod->coursemodule)) { //add
		//echo "in 8th if";
		//9
            if (! $course = get_record("course", "id", $mod->course)) {
			//echo "in 9th if";	
                error("This course doesn't exist");
            }
            $mod->instance = '';
            $mod->coursemodule = '';
        } else { 
		//echo "in 9th if else";
		//delete and update
//10
			if (! $cm = get_record("course_modules", "id", $mod->coursemodule)) {
					//echo "in 10 th if";			
                error("This course module doesn't exist");
            }
//11
            if (! $course = get_record("course", "id", $cm->course)) {
				//echo "in 11 th if";
                error("This course doesn't exist");
            }
            $mod->instance = $cm->instance;
            $mod->coursemodule = $cm->id;
        }

        require_login($course->id); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $course->id);
        require_capability('moodle/course:manageactivities', $context);

        $mod->course = $course->id;
        $mod->modulename = clean_param($mod->modulename, PARAM_SAFEDIR);  // For safety
        $modlib = "$CFG->dirroot/mod/$modulename/lib.php";
//12
        if (file_exists($modlib)) {
			//echo "in 12 th if".$modlib;
            include_once($modlib);
        } else {
			//echo "in 12 th if else";
            error("This module is missing important code! ($modlib)");
        }
		
        $addinstancefunction    = $mod->modulename."_add_instance";
        $updateinstancefunction = $mod->modulename."_update_instance";
        $deleteinstancefunction = $mod->modulename."_delete_instance";
        $moderr = "$CFG->dirroot/mod/$mod->modulename/moderr.html";

        switch ($mode) {
            case "update":
//13
                if (isset($mod->name)) {
					//echo "in 13 th if";
           //14       
				  if (trim($mod->name) == '') {
					// echo "in 14 th if";
                        unset($mod->name);
                    }
                }

                $return = $updateinstancefunction($mod);
	//15
                if (!$return) {
				//echo "in 15 th if";
	//16				
                    if (file_exists($moderr)) {
						//echo "in 16 th if";
                        $form = $mod;
                        include_once($moderr);
                        die;
                    }
                    error("Could not update the $mod->modulename", "view.php?id=$course->id");
                }
		//17
                if (is_string($return)) {
					//echo "in 17 th if";
                    error($return, "view.php?id=$course->id");
                }
//18
                if (isset($mod->visible)) {
					//echo "in 18th if";				
                    set_coursemodule_visible($mod->coursemodule, $mod->visible);
                }
//19
                if (isset($mod->groupmode)) {
					//echo "in 19 th if";
                    set_coursemodule_groupmode($mod->coursemodule, $mod->groupmode);
                }
//20
                if (isset($mod->redirect)) {
					//echo "in 20 th if";
                    $SESSION->returnpage = $mod->redirecturl;
                } else {
				//echo "in 20 th if else";
                    $SESSION->returnpage = "$CFG->wwwroot/mod/$mod->modulename/view.php?id=$mod->coursemodule";
                }

                add_to_log($course->id, "course", "update mod",
                           "../mod/$mod->modulename/view.php?id=$mod->coursemodule",
                           "$mod->modulename $mod->instance");
                add_to_log($course->id, $mod->modulename, "update",
                           "view.php?id=$mod->coursemodule",
                           "$mod->instance", $mod->coursemodule);
                break;

            case "add":
//21
                if (!course_allowed_module($course,$modulename)) {
					//echo "in 21 if";
                    error("This module ($mod->modulename) has been disabled for this particular course");
                }
//22
                if (!isset($mod->name) || trim($mod->name) == '') {
					//echo "in 22 if";
                    $mod->name = get_string("modulename", $modulename);
                }

$obj2->name=$event;
$obj2->url=$presenterurl;
$obj2->attendeeurl=$attendeeurl;
$obj2->recordingurl=$recodingurl;
$obj2->reviewurl=$reviewurl;
$obj2->wtime=$time;
$obj2->wdur=$duration;


$obj2->wdate=make_timestamp($year, $month, $day, $hh1, $mm1);

$obj2->wtype=$waudio;
$obj2->insescod=$insescod;
$type=$_REQUEST['type'];
					 if($type=="yes")
					 {
						 $value=1;
					 }
					 else
					 {
						 $value=0;
					 }
					
$obj2->statusrecording=$value;
$obj2->timezone=$timezone;
$obj2->oldclasses='';
                $return = $addinstancefunction($obj2);
               
////////////////////////adding information in wiziq attende info table////////////////////////////////      
      $obj->username=$usr;
	  $obj->attendeeurl=$presenterurl;
	  $obj->insescod=$insescod;
	  $obj->userid=$USER->id;
    $result=wiziq_add_attendeeinfo($obj);
	
	
      	   
		if($eventtype=="site")
		{
			$form1->courseid=SITEID;
			$form1->groupid=0;
		 	$form1->name='<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/icon.gif" style="vertical-align: middle;"/>'." ".$name;
			
			
		 	$form1->description='<input type="text" value="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/view.php" onfocus="this.select();"><br><a href="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/view.php?instance='.$return.'" >View Class details</a>';
            $form1->userid=intval($USER->id);
            $form1->modulename="";//"wiziq";
            $form1->instance=$return;
			$form1->timestart=make_timestamp($year, $month, $day, $hh1, $mm1);
			$form1->timeduration=$_REQUEST['duration']*60;
            $form1->eventtype=$eventtype;
			$form1->format=1;
            $form1->visible=1;
			$eventid = wiziq_add_event($form1);  
		} 
		if($eventtype=='course')
		{
			
					$form1->courseid=$COURSE->id;
					$form1->groupid=0;
			 		$form1->name='<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/icon.gif" style="vertical-align: middle;"/>'." ".$name;
					$form1->description='<input type="text" value="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/view.php" onfocus="this.select();"><br><a href="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/view.php?instance='.$return.'" >View Class details</a>';
        	    	$form1->userid=intval($USER->id);
            	   	$form1->modulename="";//"wiziq";
               		$form1->instance=$return;
     		    	$form1->timestart=make_timestamp($year, $month, $day, $hh1, $mm1);
			    	$form1->timeduration=$_REQUEST['duration']*60;
                	$form1->eventtype=$eventtype;
					$form1->format=1;
                	$form1->visible=1;
					$eventid = wiziq_add_event($form1); 
					
		}
		if($eventtype=='user')
		{

			
					$form1->courseid=0;
					$form1->groupid=0;
					$form1->name='<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/icon.gif" style="vertical-align: middle;"/>'." ".$name;
				 	$form1->description='<input type="text" value="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/view.php" onfocus="this.select();"><br><a href="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/view.php?instance='.$return.'" >View Class details</a>';
		            $form1->userid=$USER->id;
		            $form1->modulename="";//"wiziq";
		            $form1->instance=$return;
					$form1->timestart=make_timestamp($year, $month, $day, $hh1, $mm1);
					$form1->timeduration=$_REQUEST['duration']*60;
		            $form1->eventtype=$eventtype;
					$form1->format=1;
		            $form1->visible=1;
					$eventid = wiziq_add_event($form1); 
					
				
		}
		if($eventtype=='group')
		{
			foreach($groupid as $value)
			{
				if($value!="")
				{
				$form1->groupid=$value;
				$form1->courseid=$COURSE->id;
		 		$form1->name='<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/icon.gif" style="vertical-align: middle;"/>'." ".$name;
				$form1->description='<input type="text" value="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/view.php" onfocus="this.select();"><br><a href="'.$CFG->wwwroot.'/mod/'.$mod->modulename.'/view.php?instance='.$return.'" >View Class details</a>';
            	$form1->userid=intval($USER->id);
               	$form1->modulename="";//"wiziq";
               	$form1->instance=$return;
     		    $form1->timestart=make_timestamp($year, $month, $day, $hh1, $mm1);
			    $form1->timeduration=$_REQUEST['duration']*60;
                $form1->eventtype=$eventtype;
				$form1->format=1;
                $form1->visible=1;
				$eventid = wiziq_add_event($form1);  
				}
			}
		}

                // ends here
				//23
                if (!$return) {
					//echo "in 23 rd if";
					//24
                    if (file_exists($moderr)) {
						//echo "in 24 th if";
                        $form = $mod;
                        include_once($moderr);
                        die;
                    }
                    error("Could not add a new instance of $mod->modulename", "view.php?id=$course->id");
                }
				//25
                if (is_string($return)) {
                   // echo "in 25 th if";
					error($return, "view.php?id=$course->id");
                }
//26
                if (!isset($mod->groupmode)) { // to deal with pre-1.5 modules
				//echo "in 26 th if";
                    $mod->groupmode = $course->groupmode;
					//echo "value of group mode".$mod->groupmode;/// Default groupmode the same as course
                }

                $mod->instance = $return;

                // course_modules and course_sections each contain a reference
                // to each other, so we have to update one of them twice.
//27
                if (! $mod->coursemodule = add_course_module($mod) ) {
					//echo "in 27 th if";
                    error("Could not add a new course module");
                }
				//28
                if (! $sectionid = add_mod_to_section($mod) ) {
					//echo "in 28 th if";
                    error("Could not add the new course module to that section");
                }
//29
                if (! set_field("course_modules", "section", $sectionid, "id", $mod->coursemodule)) {
					//echo "in 29 th if";
                    error("Could not update the course module with the correct section");
                }
//30
                if (!isset($mod->visible)) {   // We get the section's visible field status
				//echo "in 30 th if";
                    $mod->visible = get_field("course_sections","visible","id",$sectionid);
                }
                // make sure visibility is set correctly (in particular in calendar)
                set_coursemodule_visible($mod->coursemodule, $mod->visible);
//31
                if (isset($mod->redirect)) {
					//echo "in 31 st if";
                    $SESSION->returnpage = $mod->redirecturl;
                } else {
					//echo "in 31 st if else";
 //exit;
                    $SESSION->returnpage = "$CFG->wwwroot/mod/$mod->modulename/view.php?instance=$return&type=$value";
                }

                add_to_log($course->id, "course", "add mod",
                           "../mod/$mod->modulename/view.php?id=$mod->coursemodule",
                           "$mod->modulename $mod->instance");
                add_to_log($course->id, $mod->modulename, "add",
                           "view.php?id=$mod->coursemodule",
                           "$mod->instance", $mod->coursemodule);
                break;

            case "delete":
			//32
                if (! $deleteinstancefunction($mod->instance)) {
					//echo "in 32 nd if";
                    notify("Could not delete the $mod->modulename (instance)");
                }
				//33
                if (! delete_course_module($mod->coursemodule)) {
					//echo "in 33 if";
                    notify("Could not delete the $mod->modulename (coursemodule)");
                }
				//34
                if (! delete_mod_from_section($mod->coursemodule, "$mod->section")) {
					//echo "in 34 if";
                    notify("Could not delete the $mod->modulename from that section");
                }

                unset($SESSION->returnpage);

                add_to_log($course->id, "course", "delete mod",
                           "view.php?id=$mod->course",
                           "$mod->modulename $mod->instance", $mod->coursemodule);
                break;
            default:
                error("No mode defined");

        }

        rebuild_course_cache($course->id);
//35
        if (!empty($SESSION->returnpage)) {
			//echo "in 35 th if";
            $return = $SESSION->returnpage;
            unset($SESSION->returnpage);
            redirect($return);
        } else {
			//echo "in 35 th if else";
								
            redirect("view.php?id=$course->id#section-$sectionreturn");
        }
      
    }
//36
    if ((!empty($movetosection) or !empty($moveto)) and confirm_sesskey()) {
		//echo "in 36 th if";
//37
        if (! $cm = get_record("course_modules", "id", $USER->activitycopy)) {
			//echo "in 37 th if";
            error("The copied course module doesn't exist!");
        }
//38
        if (!empty($movetosection)) {
			//echo "in 38 th if";
			//39
            if (! $section = get_record("course_sections", "id", $movetosection)) {
				//echo "in 39 th if";
                error("This section doesn't exist");
            }
            $beforecm = NULL;

        } else {                 //echo "in 39 th if else";     // normal moveto
//40
				if (! $beforecm = get_record("course_modules", "id", $moveto)) {
					//echo "in 40 th if";
                error("The destination course module doesn't exist");
            }
			//41
            if (! $section = get_record("course_sections", "id", $beforecm->section)) {
				//echo "in 41 th if";
                error("This section doesn't exist");
            }
        }

        require_login($section->course); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $section->course);
        require_capability('moodle/course:manageactivities', $context);
//42
        if (!ismoving($section->course)) {
			//echo "in 42nd if";
            error("You need to copy something first!");
        }

        moveto_module($cm, $section, $beforecm);

        unset($USER->activitycopy);
        unset($USER->activitycopycourse);
        unset($USER->activitycopyname);

        rebuild_course_cache($section->course);
//43
        if (SITEID == $section->course) {
			//echo "in 43 rd if";
            redirect($CFG->wwwroot);
        } else {
			//echo "in 43 rd if else";
			
            redirect("view.php?id=$section->course#section-$sectionreturn");
        }

    } else if (!empty($indent) and confirm_sesskey()) {
//echo "in 43 th if else";
        $id = required_param('id',PARAM_INT);
//44

        if (! $cm = get_record("course_modules", "id", $id)) {
			//echo "in 44 th if";
            error("This course module doesn't exist");
        }

        require_login($cm->course); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $cm->course);
        require_capability('moodle/course:manageactivities', $context);

        $cm->indent += $indent;
//45
        if ($cm->indent < 0) {
			//echo "in 45 th if";
            $cm->indent = 0;
        }
//46
        if (!set_field("course_modules", "indent", $cm->indent, "id", $cm->id)) {
			//echo "in 46 th if";
            error("Could not update the indent level on that course module");
        }
//47
        if (SITEID == $cm->course) {
			//echo "in 47 th if";
            redirect($CFG->wwwroot);
        } else {
			//echo "in 47 th if else";
			
            redirect("view.php?id=$cm->course#section-$sectionreturn");
        }
        exit;

    } else if (!empty($hide) and confirm_sesskey()) {
//48
        if (! $cm = get_record("course_modules", "id", $hide)) {
			//echo "in 48 th if";
            error("This course module doesn't exist");
        }
exit;
        require_login($cm->course); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $cm->course);
        require_capability('moodle/course:activityvisibility', $context);

        set_coursemodule_visible($cm->id, 0);

        rebuild_course_cache($cm->course);

        if (SITEID == $cm->course) {
            redirect($CFG->wwwroot);
        } else {
            redirect("view.php?id=$cm->course#section-$sectionreturn");
        }
        exit;

    } else if (!empty($show) and confirm_sesskey()) {

        if (! $cm = get_record("course_modules", "id", $show)) {
            error("This course module doesn't exist");
        }

        require_login($cm->course); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $cm->course);
        require_capability('moodle/course:activityvisibility', $context);

        if (! $section = get_record("course_sections", "id", $cm->section)) {
            error("This module doesn't exist");
        }

        if (! $module = get_record("modules", "id", $cm->module)) {
            error("This module doesn't exist");
        }

        if ($module->visible and ($section->visible or (SITEID == $cm->course))) {
            set_coursemodule_visible($cm->id, 1);
            rebuild_course_cache($cm->course);
        }

        if (SITEID == $cm->course) {
            redirect($CFG->wwwroot);
        } else {
            redirect("view.php?id=$cm->course#section-$sectionreturn");
        }
        exit;

    } else if ($groupmode > -1 and confirm_sesskey()) {

        $id = required_param( 'id', PARAM_INT );

        if (! $cm = get_record("course_modules", "id", $id)) {
            error("This course module doesn't exist");
        }

        require_login($cm->course); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $cm->course);
        require_capability('moodle/course:manageactivities', $context);

        set_coursemodule_groupmode($cm->id, $groupmode);

        rebuild_course_cache($cm->course);

        if (SITEID == $cm->course) {
            redirect($CFG->wwwroot);
        } else {
            redirect("view.php?id=$cm->course#section-$sectionreturn");
        }
        exit;

    } else if (!empty($copy) and confirm_sesskey()) { // value = course module

        if (! $cm = get_record("course_modules", "id", $copy)) {
            error("This course module doesn't exist");
        }

        require_login($cm->course); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $cm->course);
        require_capability('moodle/course:manageactivities', $context);

        if (! $section = get_record("course_sections", "id", $cm->section)) {
            error("This module doesn't exist");
        }

        if (! $module = get_record("modules", "id", $cm->module)) {
            error("This module doesn't exist");
        }

        if (! $instance = get_record($module->name, "id", $cm->instance)) {
            error("Could not find the instance of this module");
        }

        $USER->activitycopy = $copy;
        $USER->activitycopycourse = $cm->course;
        $USER->activitycopyname = $instance->name;

        redirect("view.php?id=$cm->course#section-$sectionreturn");

    } else if (!empty($cancelcopy) and confirm_sesskey()) { // value = course module

        $courseid = $USER->activitycopycourse;

        unset($USER->activitycopy);
        unset($USER->activitycopycourse);
        unset($USER->activitycopyname);

        redirect("view.php?id=$courseid#section-$sectionreturn");

    } else if (!empty($delete) and confirm_sesskey()) {   // value = course module

        if (! $cm = get_record("course_modules", "id", $delete)) {
            error("This course module doesn't exist");
        }

        if (! $course = get_record("course", "id", $cm->course)) {
            error("This course doesn't exist");
        }

        require_login($cm->course); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $cm->course);
        require_capability('moodle/course:manageactivities', $context);

        if (! $module = get_record("modules", "id", $cm->module)) {
            error("This module doesn't exist");
        }

        if (! $instance = get_record($module->name, "id", $cm->instance)) {
            // Delete this module from the course right away
            if (! delete_mod_from_section($cm->id, $cm->section)) {
                notify("Could not delete the $module->name from that section");
            }
            if (! delete_course_module($cm->id)) {
                notify("Could not delete the $module->name (coursemodule)");
            }
            error("The required instance of this module didn't exist.  Module deleted.",
                  "$CFG->wwwroot/course/view.php?id=$course->id");
        }

        $fullmodulename = get_string("modulename", $module->name);

        $form->coursemodule = $cm->id;
        $form->section      = $cm->section;
        $form->course       = $cm->course;
        $form->instance     = $cm->instance;
        $form->modulename   = $module->name;
        $form->fullmodulename  = $fullmodulename;
        $form->instancename = $instance->name;
        $form->sesskey      = !empty($USER->id) ? $USER->sesskey : '';

        $strdeletecheck = get_string('deletecheck', '', $form->fullmodulename);
        $strdeletecheckfull = get_string('deletecheckfull', '', "$form->fullmodulename '$form->instancename'");

        $CFG->pagepath = 'mod/'.$module->name.'/delete';

        print_header_simple($strdeletecheck, '', $strdeletecheck);

        print_simple_box_start('center', '60%', '#FFAAAA', 20, 'noticebox');
        print_heading($strdeletecheckfull);
        include_once('mod_delete.html');
        print_simple_box_end();
        print_footer($course);

        exit;


    } else if (!empty($update) and confirm_sesskey()) {   // value = course module

        if (! $cm = get_record("course_modules", "id", $update)) {
            error("This course module doesn't exist");
        }

        if (! $course = get_record("course", "id", $cm->course)) {
            error("This course doesn't exist");
        }

        require_login($course->id); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $course->id);
        require_capability('moodle/course:manageactivities', $context);

        if (! $module = get_record("modules", "id", $cm->module)) {
            error("This module doesn't exist");
        }

        if (! $form = get_record($module->name, "id", $cm->instance)) {
            error("The required instance of this module doesn't exist");
        }

        if (! $cw = get_record("course_sections", "id", $cm->section)) {
            error("This course section doesn't exist");
        }

        if (isset($return)) {
            $SESSION->returnpage = "$CFG->wwwroot/mod/$module->name/view.php?id=$cm->id";
        }

        $form->coursemodule = $cm->id;
        $form->section      = $cm->section;     // The section ID
        $form->course       = $course->id;
        $form->module       = $module->id;
        $form->modulename   = $module->name;
        $form->instance     = $cm->instance;
        $form->mode         = "update";
        $form->sesskey      = !empty($USER->id) ? $USER->sesskey : '';

        $sectionname = get_section_name($course->format);
        $fullmodulename = get_string("modulename", $module->name);

        if ($form->section && $course->format != 'site') {
            $heading->what = $fullmodulename;
            $heading->in   = "$sectionname $cw->section";
            $pageheading = get_string("updatingain", "moodle", $heading);
        } else {
            $pageheading = get_string("updatinga", "moodle", $fullmodulename);
        }
        $strnav = "<a href=\"$CFG->wwwroot/mod/$module->name/view.php?id=$cm->id\">".format_string($form->name,true)."</a> ->";

        if ($module->name == 'resource') {
            $CFG->pagepath = 'mod/'.$module->name.'/'.$form->type;
        } else {
            $CFG->pagepath = 'mod/'.$module->name.'/mod';
        }

    } else if (!empty($duplicate) and confirm_sesskey()) {   // value = course module


        if (! $cm = get_record("course_modules", "id", $duplicate)) {
            error("This course module doesn't exist");
        }

        if (! $course = get_record("course", "id", $cm->course)) {
            error("This course doesn't exist");
        }

        require_login($course->id); // needed to setup proper $COURSE
        $context = get_context_instance(CONTEXT_COURSE, $course->id);
        require_capability('moodle/course:manageactivities', $context);

        if (! $module = get_record("modules", "id", $cm->module)) {
            error("This module doesn't exist");
        }

        if (! $form = get_record($module->name, "id", $cm->instance)) {
            error("The required instance of this module doesn't exist");
        }

        if (! $cw = get_record("course_sections", "id", $cm->section)) {
            error("This course section doesn't exist");
        }

        if (isset($return)) {
            $SESSION->returnpage = "$CFG->wwwroot/mod/$module->name/view.php?id=$cm->id";
        }

        $section = get_field('course_sections', 'section', 'id', $cm->section);

        $form->coursemodule = $cm->id;
        $form->section      = $section;     // The section ID
        $form->course       = $course->id;
        $form->module       = $module->id;
        $form->modulename   = $module->name;
        $form->instance     = $cm->instance;
        $form->mode         = "add";
        $form->sesskey      = !empty($USER->id) ? $USER->sesskey : '';

        $sectionname    = get_string("name$course->format");
        $fullmodulename = get_string("modulename", $module->name);

        if ($form->section) {
            $heading->what = $fullmodulename;
            $heading->in   = "$sectionname $cw->section";
            $pageheading = get_string("duplicatingain", "moodle", $heading);
        } else {
            $pageheading = get_string("duplicatinga", "moodle", $fullmodulename);
        }
        $strnav = "<a href=\"$CFG->wwwroot/mod/$module->name/view.php?id=$cm->id\">$form->name</a> ->";

        $CFG->pagepath = 'mod/'.$module->name.'/mod';


    } else if (!empty($add) and confirm_sesskey()) {

        $id = required_param('id',PARAM_INT);
        $section = required_param('section',PARAM_INT);

        if (! $course = get_record("course", "id", $id)) {
            error("This course doesn't exist");
        }

        if (! $module = get_record("modules", "name", $add)) {
            error("This module type doesn't exist");
        }

        $context = get_context_instance(CONTEXT_COURSE, $course->id);
        require_capability('moodle/course:manageactivities', $context);

        if (!course_allowed_module($course,$module->id)) {
            error("This module has been disabled for this particular course");
        }

        require_login($course->id); // needed to setup proper $COURSE

        $form->section    = $section;         // The section number itself
        $form->course     = $course->id;
        $form->module     = $module->id;
        $form->modulename = $module->name;
        $form->instance   = "";
        $form->coursemodule = "";
        $form->mode       = "add";
        $form->sesskey    = !empty($USER->id) ? $USER->sesskey : '';
        if (!empty($type)) {
            $form->type = $type;
        }

        $sectionname    = get_string("name$course->format");
        $fullmodulename = get_string("modulename", $module->name);

        if ($form->section && $course->format != 'site') {
            $heading->what = $fullmodulename;
            $heading->to   = "$sectionname $form->section";
            $pageheading = get_string("addinganewto", "moodle", $heading);
        } else {
            $pageheading = get_string("addinganew", "moodle", $fullmodulename);
        }
        $strnav = '';

        $CFG->pagepath = 'mod/'.$module->name;
        if (!empty($type)) {
            $CFG->pagepath .= '/' . $type;
        }
        else {
            $CFG->pagepath .= '/mod';
        }

    } else {
        error("No action was specfied");
    }

    require_login($course->id); // needed to setup proper $COURSE
    $context = get_context_instance(CONTEXT_COURSE, $course->id);
    require_capability('moodle/course:manageactivities', $context);

    $streditinga = get_string("editinga", "moodle", $fullmodulename);
    $strmodulenameplural = get_string("modulenameplural", $module->name);

    if ($module->name == "label") {
        $focuscursor = "form.content";
    } else {
        $focuscursor = "form.name";
    }

    print_header_simple($streditinga, '',
     "<a href=\"$CFG->wwwroot/mod/$module->name/index.php?id=$course->id\">$strmodulenameplural</a> ->
     $strnav $streditinga", $focuscursor, "", false);

    if (!empty($cm->id)) {
        $context = get_context_instance(CONTEXT_MODULE, $cm->id);
        $currenttab = 'update';
        include_once($CFG->dirroot.'/'.$CFG->admin.'/roles/tabs.php');
    }

    unset($SESSION->modform); // Clear any old ones that may be hanging around.

    $modform = $CFG->dirroot."/mod/$module->name/mode1.html";
//echo $modform;
    if (file_exists($modform)) {
//echo("file exist"); 
        if ($usehtmleditor = can_use_html_editor()) {
            $defaultformat = FORMAT_HTML;
            $editorfields = '';
        } else {
            $defaultformat = FORMAT_MOODLE;
        }

        $icon = '<img class="icon" src="'.$CFG->modpixpath.'/'.$module->name.'/icon.gif" alt="'.get_string('modulename',$module->name).'"/>';

        print_heading_with_help($pageheading, "mods", $module->name, $icon);
        print_simple_box_start('center', '', '', 5, 'generalbox', $module->name);
        include_once($modform);
        print_simple_box_end();

       if ($usehtmleditor and empty($nohtmleditorneeded)) {
            use_html_editor($editorfields);
        }

    } else {
        notice("This module cannot be added to this course yet! (No file found at: $modform)", "$CFG->wwwroot/course/view.php?id=$course->id");
    }

    print_footer($course);

 }
 
 else{
 $flag="none";

echo ' <script language="javascript" type="text/javascript">
		var chk =  "'.$flag.'" ;
		if(chk == "none")
		{
			document.getElementById("div123").style.display="none";
		}
				
		</script>;  ';
 require_login($course->id);
 if ($course->category) {
        $navigation = "<a href=\"../../course/view.php?id=$course->id\">$course->shortname</a> ->";
    } else {
        $navigation = '';
    }

//    print_header("WizIQ class", "Error In Scheduling WizIQ Live Class");
	
	?>
    <br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="5"><strong><img src="icon.gif" hspace="10" height="16" width="16" border="0" alt="" />Error In Scheduling WiZiQ Live Class</strong></font></p>
    <?php
		
	print_header("WizIQ class", "");
    
	print_simple_box_start('center', '100%');

    
    echo '<strong><center><font color="red">'.$ErrorMessage.'</font></center></strong><br><br>';
echo'<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a>';
    print_simple_box_end();
    print_footer($course);   
  //  echo("in error this is wat have to check");
 }
?>