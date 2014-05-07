<?php
            include('conexion.php');
              $u=$_POST["consultor"];
              $c ="SELECT count(*) as numer
                        FROM grupo_empresa g, consultor_tis c, usuario u, integrante i
                        WHERE c.nombre_usuario = '$u'
                        AND c.nombre_usuario = g.consultor_tis
                        AND g.nombre_usuario = u.nombre_usuario
                        AND i.nombre_usuario = g.nombre_usuario";
               $r = mysql_query($c);
               $res = mysql_fetch_array($r);
               $num=  $res['numer'];
               $counta=0;
               while($counta < $num){
                       $a = $_POST["a".$counta];
                       $b=0;

                       if($_POST["b".$counta]){
                           $b=1;                     
                       }
                        $sql = "UPDATE usuario
                        SET habilitado='$b'
                        WHERE nombre_usuario ='$a'";
                        $result = mysql_query($sql);      
                 $counta++;
               }
               header("Location:../administrar_grupo.php");
              
?>