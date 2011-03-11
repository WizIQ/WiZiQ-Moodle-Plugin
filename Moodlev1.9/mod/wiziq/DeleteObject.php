<?php

require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
require_once('wiziqconf.php');
require_login();
 $sectionreturn = optional_param('sr', '', PARAM_INT);
    $course = optional_param('course', 0, PARAM_INT);
    
    $urlcourse = optional_param('course', 0, PARAM_INT);

if(!$site = get_site()) {
        redirect($CFG->wwwroot.'/'.$CFG->admin.'/index.php');
    }
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
$navlinks[] = array('name' => 'Delete WiZiQ Content', 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);
	
	
	print_header($site->shortname.':'.$strwiziqs,$strwiziqs,$navigation, $wiziq->name,"", true,"",user_login_string($site));
	print_simple_box_start('center', '', '', 5, 'generalbox', $module->name);	
	
$contentid=$_REQUEST['contentid'];
$folderid=$_REQUEST['folderid'];
$flag=$_REQUEST['flag'];
$offset=$_REQUEST['offset'];
$currenttotal=$_REQUEST['currenttotal'];
$q=urlencode($_REQUEST['q']);

if($_REQUEST['flag']!=1)
{
?><div align="center" style="margin-top:20px; margin-bottom:20px; width:550px; height:100px; margin-left:230px; background-color:#FAA; padding-top:20px; padding-left:5px; padding-right:5px; border-color:#DDD; border-width:thin; border-style:solid" ><font face="Arial, Helvetica, sans-serif" color="#020202" size="3"><strong>Are you sure you want to delete the selected content?</strong></font><br />
<div align="center"><font face="Arial, Helvetica, sans-serif" color="#0066CC" size="5"><strong><input type="submit" value="Yes" name="yes" onclick="javascript:location.href='deleteobject.php?flag=1&contentid=<?php echo $contentid; ?>&folderid=<?php echo $folderid; ?>&offset=<?php echo $offset; ?>&currenttotal=<?php echo $currenttotal; ?>&q=<?php echo $q; ?>&course=<?php echo $urlcourse; ?>'" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="No" name="no" onclick="javascript:history.go(-1)"/></strong></font></div>


</div>
<?php
}
if($flag==1 && !empty($folderid))
{
$query="select * from ".$CFG->prefix."wiziq_content where parentid=".$folderid." and isdeleted=0";
$result=mysql_query($query);
if(mysql_num_rows($result)==0)
{
	//////////////////// DELETE CODE/////////////////////////////
	
	$query1="update ".$CFG->prefix."wiziq_content set isDeleted=1 where id=".$folderid;
	mysql_query($query1);
	echo '<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We Are Processing Your Request. Please Wait............</strong></font></p>';
	redirect("managecontent.php?offset=$offset&currenttotal=$currenttotal&q=$q&course=$urlcourse");

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
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#0066CC" size="5"><strong>The Folder can not be deleted. Please delete the files from the respective folder. </strong></font></p> </td>
  </tr>
  <tr>
    <td align="center"> <input type="button" class="txtbox" name="Cancel" value="Go to content list" onClick='javascript:location.href="managecontent.php?offset=<?php echo $offset; ?>&currenttotal=<?php echo $currenttotal; ?>&q=<?php echo $q; ?>&course=<?php echo $urlcourse; ?>"'> </td>
  </tr>
</table>
<?php
}
}
else if($flag==1 && !empty($contentid))
{
	try
	{
	//////////////////// DELETE CODE/////////////////////////////
	$content = file_get_contents($contentUpload.'?method=deletecontent&key='.$customer_key.'&contentid='.$contentid);
 

	 $objDOM = new DOMDocument();
 	 $objDOM->loadXML($content); 
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
$contentDelete= $objDOM->getElementsByTagName("rsp")->item(0);	
$isDeleted = $contentDelete->getAttributeNode('stat')->value;


if($isDeleted=="ok")
{
	$query1="update ".$CFG->prefix."wiziq_content set isDeleted=1 where contentid=".$contentid;
	mysql_query($query1);
	echo '<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We Are Processing Your Request. Please Wait............</strong></font></p>';
	redirect("managecontent.php?offset=$offset&currenttotal=$currenttotal&q=$q&course=$urlcourse");
}

}
print_footer();
?>


