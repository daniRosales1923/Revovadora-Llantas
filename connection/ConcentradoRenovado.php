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
<title>Concentrado Renovado</title>
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
						<li class="active"><a style="color: #9e9e9ed6;" href="">CONCENTRADO RENOVADO</a></li>
						<li><a href="Ventas.php">VENTA <i class="fas fa-dollar-sign"></i></a></li>
						<li><a href="Reportes.php">REPORTES <i class="far fa-clipboard"></i></a></li>
						<li><a href="Usuarios.php">USUARIOS <i class="fas fa-users"></i></a></li>
						<li><a href="login.php">SALIR <i class="fas fa-exit"></i></a></li>
					</ul>
				</nav>
			</header>
			<div class="area_trabajo">
			<div>
				<?PHP 
					if (isset($_REQUEST['Limpiar']))
						Limpiar();
					else
						if (isset($_REQUEST['Guardar']))
							Guardar();
						else
							Restaura($_SESSION["FolioCR"]);

						if ( isset($_REQUEST['txtidLLanta'])){
							$_SESSION["idllantaCR"] = $_REQUEST['txtidLLanta'];
							if (!isset($_REQUEST['Limpiar'])){
								if (isset($_REQUEST['GuardaLllanta'])){
									if (!GuardaDetalle()){
										echo "<h1> ERROR</h1> ";
									}
								}
							}
							if(isset($_REQUEST['LimpiarLlanta'])){
								$_SESSION["idllantaCR"]="";
							}
								formularioLlantas($_SESSION["idllantaCR"]);
						}
						else
							formularioLlantas($_SESSION["idllantaCR"]);
						llenaGWDetalle($_SESSION["FolioCR"]);	
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

<?php 
		
	function Guardar(){
		global $ClsCn, $Ins, $idUsr;
		$comentario = $_REQUEST['txtComentario'];
		$Folio = "";
		if ($Ins->AltaConcentrados($idUsr,$comentario)==1){
			$consulta = "select max(idconcentrado) as folio from concentradorenovado";
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
		global $ClsCn, $Consultas, $Usr, $Usrname;
		$btnGuarda = '<input class="buttons-save" type="submit" name="Guardar" value="Guardar" >';
		if($prmFolio!=""){
			$btnGuarda="";
			$Consulta = $Consultas->DatosConcentrado($prmFolio,'','AC');
			$ClsCn->Conecta();
			$rst = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($rst);
			$arr = pg_fetch_array($rst, 0, PGSQL_ASSOC);
			$folio = $arr["idconcentrado"];
			if ($folio != ""){
			  $_SESSION["FolioCR"] =$folio;
				$_SESSION["fechaCR"] = $arr['fecha'];
				$_SESSION["statusCR"]  = $arr['status'];
				$_SESSION["comentarioCR"]  = $arr['comentario'];
				$ClsCn->Desconecta();
			}
		}
			//header("location:concentradorenovado.php");
			echo '<form class="entry" id="Entrada" method="POST"> 
				<div class="entry-form__header"> 
					<div class="aling__input"> 
						<label id= "lblFolio" name = "lblFolio" >Folio</label> 
						<input class="form" id="txtFolio" name="txtFolio" type="text"  value = "'.$_SESSION["FolioCR"].'" readonly > 
					</div> 
					<div class="aling__input"> 
						<label id= "lblFolio" name = "lblFolio" >Fecha</label> 
						<input class="form" id="txtFecha" name="txtFecha" type="text"  value = "'.$_SESSION["fechaCR"].'" readonly > 
					</div> 
					<div class="aling__input"> 
						<label id= "lblStatus" name = "lblStatus" >Status</label> 
						<input class="form" id="txtStatus"  name="txtStatus" type="text"  value = "'.$_SESSION["statusCR"].'" readonly > 
					</div> 
				</div> 
				<div class="entry-form__body"> 
					<div class="aling__input"> 
						<label id= "lblUsuario" name= "lblUsuario"> Usuario </label> 
						<input class="form" id="txtUsuario"name="txtUsuario" type="text" value = "('. $Usr. ')'. $Usrname.'" readonly > 
					</div> 
				</div> 
				<div class="entry-form__footer"> 
					 
					<div class="aling__input" style="margin: 5px;"> 
						<label name = "lblComentario" >Comentario</label> 
						<textarea class="form-comment" name="txtComentario" maxlength="50" value="'.$_SESSION["comentario"].'"  rows="5" cols="30" placeholder="Escribe aquí tus comentarios"></textarea> 
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
		$modelo =  $_REQUEST['txtMarca'];
		$observacion =  $_REQUEST['txtObservacion'];
		$trabajo = $_REQUEST['ddlTrabajo'];
		$Folio = "";
		if ($Ins->AltaDetalleContrado($_SESSION["FolioCR"], $idllanta, $trabajo,$observacion)>0){
			$ClsCn->Desconecta();
			return true;
			}
		else
			return false;
	}

	function Limpiar(){
		$_SESSION["FolioCR"]="";
		$_SESSION["fechaCR"] = "";
		$_SESSION["statusCR"]  = "";
		$_SESSION["comentarioCR"]  = "";
		$_SESSION["MarcaCR"] ="";
		$_SESSION["ModeloCR"] ="";
		$_SESSION["idllantaCR"]="";
		header("location:concentradorenovado.php");
	}


	function formularioLlantas($prmidllanta){
		global $ClsCn, $Consultas;
		if($_SESSION["FolioCR"]!=""){
			$marca = $modelo = $matricula = $trabajo = $idmodelo = "";
			if($prmidllanta !=""){
				
				$Consulta =  $Consultas->DatosLlantas($prmidllanta,'','','');
				$ClsCn->Conecta();
				$rst = $ClsCn->EjecutaConsulta($Consulta);
				$rows =pg_numrows($rst);
				if ($rows>0){
					$arr = pg_fetch_array($rst, 0, PGSQL_ASSOC);
					$idllanta = $arr["idllanta"];
					if ($idllanta!=""){
						$matricula = $arr["descripcion"] ;
						$marca = $arr["marca"];
						$modelo = $arr["modelo"];
						$idmodelo = $arr["idmodelo"];
						$trabajo = $arr["idtrabajo"];		
					}
				}
				else
					$_SESSION["idllantaCR"] = "";
			}
				echo '<form class="form-llantas" id="LLantas">
					<div style="padding: 5px 110px;">
						En caso que se le haya hecho otro trabajo aqui es donde se agrega...
					</div>
					<div class="entry-form__header">
						<div class="aling__input">
							<label id= "lblIDllanta">ID llanta</label>
							<input class="form-llanta" type="text" name="txtidLLanta" onchange="this.form.submit()" value = "'.$_SESSION["idllantaCR"].'">
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
							'. ComboTrabajo($idmodelo,$trabajo).'
						</div>
						<div class="aling__input">
							<label id="Trabajo"> Observacion </label>
							<input class="form-llanta" type="text" name="txtObservacion">
						</div>
						<div class="buttons">
							<input class="buttons-save" type="submit" name="GuardaLllanta" value="Agregar" >
							<input class="buttons-clean" type="submit" name="LimpiarLlanta" value="Limpiar">
						</div>
					</div>
				</form>';
		}
	}

	function  ComboTrabajo($Modelo,$Trabajo){
		global $ClsCn;
		$Combo = "<select class='form-llanta__select' style='with= auto;' name ='ddlTrabajo'>";
		if ($Modelo !="" and $Modelo !="-1"){
			$Consulta = "select t.idtrabajo, t.desctrabajo, t.status, t.idmodelo, m.modelo from trabajo t, modelo m where t.idmodelo = m.idmodelo and m.idmodelo = $Modelo ";
			$ClsCn->conecta();
			$Rst = $ClsCn->EjecutaConsulta($Consulta);
			$i=0;
			if(pg_num_rows($Rst)>0){
				while($row=pg_fetch_array($Rst)){
					if($i==0)
						$Combo .="<option value='-1'> --Seleccionar--</option>\n";
					if($Trabajo == $row['idtrabajo'])
						$Combo .="<option value='".$row['idtrabajo']."' selected >(".$row['idtrabajo'].") ".$row['desctrabajo']."</option>\n";
					else
						$Combo .="<option value='".$row['idtrabajo']."' >(".$row['idtrabajo'].") ".$row['desctrabajo']."</option>\n";
					$i++;
				}
				
			$ClsCn->desconecta();
			}
		}
		$Combo .="</select>";
		return $Combo;
	}

	function llenaGWDetalle($prmFolio){
		global $ClsCn, $Consultas;

		if($prmFolio!=""){
			$Consulta = $Consultas->DatosConcentradodetalle($prmFolio,'','');
			$ClsCn->conecta();
			$result = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($result);
			$tabla = "<div class='content__table'><table>\n
					<thead>\n
					<tr bgcolor='blue' >\n
					<th>  ID Detalle </th>\n
					<th>  ID Llanta  </th>\n
					<th>  Número de serie  </th>\n
					<th>  Marca  </th>\n
					<th>  Modelo  </th>\n
					<th>  Trabajo  </th>\n
					</tr>\n
					</thead>\n";
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				$tabla .="<tr>\n".
						"<td>".$arr["iddetalle"]."</td>\n".
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
	}
?>