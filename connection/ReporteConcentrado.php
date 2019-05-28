<!doctype html><?php
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
<html>
<head>
<meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
    crossorigin="anonymous">
    <link rel="stylesheet" href = "../assets/css/entry.css">
<title>REPORTE CONCENTRADO RENOVADO</title>
</head>

<body>
 <form id="Reporte" method="POSTS">
        <table >
          <tr>
            <td><label>Folio Inicial</label></td>
            <td><label>Folio Final</label></td>
            <td><label>Usuario</label></td>
            
          </tr>
          <tr>
            <td><input class="form__input"  type="text" name="txtFolIni" width="80px"></td>
            <td><input class="form__input" type="text" name="txtFolFin" width="80px"></td>
            <td><?php echo ComboUsuario();?></td>
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
		$query = "select c.idconcentrado, c.fecha, '('||u.usuario||') '|| u.nombre as Usuario, cr.iddetalle, dl.idllanta, dl.descripcion, t.desctrabajo 
from concentradorenovado c, concetradorenovadodetalle cr, trabajo t, usuario u ,datosllantas dl
where c.idconcentrado = cr.idconcentrado and c.idusuario = u.idusuario and cr.idllanta = dl.idllanta and cr.idtrabajo = t.idtrabajo $Condicion order by c.idconcentrado, dl.idllanta, cr.iddetalle";

		$ClsCn->Conecta();
		$result = $ClsCn->EjecutaConsulta($query);
		$rows =pg_numrows($result);
			$tabla = "<div class='content__table'><table >\n
					<thead>\n
					<tr>\n
					<th>  FOLIO  </th>\n
					<th>  FECHA </th>\n
					<th>  USUARIO  </th>\n
					<th>  IDDETALLE  </th>\n
					<th>  IDLLANTA  </th>\n
					<th>  NUMERO DE SERIE  </th>\n
					<th>  TRABAJO  </th>\n
					</tr>\n
					</thead>\n";
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				
				$tabla .="<tr>\n".
						"<td id ='". $i."' >".$arr["idconcentrado"]."</td>\n".
						"<td >".$arr["fecha"]."</td>\n".
						"<td >".$arr["usuario"]."</td>\n".
						"<td>".$arr["iddetalle"]."</td>\n".
						"<td>".$arr["idllanta"]."</td>\n".
						"<td>".$arr["descripcion"]."</td>\n".
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
		$Condicion = " ";
		if($FolIni != "")
			$Condicion.="And c.idconcentrado >= $FolIni ";
		if($FolFin != "")
			$Condicion .="And c.idconcentrado <= $FolFin ";
		if($Usuario !="-1")
			$Condicion = "And c.idusuario = $Usuario ";
			
		return $Condicion;
	}

?>
