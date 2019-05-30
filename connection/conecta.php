 <?php
	// Conectando, seleccionando la base de datos
	class ConexionDatos{
		static  private $Host ="";
		static private $User = "";
		static private $Password= "";
		static private $DataBase = "";
		static private $Conexion ;
		
		function __construct (){
			global $Host, $User, $Password, $DataBase;
		    $Host = "localhost";
			$User = "postgres";
			//Dani
			//$Password= "1234";
			//Jona
			 $Password= "benji$99";
			$DataBase = "Renovadora";
		}

		function Conecta(){
			global $Host, $User, $Password, $DataBase,$Conexion;
			$Conexion = pg_connect("host=$Host dbname=$DataBase user=$User password=$Password");
			if (!$Conexion){
				die("error");
			}
		}

		function Desconecta(){
			global $Conexion;
			pg_close($Conexion);
		}

		
		function EjecutaConsulta($Consulta){
			global $Conexion;
			$Resultado = pg_query($Conexion,$Consulta);
			return $Resultado;
		}
		
		function DatosUsuario($Usr, $Pwd){
            $Condicion = "Where U.idusuario = U.idusuario ";
            if ($Usr!=""){
                $Condicion = $Condicion ."And U.Usuario = '$Usr'";
                if ($Pwd!=""){
                    $Condicion = $Condicion ."And U.Contraseña = '$Pwd'";
                    return $this->EjecutaConsulta("Select U.idusuario, U.nombre, U.apellidopaterno, U.apellidomaterno, U.correo, U.telefono,  U.usuario, U.status from usuario AS U ". $Condicion);
                }
	                else{
                  $msj ="Llene el campo Usuario";
                }
            }
            else{
                $msj= "Llene el campo Usuario";
            }
        }

	}

?>