<?php
/*CONEXION CON LA BASE DE DATOS USUARIO:jimmy PASS:201101027 BASEDEDATOS:sistema_tis*/
	$conn = mysql_connect("localhost","tis","tis") or die(mysql_error());
	mysql_select_db("tis", $conn) or die(mysql_error());
	mysql_query("SET NAMES 'utf8'");
?>