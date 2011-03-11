<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Manage Content</title>
<style type="text/css">
.ulink{ text-decoration:underline;}
.ulink:hover{ text-decoration:none;} 
 
</style>
</head>
<body>
<form action="ManageContent.php" method="post">
<?php
require_once("../../config.php");
 require_once("lib.php");
 require_once($CFG->dirroot .'/course/lib.php');
 require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
include("contentPaging.php");
require_once("wiziqconf.php");
require_once("cryptastic.php");
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
	
	
    $eventid = optional_param('id', 0, PARAM_INT);
    $eventtype = optional_param('type', 'select', PARAM_ALPHA);
    $urlcourse = optional_param('course', 0, PARAM_INT);
	$cal_y = optional_param('cal_y');
    $cal_m = optional_param('cal_m');
    $cal_d = optional_param('cal_d');
	
    if(isguest()) {
        // Guests cannot do anything with events
        redirect(CALENDAR_URL.'view.php?view=upcoming&amp;course='.$urlcourse);
    }

    $focus = '';

    if(!$site = get_site()) {
        redirect($CFG->wwwroot.'/'.$CFG->admin.'/index.php');
    }
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
	 // If a course has been supplied in the URL, change the filters to show that one
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
	$navlinks[] = array('name' => 'WiZiQ Content', 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);
	
	print_header($SITE->shortname.':'.$strwiziqs,$strwiziqs,$navigation, $wiziq->name,"", true,"",user_login_string($site));
	print_simple_box_start('center', '', '', 5, 'generalbox', $module->name);
	//include("sideblock.php");
	?>
<table><tr>
<td width="180px" align="left" valign="top">
<?php
include("sideblock.php");
?>
</td>
<td width="800px">

   
    <table cellspacing="3" cellpadding="3" border="0" width="100%" style="margin-left: auto; margin-right:100px; font-size:14px;font-family:Arial,Verdana,Helvetica,sans-serif; ">
    <tr><td>
    <input type="hidden" name="refreshCount" id="refreshCount" value=""/>
    
    <table class="files" border="0" cellpadding="2" cellspacing="2" width="660" height="100%;" style="border-bottom:solid 1px #ddd; margin-bottom:10px">
    <tr><td valign="top" align="left" style="font-size:14px; font-weight:bold">Manage Content</td></tr>
    <tr><td valign="top" height="15px"></td></tr>
    <tr>
    <th scope="col" class="header name" align="left" width="330" style="padding-left:10px; font-size:12px">Name</th>
    <th scope="col" class="header size" align="left" valign="top" width="180" style="font-size:12px;" >Status
     <?php
	 
	 $url=curPageURL(); 
	  $urlparam=split("&",$url);
	  $size=sizeof($urlparam);
	  //echo "r=".$urlparam[$size-1]=="refresh=1";
	 //print_r($mn);
$abs= $_SERVER["REQUEST_URI"];
$index=strpos($abs,"?");
if(empty($index))
{
?>
     	<a href="<?php echo curPageURL()."?refresh=1"; ?>" id="hrefRefresh"><img src="images/refresh.jpg" alt="Refresh" title="Refresh" align="top"/></a>
	 <?php 
}
	else if($urlparam[$size-1]=="refresh=1" ) {?>
     	<a href="<?php echo curPageURL(); ?>" id="hrefRefresh"><img src="images/refresh.jpg" alt="Refresh" title="Refresh" align="top"/></a>
	 <?php } else { ?>
     	<a href="<?php echo curPageURL()."&refresh=1"; ?>" id="hrefRefresh"><img src="images/refresh.jpg" alt="Refresh" title="Refresh" align="top"/></a><?php }?>
    </th><th scope="col" width="150" class="header commands" style="font-size:12px">Action</th>
    </tr>
    
<?php
//$_request=array();

//echo curPageURL();
if(!empty($_REQUEST['q']))
{
 parse_str(urldecode(decrypt($_REQUEST['q'])),$_request);

}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

$sublevel=1;
$subfolder="0|Content";
if(!empty($_request['s']))
{

$subfolder=$_request['s'];
 $arrayfolder=explode(",",$subfolder);
 //print_r($arrayfolder);
$sublevel=sizeof($arrayfolder)-1;
for($i=0;$i<sizeof($arrayfolder);$i++)
 {
	 
if(!empty($_subfolder))
	 $_subfolder=$_subfolder.",".$arrayfolder[$i];
else
$_subfolder=$arrayfolder[$i];

	$arraystring=explode("|",$arrayfolder[$i]); 
 $delstr='id='.$arraystring[0].'&s='.$_subfolder;	

//echo '<a href="managecontent.php?id='.$arraystring[0].'&s='.$_subfolder.'">'.$arraystring[1].'</a>'.'>>';
if($i<sizeof($arrayfolder)-1)
{

	$msg='id='.$arraystring[0].'&s='.$_subfolder;
	$str =urlencode(encrypt(urlencode($msg)));

	$alink='<a href="managecontent.php?q='.$str.'&course='.$urlcourse.'">'.$arraystring[1].'</a>';
$alink=$alink.'>>';
}
else
$alink=$arraystring[1];
echo $alink;
 }
}
$delstr=urlencode(encrypt(urlencode($delstr)));
/*if(!empty($_REQUEST['c']))
{
$sublevel=$_REQUEST['c']+1;	
}*/
//echo "id in request".$_request['id'];
if(!empty($_request['id']))
{
$id=$_request['id'];
}
else 
$id=0;
if($id==0)
{
$_SESSION['folderSubLevel']=1;	
}



if($_POST['btnCreateFolder'])
{
$foldername=$_REQUEST['txtFolder'];

$folderquery="select * from mdl_wiziq_content where name='".$foldername."' and isdeleted=0 and userid=".$USER->id;
	

$folderResult=mysql_query($folderquery);
if(mysql_num_rows($folderResult)>0)
{
	$errorMsg="This Folder Name is already in use";
	
}
else
{
      $wiziq->name=$foldername;
	  $wiziq->title="folder";
	  $wiziq->description="";
	  $wiziq->type=1;
	  $wiziq->uploaddatetime=time();
	  $wiziq->userid=$USER->id;
	  $filepath="";//'<a href="ManageContent.php?parentid='.$parentid.'">'.$_REQUEST['parentfoldername'].'</a>/';
	  $wiziq->filepath=$filepath;
	  $wiziq->parentid=$id;
insert_record("wiziq_content", $wiziq);	
}
}

$limit=10;
/*$rolequery="select ra.roleid from ".$CFG->prefix."context,".$CFG->prefix."role_assignments ra where ".$CFG->prefix."context.id=ra.contextid and ra.userid=".$USER->id." and (".$CFG->prefix."context.instanceid=".$COURSE->id ." or ".$CFG->prefix."context.instanceid=". 0 .")";

$rows=array();
$roleResult=mysql_query($rolequery);

$i=0;
while($rows=mysql_fetch_array($roleResult))
{
$roleresultant[$i]=$rows['roleid'];
$i++;
}

sort($roleresultant);
$role=$roleresultant[0];
if( $role==1 )
{
$query="select * from ".$CFG->prefix."wiziq_content where parentid=".$id." and isDeleted=0 order by parentid, filepath, name";
}
else
{*/
$query="select * from ".$CFG->prefix."wiziq_content where userid=".$USER->id." and parentid=".$id." and isDeleted=0 order by parentid, filepath, name";	
//}
$query=paging_1($query,"","0%");
//$result=mysql_query($query) or die("fail to get records");

//////////////////// REFRESH CODE /////////////////////////
if($_REQUEST['refresh']==1)
{
if( $role==1 )
{
$refreshQuery="select * from ".$CFG->prefix."wiziq_content where parentid=".$id." and isDeleted=0 and status=1 and type=2";
}
else
{
$refreshQuery="select * from ".$CFG->prefix."wiziq_content where userid=".$USER->id." and parentid=".$id." and isDeleted=0 and status=1 and type=2";
}	
$resultRefresh=mysql_query($refreshQuery) or die("fail to get records for refresh code");
if(mysql_num_rows($resultRefresh)!=0)
{
	for($i=0;$i<=mysql_num_rows($resultRefresh);$i++)
	{
		$resultset=mysql_data_seek($resultRefresh,$i);
		$resultset=mysql_fetch_assoc($resultRefresh);
		$cids=$cids.",".$resultset['contentid'];
		
	}
 $cids=trim($cids,",");
	//$cids="17302,17301,16577,16576";
 $content = file_get_contents($contentUpload.'?method=contentconversionstatus&cids='.$cids.'');

try
	{
	 $objDOM = new DOMDocument();
 	 $objDOM->loadXML($content); 
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
$contentTable= $objDOM->getElementsByTagName("content");	
$length =$contentTable->length;
//$i=1;
foreach( $contentTable as $value )
  {
	  
	//  $j=1;
$conid = $value->getElementsByTagName("id");
 $conid= $conid->item(0)->nodeValue;
//$statusXMLarray[$i][$j]=$conid;  

$stat = $value->getElementsByTagName("stat");
 $stat= $stat->item(0)->nodeValue;
//$statusXMLarray[$i][$j+1]=$stat;
//$i++;
$sqlStatement='update '.$CFG->prefix.'wiziq_content set status='.$stat.' where contentid='.$conid;
mysql_query($sqlStatement) or die("can not update");
  }
     
}
//print_r($statusXMLarray);
}
$result=mysql_query($query) or die("fail to get records");
if(mysql_num_rows($result)!=0)
{
for($i=0;$i<mysql_num_rows($result);$i++)
{
	$resultset=mysql_data_seek($result,$i);
	$resultset=mysql_fetch_assoc($result);
if($resultset['type']==2) //file
{
?>
<tr class="folder"><td align="left" width="330" class="name" style="white-space: nowrap;padding:0 0 10px 10px"><?php echo "<img src=\"images/".$resultset['icon']."\" /> ".$resultset['title']; ?>
<?php
}
else if($resultset['type']==1) //folder
{
	//$subfolder=$subfolder.",".$resultset['id']."|".$resultset['name'];
?>

<tr class="folder">

<td align="left" class="name" width="330" style="white-space: nowrap;padding:0 0 10px 10px"><?php 
$msgtable='id='.$resultset['id'].'&s='.$subfolder.','.$resultset['id'].'|'.$resultset['name'];
	 $strtable =urlencode(encrypt(urlencode($msgtable)));
echo "<img src=\" ".$CFG->pixpath."/f/folder.gif\"  />"." <a href=\"ManageContent.php?q=".$strtable."&course=".$urlcourse."\"  >". $resultset['name']."</a>"	;
}
?></td><td width="180px" valign="top" style="padding:0 0 10px 10px"><?php  
     
		 if($resultset['type']==2) //file
		 {
		  	  if($resultset['status']==3)
			  echo 'Not Available';
			  else if ($resultset['status']==2)
			  echo 'Available';
			  else
			  echo 'InProgress';
			 
		 }
		  ?></td><td class="commands" width="140px" align="center" style="font-size:12px;padding:0 0 10px 10px"><?php if($resultset['type']==2){ ?>
     	<a href="deleteobject.php?<?php echo "contentid=".$resultset['contentid']."&q=".$delstr."&offset=".$_REQUEST['offset']."&currenttotal=".$_REQUEST['currenttotal']."&course=".$urlcourse; ?>" id="hrefDelete" class="ulink" ><span class="ulink">Delete</span></a><?php } else if($resultset['type']==1){ ?><a href="deleteobject.php?<?php echo "folderid=".$resultset['id']."&q=".$delstr."&offset=".$_REQUEST['offset']."&currenttotal=".$_REQUEST['currenttotal']."&course=".$urlcourse; ?>" id="hrefDelete" class="ulink"><span class="ulink">Delete</span></a><?php } ?> </td></tr>
<?php

}
}
else
{
?>
<tr><td colspan="3"><center>No files in this folder</center><br /><a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a></td></tr>
<?php
}
?>

</table>

<table cellspacing="2" cellpadding="2" border="0" width="640">
<tr><td style="font-size:12px">
<?php
$createid='id='.$id.'&s='.$subfolder;
	 $strcreate =urlencode(encrypt(urlencode($createid)));
if($sublevel<=2)
{
	
?>
 <div style="color:red" id="errorMsg"><?php if(!empty($errorMsg)) { echo $errorMsg; } ?></div>     

<input type="text" id="txtFolder" name="txtFolder" maxlength="20"/> &nbsp; &nbsp; &nbsp;<input type="submit" id="btnCreateFolder" name="btnCreateFolder" value="Make Folder" onclick="return submitForm('<?php echo $strcreate; ?>','<?php echo $urlcourse; ?>');"/>&nbsp; &nbsp; &nbsp; 

<?php
}
?>
<a href="file.php?q=<?php echo $strcreate; ?>&course=<?php echo $urlcourse; ?>">Upload File</a>
</td>
<td>
<?php
$str="";
paging_2($str,"0%",$strcreate);?>
</td></tr>
</table>

</td></tr>
 </table>
 </td>
 </tr>
 </table>

<?php
print_footer();	?>

</form>
</body>
<script type="text/javascript">
function submitForm(id,courseid)
{
	//alert(id+','+s);
	if(document.getElementById('txtFolder').value=="")
	{
	document.getElementById('errorMsg').innerHTML="Enter folder name";	
	return false;
	}
	
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

  for (var i = 0; i < document.getElementById('txtFolder').value.length; i++) {
  	if (iChars.indexOf(document.getElementById('txtFolder').value.charAt(i)) != -1) {
  	document.getElementById('errorMsg').innerHTML="Special characters are not allowed.";
  	return false;
  	}
  }
	 var form = document.forms[0];
    var action = form.action; 
	
	action=action+'?q='+id+'&course='+courseid;
	
  form.action =action;
  return true;
}
function refreshlink()
{
var currentPageUrl=location.href;
document.getElementById('refreshCount').value="1";
document.getElementById('hrefRefresh').href=currentPageUrl;
}
</script>
</html>