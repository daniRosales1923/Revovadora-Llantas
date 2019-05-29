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
<link rel="stylesheet" href = "../assets/css/entry.css">
<title>Reporte Ventas</title>
<script>
function imprimir(){
var printContents = document.getElementById('Imp').outerHTML;
        w = window.open();
		w.document.write('<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href = "../assets/css/entry.css"><body><center>REPORTE DE VENTAS </center>');
        w.document.write(printContents);
		w.document.write('</body></html>');
        w.document.close(); // necessary for IE >= 10
        w.focus(); // necessary for IE >= 10
		w.print();
		w.close();
        return true;}
</script>
</head>

<body style="background-color: #9c99998a">


 <form id="Reporte" method="POSTS" style="padding: 10px;" class="entry">
		<div  class="entry-form__header-report"> 
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
		$total=0;
		$query = "select s.idsalida, s.iddetsalida, s.idconcentrado, s.iddetconcen, s.idllanta, dl.descripcion, t.desctrabajo, s.monto from salidas v, salidasdetalle s, datosllantas dl, trabajo t,concetradorenovadodetalle cd, concentradorenovado c  where v.idsalida = s.idsalida and s.idconcentrado = c.idconcentrado and s.iddetconcen = cd.iddetalle and s.idllanta = cd.idllanta and cd.idllanta = dl.idllanta and  cd.idtrabajo = t.idtrabajo  $Condicion order by s.idllanta, s.iddetsalida";
		$ClsCn->Conecta();
		$result = $ClsCn->EjecutaConsulta($query);
		$rows =pg_numrows($result);
			$tabla = "<input type='image' onclick='imprimir();'  src='../assets/img/impresora.png' width='30px' height='30px'>
			<div id='Imp' class='content__table-report'><table>\n
					<thead>\n
					<tr bgcolor='blue' >\n
					<th>  FOLIO </th>\n
					<th>  ID Detalle </th>\n
					<th>  ID Llanta  </th>\n
					<th>  NUMERO DE SERIE  </th>\n
					<th>  TRABAJO  </th>\n
					<th>  MONTO  </th>\n
					</tr>\n
					</thead>\n";
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				$tabla .="<tr>\n".
						"<td>".$arr["idsalida"]."</td>\n".
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
						"<td></td>\n".
						"<td>Total </td>\n".
						"<td>$".$total."</td>\n".
						"</tr>\n";
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
			$Condicion.="And s.idsalida >= $FolIni ";
		if($FolFin != "")
			$Condicion .="And s.idsalida <= $FolFin ";
		if($Usuario !="-1")
			$Condicion = "And v.idusuario = $Usuario ";
		if($Cliente != "-1")
			$Condicion = "And v.idcliente = $Cliente ";
			
		return $Condicion;
	}
?>