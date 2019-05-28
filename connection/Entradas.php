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
<title>Entradas</title>
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
						<li class="active"><a style="color: #9e9e9ed6;" href="">ENTRADAS</a></li>
						<li><a href="concentradorenovado.php">CONCENTRADO RENOVADO</a></li>
						<li><a href="Ventas.php">VENTA <i class="fas fa-dollar-sign"></i></a></li>
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
					if (isset($_REQUEST['Limpiar']))
						Limpiar();
					else
						if (isset($_REQUEST['Guardar']))
							Guardar();
						else
							Restaura($_SESSION["Folio"]);
							
					if (isset($_REQUEST['ddlMarca'])){
							$_SESSION["Marca"] = $_REQUEST['ddlMarca'];
							if ( isset($_REQUEST['ddlModelo'])){
								$_SESSION["Modelo"] = $_REQUEST['ddlModelo'];
								if (!isset($_REQUEST['Limpiar'])){
									if (isset($_REQUEST['GuardaLllanta'])){
										if (!GuardaLlanta())
											echo "<h1> ERROR</h1> ";
										else
											formularioLlantas($_SESSION["Folio"]);	
									}
									else
										formularioLlantas($_SESSION["Folio"]);
								}
							}
							else
								formularioLlantas($_SESSION["Folio"]);
						}
						else
							formularioLlantas($_SESSION["Folio"]);
					LLenaGWLanntas($_SESSION["Folio"]);	
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
		$cliente = $_REQUEST['ddlCliente'];
		$comentario = $_REQUEST['txtComentario'];
		$Folio = "";
		if ($Ins->AltaEntradas($idUsr,$comentario, $cliente)==1){
			$consulta = "select max(folioentrada) as folio from entrada";
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
	
	function Restaura($prmFolioEnt){
		global $ClsCn,$Consultas,$Usr, $Usrname;
		$btnGuarda='<input class="buttons-save" type="submit" name="Guardar" value="Guardar" >';
		if($prmFolioEnt!=""){
			$Consulta = $Consultas->DatosEntrada($prmFolioEnt,'','AC','');
			$ClsCn->Conecta();
			$rst = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($rst);
			$arr = pg_fetch_array($rst, 0, PGSQL_ASSOC);
			$folio = $arr["folioentrada"];
			if ($folio != ""){
			  $_SESSION["Folio"] = $arr['folioentrada'];
				$_SESSION["fecha"] = $arr['fecha'];
				$_SESSION["idcliente"] = $arr['idcliente'];
				$_SESSION["status"]  = $arr['status'];
				$_SESSION["comentario"]  = $arr['comentario'];
				$ClsCn->Desconecta();
				//header("location:Entradas.php");
			}
		}
		echo '
				<form class="entry" id="Entrada" method="POST"> 
				<div class="entry-form__header"> 
					<div class="aling__input"> 
						<label id= "lblFolio" name = "lblFolio" >Folio</label> 
						<input class="form" id="txtFolio" name="txtFolio" type="text"  value = "'.$_SESSION["Folio"].'" readonly > 
					</div> 
					<div class="aling__input"> 
						<label id= "lblFolio" name = "lblFolio" >Fecha</label> 
						<input class="form" id="txtFecha" name="txtFecha" type="text"  value = "'.$_SESSION["fecha"].'" readonly > 
					</div> 
					<div class="aling__input"> 
						<label id= "lblStatus" name = "lblStatus" >Status</label> 
						<input class="form" id="txtStatus"  name="txtStatus" type="text"  value = "'.$_SESSION["status"].'" readonly > 
					</div> 
				</div> 
				<div class="entry-form__body"> 
					<div class="aling__input"> 
						<label id= "lblUsuario" name= "lblUsuario"> Usuario </label> 
						<input class="form" id="txtUsuario"name="txtUsuario" type="text" value = "('. $Usr. ')'. $Usrname.'" readonly > 
					</div> 
					<div class="aling__input"> 
						<label name = "lblStatus" >Cliente</label> 
						'.LlenaComboCliente($_SESSION["idcliente"]).'  
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
	function GuardaLlanta(){
		global $ClsCn, $Ins, $idUsr;
		$Numserie = $_REQUEST['txtNumSerie'];
		$trabajo = $_REQUEST['ddlTrabajo'];
		$Folio = "";
		if ($Ins->AltaCascos($_SESSION["Folio"], $Numserie,$_SESSION["Marca"],$_SESSION["Modelo"],$_SESSION["idcliente"],$trabajo)==1){
			$ClsCn->Desconecta();
			$_SESSION["Marca"]="";
			$_SESSION["Modelo"]="";
			return true;
			}
		else
			return false;
		
	}

	function LlenaComboCliente($cliente){
		global $ClsCn, $Consultas;
		$ClsCn->conecta();
		$query = $Consultas->DatosClientes($cliente,'','','','','','','AC');
		$Rst = $ClsCn->EjecutaConsulta($query);
		$Combo = "";
		$i=0;
		if(pg_num_rows($Rst)>0){
			$Combo = "<Select class='form-select'  id= 'DDLCliente' name='ddlCliente'>";
			while($row=pg_fetch_array($Rst)){
				if($i==0)
				if ($cliente == '' )
					$Combo .="<option value='-1'> --Seleccionar--</option>\n";
				$Combo .="<option value='".$row['idcliente']."'> (".$row['rfc'].") ".$row['nombre']." ".$row['apellidopaterno']." ".$row['apellidomaterno']."</option>\n";
				$i++;
			}
			$Combo .="</select>";
		$ClsCn->desconecta();
			return $Combo;
		}
	}
	
	function Limpiar(){
		$_SESSION["Folio"]="";
		$_SESSION["fecha"] = "";
		$_SESSION["idcliente"] = "";
		$_SESSION["status"]  = "";
		$_SESSION["comentario"]  = "";
		$_SESSION["Marca"] ="";
		$_SESSION["Modelo"] ="";
		header("location:Entradas.php");
	}


	function formularioLlantas($prmFolio){
	if(isset($_REQUEST["Marca"]))
		$marca = $_REQUEST["Marca"];
		if($prmFolio!=""){
			echo '<form id="LLantas">
			<div class="entry-form__header">
				<div class="aling__input">
					<label id= "lblMarca" name = "lblFolio" >Marca</label>
					'. ComboMarcas() .'
				</div>
				<div class="aling__input">
					<label id= "lblModelo" name = "lblStatus" >Modelo</label>
					'. ComboModelo($_SESSION["Marca"]).'
				</div>
				<div class="aling__input">
					<label id= "Trabajo" name= "lblUsuario"> Trabajo </label>
					'. ComboTrabajo($_SESSION["Modelo"]).'
				</div>
				<div class="aling__input">
					<label id= "lblMatricula" name = "lblFolio" >Numero de serie</label>
					<input class="form-llanta" type="text" name="txtNumSerie">
				</div>
				<input class="buttons-save" type="submit" name="GuardaLllanta" value="Agregar" >
			</div>
			</form>';
		}
	}
	
	function ComboMarcas(){
		global $ClsCn;
		$Marca="";
		if ($_SESSION["Marca"]!="" and $_SESSION["Marca"] !="-1")
			$Marca = $_SESSION["Marca"];
		$Consulta ="Select ma.idmarca, ma.marca, ma.status from marcas ma where ma.status ='AC' ";
		$ClsCn->conecta();
		$Rst = $ClsCn->EjecutaConsulta($Consulta);
		$Combo = "";
		$i=0;
		if(pg_num_rows($Rst)>0){
			$Combo = '<select class="form-llanta" onchange="this.form.submit()" name ="ddlMarca">';
			while($row=pg_fetch_array($Rst)){
				if($i==0)
					$Combo .="<option value='-1'> --Seleccionar--</option>\n";
				if ($Marca ==$row['idmarca'])
					$Combo .="<option value='".$row['idmarca']."' selected>(".$row['idmarca'].")".$row['marca']."</option>\n";
				else
					$Combo .="<option value='".$row['idmarca']."'>(".$row['idmarca'].")".$row['marca']."</option>\n";
				$i++;
			}
			$Combo .="</select>";
		$ClsCn->desconecta();
		
		return $Combo;
		}
	}
		function ComboModelo($Marca){
		global $ClsCn;
		$Modelo="";
		if ($_SESSION["Modelo"]!="" and $_SESSION["Modelo"] !="-1")
			$Modelo = $_SESSION["Modelo"];
		$Combo = "<select class='form-llanta__select' style='with= auto;' onchange='this.form.submit()' name ='ddlModelo'>";
		if ($Marca !="" and $Marca !="-1"){
			$Consulta ="Select m.idmodelo, m.idmarca, m.modelo, ma.marca, m.status from modelo m, marcas ma where m.idmarca = ma.idmarca and m.status ='AC' and m.idmarca=$Marca ";
			$ClsCn->conecta();
			$Rst = $ClsCn->EjecutaConsulta($Consulta);
			$i=0;
			if(pg_num_rows($Rst)>0){
				while($row=pg_fetch_array($Rst)){
					if($i==0)
						$Combo .="<option value='-1'> --Seleccionar--</option>\n";
					if ($Modelo ==$row['idmodelo'])
						$Combo .="<option value='".$row['idmodelo']."' selected>(".$row['idmodelo'].")".$row['modelo']."</option>\n";
					else
						$Combo .="<option value='".$row['idmodelo']."' >(".$row['idmodelo'].")".$row['modelo']."</option>\n";
					$i++;
				}
				
			$ClsCn->desconecta();
			}
		}
		$Combo .="</select>";
		return $Combo;
	}
	
	function  ComboTrabajo($Modelo){
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
					$Combo .="<option value='".$row['idtrabajo']."' >".$row['desctrabajo']."</option>\n";
					$i++;
				}
				
			$ClsCn->desconecta();
			}
		}
		$Combo .="</select>";
		return $Combo;
	}
	function LLenaGWLanntas($prmFolio){
		global $ClsCn, $Consultas;
	
		if($prmFolio!=""){
			$Consulta = $Consultas->DatosLlantas('',$prmFolio,'','');
			$ClsCn->conecta();
			$result = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($result);
			$tabla = "<div class='content__table'><table>\n
					<thead>\n
					<tr>\n
					<th>  idLlanta  </th>\n
					<th>  Número de serie  </th>\n
					<th>  Marca  </th>\n
					<th>  Modelo  </th>\n
					<th>  Trabajo  </th>\n
					</tr>\n
					</thead>\n";
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				$tabla .="<tr>\n".
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