<?php
	include('conexion.php');
	$cantidad_valida=false;
	$cantidad_faltante=0;
	$nombre_usuario=$_SESSION['nombre_usuario'];
	$consulta_sql="SELECT COUNT(*) as numero
	from  integrante
	WHERE grupo_empresa='$nombre_usuario'";
	$consulta = mysql_query($consulta_sql,$conn)
		or die("Could not execute the select query.");

	$resultado = mysql_fetch_assoc($consulta);
	if (!empty($resultado['numero'])){
		$numero_integrantes=$resultado['numero'];
		if ($numero_integrantes<3) {
			$cantidad_valida=false;
			$cantidad_faltante=3-$numero_integrantes;
		}
		elseif ($numero_integrantes>=3) 
		{
			$cantidad_valida=true;
			$cantidad_faltante=5-$numero_integrantes;
		}
	}
	mysql_free_result($consulta);
?>
