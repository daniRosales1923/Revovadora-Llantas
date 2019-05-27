
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	if (isset($_REQUEST['Guardar'])){
		global $ClsCn;
		$idmodelo =$_REQUEST['DDLModelo'];
		$Trabajo = $_REQUEST['txtTrabajo'];
		$costo = $_REQUEST['txtCosto'];

		$query = "Insert into trbajos (idmodelo, desctrabajo, costo, status) values ( $idmodelo,$Trabajo, $Costo, 'AC')";
		echo $query;
	}
?>
</body>
</html>
