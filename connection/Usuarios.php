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
<title>Usuarios</title>
</head>
<script language="JavaScript" type="text/JavaScript">
function checar(){
	with (document.forms['Usuarios']){  
		if (txtPwd.value==txtPwdConf.value){ 
				document.getElementById('imgcheck').src="../assets/img/ok.png";
				document.getElementById("Guardar").style.visibility  = 'visible';
				document.getElementById("Guardar").style.display='';				
		}
		else{ 
					document.getElementById('imgcheck').src="../assets/img/not.png";
					document.getElementById("Guardar").style.visibility  = 'hidden';
					document.getElementById("Guardar").style.display='none';
		}
	}
}
</script> 
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
											<li><a href="Ventas.php">VENTAS <i class="fas fa-dollar-sign"></i></a></li>
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
											<li  class="active"><a style="color: #9e9e9ed6;" href="">USUARIOS <i class="fas fa-users"></i></a></li>
											<li><a href="login.php">SALIR <i class="fas fa-exit"></i></a></li>
									</ul>
							</nav>
					</header>
					<div class="area_trabajo">
					<div>

<form class="entry" name="Usuarios" method="POST"> 
	<div class="entry-form__header"> 
		<div class="aling__input"> 
			<label id='lblNombre'> Nombre </label>
			<input class="form" type="text" name='txtNombre' >
		</div> 
		<div class="aling__input"> 
			<label id='lblApellidoP'>Apellido Paterno</label>
			<input class="form" type="text" name='txtApePat' >
		</div> 
		<div class="aling__input"> 
			<label id='lblApellidoM'>Apellido Materno</label>
			<input class="form" type="text" name='txtApeMat' >
		</div> 
	</div> 
	<div class="entry-form__body"> 
		<div class="aling__input"> 
			<label id='lblCorreo'> Correo</label>
			<input class="form" type="text" name='txtCorreo' >
		</div> 
		<div class="aling__input"> 
			<label>Telefono</label>
			<input class="form" type="text" name='txtTel' >
		</div> 
		<div class="aling__input"> 
			<label>Usuario</label>
			<input class="form" type="text" name='txtUsuario' >
		</div> 
	</div>
	<div class="entry-form__body">
		<div class="aling__input"> 
			<label>Contraseña</label>
			<input class="form" type="password" name='txtPwd' onChange="checar()">
		</div> 
		<div class="aling__input"> 
			<label>Confirmar Contraseña</label>
			<input class="form" type="password" name='txtPwdConf' onChange="checar()">
		</div>
		<div class="check">
			<img id="imgcheck" src="../assets/img/not.png" width="30" height="30"  alt=""/>
		</div>
	</div>
	<div class="buttons">
		<input class="buttons-save" type="submit" id="Guardar" name="Guardar" value="Guardar" style="visibility:hidden; display:none">
	</div>
</form>';

<?php 
	if (isset($_REQUEST['Guardar'])){
		Guardar();
		LlenaGWUsuario();
	}
	else
		LlenaGWUsuario();
	
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
		if($idUsr==1000 and $Usr="admin"){
			$Nombre = $_REQUEST['txtNombre'];
			$ApPat = $_REQUEST['txtApePat'];
			$ApMat = $_REQUEST['txtApeMat'];
			$Correo = $_REQUEST['txtCorreo'];
			$Telefono = $_REQUEST['txtTel'];
			$Usuario = $_REQUEST['txtUsuario'];
			$Pwd = $_REQUEST['txtPwd'];
			$msj="";
			if ($Nombre =="")
				$msj.="Llena el campo nombre <br>";
			if($ApPat=="")
				$msj.="Llena el campo apellido paterno <br>";
			if($ApMat=="")
				$msj.="Llena el campo apellido materno <br>";
			if($Usuario=="")
				$msj .= "Llena el campo Usuario<br>";
			if($Pwd=="")
				$msj .= "Llena el campo contraseña<br>";
			if($Correo=="")
				$msj .= "Llena el campo Correo<br>";
			if($Telefono=="")
				$msj .= "Llena el campo Telefono<br>";
			if($msj=="")
				if ($Ins->AltaUsuarios($Nombre, $ApPat, $ApMat, $Correo, $Telefono, $Usuario, $Pwd)==1)
						echo "Guardado";
				else
					echo "<h1>Error</h1>";
			else
				echo $msj;
		}
		else
			echo "NO ERES USUARIO ADMIN";
	}
	
	function LlenaGWUsuario(){
		global $Consultas, $ClsCn;
		$Consulta = $Consultas->DatosUsuarios();
			$ClsCn->conecta();
			$result = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($result);
			$tabla = "<div class='content__table'><table>\n
					<thead>\n
					<tr bgcolor='blue' >\n
					<th>  ID USUARIO </th>\n
					<th>  Nombre </th>\n
					<th>  Apellidos </th>\n
					<th>  Correo </th>\n
					<th>  Telefono  </th>\n
					</tr>\n
					</thead>\n";
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				$tabla .="<tr>\n".
						"<td>".$arr["idusuario"]."</td>\n".
						"<td>".$arr["nombre"]."</td>\n".
						"<td>".$arr["apellidopaterno"]." ".$arr["apellidomaterno"]."</td>\n".
						"<td>".$arr["correo"]."</td>\n".
						"<td>".$arr["telefono"]."</td>\n".
						"</tr>\n";
			}
			$tabla .="</table></div>";
			echo $tabla;
		}
		
?>