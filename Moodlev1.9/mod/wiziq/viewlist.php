
<?php
ob_start();

$error=$_REQUEST['error'];
?>
<html>
<head>
<title> THIS PAGE IS SHOWING ERROR FOR THE USER</title>
</head>
<body>

<BR /><BR /><BR /><BR /><BR /><BR /><BR /><BR /><BR /><BR /><BR /><BR /><BR /><BR />
<div align="center">
<font face="Arial, Helvetica, sans-serif" color="#CC0000">
YOU ENTERED THE WRONG TIME FOR SCHEDULING YOUR CLASS!!!!
<BR /><BR />PLEASE ENTER IT CORRECTLY!!!!<BR /><BR />
<?php 
echo "value of error is".$error;
?>
<a href="view.php">CLICK HERE TO RE-SCHEDULE YOUR CLASS</a>
</font>
</div> 

</body>
</html>