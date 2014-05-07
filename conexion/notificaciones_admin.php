<?php
    if(!isset($titulo)){
        header('Location: ../index.php');
    }
    
    include("conexion.php");
    $men =1;
    $consulta_sql="SELECT COUNT(*) as num
                    FROM usuario
                    WHERE (tipo_usuario = '2' || tipo_usuario = '3') AND habilitado = '0'";
    $consulta = mysql_query($consulta_sql,$conn)
		or die("Could not execute the select query.");
	$resultado = mysql_fetch_assoc($consulta);

    if($resultado['num']>0 ){
       echo "<ul>
	         <li>Hay ".$resultado['num']." nuevos consultores</li>
	         </ul>";
             $men =0;
             }

           $consulta_sql="SELECT COUNT(*) as num
                    FROM usuario
                    WHERE tipo_usuario = '4'  AND habilitado = '0'";
            $consulta = mysql_query($consulta_sql,$conn)
        		or die("Could not execute the select query.");
        	$resultado = mysql_fetch_assoc($consulta);

            if($resultado['num']>0 ){
               echo "<ul>
        	         <li>hay ".$resultado['num']." nuevos grupos empresa</li>
        	         </ul>";
                     $men =0;

             }

           $consulta_sql="SELECT COUNT(*) as num
                            FROM mensaje
                            WHERE para_usuario = \"admin\"";
            $consulta = mysql_query($consulta_sql,$conn)
        		or die("Could not execute the select query.");
        	$resultado = mysql_fetch_assoc($consulta);

            if($resultado['num']>0 ){
               echo "<ul>
        	         <li>Tienes ".$resultado['num']." mensajes</li>
        	         </ul>";
                     $men =0;
             }
            if($men=='1')   {
                echo "<ul>
        	         <li>No tienes notificaciones </li>
        	         </ul>";
            }


?>
             