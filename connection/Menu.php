<?php
     header('Content-Type: text/html; charset=UTF-8');
     session_start();
     if (isset($_SESSION['nombre'])){
         /* Variables session Entrada */
				$_SESSION["Folio"]="";
				$_SESSION["fecha"] = "";
				$_SESSION["comentario"]  = "";
				$_SESSION["idcliente"] = "";
				$_SESSION["status"]  = "";
				$_SESSION["idllanta"] = "";
				$_SESSION["Marca"] ="";
				$_SESSION["Modelo"] ="";
			/* Variables session CR*/
				$_SESSION["idllantaCR"] = "";
				$_SESSION["MarcaCR"] ="";
				$_SESSION["ModeloCR"] ="";
				$_SESSION["FolioCR"]="";
				$_SESSION["fechaCR"] = "";
				$_SESSION["comentarioCR"]  = "";
				$_SESSION["statusCR"]  = "";
			/* variables VT */
				$_SESSION["idllantaVT"] = "";
				$_SESSION["MarcaVT"] ="";
				$_SESSION["ModeloVT"] ="";
				$_SESSION["FolioVT"]="";
				$_SESSION["fechaVT"] = "";
				$_SESSION["statusVT"]  = "";
				$_SESSION["idclienteVT"]="";
				$_SESSION["pag"]="";
     }else{
 	 	header('Location: LogIn.php');
      	die() ;
     }
	 
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

        <section class="main">
            <div class="section_logo">
                <div id="logo">
                    <img src="../assets/img/logo2.png" width="195" height="195">
				</div>
                <h2 class="item_title-2">Renovadora de llantas</h2>
            </div>

            <div class="section_content">
                <header class="section_content-nav">
                    <div class="title">
                        <h2 class="item_title">Renovadora de llantas</h2>
                    </div>
                    <input class="burger-check" id="burger-check" type="checkbox">
                    <label for="burger-check" class="burger"></label>
                    <nav class="navigation">
                        <ul>
                            <li><a href="Entradas.php">ENTRADAS</a></li>
                            <li><a href="concentradorenovado.php">CONCENTRADO RENOVADO</a></li>
                            <li><a href="Ventas.php">VENTAS <i class="fas fa-dollar-sign"></i></a></li>
                            <li><a href="">REPORTES <i class="far fa-clipboard"></i></a></li>
                            <li><a href="">USUARIOS <i class="fas fa-users"></i></a></li>
                            <li><a href="login.php">SALIR <i class="fas fa-exit"></i></a></li>
                        </ul>
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