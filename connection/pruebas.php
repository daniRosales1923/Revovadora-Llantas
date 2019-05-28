<?php
    session_start();
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php
		include_once("Insert.php");
		include_once("Consultas.php");
		include_once("conecta.php");
		// $ClsCn = new ConexionDatos();
		 $Ins = new Insertadatos();
		 //$Con = new Consultas();

		if ($Ins->AltaEntradas(1,"esto es una prueba",2)==1)
			echo "exito";
		else
			echo "<h1>Error</h1>";
	?>
</body>
</html>