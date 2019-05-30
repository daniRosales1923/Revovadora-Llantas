<script>
<?php
    session_start();
    unset($_SESSION['nombre']);
?>
</script>
<html>
    <head>
        <title>Login</title>
        <meta charset=“UTF-8”>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
        <link rel="stylesheet" href = "../assets/css/login.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>

       <div class="login" id = "Login">
           <div class="icon">
                <i class="fas fa-user fa-3x"></i>
           </div>
            <form class="form" method="POST" >
                <input class="form__input" type=“text” placeholder="Usuario*" name=“txtusr” />
                <input class="form__input" type="password" placeholder="Contraseña*" name=“txtpwd” />
                <input class="button-save"name="Login" value="Ingresar" type="submit" />
            </form>
       </div>
    </body>
</html>

<?php
       
        include("conecta.php");
        $ClsCn = new ConexionDatos();
        $ClsCn->conecta();
		$usr= "";
		$pwd="";
		if(isset($_REQUEST['Login'])){
			$usr= $_REQUEST['“txtusr”'];
			$pwd=$_REQUEST['“txtpwd”'];
			if ($usr!= "" and $pwd!=""){
				$result = $ClsCn->DatosUsuario($usr, $pwd);
				$rows =pg_numrows($result);
				if($rows>0){
					$arr = pg_fetch_array($result, 0, PGSQL_ASSOC);
					$IdUsr = $arr["idusuario"];
					if ($IdUsr != ""){
							/* variables de sesion para los usuarios */
							$_SESSION['idusr'] = $arr['idusuario'];
							$_SESSION['nombre'] = $arr['nombre'];
							$_SESSION['apellido'] = $arr['apellidopaterno'];
							$_SESSION['usuario'] = $arr['usuario'];
							
							$_SESSION['start'] = time();
							$_SESSION['expire'] = $_SESSION['start'] + (10 * 60) ;
							header('Location: Menu.php');
							die() ;
					}
					$ClsCn->Desconecta();
				}
				else
					echo	'<script language="javascript"> '."alert('Verifica tu usuario y contraseña')".'</script>';
			}
			else
					echo	'<script language="javascript"> '."alert('Llena los campos...')".'</script>';
		}
?>