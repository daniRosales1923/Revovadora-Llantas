<?php
    // header('Content-Type: text/html; charset=UTF-8');
    // session_start();
    // if (isset($_SESSION['nombre'])){
    //     $cliente = $_SESSION['nombre'];
    // }else{
 	// 	header('Location: LogIn.php');
    //  	die() ;
    // }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset=“UTF-8”>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
    crossorigin="anonymous">
    <link rel="stylesheet" href = "../assets/css/main.css">
    </head>

    <body>
        <!-- <div id="sesion_cliente">
            <?php 
            // if(isset($_SESSION['nombre'])){
            //     echo "<p> Bienvenido ".$cliente."&nbsp;&nbsp;";
            //     echo "<a href='LogIn.php?salir=1'>Salir</a></p>";
            //     if(isset($_REQUEST["salir"])){
            //         unset($_SESSION["cliente"]);
            //     }
            // }
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
                 Aqui va todo el código del cuerpo... 
            </div>
        </div> -->

        <section class="main">
            <div class="section_logo">
                <div id="logo">
					<img src="../assets/img/logo2.png" width="195" height="195">
				</div>
            </div>

            <div class="section_content">
                <header class="section_content-nav">
                    <div class="title">
                        <h2 class="item_title">Renovadora de llantas</h2>
                    </div>
                    <nav class="navbar" id="menu">
                        <ul>
                            <li><a href="">ENTRADAS</a></li>
                            <li><a href="">CONCENTRADO RENOVADO</a></li>
                            <li><a href="">VENTAS</a></li>
                            <li><a href="">REPORTES</a></li>
                            <li><a href="">USUARIOS</a></li>
                        </ul>

                        <input class="burger-check" id="burger-check" type="checkbox"><label for="burger-check" class="burger">
                    </nav>
                </header>
                <div class="area_trabajo">
                    Esta es un area de trabajo
                </div>

            </div>
            
        </section>
		<footer class="footer">
				<p class="footer-text">
                <i class="fas fa-copyright"></i> Todos los derechos reservados - Instituto Tecnologico de Orizaba. <br>
					Diseñado por alumnos del plantel.
				</p>
		</footer>
    </body>
</html>