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
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
    crossorigin="anonymous">
    <link rel="stylesheet" href = "../assets/css/entry.css">
<title>Usuarios</title>
</head>
<script language="JavaScript" type="text/JavaScript">
function checar()
{
    with (document.forms['Usuarios'])
        {  
            if (txtPwd.value==txtPwdConf.value) 
               { 
				 document.getElementById('imgcheck').src="../assets/img/ok.png";
				 document.getElementById("Guardar").style.visibility  = 'visible';
				 document.getElementById("Guardar").style.display='';				
               }
            else
              { 
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
                            <li><a href="Reportes.php">REPORTES <i class="far fa-clipboard"></i></a></li>
                            <li><a href="Usuarios.php">USUARIOS <i class="fas fa-users"></i></a></li>
                            <li><a href="login.php">SALIR <i class="fas fa-exit"></i></a></li>
                        </ul>
                    </nav>
                </header>
                <div class="area_trabajo">
                <div>
<form name="Usuarios"  method="POST">
    <table width="100%">
      <tr>
        <td><label id='lblNombre'> Nombre </label></td>
        <td><label id='lblApellidoP'>Apellido Paterno</label></td>
        <td><label id='lblApellidoM'>Apellido Materno</label></td>
        <td colspan="2"><label id='lblCorreo'> Correo</label></td>
      </tr>
      <tr>
        <td><input type="text" name='txtNombre' ></td>
        <td><input type="text" name='txtApePat' ></td>
        <td><input type="text" name='txtApeMat' ></td>
        <td colspan="2"><input type="text" name='txtCorreo' ></td>
      </tr>
      <tr>
        <td><label>Telefono</label></td>
        <td><label>Usuario</label></td>
        <td><label>Contraseña</label></td>
        <td><label>Confirma Contraseña</label></td>
      </tr>
      <tr>
        <td><input type="text" name='txtTel' ></td>
        <td><input type="text" name='txtUsuario' ></td>
        <td><input type="password" name='txtPwd' onChange="checar()"></td>
        <td><input type="password" name='txtPwdConf' onChange="checar()"></td>
        <td><img id="imgcheck" src="../assets/img/not.png" width="30" height="30"  alt=""/></td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="submit" id="Guardar" name="Guardar" value="Guarda Usuario" style="visibility:hidden; display:none">
</form>

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
		$Nombre = $_REQUEST['txtNombre'];
		$ApPat = $_REQUEST['txtApePat'];
		$ApMat = $_REQUEST['txtApeMat'];
		$Correo = $_REQUEST['txtCorreo'];
		$Telefono = $_REQUEST['txtTel'];
		$Usuario = $_REQUEST['txtUsuario'];
		$Pwd = $_REQUEST['txtPwd'];
		$msj="";
		if ($Nombre =="")
			$msj.="llena el campo nombre <br>";
		if($ApPat=="")
			$msj.="llena el campo apellido paterno <br>";
		if($ApMat=="")
			$msj.="llena el campo apellido materno <br>";
		if($Usuario=="")
			$msj .= "llena el campo Usuario<br>";
		if($Pwd=="")
			$msj .= "llena el campo contraseña<br>";
		if($Correo=="")
			$msj .= "llena el campo Correo<br>";
		if($Telefono=="")
			$msj .= "llena el campo Telefono<br>";
		if($msj=="")
			if ($Ins->AltaUsuarios($Nombre, $ApPat, $ApMat, $Correo, $Telefono, $Usuario, $Pwd)==1)
					echo "Guardado";
			else
				echo "<h1>Error</h1>";
		else
			echo $msj;
	}
	
	function LlenaGWUsuario(){
		global $Consultas, $ClsCn;
		$Consulta = $Consultas->DatosUsuarios();
			$ClsCn->conecta();
			$result = $ClsCn->EjecutaConsulta($Consulta);
			$rows =pg_numrows($result);
			$tabla = "<table border='2' width='100%'>\n
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
			$tabla .="</table>";
			echo $tabla;
	}
		
