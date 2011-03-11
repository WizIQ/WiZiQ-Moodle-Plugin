<style type="text/css">
.ulink{text-decoration:underline; font-weight:bold; font-size:12px}
.ulink:hover{text-decoration:none;font-weight:bold;font-size:12px}
.dv100{width:100%; float:left}
</style>
<?php // $Id: index.php,v 1.5 2006/08/28 16:41:20 mark-nielsen Exp $
/**
 * This page lists all the instances of wiziqwiziq in a particular course
 *
 * @wiziq 
 * @version $Id: index.php,v 1.5 2006/08/28 16:41:20 mark-nielsen Exp $
 * @package wiziq
 **/

/// Replace wiziq with the name of your module

    require_once("../../config.php");
  require_once("lib.php");
 include("paging.php");
 require_once($CFG->dirroot .'/course/lib.php');
 require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
require_once("wiziqconf.php");
    $id = required_param('id', PARAM_INT);   // course

    if (! $course = get_record("course", "id", $id)) {
        error("Course ID is incorrect");
    }

    require_login($course->id);

    add_to_log($course->id, "wiziq", "view all", "index.php?id=$course->id", "");


/// Get all required stringswiziq
//preeti found here wiziq
    $strwiziqs = get_string("modulenameplural", "wiziq");
    $strwiziq  = get_string("WiZiQ", "wiziq");


/// Print the header

    if ($course->category) {
        $navigation = "<a href=\"../../course/view.php?id=$course->id\">$course->shortname</a> ->";
    } else {
        $navigation = '';
    }

    print_header("$course->shortname: $strwiziqs", "$course->fullname", "$navigation $strwiziqs", "", "", true, "", navmenu($course));
	echo "<br />";
include("sideblock.php");
/// Get all the appropriate data

  $limit=10;  
$todaydate=usergetdate(time());

$timestamp= make_timestamp($todaydate['year'], $todaydate['mon'], $todaydate['wday'], $todaydate['hours'], $todaydate['minutes']);
/// Print the list of instances (your module will probably extend this)
 $query="(SELECT * FROM ".$CFG->prefix."wiziq order by insescod DESC)" ;
$query=paging_1($query,"","0%",$id);
$result=mysql_query($query) or die("sql failed gettin wiziqs");
echo '<table border="0" cellpadding="5px" cellspacing="5px" width="800px" bordercolor="#efefef" align="right">
<th align="left" height="30px" style="background-color:#efefef;">WiZiQ Classes</th>';
while($rn=mysql_fetch_array($result))
{
 $udate=usergetdate($rn["wdate"]);
 $m=$udate['mon'];
 $y=$udate['year'];
 $d=$udate['mday'];
$wdate=$m."/".$d."/".$y;
echo '<tr style="border-bottom:solid 1px #efefef"><td style="font-size:12px; "><a href="view.php?id='.$rn["id"].'" class="ulink" ><strong>'.$rn["name"].'</strong></a></br>'.$wdate.'-'.$rn["wtime"].  ($rn["timezone"]).'</td></tr>';
}
 echo '<tr><td>';
$str="";
paging_2($str,"0%",$id);

echo '</td></tr>';   
echo '</table>';


/// Finish the page
    print_footer($course);
?>
