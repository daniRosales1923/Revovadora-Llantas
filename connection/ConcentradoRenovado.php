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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
    crossorigin="anonymous">
    <link rel="stylesheet" href = "../assets/css/main.css">
<title>Concentrado Renovado</title>
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
                    <input class="burger-check" id="burger-check" type="checkbox"><label for="burger-check" class="burger"></label>
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
		$btnGuarda = '<input type="submit" name="Guardar" value="Guardar" >';
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
			echo' <form> 
                    <table>
                      <tr>
                        <td><label id= "lblFolio" name = "lblFolio" >Folio</label></td>
                        <td><label id= "lblFolio" name = "lblFolio" >Fecha</label></td>
                        <td><label id= "lblStatus" name = "lblStatus" >Status</label></td>
                        <td><label id= "lblUsuario" name= "lblUsuario"> Usuario </label> </td>
                      </tr>
                      <tr>
                        <td><input id="txtFolio" name="txtFolio" type="text"  value = "'.$_SESSION["FolioCR"].'" readonly ></td>
                        <td><input id="txtFecha" name="txtFecha" type="text"  value = "'. $_SESSION["fechaCR"].'" readonly ></td>
                        <td><input id="txtStatus"  name="txtStatus" type="text"  value = "'.$_SESSION["statusCR"].'" readonly ></td>
                        <td><input id="txtUsuario"name="txtUsuario" type="text" value = "('. $Usr. ') '. $Usrname.'" readonly ></td>
                      </tr>
                       <tr>
                        <td><label name = "lblComentario" >Comentario</label></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                       <tr>
                        <td colspan="3"><input name="txtComentario"  value="'. $_SESSION["comentarioCR"] .'" > </td>
                        <td> </td>
                      </tr>
                    </table>
                    '.$btnGuarda.'
                    <input type="submit" name="Limpiar" value="Limpiar" >
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
				echo '<center> En caso que se le haya hecho otro trabajo aqui es donde se agrega...</center>
					<form id="LLantas"> 
						<table>
							  <tr>
								<td><label id= "lblIDllanta" >ID llanta</label></td>
								<td><label id= "lblMatricula" >Numero de serie</label></td>
								<td><label id= "lblMarca"  >Marca</label></td>
								<td><label id= "lblModelo"  >Modelo</label></td>
								<td><label id= "Trabajo"> Trabajo </label> </td>
								<td><label id= "Trabajo"> Observacion </label> </td>
								<td> </td>
							  </tr>
							  <tr>
								<td> 
									<input type="text" name="txtidLLanta" onchange="this.form.submit()" value = "'.$_SESSION["idllantaCR"].'">
								</td>
								<td> 
									<input type="text" name = "txtNumSerie" value="'.$matricula.'" readonly>
								</td>
								<td>
									<input type="text" name="txtMarca" value="'.$marca.'" readonly>
								</td>
								<td>
									<input type="text" name="txtModelo" value="'. $modelo.'" readonly>
								</td>
								<td>'. ComboTrabajo($idmodelo,$trabajo).'</td>
								<td><input type="text" name="txtObservacion"></td>
								<td> <input type="submit" name="GuardaLllanta" value="Agregar" ></td>
								<td> <input type="submit" name="LimpiarLlanta" value="Limpiar" ></td>
							  </tr>
						</table>
					</form>';
		}
	}
	
	function  ComboTrabajo($Modelo,$Trabajo){
		global $ClsCn;
		$Combo = "<select  name ='ddlTrabajo'>";
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
			$tabla = "<table border='2' height='100%' width='100%'>\n
					<thead>\n
					<tr bgcolor='blue' >\n
					<th>  ID Detalle </th>\n
					<th>  ID Llanta  </th>\n
					<th>  numero de serie  </th>\n
					<th>  marca  </th>\n
					<th>  modelo  </th>\n
					<th>  trabajo  </th>\n
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
			$tabla .="</table>";
			echo $tabla;
		}
	}
	
	
?>