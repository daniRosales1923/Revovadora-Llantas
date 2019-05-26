<?php
    header('Content-Type: text/html; charset=UTF-8');
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
    <link rel="stylesheet" href = "../assets/css/main.css">
<title>Entradas</title>
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
                            <li><a href="">VENTAS <i class="fas fa-dollar-sign"></i></a></li>
                            <li><a href="">REPORTES <i class="far fa-clipboard"></i></a></li>
                            <li><a href="">USUARIOS <i class="fas fa-users"></i></a></li>
                            <li><a href="login.php">SALIR <i class="fas fa-stop"></i></a></li>
                        </ul>
                    </nav>
                </header>
                <div class="area_trabajo">
                <center><a> ENTRADAS </a></center>
<form id="Entrada" method="POST">
<table>
  <tr>
    <td><label id= "lblFolio" name = "lblFolio" >Folio</label></td>
    <td><label id= "lblFolio" name = "lblFolio" >Fecha</label></td>
    <td><label id= "lblStatus" name = "lblStatus" >Status</label></td>
    <td><label id= "lblUsuario" name= "lblUsuario"> Usuario </label> </td>
  </tr>
  <tr>
    <td><input id="txtFolio" name="txtFolio" type="text"  value = "<?php echo $_SESSION["Folio"]?>" readonly ></td>
    <td><input id="txtFecha" name="txtFecha" type="text"  value = "<?php echo $_SESSION["fecha"]?>" readonly ></td>
    <td><input id="txtStatus"  name="txtStatus" type="text"  value = "<?php echo $_SESSION["status"]?>" readonly ></td>
    <td><input id="txtUsuario"name="txtUsuario" type="text" value = "<?php echo "(". $Usr. ") ". $Usrname?>" readonly ></td>
  </tr>
  <tr>
    <td><label name = "lblStatus" >Cliente</label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><?php echo LlenaComboCliente($_SESSION["idcliente"]);?> </td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><label name = "lblComentario" >Comentario</label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><input name="txtComentario"  value="<?php echo  $_SESSION["comentario"] ?>" > </td>
    <td> </td>
  </tr>
</table>
<input type="submit" name="Guardar" value="Guardar" >
<input type="submit" name="Limpiar" value="Limpiar" >
</form>
<div>

<?PHP 
	if (isset($_REQUEST['ddlMarca'])){
			$_SESSION["Marca"] = $_REQUEST['ddlMarca'];
			if ( isset($_REQUEST['ddlModelo'])){
				$_SESSION["Modelo"] = $_REQUEST['ddlModelo'];
				if (isset($_REQUEST['GuardaLllanta'])){
					if (!GuardaLlanta())
						echo "<h1> ERROR</h1> ";
					else
						formularioLlantas($_SESSION["Folio"]);	
				}
				else
					formularioLlantas($_SESSION["Folio"]);
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
	if (isset($_REQUEST['Guardar']))
		Guardar();
	if (isset($_REQUEST['Limpiar']))
		Limpiar();
	
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
		global $ClsCn,$Consultas;
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
			header("location:Entradas.php");
		}
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
			$Combo = "<Select id= 'DDLCliente' name='ddlCliente'>";
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
				<table>
					  <tr>
						<td><label id= "lblMatricula" name = "lblFolio" >Numero de serie</label></td>
						<td><label id= "lblMarca" name = "lblFolio" >Marca</label></td>
						<td><label id= "lblModelo" name = "lblStatus" >Modelo</label></td>
						<td><label id= "Trabajo" name= "lblUsuario"> Trabajo </label> </td>
						<td> </td>
					  </tr>
					  <tr>
						<td><input type="text" name="txtNumSerie"> </td>
						<td>'. ComboMarcas() .'</td>
						<td>'. ComboModelo($_SESSION["Marca"]).'</td>
						<td>'. ComboTrabajo($_SESSION["Modelo"]).'</td>
						<td> <input type="submit" name="GuardaLllanta" value="Agregar" ></td>
					  </tr>
				</table>
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
			$Combo = '<select onchange="this.form.submit()" name ="ddlMarca">';
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
		$Combo = "<select onchange='this.form.submit()' name ='ddlModelo'>";
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
			$Consulta = $Consultas->DatosLlantas('',$prmFolio,'');
			$ClsCn->conecta();
			$result = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($result);
			$tabla = "<table border='2' height='100%' width='100%'>\n
					<thead>\n
					<tr bgcolor='blue' >\n
					<th>  idllanta  </th>\n
					<th>  numero de serie  </th>\n
					<th>  marca  </th>\n
					<th>  modelo  </th>\n
					<th>  trabajo  </th>\n
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
			$tabla .="</table>";
			echo $tabla;
		}
	}
	
	
?>