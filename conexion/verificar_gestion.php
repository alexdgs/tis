<?php
	
	include('conexion.php');
	$gestion_valida=false;
	$nombre_gestion="no definida";
	$consulta_sql="SELECT id_gestion, gestion
				   from gestion_empresa_tis
				   WHERE gestion_activa=1 AND gestion!='0'";
	$consulta = mysql_query($consulta_sql,$conn)
		or die("Could not execute the select query.");

	$resultado = mysql_fetch_assoc($consulta);
	if (!empty($resultado['id_gestion'])){
		$gestion_valida=true;
		$id_gestion=$resultado['id_gestion'];
		$nombre_gestion=$resultado['gestion'];
	}
	mysql_free_result($consulta);
?>
