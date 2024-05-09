<?php


/*$serverName="localhost";
$uid = 'edms';
$pwd = "49HPYH2@siaya";
$dbase = "edms";*/

//$serverName = "(local)\sqlexpress";    

//$serverName = "WIN-PCKKBULHUNJ\SQLEXPRESS";
 //serverName\instanceName
//$serverName = "serverName\\sqlexpress, 1542"; //serverName\instanceName, portNumber (default is 1433)
/*$myServer = "WIN-PCKKBULHUNJ";
$myUser = "edms";
$myPass = '49HPYH2@siaya';
$myDB = "edms";
*/
// $serverName = "WIN-PCKKBULHUNJ\SQLEXPRESS"; //serverName\instanceName, portNumber (default is 1433)
// $connectionInfo = array( "Database"=>"edms", "UID"=>"edms", "PWD"=>"49HPYH2@siaya");
// $db = sqlsrv_connect( $serverName, $connectionInfo);

/*if( $db ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}*/


$db = mysqli_connect("localhost","root","","edms_2");
?>