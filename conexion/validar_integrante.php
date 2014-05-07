<?php
            include('conexion.php');
              $u=$_POST["grupo"];
              $c ="SELECT count(*) as numer
                              from integrante, usuario, carrera 
                              where grupo_empresa='$u'
                              and  usuario.nombre_usuario=integrante.nombre_usuario 
                              AND carrera=carrera.id_carrera";
               $r = mysql_query($c);
               $res = mysql_fetch_array($r);
               $num=  $res['numer'];
               $counta=0;
               while($counta < $num){
                       $a=$_POST["a".$counta];
                       $b=0;

                       if($_POST["b".$counta]){
                           $b=1;                     
                       }
                        $sql = "UPDATE usuario
                        SET habilitado='$b'
                        WHERE nombre_usuario = '$a'";
                        $result = mysql_query($sql);      
                 $counta++;
               }
               header("Location:../administrar_integrante.php");
              
?>