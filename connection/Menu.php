<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    if (isset($_SESSION['nombre'])){
        $cliente = $_SESSION['nombre'];
    }else{
 		header('Location: LogIn.php');
     	die() ;
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
      
    </head>

    <body>
        <div id="sesion_cliente">
            <?php 
            if(isset($_SESSION['nombre'])){
                echo "<p> Bienvenido ".$cliente."&nbsp;&nbsp;";
                echo "<a href='LogIn.php?salir=1'>Salir</a></p>";
                if(isset($_REQUEST["salir"])){
                    unset($_SESSION["cliente"]);
                }
            }
            ?>
        </div>

        <div id="menu_cliente">
            <ul id="menu_horizontal">
                <li class="nueva" id="nueva"><a class="active" href="menu_cliente.php?nueva=1#nueva">NUEVA OPINIÓN</a></li>
                <li class="ver" id="ver"><a href="menu_cliente.php?ver=1#ver">VER OPINIONES</a></li>
                <li class="eliminar" id="eliminar"><a href="menu_cliente.php?eliminar=1#eliminar">ELIMINAR OPINIÓN</a></li>
                <li class="datos_cliente" id="datos_cliente"><a href="menu_cliente.php?datos_cliente=1#datos_cliente">DATOS PERSONALES</a></li>
            </ul>

            <div id="cuerpo_body">
                <!-- Aqui va todo el código del cuerpo... -->
            </div>
        </div>
    </body>
</html>