<?php
require_once("../../config.php");
    	require_once("lib.php");
      	require_once($CFG->dirroot.'/course/lib.php');
    	require_once($CFG->dirroot.'/calendar/lib.php');
		require_once("wiziqconf.php");
class ClassView_Role
{
public $_className="";
public $_classType="";
public $_classDate="";
public $_classTime="";
public $_classTimeZone="";
public $_classDuration="";
public $_classAudioVideo="";
public $_classStatus="";
public $_classPresenterLink="";
public $_classAttendeeLink="";
public $_classRecordingLink="";
public $_eventUserID="";
public $_roleID="";
public $_timeCheck="";
public $_sessionCode="";
public $_eventID="";
public $_ID="";
public $_udate=array();
public $_todayDate=array();
public $enterflag=1;
public $_courseID="";
public $_userID="";
function check()
{
 echo "checking".$this->_className;
 print_r($this->_udate);
}
function AdminRole()
{
echo '<form name="view"  action="edit_view.php" >
    <div style="float:right; width:750px; margin:10px 0px 0px 10px">
	<div class="dv100"><span style="font-size:16px; float:left; font-weight:bold">'.$this->_className.'</span>
<span style="color:#666; font-size:12px; float:left; margin-left:10px; margin-top:3px">'.$this->_classType.'</span>
</div>
<div class="dv100" style="font-size:12px">'.$this->_classDate.'-'.$this->_classTime.' ('.$this->_classTimeZone.')</div>
 <div style="float:left; margin-top:40px; width:530px; border-bottom:solid 1px #ddd; padding-bottom:20px">
 <p class="dv100"><span class="dur_txt b_txt">Duration</span>
  <span class="type_txt b_txt" >Types of Class</span>
  <span class="rec_txt b_txt">Record this class</span></p>
   <p class="dv100"><span class="dur_txt" style="padding-top:5px;">'.$this->_classDuration.' Minutes</span>
  <span class="type_txt" style="padding-top:5px;">'.$this->_classAudioVideo.'</span>
  <span class="rec_txt" style="padding-top:5px;">'.$this->_classStatus.'</span></p>
 </div>
 <div class="formdv">
   <div class="dv100"><span class="form_left">&nbsp;</span><span class="form_right" style="margin-top:20px">
Use this link to enter in the class.
 </span></div>

 <div class="dv100"><span class="form_left">Presenter Link:</span><span class="form_right">
 <input type="text" onclick="this.select()" value="'.$this->_classPresenterLink.'"  size="35px" class="m_textinput" readonly="true"/>
 </span></div>

   <div class="dv100"> <span class="form_left" >&nbsp;</span><span class="form_right" style="margin-top:20px">
Use this link to invite attendee in the class.
 </span></div>

  <div class="dv100"><span class="form_left">Attendee Link:</span><span class="form_right">
 <input type="text" onclick="this.select()" value=" '.$this->_classAttendeeLink.'"  size="35px" class="m_textinput" readonly="true"/>
  </span></div>';
			  if($this->_classStatus=="Yes" && ($this->_eventUserID==$this->_userID  || $this->_roleID=='1' ))
			  {
			  echo '<div class="dv100"><span class="form_left">&nbsp;</span><span class="form_right" style="margin-top:20px">
Use this link to view recording of the class.
 </span></div>
  <div class="dv100"><span class="form_left">Recording Link:</span><span class="form_right">
 <input type="text" onclick="this.select()" value="'.$this->_classRecordingLink.'"  size="35px" class="m_textinput" readonly="true"/>
  </span></div>';
			  }
		echo '<div class="dv100"><span class="form_left"></span><span class="form_right" style="margin-top:20px">';
		  if( $this->_udate['year'] == $this->_todayDate['year'])
             {
              if($this->_udate['yday'] >= $this->_todayDate['yday'])
               {
                 if( $this->_udate['mon'] >= $this->_todayDate['mon'] )
			      {
					 $this->enterflag=0;
		        	 echo'<input type="submit" value="Enter Class" id="btnenter" onclick="return setValue(this.value);"/>';
			      }
               }
             }
		   else if($this->_udate['year'] > $this->_todayDate['year'])
		   {
  			  $this->enterflag=0;
			  echo'<input type="submit" value="Enter Class" id="btnenter" onclick="return setValue(this.value);"/>';
		   }
		   if( $this->_timeCheck==0 && ($this->_eventUserID==$this->_userID || $this->_roleID=='1' ))
			{
			echo '<a href="edit_view.php?SessionCode='.$this->_sessionCode.'&id='.$this->_ID.'&eventid='.$this->_eventID.'&eventtype='.$this->_classType.'" class="ulink" style="padding-left:10px">Edit Class</a>';
			}
		   if($this->_classStatus=="Yes" && $this->enterflag==1)
		   {
			  echo '<input type="button" onclick="return openDetails(\''.$this->_classRecordingLink.'\');" value="View Recording"/>
			  &nbsp;&nbsp;<a class="ulink" href="attendancereport.php?courseid='.$this->_courseID.'&SessionCode='.$this->_sessionCode.'"><span  class="ulink">View Attendance</span></a> &nbsp;&nbsp; <a class="ulink" onclick="return PopUp(\''.$this->_sessionCode.'\');" href="javascript:void(0);"><span class="ulink">Download Recording</span></a>
			  ';
		   }
	          echo '</span></div></div>
 </div><input type="hidden" value="'.$this->_sessionCode.'" name="SessionCode" id="SessionCode"/><input type="hidden" value="'.$this->_ID.'" name="id"/><input type="hidden" value="'.$this->_eventID.'" name="eventid"/></form>';

}

function TeacherRole()
{
	echo '<form name="view"  action="edit_view.php">
    <div style="float:right; width:750px; margin:10px 0px 0px 10px">
	<div class="dv100"><span style="font-size:16px; float:left; font-weight:bold">'.$this->_className.'</span>
<span style="color:#666; font-size:12px; float:left; margin-left:10px; margin-top:3px">'.$this->_classType.'</span>
</div>
<div class="dv100" style="font-size:12px">'.$this->_classDate.'-'.$this->_classTime.' ('.$this->_classTimeZone.')</div>
 <div style="float:left; margin-top:40px; width:530px; border-bottom:solid 1px #ddd; padding-bottom:20px">
 <p class="dv100"><span class="dur_txt b_txt">Duration</span>
  <span class="type_txt b_txt" >Types of Class</span>
  <span class="rec_txt b_txt">Record this class</span></p>
   <p class="dv100"><span class="dur_txt" style="padding-top:5px;">'.$this->_classDuration.' Minutes</span>
  <span class="type_txt" style="padding-top:5px;">'.$this->_classAudioVideo.'</span>
  <span class="rec_txt" style="padding-top:5px;">'.$this->_classStatus.'</span></p>
 </div>
 <div class="formdv">';
  if($this->_eventUserID==$this->_userID  || $this->_roleID=='1' )
			{
echo  '
   <div class="dv100"><span class="form_left">&nbsp;</span><span class="form_right" style="margin-top:20px">
Use this link to enter in the class.
 </span></div>

 <div class="dv100"><span class="form_left">Presenter Link:</span><span class="form_right">
 <input type="text" onclick="this.select()" value="'.$this->_classPresenterLink.'"  size="35px" class="m_textinput" readonly="true"/>
 </span></div>

   <div class="dv100"> <span class="form_left" >&nbsp;</span><span class="form_right" style="margin-top:20px">
Use this link to invite attendee in the class.
 </span></div>

  <div class="dv100"><span class="form_left">Attendee Link:</span><span class="form_right">
 <input type="text" onclick="this.select()" value=" '.$this->_classAttendeeLink.'"  size="35px" class="m_textinput" readonly="true"/>
  </span></div>';
			}
			  if($this->_classStatus=="Yes" && ($this->_eventUserID==$this->_userID  || $this->_roleID=='1' ))
			  {
			  echo '<div class="dv100"><span class="form_left">&nbsp;</span><span class="form_right" style="margin-top:20px">
Use this link to view recording of the class.
 </span></div>
  <div class="dv100"><span class="form_left">Recording Link:</span><span class="form_right">
 <input type="text" onclick="this.select()" value="'.$this->_classRecordingLink.'"  size="35px" class="m_textinput" readonly="true"/>
  </span></div>';
			  }
echo '<div class="dv100"><span class="form_left"></span><span class="form_right" style="margin-top:20px">';
		  if( $this->_udate['year'] == $this->_todayDate['year'])
             {
              if($this->_udate['yday'] >= $this->_todayDate['yday'])
               {
                 if( $this->_udate['mon'] >= $this->_todayDate['mon'] )
			      {
					 $this->enterflag=0;
		        	 echo'<input type="submit" value="Enter Class" id="btnenter" onclick="return setValue(this.value);"/>';
			      }
               }
             }
		   else if($this->_udate['year'] > $this->_todayDate['year'])
		   {
  			  $this->enterflag=0;
			  echo'<input type="submit" value="Enter Class" id="btnenter" onclick="return setValue(this.value);"/>';
		   }
		   if( $this->_timeCheck==0 && ($this->_eventUserID==$this->_userID  || $this->_roleID=='1' ))
			{
			echo '<a href="edit_view.php?SessionCode='.$this->_sessionCode.'&id='.$this->_ID.'&eventid='.$this->_eventID.'&eventtype='.$this->_classType.'" class="ulink" style="padding-left:10px">Edit Class</a>';
			}
		   if($this->_classStatus=="Yes" && $this->enterflag==1)
		   {
			  echo '<input type="button" onclick="return openDetails(\''.$this->_classRecordingLink.'\');" value="View Recording"/>
			  &nbsp;&nbsp;<a  href="attendancereport.php?courseid='.$this->_courseID.'&SessionCode='.$this->_sessionCode.'" class="ulink"><span  class="ulink">View Attendance</span></a> &nbsp;&nbsp; <a onclick="return PopUp(\''.$this->_sessionCode.'\');" href="javascript:void(0);" class="ulink"><span  class="ulink">Download Recording</span></a>
			  ';
		   }
	          echo '</span></div></div>
 </div><input type="hidden" value="'.$this->_sessionCode.'" name="SessionCode" id="SessionCode"/><input type="hidden" value="'.$this->_ID.'" name="id"/><input type="hidden" value="'.$this->_eventID.'" name="eventid"/></form>';
}

function StudentRole()
{
echo '<form name="view" action="">
	<div style="float:left; width:550px; margin-left:20px; margin-top:20px;">
	<div class="dv100"><span style="font-size:16px; float:left; font-weight:bold">'.$this->_className.'</span>
<span style="color:#666; font-size:12px; float:left; margin-left:10px; margin-top:3px">'.$this->_classType.'</span>
</div>
<div class="dv100" style="font-size:12px">'.$this->_classDate.'-'.$this->_classTime.' ('.$this->_classTimeZone.')</div>
 <div style="float:left; margin-top:40px; width:530px; border-bottom:solid 1px #ddd; padding-bottom:20px">
 <p><span class="dur_txt b_txt">Duration</span>
  <span class="type_txt b_txt" >Types of Class</span>
  <span class="rec_txt b_txt">Record this class</span></p>
   <p ><span class="dur_txt" style="padding-top:5px;">'.$this->_classDuration.' Minutes</span>
  <span class="type_txt" style="padding-top:5px;">'.$this->_classAudioVideo.'</span>
  <span class="rec_txt" style="padding-top:5px;">'.$this->_classStatus.'</span></p>
 </div>
 <div class="formdv">';
			  if($this->_classStatus=="Yes" && ($this->_eventUserID==$this->_userID  || $this->_roleID=='1' ))
			  {
			  echo '<div class="dv100"><span class="form_left">&nbsp;</span><span class="form_right" style="margin-top:20px">
Use this link to view recording of the class.
 </span></div>
  <div class="dv100"><span class="form_left">Recording Link:</span><span class="form_right">
 <input type="text" onclick="this.select()" value="'.$this->_classRecordingLink.'"  size="35px" class="m_textinput" readonly="true"/>
  </span></div>';
			  }
		if( $this->_timeCheck==0 && ($this->_eventUserID==$this->_userID  || $this->_roleID=='1' ))
			{
			echo '<input type="submit" name="update" value="Edit Class" id="name"/>';
			}

		  if( $this->_udate['year'] == $this->_todayDate['year'])
             {
              if($this->_udate['yday'] >= $this->_todayDate['yday'])
               {
                 if( $this->_udate['mon'] >= $this->_todayDate['mon'] )
			      {
					 $this->enterflag=0;
		        	 echo'<input type="submit" value="Enter Class" id="btnenter" onclick="return setValue(this.value);"/>';
			      }
               }
             }
		   else if($this->_udate['year'] > $this->_todayDate['year'])
		   {
  			  $this->enterflag=0;
			  echo'<input type="submit" value="Enter Class" id="btnenter" onclick="return setValue(this.value);"/>';
		   }
		   if($this->_classStatus=="Yes" && $this->enterflag==1)
		   {
			  echo '<a onclick="return openDetails(\''.$this->_classRecordingLink.'\');" href="javascript:void(0);" class="ulink"><span  class="ulink">View Recording</span></a>';
		   }
	          echo '</div>
 </div><input type="hidden" value="'.$this->_sessionCode.'" name="SessionCode" id="SessionCode"/></form>';
}
function iFrameLoad()
{
echo '<div style="width:550px; float:left;">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:520px;height:125px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
 </div>';
}
}
?>