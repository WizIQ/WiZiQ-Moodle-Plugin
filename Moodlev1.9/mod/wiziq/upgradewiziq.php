<?php
require_once("../../config.php");
require_once("lib.php");
 require_once($CFG->dirroot .'/course/lib.php');
 require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
require_login();
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
	$navlinks[] = $calendar_navlink;
	$navlinks[] = array('name' => 'WiZiQ Content', 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);
	
	print_header($SITE->shortname.':'.$strwiziqs,$strwiziqs,$navigation, $wiziq->name,"", true,"",user_login_string($site));
	print_simple_box_start('center', '', '', 5, 'generalbox', $module->name);
	
$flag=0;
if($USER->id==2)
{
$conn = mysql_connect($CFG->dbhost, $CFG->dbuser, $CFG->dbpass) or die('<br><b>Message:</b> Error connecting to mysql');

$dbname = $CFG->dbname;
mysql_select_db($dbname);	

$sql0="CREATE TABLE IF NOT EXISTS `".$CFG->prefix."wiziq_content` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NULL,
  `filepath` varchar(50) NULL,
  `parentid` int(20) NULL,
  `type` tinyint(1) NULL,
  `uploaddatetime` varchar(50) NULL,
  `description` text NULL,
  `userid` int(20) NULL,
  `title` varchar(50) NULL,
  `contentid` int(20) NOT NULL DEFAULT '0',
  `icon` varchar(50) NULL,
  `status` int(10) NOT NULL DEFAULT '1',
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54" ;
mysql_query($sql0) or die("<br>Message: wiziq_content table could not be created");

if(mysql_num_rows(mysql_query("SELECT * FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA='".$dbname."' AND COLUMN_NAME='oldclasses' AND TABLE_NAME='".$CFG->prefix."wiziq'"))>0)
{
	echo "<br><b>Message:</b> OldClasses column exists";
	$flag=1;
}
else
{
$sql1="ALTER TABLE `".$CFG->prefix."wiziq` ADD oldclasses tinyint(1)";	
mysql_query($sql1) or die("<br><b>Message:</b> wiziq table could not be altered");
$flag=1;
$sql2="UPDATE `".$CFG->prefix."wiziq` SET oldclasses=1";
mysql_query($sql2) or die("<br><b>Message:</b> wiziq could not be updated");
$flag=2;
}

if(mysql_num_rows(mysql_query("select * from ".$CFG->prefix."wiziq_attendee_info"))>0)
{
echo "<br><b>Message:</b> wiziq_attendee_info table already exists";
$flag=0;	
}
else
{
$sql3="CREATE TABLE IF NOT EXISTS `".$CFG->prefix."wiziq_attendee_info`(`id` int(10) unsigned NOT NULL auto_increment,`username` char(255)  NOT NULL  ,`attendeeurl` char(255)  NOT NULL ,`insescod` char(255)  NOT NULL ,`userid` int(10) unsigned NOT NULL ,PRIMARY KEY  (`id`)) "; 	
mysql_query($sql3) or die("<br><b>Message:</b> wiziq_attendee_info table could not be created");
$flag=3;
}
if($flag==3)
{
echo '<br><br><strong><center><font color="red"><p>The script has been run successfully.</p></font></center></strong><br>

<p style="padding-left:20px">Next Step:<br> 
Log-in to your moodle site and click on the Notifications link to complete the installation of WiZiQ Virtual Classroom module.</p> 
';	
}
}

print_footer();	
?>