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