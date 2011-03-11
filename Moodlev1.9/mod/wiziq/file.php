<?php
setcookie("query", $_REQUEST['q']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WiZiQ Content</title>
<style type="text/css">
.ulink{text-decoration:underline; font-weight:bold; font-size:12px}
.ulink:hover{text-decoration:none;font-weight:bold;font-size:12px}
</style>
</head>
<body>
<form id="form1" name="form1" method="post" enctype="multipart/form-data" >
<?php
require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
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
	$navlinks[] = array('name' => 'Upload File', 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);
	
	print_header($SITE->shortname.':'.$strwiziqs,$strwiziqs,$navigation, $wiziq->name,"", true,"",user_login_string($site));
	print_simple_box_start('center', '', '', 5, 'generalbox', $module->name);
	?>
<table><tr><td width="180px" align="left" valign="top">
<?php
include("sideblock.php");
?>
</td><td width="800px">

<table cellspacing="2" cellpadding="2" border="0" width="640" style=" margin-right: auto; margin-left: auto;">
 <tr>
 <td valign="top" align="left">
    <table align="left">
     <tr><td  colspan="2" valign="top" align="left" width="50%" style="font-weight:bold;">Upload Content</td>
     <td></td>
     </tr>
     <tr>
 <td style="height:10px"></td>
 <td style="height:10px"><div style="color:red" id="errorMsg"></div> </td>
 </tr>
 <tr>
 <td valign="top" align="left" style="font-weight:bold; font-size:12px; margin-left:30px; float:left"> 
<label for="file" style="width:65px; float:left">Upload File:</label></td>
<td valign="top" align="left"><input type='hidden' name='upProgressID' id='upProgressID' />

        <input type="file" id="fileupload"  name="fileupload" size='40'/>
</td>
</tr>
<tr>
<td style="height:20px"></td>
</tr>
<tr>
<td align="right" style="font-weight:bold;font-size:12px"><label>Title:</label></td>
<td><input type="text" id="txtTitle" name="txtTitle" maxlength="50" style='width:300px'/></td>

</tr><tr>
<td style="height:20px"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><!--<label>Description</label>
<textarea id="txtDesc" name="txtDesc" ></textarea><br />
<br />-->
  <input type="submit" value="Upload" name="btnupload" id="btnupload" onClick="return SubmitUpload(this);" />
  <a href="javascript:history.go(-1)" ><span class="ulink" style="margin-left:13px">Cancel</span></a>
  </td>

</tr>
    
    </table>
    </td>


<td align="center">
<div style="font-size:12px; float:left; margin-left:40px; font-weight:bold; margin-top:35px">Supported file formats and Sizes</div>
<div style="color:#818181;font-size:11px;float:left; margin-left:40px;">
<img src="<?php echo $CFG->wwwroot; ?>/mod/wiziq/images/fileformat.gif" />
 </div>
 </td>
 </tr>


<?php
if(!empty($_REQUEST['q']))
{

 parse_str(urldecode(decrypt($_REQUEST['q'])),$_request);

}
$id=$_request['id'];
 $s=$_request['s'];
 if(!empty($s))
 {
$subfolder=$_request['s'];
 $arrayfolder=explode(",",$subfolder);
 $sublevel=sizeof($arrayfolder)-1;
for($i=1;$i<sizeof($arrayfolder);$i++)
 {
	$arraystring=explode("|",$arrayfolder[$i]); 
	if($i<sizeof($arrayfolder)-1)
{
	$a=$arraystring[1];
$alink.=$a.'\\';
}
else
$alink.=$arraystring[1];

 }
 
 }
echo '<input type="hidden" id="folderid" name="folderid" value="'.$alink.'" />';

?>
</table>
</td></tr></table>
</form>

</body>
<script type="text/javascript" language="javascript">
function SubmitUpload(btn)
        {
			var btnID=btn;
			var check=CallSubmit();
			if(check==true)
			{
				var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

				for (var i = 0; i < document.getElementById('txtTitle').value.length; i++) 
				{
				if (iChars.indexOf(document.getElementById('txtTitle').value.charAt(i)) != -1)
				{
				document.getElementById('errorMsg').innerHTML="Special characters are not allowed.";
				return false;
  				}
  				}
			//var filePath=document.getElementById('fileupload').value;
   			//var fileName=filePath.substr(filePath.lastIndexOf('\\')+1);
   
			
			//document.cookie="title=" +title;
			//document.cookie="Desc=" +document.getElementById("txtDesc").value;
            var ts = new Date().getTime(); 
            //alert("iframe"+document.getElementById('filename').value);
            document.getElementById('upProgressID').value =ts;
			//alert(document.getElementById('upProgressID').value);
            up_UpdateFormAction(btnID);
            //document.forms["form1"].submit();
			document.form1.submit();
			return true;
			}
			else
			return false;
		}
		function CallSubmit()
{
	
	
			if(document.getElementById('fileupload').value=="")
			{
				document.getElementById('errorMsg').innerHTML="Choose the file";
				return false;
			}
			else
			{
	     
				var check=checkExtension();
				if(check==0)
				{
					document.getElementById('errorMsg').innerHTML="File type not supported";
					return false;
				}
				 return true;
			}
			return true;
}
 function checkExtension()
    {
    
        // for mac/linux, else assume windows
       
        var fileTypes     = new Array('.ppt','.pptx','.jnt','.rtf','.pps','.pdf','.swf','.doc','.xls','.xlsx','.docx','.ppsx','.flv','.mp3','.wmv','.wav','.wma','.mov','.avi','.mpeg'); // valid filetypes
        var fileName      = document.getElementById('fileupload').value; // current value
		
        var extension     = fileName.substr(fileName.lastIndexOf('.'), fileName.length);
		
        var valid = 0;
        
        for(var i in fileTypes)
        {
        
            if(fileTypes[i].toUpperCase() == extension.toUpperCase())
            {
                valid = 1;
                break;
                
            }
        
        }
       		  
        return valid;
    }
//var rootUrl="http://192.168.17.57/aGLiveContentAPI/contentmanager.ashx";
//var rootUrl="http://192.168.17.231/aGLiveContentAPI/contentmanager.ashx";
var rootUrl="<?php echo $contentUpload; ?>";

var sessioncode=16326;//26046;

function up_UpdateFormAction(btnID)
{//document.getElementById('upProgressID').value='1281613863469';
    var form = document.forms[0];
    var action = form.action;
    
    var re = new RegExp('&?UploadID=[^&]*');
    if (action.match(re)) action = action.replace(re, '');
    
    var delim;
   
    if (action.indexOf('?') == action.length-1) 
    {
         delim = '';
    }
    else 
    {
        delim = '?';
        if (action.indexOf('?') > -1) delim = '&';
    }
	var filename=document.getElementById('fileupload').value;
   var fileupload=filename.substr(filename.lastIndexOf('\\')+1);
  var title=document.getElementById("txtTitle").value;
			if(title=='')
			title=fileupload;
var folderid=document.getElementById('folderid').value;
btnID.disabled="disabled";
    form.action = rootUrl+'?method=upload&filename='+fileupload+'&UploadID=' + document.getElementById('upProgressID').value+'&m=o&sessioncode=16326&uc=<?php echo $USER->id; ?>&p='+folderid+'&k=<?php echo $customer_key; ?>&nexturl=<?php echo $CFG->wwwroot ;?>/mod/wiziq/uploadreturn.php?t='+title+'|'+<?php echo $urlcourse; ?>;
 //alert(form.action); 
   
}
</script>
</html>

 
<?php

print_footer();	
?>