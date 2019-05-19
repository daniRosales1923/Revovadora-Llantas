<?php
session_start(); 

?>
<?php
       
        include("conecta.php");
        $ClsCn = new ConexionDatos();
        $ClsCn->conecta();
        $result = $ClsCn->DatosUsuario($_POST['“txtusr”'], $_POST['“txtpwd”'] );
        $rows =pg_numrows($result);
        $arr = pg_fetch_array($result, 0, PGSQL_ASSOC);
        $IdUsr = $arr["idusuario"];
        if ($IdUsr != ""){
                $_SESSION['idusr'] = $arr['idusuario'];
                $_SESSION['nombre'] = $arr['nombre'];
                $_SESSION['apellido'] = $arr['apellidopaterno'];
                $_SESSION['usuario'] = $arr['usuario'];
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (10 * 60) ;
                header('Location: Menu.php');
                die() ;
        }
        else{
            
        }
?>