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
<title>Alta Clientes</title>
</head>

<body style="background-color: #9c99998a">

<form class="entry" name="Usuarios" method="POST"> 
	<div class="entry-form__header-report"> 
		<div class="aling__input"> 
			<label id='lblNombre'> Nombre </label>
			<input class="form" type="text" name='txtNombre' minlength="3" maxlength="50" pattern="[a-zA-Z]" require>
		</div> 
		<div class="aling__input"> 
			<label id='lblApellidoP'>Apellido Paterno</label>
			<input class="form" type="text" name='txtApePat' minlength="3" maxlength="50" pattern="[a-zA-Z]" require>
		</div> 
		<div class="aling__input"> 
			<label id='lblApellidoM'>Apellido Materno</label>
			<input class="form" type="text" name='txtApeMat' minlength="3" maxlength="50" pattern="[a-zA-Z]" require>
		</div> 
	</div> 
	<div class="entry-form__header-report"> 
		<div class="aling__input"> 
			<label id='lblCorreo'> Correo</label>
			<input class="form" type="text" name='txtCorreo'  minlength="10" maxlength="70" require>
		</div> 
		<div class="aling__input"> 
			<label>Telefono</label>
			<input class="form" type="text" name='txtTel' maxlength="10" pattern="[0-9]{10}" require>
		</div> 
		<div class="aling__input"> 
			<label>RFC</label>
			<input class="form" type="text" id='txtRFC'name='txtRFC' maxlength="13" require>
		</div> 
     </div>
     <div class="entry-form__header-report"> 
        <div class="aling__input"> 
			<label>Calle</label>
			<input class="form" type="text" name='txtCalle'  minlength="10"  maxlength="40">
		</div> 
        <div class="aling__input"> 
			<label>Num Ext</label>
			<input class="folio" type="text" name='txtNumExt'  maxlength="10" pattern="[0-9]{0,9}+[a-zA-z]{1}">
		</div> 
        <div class="aling__input"> 
			<label>Num Int</label>
			<input class="folio" type="text" name='txtNumInt'  maxlength="10" pattern="[0-9]{0,9}+[a-zA-z]{1}">
		</div> 
    </div>
   <div class="entry-form__header-report"> 
        <div class="aling__input"> 
			<label>Colonia</label>
			<input class="form" type="text" name='txtCol'  minlength="10" maxlength="40">
		</div> 
         <div class="aling__input"> 
			<label>C.P.</label>
			<input class="folio" type="text" name='txtCP' maxlength="5" pattern="[0-9]{5}" require>
		</div> 
        <div class="aling__input"> 
			<label>Localidad</label>
			<input class="form" type="text" name='txtLoc' maxlength="50">
		</div> 
	</div>
	<div class="buttons">
		<pre>{{form.invalid| json}}</pre>
		<input class="buttons-save" type="submit" id="Guardar" name="Guardar" value="Guardar" disabled="form.invalid">
	</div>
</form>

<?php 
	if (isset($_REQUEST['Guardar'])){
		Guardar();
		LLenaClientes();
	}
	else
		LlenaClientes();
	
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
		global $ClsCn, $Ins, $idUsr, $Consultas;
		if($idUsr==1000 and $Usr="admin"){
			$Nombre = $_REQUEST['txtNombre'];
			$ApPat = $_REQUEST['txtApePat'];
			$ApMat = $_REQUEST['txtApeMat'];
			$RFC = $_REQUEST['txtRFC'];
			$Telefono = $_REQUEST['txtTel'];
			$Correo= $_REQUEST['txtCorreo'];
			$calle =  $_REQUEST['txtCalle'];
			$numext =  $_REQUEST['txtNumExt'];
			$numint =  $_REQUEST['txtNumInt'];
			$cp = $_REQUEST['txtCP'];
			$colonia= $_REQUEST['txtCol'];
			$localidad= $_REQUEST['txtLoc'];
			$msj="";
			if ($Nombre =="")
				$msj.="Llena el campo nombre <br>";
			if($ApPat=="")
				$msj.="Llena el campo apellido paterno <br>";
			if($ApMat=="")
				$msj.="Llena el campo apellido materno <br>";
			if($RFC=="")
				$msj .= "Llena el campo RFC<br>";
			else{
				$Consulta = $Consultas->DatosClientes('', $RFC,'', '', '','', '','AC');
				$ClsCn->conecta();
				$result = $ClsCn->EjecutaConsulta($Consulta);
				$rows = pg_numrows($result);
				if($rows>0){
					$arr = pg_fetch_array($result, 0, PGSQL_ASSOC);
				$msj.= 'El RFC Ingresado ya esta registrado con la clave '.$arr['idcliente']. '--'.$arr['nombre'] . '<br>';
				}
			}
			if($Telefono=="")
				$msj .= "Llena el campo Telefono<br>";
		
			//intenta guardar
			if($msj==""){
					if ($Ins->AltaClientes($Nombre, $ApPat, $ApMat, $Correo, $Telefono, $RFC, $calle, $numext, $numint, $colonia, $cp, $localidad)==1)
							echo "Guardado";
					else
						echo "<h1>Error</h1>";
			}
			else
				echo $msj;
		}
		else
			echo "NO ERES USUARIO ADMIN";
	}
	
	function LlenaClientes(){
		global $Consultas, $ClsCn;
		$Consulta = $Consultas->DatosClientes('', '', '', '', '', '', '','AC');
			$ClsCn->conecta();
			$result = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($result);
			$tabla = "<div class='content__table-report'><table>\n
					<thead>\n
					<tr bgcolor='blue' >\n
					<th>  Nombre </th>\n
					<th>  Apellidos </th>\n
					<th>  Correo </th>\n
					<th>  Telefono  </th>\n
					<th>  RFC  </th>\n
					</tr>\n
					</thead>\n";
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				$tabla .="<tr>\n".
						"<td>".$arr["nombre"]."</td>\n".
						"<td>".$arr["apellidopaterno"]." ".$arr["apellidomaterno"]."</td>\n".
						"<td>".$arr["correo"]."</td>\n".
						"<td>".$arr["telefono"]."</td>\n".
						"<td>".$arr["rfc"]."</td>\n".
						"</tr>\n";
			}
			$tabla .="</table></div>";
			echo $tabla;
		}
		
?>