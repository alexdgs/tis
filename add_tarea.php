
<?php
   include('conexion/conexion.php');

    $operacion=$_POST['operacion'];


     if($operacion == "insert"){

    $grupoempresa=$_POST['grupoEmpresa'];
	$decripsion=$_POST['what'];
	$responsable=$_POST['choose_responsable'];
	$fechaini=$_POST['startDate'];
    $fechafin=$_POST['endDate'];
    $colorTarea=$_POST['colorBackground'];
    $colorTexto=$_POST['colorForeground'];
    $res=$_POST['res'];
    $actividad=$_POST['choose_actividad'];
               /*  $consulta_actividades = "SELECT age.id_actividad_grupo_empresa,age.fecha_inicio,age.fecha_fin
                                          FROM entrega_producto ep,actividad_grupo_empresa age
                                          WHERE ep.grupo_empresa = '".$grupoempresa."' AND ep.id_entrega_producto = age.id_actividad_grupo_empresa";
            			                  $resultado_actividades = mysql_query($consulta_actividades);  */
            			                 // while($row_actividades = mysql_fetch_array($resultado_actividades)) {
                 $sql = "INSERT INTO tarea (id_tarea,descripcion,integrante,actividad_grupo_empresa,fecha_inicio,fecha_fin,resultado,verificable,color_tarea,color_texto)
                         VALUES (' ','$decripsion','$responsable','$actividad','$fechaini','$fechafin','$res',' ','$colorTarea','$colorTexto')";
            	         $result = mysql_query($sql,$conn) or die(mysql_error());
                                         //              break;
                                          //             }
          }
 if($operacion == "update"){

    $grupoempresa=$_POST['grupoEmpresa'];
	$decripsion=$_POST['what'];
	$fechaini=$_POST['startDate'];
    $fechafin=$_POST['endDate'];
    $fechaanini=$_POST['fechaini'];
    $fechaanfin=$_POST['fechafin'];

    $dateininew=date_parse($fechaini);
    $dateininew=$dateininew.date("Y-m-d");
    $datefinnew=date_parse($fechafin);     $datefinnew=$datefinnew.date("Y-m-d");
    $dateiniold=date_parse($fechaanini);   $dateiniold=$dateiniold.date("Y-m-d");
    $datefinold=date_parse($fechaanfin);   $datefinold=$datefinold.date("Y-m-d");

    $consulta_t = "SELECT t.id_tarea,t.fecha_inicio,t.fecha_fin,t.descripcion
                   FROM entrega_producto ep,actividad_grupo_empresa age,tarea t
                   WHERE ep.grupo_empresa='$grupoempresa'and ep.id_entrega_producto=age.entrega_producto
                   and age.id_actividad_grupo_empresa=t.actividad_grupo_empresa  and t.descripcion='$decripsion'";      // and t.fecha_inicio = '$dateiniold ' and  t.fecha_fin='$datefinold'
    $resultado_t = mysql_query($consulta_t);
                      while($row_t = mysql_fetch_array($resultado_t)) {
                             $sql = "UPDATE tarea SET  fecha_inicio='$dateininew', fecha_fin='$datefinnew', descripcion='$fechaini'
                             WHERE id_tarea = '".$row_t['id_tarea']."'";
                             $result = mysql_query($sql,$conn) or die(mysql_error());
                      }



                       }

 if($operacion == "deletetarea"){
    $grupoempresa=$_POST['grupoEmpresa'];
	$decripsion=$_POST['what'];
	$fechaini=$_POST['startDate'];
    $fechafin=$_POST['endDate'];
    $dateininew=date_parse($fechaini);     $dateininew=$dateininew.date("Y-m-d");
    $datefinnew=date_parse($fechafin);     $datefinnew=$datefinnew.date("Y-m-d");

    $consulta_t = "SELECT t.id_tarea,t.fecha_inicio,t.fecha_fin,t.descripcion
                   FROM entrega_producto ep,actividad_grupo_empresa age,tarea t
                   WHERE ep.grupo_empresa='$grupoempresa'and ep.id_entrega_producto=age.entrega_producto
                   and age.id_actividad_grupo_empresa=t.actividad_grupo_empresa  and t.descripcion='$decripsion'";      // and t.fecha_inicio = '$dateiniold ' and  t.fecha_fin='$datefinold'
    $resultado_t = mysql_query($consulta_t);
     while($row_t = mysql_fetch_array($resultado_t)) {
                             $sql = "DELETE from tarea
                             WHERE id_tarea = '".$row_t['id_tarea']."'";
                             $result = mysql_query($sql,$conn) or die(mysql_error());
                      }




    }
if($operacion == "deleteall"){

              $sql = "INSERT INTO tarea (id_tarea,descripcion,integrante,actividad_grupo_empresa,fecha_inicio,fecha_fin,resultado,verificable,color_tarea,color_texto)
            VALUES (' ','1','1','1',' ',' ','res','a','f','f')";
            	         $result = mysql_query($sql,$conn) or die(mysql_error());

    $grupoempresa=$_POST['grupoEmpresa'];
	$decripsion=$_POST['what'];


    $consulta_t = "SELECT t.id_tarea,t.fecha_inicio,t.fecha_fin,t.descripcion
                   FROM entrega_producto ep,actividad_grupo_empresa age,tarea t
                   WHERE ep.grupo_empresa='$grupoempresa'and ep.id_entrega_producto=age.entrega_producto
                   and age.id_actividad_grupo_empresa=t.actividad_grupo_empresa "; // and t.descripcion='$decripsion'";      // and t.fecha_inicio = '$dateiniold ' and  t.fecha_fin='$datefinold'
    $resultado_t = mysql_query($consulta_t);
     while($row_t = mysql_fetch_array($resultado_t)) {
                             $sql = "DELETE from tarea
                             WHERE id_tarea = '".$row_t['id_tarea']."'";
                             $result = mysql_query($sql,$conn) or die(mysql_error());
                      }




    }






















?>