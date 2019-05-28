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
    <link rel="stylesheet" href = "../assets/css/entry.css">
    </head>

    <body>

      <section class="main">
        <div class="section_logo">
            <div class="navbar-logo" > 
                <h1 class="navbar-logo__title">Tire</h1>
                <p class="navbar-logo__subtitle">RENOVATOR</p>
            </div>
        </div>

        <div class="section_content">
            <header class="section_content-nav">
                <input class="burger-check" id="burger-check" type="checkbox">
                <label for="burger-check" class="burger"></label>
                <nav class="navigation">
                    <ul>
                        <li><a href="Entradas.php">ENTRADAS</a></li>
                        <li><a href="concentradorenovado.php">CONCENTRADO RENOVADO</a></li>
                        <li><a href="Ventas.php">VENTAS <i class="fas fa-dollar-sign"></i></a></li>
                        <li>
                        <div class="dropdown">
                            <button class="dropbtn">REPORTES <i class="far fa-clipboard"></i> </button>
                            <div class="dropdown-content">
                                <a href="ReporteEntradas.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=600'); return false;">Reportes entradas</a> 
                                <a href="usuarios.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=600'); return false;">Reportes Concentrado Renovado</a> 
                                <a href="usuarios.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=600'); return false;">Reportes Ventas</a> 
                            </div>
                        </div>
                        </li>
                        <li><a href="Usuarios.php">USUARIOS <i class="fas fa-users"></i></a></li>
                        <li><a href="login.php">SALIR <i class="fas fa-exit"></i></a></li>
                    </ul>
                </nav>
            </header>
            <div class="area_trabajo">
                <header class="start row bottom-xs center-xs">
                    <div class="start-logo" > 
                        <h1 class="start-logo__title">Tire</h1>
                        <p class="start-logo__subtitle">RENOVATOR</p>
                    </div>
                </header>
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