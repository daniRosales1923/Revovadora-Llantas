<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reportes</title>
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
				<input class="burger-check" id="burger-check" type="checkbox"><label for="burger-check" class="burger"></label>
				<nav class="navigation">
					<ul>
						<li><a href="Entradas.php">ENTRADAS</a></li>
						<li class="active"><a style="color: #9e9e9ed6;" href="concentradorenovado.php">CONCENTRADO RENOVADO</a></li>
						<li><a href="Ventas.php">VENTA <i class="fas fa-dollar-sign"></i></a></li>
						<li  class="active"><a style="color: #9e9e9ed6;" href="">REPORTES <i class="far fa-clipboard"></i></a></li>
						<li><a href="Usuarios.php">USUARIOS <i class="fas fa-users"></i></a></li>
						<li><a href="login.php">SALIR <i class="fas fa-exit"></i></a></li>
					</ul>
				</nav>
			</header>
			<div class="area_trabajo">
<a href="ReporteEntradas.php" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=600'); return false;">Reportes entradas</a> 
<a href="usuarios.php" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=600'); return false;">Reportes Concentrado Renovado</a> 
<a href="usuarios.php" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=600'); return false;">Reportes Ventas</a> 
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