<?php
    //header('Content-Type: text/html; charset=UTF-8');
    session_start();
    if (isset($_SESSION['nombre'])){
		global $ClsCn, $Ins, $Consultas, $idUsr;
        $idUsr = $_SESSION['idusr'];
		$Usrname = $_SESSION['nombre'];
		$UsrAp =  $_SESSION['apellido'];
		$Usr = $_SESSION['usuario'];
		include_once("conecta.php");
		include_once("Consultas.php");
		include_once("Insert.php");
		$ClsCn = new ConexionDatos();
		$Ins = new Insertadatos();
		$Consultas = new Consultas();
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
    }else{
 		header('Location: LogIn.php');
     	die() ;
    }
	
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
    crossorigin="anonymous">
    <link rel="stylesheet" href = "../assets/css/entry.css">
<title>Reporte Entradas</title>
</head>

<body style="background-color: #9c99998a">
    <form class="entry" id="Reporte" method="POSTS" style="padding: 10px;">
		<div class="entry-form__header-report"> 
			<div class="aling__input"> 
				<label id= "lblFolio" name = "lblFolio" >Folio inicial</label> 
				<input class="folio"  type="text" name="txtFolIni">
			</div> 
			<div class="aling__input"> 
				<label id= "lblFolio" name = "lblFolio" >Folio final</label> 
				<input class="folio" type="text" name="txtFolFin">
			</div> 
			<div class="aling__input"> 
				<label id= "lblStatus" name = "lblStatus" >Usuario</label> 
				<?php echo ComboUsuario();?>
			</div> 
			<div class="aling__input"> 
				<label id= "lblStatus" name = "lblStatus" >Cliente</label> 
				<?php echo ComboCliente();?>
			</div>
			<input class="buttons-save" type="submit" name="llenar" value="Llenar">
		</div> 
    </form>
</body>
</html>

<?php 
	if (isset($_REQUEST['llenar']))
		llenatabla();
	function ComboCliente(){
		global $ClsCn, $Consultas;
		$ClsCn->conecta();
		$query = $Consultas->DatosClientes('','','','','','','','AC');
		$Rst = $ClsCn->EjecutaConsulta($query);
		$Combo = "";
		$i=0;
		if(pg_num_rows($Rst)>0){
			$Combo = "<Select class='form-select'  id= 'DDLCliente' name='ddlCliente'>";
			while($row=pg_fetch_array($Rst)){
				if($i==0)
					$Combo .="<option value='-1'> --Seleccionar--</option>\n";
				$Combo .="<option value='".$row['idcliente']."'> (".$row['rfc'].") ".$row['nombre']." ".$row['apellidopaterno']." ".$row['apellidomaterno']."</option>\n";
				$i++;
			}
			$Combo .="</select>";
		$ClsCn->desconecta();
			return $Combo;
		}
	}

	function ComboUsuario(){
		global $ClsCn, $Consultas;
		$ClsCn->conecta();
		$query = $Consultas->DatosUsuarios();
		$Rst = $ClsCn->EjecutaConsulta($query);
		$Combo = "";
		$i=0;
		if(pg_num_rows($Rst)>0){
			$Combo = "<Select class='form-select'  id= 'DDLUsuraio' name='ddlUsuario'>";
			while($row=pg_fetch_array($Rst)){
				if($i==0)
					$Combo .="<option value='-1'> --Seleccionar--</option>\n";
				$Combo .="<option value='".$row['idusuario']."'>".$row['nombre']." ".$row['apellidopaterno']." ".$row['apellidomaterno']."</option>\n";
				$i++;
			}
			$Combo .="</select>";
		$ClsCn->desconecta();
			return $Combo;
		}
	}
	
	function llenatabla(){
		global $ClsCn;
		$Condicion = creacondicion();
		$query = "select e.folioentrada, e.fecha, '('||u.usuario||') '|| u.nombre as Usuario, c.nombre ||' '|| c.apellidopaterno || ' ' || c.apellidomaterno as Cliente, dl.idllanta, dl.descripcion, ma.marca, mo.modelo, t.desctrabajo from entrada e, datosllantas dl, usuario u, marcas ma, modelo mo, trabajo t, cliente c where e.folioentrada = dl.folioentrada and e.idusuario = u.idusuario and e.idcliente = c.idcliente and dl.idmarca = ma.idmarca and dl.idmodelo = mo.idmodelo and dl.idtrabajo = t.idtrabajo $Condicion order by e.folioentrada, dl.idllanta";
		$ClsCn->Conecta();
		$result = $ClsCn->EjecutaConsulta($query);
		$rows =pg_numrows($result);
			$tabla = "<div class='content__table-report'><table >\n
					<thead>\n
					<tr>\n
					<th>  FOLIO  </th>\n
					<th>  FECHA </th>\n
					<th>  USUARIO  </th>\n
					<th>  CLIENTE  </th>\n
					<th>  IDLLANTA  </th>\n
					<th>  NUM. SERIE  </th>\n
					<th>  MARCA  </th>\n
					<th>  MODELO  </th>\n
					<th>  TRABAJO  </th>\n
					</tr>\n
					</thead>\n";
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				
				$tabla .="<tr>\n".
						"<td id ='". $i."' >".$arr["folioentrada"]."</td>\n".
						"<td >".$arr["fecha"]."</td>\n".
						"<td >".$arr["usuario"]."</td>\n".
						"<td >".$arr["cliente"]."</td>\n".
						"<td>".$arr["idllanta"]."</td>\n".
						"<td>".$arr["descripcion"]."</td>\n".
						"<td>".$arr["marca"]."</td>\n".
						"<td>".$arr["modelo"]."</td>\n".
						"<td>".$arr["desctrabajo"]."</td>\n".
						"</tr>\n";
	
			}
			$tabla .="</table></div>";
			echo $tabla;
	}
	
	function creacondicion(){
		$FolIni=$_REQUEST["txtFolIni"];
		$FolFin = $_REQUEST["txtFolFin"];
		$Usuario=$_REQUEST["ddlUsuario"];
		$Cliente = $_REQUEST["ddlCliente"];
		$Condicion = " ";
		if($FolIni != "")
			$Condicion.="And e.folioentrada >= $FolIni ";
		if($FolFin != "")
			$Condicion .="And e.folioentrada <= $FolFin ";
		if($Usuario !="-1")
			$Condicion = "And e.idusuario = $Usuario ";
		if($Cliente != "-1")
			$Condicion = "And e.idcliente = $Cliente ";
			
		return $Condicion;
	}

?>