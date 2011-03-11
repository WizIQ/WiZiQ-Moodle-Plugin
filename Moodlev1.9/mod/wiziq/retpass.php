 <?php
 
 require_once("../../config.php");
    require_once("lib.php");
    require_once($CFG->dirroot.'/mod/wiziq/nusoap/lib/nusoap.php');
   
	
		
 $email=$_POST['email'];
  
	
class detail {

     		var $userEmailAddress;
   
			}
			
    
			$obj = new detail;
//			$obj->userEmailAddress=$email;
			$obj->userEmailAddress="support@wiziq.com";
			

 

$client = new  nusoap_client('http://service.wiziq.com/ws/SchedulingService.asmx');
 
  $client->xml_encoding = "UTF-8";
  $client->setHeaders(
            '
             <UserCredentials xmlns="http://tempuri.org">
      <userName>TestMoodle</userName>
      <password>TestMoodle</password>
    </UserCredentials>
            '
        );

 
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//$a="nitingoswami_21@yahoo.com";

$result = $client->call('ForgotPassword',array('objStUserEmail'=>$obj),$namespace='http://tempuri.org',$soapAction='http://tempuri.org/ForgotPassword',$headers=false,$rpcParams=null,$style='rpc',$use='encoded');
//echo("i m here");
print_r($result);





if ($client->fault) {
	echo '<h2>Fault</h2><pre>'; print_r($result); echo '</pre>';
}
 else {
	$err = $client->getError();
	if ($err) {
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		echo '<h2>Result</h2><pre>' . htmlspecialchars($result, ENT_QUOTES) . '</pre>';
	}
}
echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';  
//-------------------------
?>
