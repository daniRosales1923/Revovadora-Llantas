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
			$query = "insert into datossllantas (folioentrada, descripcion, idmarca, idmodelo, idcliente, idtrabajo, status) values($prmFolioEntrada, '$prmDescripcion',$prmMarca, $prmModelo, $prmCliente,$prmTrabajo,'AC')";
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
			$query = "insert into concentradorenovado (idusuario, comentario, fecha, status) values($prmUsuarioAlta,'$prmComentario',current_date,'AC')";
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

		function AltaDetalleContrado($prmFolioConcentrado, $prmIdLlanta, $prmTrabajo,$Comentario){
			global $ClsCn;
			$Result ;
			//se trae el siguiente id ya que no es autonumerico
			$IDdetalle;
			$query = "Select COALESCE(Max(iddetalle),0)+1 AS id from concentradorenovadodetalle where idconcentrado = $prmFolioConcentrado";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if (pg_num_rows($Rst)==1){
				$arr = pg_fetch_array($result, 0, PGSQL_ASSOC);
				$IDdetalle	= $arr["id"];
			}
			$ClsCn->Desconecta();
			//se hace insercion

			$query = "insert into concentradorenovadodetalle (idconentrado, iddetalle, idllanta, idtrabajo, comentario) values($prmFolioConcentrado, $IDdetalle, $prmIdLlanta, $prmTrabajo, '$Comentario')";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if(!$Rst){
				return 0;
			}
			else{
				return $IDdetalle;
			}
			$ClsCn->Desconecta();
		}
		function AltaSalida($prmUsuarioAlta,$prmCliente){
			global $ClsCn;
			$query = "insert into salidas values($prmUsuarioAlta, $prmCliente,'AC', current_date)";
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
		function AltaSalidaDetalle($prmFolioSalida,$prmIdConcentrado,$prmIdDetalleConcentrado, $prmIdLlanta,$prmMonto){
			//se trae el siguiente id ya que no es autonumerico
			global $ClsCn;
			$IDdetalle;
			$query = "Select COALESCE(Max(iddetsalida),0)+1 AS id from salidasdetalle where idsalida = $prmFolioSalida";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if (pg_num_rows($Rst)==1){
				$arr = pg_fetch_array($result, 0, PGSQL_ASSOC);
				$IDdetalle	= $arr["id"];
			}
			$ClsCn->Desconecta();
						
			$query = "insert into salidasdetalle values($prmFolioSalida, $IDdetalle, $prmIdConcentrado, $prmIdDetalleConcentrado, $prmIdLlanta, $prmMonto)";
			$ClsCn->Conecta();
			$Rst = $ClsCn->EjecutaConsulta($query);
			if(!$Rst){
				return 0;
			}
			else{
				return $IDdetalle;
			}
			$ClsCn->Desconecta();
		}
	}


?>