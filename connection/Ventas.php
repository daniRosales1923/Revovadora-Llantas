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
<title>Ventas</title>

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
						<li><a href="concentradorenovado.php">CONCENTRADO RENOVADO</a></li>
						<li class="active"><a style="color: #9e9e9ed6;" href="">VENTA <i class="fas fa-dollar-sign"></i></a></li>
						<li>
							<div class="dropdown">
									<button class="dropbtn">REPORTES <i class="far fa-clipboard"></i> </button>
									<div class="dropdown-content">
											<a href="ReporteEntradas.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=600'); return false;">Reportes entradas</a> 
											<a href="ReporteConcentrado.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=600'); return false;">Reportes Concentrado Renovado</a> 
											<a href="ReporteVentas.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=600'); return false;">Reportes Ventas</a> 
									</div>
							</div>
						</li>
						<li><a href="Usuarios.php">USUARIOS <i class="fas fa-users"></i></a></li>
						<li><a href="login.php">SALIR <i class="fas fa-exit"></i></a></li>
					</ul>
				</nav>
			</header>
			<div class="area_trabajo">
				<?PHP 
					if (isset($_REQUEST['Guardar']))
						Guardar();
						else
					if (isset($_REQUEST['Limpiar']))
						Limpiar();
						else
							Restaura($_SESSION["FolioVT"]);
					if ( isset($_REQUEST['txtidLLanta'])){
						$_SESSION["idllantaVT"] = $_REQUEST['txtidLLanta'];
						if (!isset($_REQUEST['Limpiar'])){
							if (isset($_REQUEST['GuardaLllanta'])){
								if (!GuardaDetalle()){
									echo "<h1> ERROR</h1> ";
								}
							}
						}
						if(isset($_REQUEST['LimpiarLlanta'])){
							$_SESSION["idllantaVT"]="";
						}
							formularioLlantas($_SESSION["idllantaVT"]);
					}
					else
						formularioLlantas($_SESSION["idllantaVT"]);
					llenaGWDetalle($_SESSION["FolioVT"]);	
				?>
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

<?PHP
	function Guardar(){
		global $ClsCn, $Ins, $idUsr;
		$Cliente = $_REQUEST['ddlCliente'];
		$Folio = "";
		if ($Ins->AltaSalida($idUsr,$Cliente)==1){
			$consulta = "select max(idsalida) as folio from salidas";
			$ClsCn->Conecta();
			$rst = $ClsCn->EjecutaConsulta($consulta);
			if(pg_num_rows($rst)>0){
				 $arr = pg_fetch_array($rst, 0, PGSQL_ASSOC);
				 $Folio = $arr["folio"];
			}
			$ClsCn->Desconecta();
				Restaura($Folio);
			}
		else
			echo "<h1>Error</h1>";
	}
	
	function Restaura($prmFolio){
		global $ClsCn,$Consultas, $idUsr, $Usr, $Usrname;
		$ImgPlus="";
		if($idUsr==1000 and $Usr="admin")
			$ImgPlus ='<a title="Nuevo cliente" href="AltaClientes.php" target="_blank" onClick="window.open(this.href, this.target, '."'width=1000,height=600'".'); return false;"> <i class="newUser fas fa-user-plus"></i> </a> ';
		$btnGuarda='<input class="buttons-save" type="submit" name="Guardar" value="Guardar" >';
		if ($prmFolio !=""){
			$btnGuarda="";
			$Consulta = $Consultas->DatosVenta($prmFolio, '','AC');
			$ClsCn->Conecta();
			$rst = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($rst);
			$arr = pg_fetch_array($rst, 0, PGSQL_ASSOC);
			$folio = $arr["idsalida"];
			if ($folio != ""){
			  $_SESSION["FolioVT"] =$folio;
				$_SESSION["fechaVT"] = $arr['fecha'];
				$_SESSION["statusVT"]  = $arr['status'];
				$_SESSION["idclienteVT"]  = $arr['idcliente'];
				$ClsCn->Desconecta();
				//header("location:Ventas.php");
			}
		}
		echo '
		<form class="entry" id="Entrada" method="POST"> 
			<div class="entry-form__header"> 
				<div class="aling__input"> 
					<label id= "lblFolio" name = "lblFolio" >Folio</label> 
					<input class="form" id="txtFolio" name="txtFolio" type="text"  value = "'.$_SESSION["FolioVT"].'" readonly > 
				</div> 
				<div class="aling__input"> 
					<label id= "lblFolio" name = "lblFolio" >Fecha</label> 
					<input class="form" id="txtFecha" name="txtFecha" type="text"  value = "'.$_SESSION["fechaVT"].'" readonly > 
				</div> 
				<div class="aling__input"> 
					<label id= "lblStatus" name = "lblStatus" >Status</label> 
					<input class="form" id="txtStatus"  name="txtStatus" type="text"  value = "'.$_SESSION["statusVT"].'" readonly > 
				</div> 
			</div> 
			<div class="entry-form__body"> 
				<div class="aling__input"> 
					<label id= "lblUsuario" name= "lblUsuario"> Usuario </label> 
					<input class="form" id="txtUsuario"name="txtUsuario" type="text" value = "('. $Usr. ')'. $Usrname.'" readonly > 
				</div> 
				<div class="aling__input"> 
					<label name = "lblStatus" >'.$ImgPlus.'Cliente</label> 
					'.LlenaComboCliente($_SESSION["idclienteVT"]).'  
				</div> 
			</div>	
			<div class="buttons">
				'.$btnGuarda.'
				<input class="buttons-clean" type="submit" name="Limpiar" value="Limpiar" >
			</div>
		</form>';
	}
	function GuardaDetalle(){
		global $ClsCn, $Ins, $idUsr;
		$idllanta = $_REQUEST['txtidLLanta'];
		$Folio = "";
		if ($Ins->AltaSalidaDetalle($_SESSION["FolioVT"], $idllanta)>0){
			//$ClsCn->Desconecta();
			return true;
			}
		else
			return false;
		
	}
	
	function Limpiar(){
		$_SESSION["FolioVT"]="";
		$_SESSION["fechaVT"] = "";
		$_SESSION["statusVT"]  = "";
		$_SESSION["idclienteVT"]  = "";
		$_SESSION["MarcaVT"] ="";
		$_SESSION["ModeloVT"] ="";
		$_SESSION["idllantaVT"]="";
		header("location:Ventas.php");
	}
		
	function LlenaComboCliente($cliente){
		global $ClsCn, $Consultas;
		$ClsCn->conecta();
		$query = $Consultas->DatosClientes($cliente,'','','','','','','AC');
		$Rst = $ClsCn->EjecutaConsulta($query);
		$Combo = "";
		$i=0;
		if(pg_num_rows($Rst)>0){
			$Combo = "<Select  class='form-select' id='DDLCliente' name='ddlCliente'>";
			while($row=pg_fetch_array($Rst)){
				if($i==0)
				if ($cliente == '' )
					$Combo .="<option value='-1'> --Seleccionar--</option>\n";
				$Combo .= "<option value='" . $row['idcliente']. "'> (" .$row['rfc'].") " . $row['nombre'] . " " . $row['apellidopaterno']. " " . $row['apellidomaterno']. "</option>\n";
				$i++;
			}
			$Combo .="</select>";
		$ClsCn->desconecta();
			return $Combo;
		}
	}

	function formularioLlantas($prmidllanta){
		global $ClsCn, $Consultas;
		if($_SESSION["FolioVT"]!=""){
			$marca = $modelo = $matricula = $trabajo = $idmodelo = "";
			if($prmidllanta !=""){
				
				$Consulta =  $Consultas->DatosLlantas($prmidllanta,'','','RE');
				$ClsCn->Conecta();
				$rst = $ClsCn->EjecutaConsulta($Consulta);
				$rows =pg_numrows($rst);
				if($rows>0){
					$arr = pg_fetch_array($rst, 0, PGSQL_ASSOC);
					$idllanta = $arr["idllanta"];
					if ($idllanta!=""){
						$matricula = $arr["descripcion"] ;
						$marca = $arr["marca"];
						$modelo = $arr["modelo"];
						$idmodelo = $arr["idmodelo"];
						$trabajo = $arr["desctrabajo"];		
					}
				}
				else
					$_SESSION["idllantaVT"] = "";
			}
			echo '<form class="form-llantas" id="LLantas">
					<div class="entry-form__header">
						<div class="aling__input">
							<label id= "lblIDllanta">ID llanta</label>
							<input class="form-llanta" type="text" name="txtidLLanta" onchange="this.form.submit()" value = "'.$_SESSION["idllantaVT"].'">
						</div>
						<div class="aling__input">
							<label id= "lblMatricula">Número de serie</label>
							<input class="form-llanta" type="text" name = "txtNumSerie" value="'.$matricula.'" readonly>
						</div>
						<div class="aling__input">
							<label id= "lblMarca">Marca</label>
							<input class="form-llanta" type="text" name="txtMarca" value="'.$marca.'" readonly>
						</div>
						<div class="aling__input">
							<label id= "lblModelo"  >Modelo</label>
							<input class="form-llanta" type="text" name="txtModelo" value="'. $modelo.'" readonly>
						</div>				
					</div>
					<div class="entry-form__header">
						<div class="aling__input">
							<label id="Trabajo" name="lblUsuario">Trabajo</label>
							'.$trabajo.'
						</div>
						<div class="buttons">
							<input class="buttons-save" type="submit" name="GuardaLllanta" value="Agregar" >
							<input class="buttons-clean" type="submit" name="LimpiarLlanta" value="Limpiar">
						</div>
					</div>
				</form>';
		}
	}
	function llenaGWDetalle($prmFolio){
		global $ClsCn, $Consultas;
	
		if($prmFolio!=""){
			$Consulta = $Consultas->DatosVentaDetalle($prmFolio,'','');
			$ClsCn->conecta();
			$result = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($result);
			$total = 0;
			$tabla = "<div class='content__table'> <table>\n
					<thead>\n
					<tr bgcolor='blue' >\n
					<th>  ID Detalle </th>\n
					<th>  ID Llanta  </th>\n
					<th>  numero de serie  </th>\n
					<th>  trabajo  </th>\n
					<th>  Monto  </th>\n
					</tr>\n
					</thead>\n";
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				$tabla .="<tr>\n".
						"<td>".$arr["iddetsalida"]."</td>\n".
						"<td>".$arr["idllanta"]."</td>\n".
						"<td>".$arr["descripcion"]."</td>\n".
						"<td>".$arr["desctrabajo"]."</td>\n".
						"<td>$".$arr["monto"]."</td>\n".
						"</tr>\n";
				 $total+=$arr["monto"];
			}
			$tabla .="<tr>\n".
						"<td></td>\n".
						"<td></td>\n".
						"<td></td>\n".
						"<td>Total a pagar</td>\n".
						"<td>$".$total."</td>\n".
						"</tr>\n";
			$tabla .="</table></div>";
			echo $tabla;
		}
	}
	
?>