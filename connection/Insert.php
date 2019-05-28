 <?php
	include_once("conecta.php");
	class Insertadatos {
		static $ClsCn;
		function __construct (){
			global $ClsCn;
			$ClsCn = new ConexionDatos();
		}

		function AltaEntradas($prmUsuarioAlta, $prmComentario, $prmCliente){
			global $ClsCn;
			$Result ;
			$query = "insert into entrada (idusuario, comentario, status, idcliente, fecha) values($prmUsuarioAlta, '$prmComentario','AC',$prmCliente, current_date)";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if(!$Rst){
				return 0;
			}
			else{
				return 1;
			}
			$ClsCn->Desconecta();
		}

		function AltaCascos($prmFolioEntrada, $prmDescripcion,$prmMarca, $prmModelo, $prmCliente,$prmTrabajo){
			global $ClsCn;
			$Result ;
			$query = "insert into datosllantas (folioentrada, descripcion, idmarca, idmodelo, idcliente, idtrabajo, status) values($prmFolioEntrada, '$prmDescripcion',$prmMarca, $prmModelo, $prmCliente,$prmTrabajo,'CA')";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if(!$Rst){
				return 0;
			}
			else{
				return 1;
			}
			$ClsCn->Desconecta();
		}
		
		function AltaConcentrados($prmUsuarioAlta,$prmComentario){
			global $ClsCn;
			$Result ;
			$query = "insert into concentradorenovado (idusuario, comentario, fecha, status) values ( $prmUsuarioAlta, '$prmComentario', current_date,'AC')";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if(!$Rst){
				return 0;
			}
			else{
				return 1;
			}
			$ClsCn->Desconecta();
		}	

		function AltaDetalleContrado($prmFolioConcentrado, $prmIdLlanta, $prmTrabajo, $Comentario){
			global $ClsCn;
			$Result ;
			//verifica que la llanta no este ya en otro concentrado
			$query = "select idconcentrado, idtrabajo from concetradorenovadodetalle where idllanta = $prmIdLlanta";
			$ClsCn->Conecta();
			$idconcentrado = "";
			$Rst = $ClsCn->EjecutaConsulta($query);
			$i=0;
			$ren=pg_num_rows($Rst);
			if($ren>0){
				while($row=pg_fetch_array($Rst) and $prmTrabajo!= $row["idtrabajo"]){
					$idconcentrado	= $row["idconcentrado"];
					$i++;
				}
			}
			$ClsCn->Desconecta();
			if (($idconcentrado == "" or $idconcentrado == $prmFolioConcentrado) and $i==$ren){
					//se trae el siguiente id ya que no es autonumerico
					$IDdetalle;
					$query = "Select COALESCE(Max(iddetalle),0)+1 AS id from concetradorenovadodetalle where idconcentrado = $prmFolioConcentrado";
					//echo $query;
					$ClsCn->Conecta();
					$Rst = $ClsCn->EjecutaConsulta($query);
					if (pg_num_rows($Rst)==1){
						$arr = pg_fetch_array($Rst, 0, PGSQL_ASSOC);
						$IDdetalle	= $arr["id"];
					}
					$ClsCn->Desconecta();
					//se hace insercion
					$query = "insert into concetradorenovadodetalle (idconcentrado, IDdetalle, idllanta, idtrabajo, comentario) values($prmFolioConcentrado, $IDdetalle, $prmIdLlanta, $prmTrabajo, '$Comentario')";
					//echo "\n".$query;
					$ClsCn->Conecta();
					$Rst = $ClsCn->EjecutaConsulta($query);
					if(!$Rst){
						return 0;
					}
					else{
						$ClsCn->EjecutaConsulta("update datosllantas set status='RE' where idllanta = $prmIdLlanta");
						return $IDdetalle;
					}
					$ClsCn->Desconecta();
			}
			else
				echo "ya esta registrado en el concentrado ".$idconcentrado;
		}
		
		function AltaSalida($prmUsuarioAlta,$prmCliente){
			global $ClsCn;
			$query = "insert into salidas (idusuario, idcliente, status, fecha) values($prmUsuarioAlta, $prmCliente,'AC', current_date)";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if(!$Rst){
				return 0;
			}
			else{
				return 1;
			}
			$ClsCn->Desconecta();
		}
		function AltaSalidaDetalle($prmFolioSalida, $prmIdLlanta){
			//se trae el siguiente id ya que no es autonumerico
			global $ClsCn;
			$IDdetalle;
			$band = 0;
			$query = "Select COALESCE(Max(iddetsalida),0)+1 AS id from salidasdetalle where idsalida = $prmFolioSalida";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if (pg_num_rows($Rst)==1){
				$arr = pg_fetch_array($Rst, 0, PGSQL_ASSOC);
				$IDdetalle	= $arr["id"];
			}
			$ClsCn->Desconecta();
			$query ="select cd.idconcentrado, cd.iddetalle, cd.idllanta, t.costo from concetradorenovadodetalle cd, trabajo t, datosllantas dl where  cd.idllanta=dl.idllanta and cd.idtrabajo = t.idtrabajo and dl.status = 'RE' and cd.idllanta = $prmIdLlanta";
			$ClsCn->conecta();
			$result = $ClsCn->EjecutaConsulta($query);
			$rows =pg_numrows($result);
			for($i=0;$i<$rows;$i++){
				$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
				$query = "insert into salidasdetalle (idsalida, iddetsalida, idconcentrado, iddetconcen, idllanta, monto) values ($prmFolioSalida, $IDdetalle, ".$arr["idconcentrado"].", ".$arr["iddetalle"].", ". $arr["idllanta"].", ".$arr["costo"]." )";
				$Rst = $ClsCn->EjecutaConsulta($query);
				if(!$Rst){
					return 0;
				}
				else{
					$ClsCn->EjecutaConsulta("update datosllantas set status='VE' where idllanta = $prmIdLlanta");
					$band = 1;
					$IDdetalle++;
				}
			}
			$ClsCn->Desconecta();
			return $band;
		}
		
		
		function AltaUsuarios($prmNombre, $prmApPat, $prmApMat, $prmCorreo, $prmTel, $Usuario, $prmPwd){
				global $ClsCn;
				$query ="INSERT INTO public.usuario(nombre, apellidopaterno, apellidomaterno, correo, telefono, usuario,contraseña, status) VALUES ('$prmNombre', '$prmApPat', '$prmApMat', '$prmCorreo', '$prmTel', '$Usuario', '$prmPwd','AC')";
				$ClsCn->Conecta();
				$Rst=$ClsCn->EjecutaConsulta($query);
				if($Rst)
					$ban = 1;
				else
					$ban =0;
				$ClsCn->Desconecta();
				return $ban;
		}
	}


?>