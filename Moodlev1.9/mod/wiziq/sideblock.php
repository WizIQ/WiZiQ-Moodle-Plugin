<head>
<style type="text/css">
.listdv{border-bottom:solid 1px #dedede; font-weight:bold; width:140px; margin-bottom:5px; padding-bottom:5px; float:left}
</style>
</head>
<?php
require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');

require_login();
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
	if(empty($course->id))
	$courseID=$COURSE->id;
	else
	$courseID=$course->id;
  $query="select ra.roleid from ".$CFG->prefix."context,".$CFG->prefix."role_assignments ra where ".$CFG->prefix."context.id=ra.contextid and ra.userid=".$USER->id." and (".$CFG->prefix."context.instanceid=".$courseID ." or ".$CFG->prefix."context.instanceid=". 0 .")";

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
if($role==1 || $role==2 || $role==3 )
{
?>

 <div class="block_wiziqlive sideblock" id="inst15" style="width:150px; float:left; ">
 <div class="header">
 <div class="title" ><h2 style="font-family:Arial, Helvetica, sans-serif"><img src="icon.gif" align="absbottom"/>&nbsp;WiZiQ Live Classes</h2></div></div>
 <div class="content" style="height:90px">
<span class="listdv"><a href="auto.php?id=<?php echo $courseID;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq">Schedule a Class</a></span>
		<span class="listdv"><a href="wiziq_list.php?course=<?php echo $courseID;?>">Manage Classes</a></span>
		<span class="listdv" style="border-bottom:none"><a href="managecontent.php?course=<?php echo $courseID;?>">Manage Content</a></span>
		</div>
        </div>

            <?php

}

?>