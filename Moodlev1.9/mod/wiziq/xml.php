<?php
require_once("wiziqconf.php");
$content = file_get_contents($ConfigFile);
if ($content !== false) {
   // do something with the content
   //echo "file is read",$content;
} else {
   // an error happened
   echo "file is not read";
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
$MaxDurationPerSession = $objDOM->getElementsByTagName("MaxUsersPerSession");
$MaxDurationPerSession = $objDOM->getElementsByTagName("PresenterEntryBeforeTime");
$MaxDurationPerSession = $objDOM->getElementsByTagName("PrivateChat");
$MaxDurationPerSession = $objDOM->getElementsByTagName("RecordingCreditLimit");
$ConcurrentSessions = $objDOM->getElementsByTagName("ConcurrentSessions");	


//$test = getElementsByTagName("appSettings");

//$album = $test->item(0)->nodeValue;

//echo $MaxDurationPerSession->item(0)->nodeValue;
//echo $ConcurrentSessions->item(0)->nodeValue;
  
?>