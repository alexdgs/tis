<?php
	session_start();
	$valido = $_SESSION['nombre_usuario'];
	if(!$valido || $valido == ""){
	header("Location:../index.php");
	}

	//start and distorying session
	session_start();
	session_destroy();

	//location is on index.php after logout
	header("Location:../index.php");
?>
