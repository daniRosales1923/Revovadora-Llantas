<?php
    session_start();
    unset($_SESSION['nombre']);
    include_once("conecta.php");
	global $ClsCn;
	$ClsCn = new ConexionDatos();
	
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		function CargaModelos(){
			var marcas = document.getElementById("DDLMarcas");
			var idmarca = marcas.options[marcas.selectedIndex].value;
			
		}
	</script>
	<title>Formulario con PHP</title>
</head>
<body>
<?php
	if (isset($_REQUEST['Guardar'])){
		global $ClsCn;
		$idmodelo =$_REQUEST['DDLModelo'];
		$Trabajo = $_REQUEST['txtTrabajo'];
		$costo = $_REQUEST['txtCosto'];

		$query = "Insert into trabajo (idmodelo, desctrabajo, costo, status) values ($idmodelo, '$Trabajo', $costo, 'AC')";
		//echo $query;
		$ClsCn->conecta();
		$Rst = $ClsCn->EjecutaConsulta($query);
		$ClsCn->desconecta();
		if($Rst){
			echo "insertado con exito";
			echo llenatabla();
		}
		else
			echo "error....";
		
	}
?>

 <div id = "Formulario">
 	 <form method="post" >
			 	<table>
			  <tr>
			    <td><label>Modelos</label></td>
			    <td><label>Trabajo</label></td>
			    <td><label>Costo</label><br></td>
			  </tr>
			  <tr>
			    <td><?php echo LlenaComboModelos();?></td>
			    <td> <input type=“text” name="txtTrabajo" /></td>
			    <td><input type="text" name="txtCosto" /></td>
			  </tr>
			</table><input name="Guardar" type="submit" />
            </form>
       </div>
</body>
</html>

<?php 
	function llenatabla(){
		global $ClsCn;
		$Consulta = "select t.idtrabajo, t.desctrabajo, t.status, t.idmodelo, m.modelo from trabajo t, modelo m where t.idmodelo = m.idmodelo ";
		$ClsCn->conecta();
		$result = $ClsCn->EjecutaConsulta($Consulta);
		$rows =pg_numrows($result);
		$tabla = "<table border='2'>\n
				<thead>\n
				<tr bgcolor='blue' >\n
				<th>  idtrabajo  </th>\n
				<th>  trabajo  </th>\n
				<th>  modelo  </th>\n
				</tr>\n
				</thead>\n";
		for($i=0;$i<$rows;$i++){
			$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
			$tabla .="<tr>\n".
					"<td>".$arr["idtrabajo"]."</td>\n".
					"<td>".$arr["desctrabajo"]."</td>\n".
					"<td>".$arr["modelo"]."</td>\n".
					"</tr>\n";

		}
		$tabla .="</table>";
		return $tabla;
	}
	function LlenaComboModelos(){
		global $ClsCn;
		$Consulta ="Select m.idmodelo, m.idmarca, m.modelo, ma.marca, m.status from modelo m, marcas ma where m.idmarca = ma.idmarca and m.status ='AC' ";
		$ClsCn->conecta();
		$Rst = $ClsCn->EjecutaConsulta($Consulta);
		$Combo = "";
		$i=0;
		if(pg_num_rows($Rst)>0){
			$Combo = "<Select id= 'DDLModelo' name='DDLModelo'>";
			while($row=pg_fetch_array($Rst)){
				if($i==0)
					$Combo .="<option value='-1'> --Seleccionar--</option>\n";
				$Combo .="<option value='".$row['idmarca']."'>".$row['marca']."--".$row['modelo']."</option>\n";
				$i++;
			}
			$Combo .="</select>";
		$ClsCn->desconecta();
			return $Combo;
		}
	}

?>