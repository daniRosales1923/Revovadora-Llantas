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
<title>Documento sin título</title>
</head>

<body>

 <form id="Reporte" method="POSTS">
        <table >
          <tr>
            <td><label>Folio Inicial</label></td>
            <td><label>Folio Final</label></td>
            <td><label>Usuario</label></td>
            <td><label>Cliente</label></td>
          </tr>
          <tr>
            <td><input class="form__input"  type="text" name="txtFolIni" width="80px"></td>
            <td><input class="form__input" type="text" name="txtFolFin" width="80px"></td>
            <td><?php echo ComboUsuario();?></td>
            <td><?php echo ComboCliente();?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input class="buttons-save" type="submit" name="llenar" value="Llenar" width="100%"></td>
          </tr>
        </table>
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
		$query = "select s.idsalida, s.iddetsalida, s.idconcentrado, s.iddetconcen, s.idllanta, dl.descripcion, t.desctrabajo, s.monto from salidas v, salidasdetalle s, datosllantas dl, trabajo t,concetradorenovadodetalle cd, concentradorenovado c  where v.idsalida = s.idsalida and s.idconcentrado = c.idconcentrado and s.iddetconcen = cd.iddetalle and s.idllanta = cd.idllanta and cd.idllanta = dl.idllanta and  cd.idtrabajo = t.idtrabajo  $Condicion order by s.idllanta, s.iddetsalida";
		$ClsCn->Conecta();
		$result = $ClsCn->EjecutaConsulta($query);
		$rows =pg_numrows($result);
			$tabla = "<div class='content__table'> <table>\n
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
						"<td>Total a pagar</td>\n".
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