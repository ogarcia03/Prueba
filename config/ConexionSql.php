<?php
$serverName = "DANIEL\SQLEXPRESS"; //serverName\instanceName
$connectionInfo = array( "Database"=>"ClientesAlmPropios", "UID"=>"isaac1", "PWD"=>"123");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>