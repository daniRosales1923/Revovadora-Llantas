<?php
	include_once("conecta.php");
	class Consultas{
		static $ClsCn ;
		function __construct (){
			global $ClsCn;
			$ClsCn = new ConexionDatos();
		}

		function DatosEntrada($prmFolioEntrada,$prmUsuario,$prmStatus,$prmCliente){
			$Condicion = " ";
			if($prmFolio<> "")
				$Condicion = "And e.folioentrada = $prmFolio ";
			if ($prmUsuario<>"")
				$Condicion = "And usuario = '$prmUsuario' ";
			if ($prmStatus <>"")
				$Condicion = "And e.status = '$prmStatus' ";
			if ($prmCliente <>"")
				$Condicion = "And c.nombre = '$prmCliente' ";
			$query = "select e.folioentrada, e.idusuario, u.nombre, e.comentario, e.status, e.idcliente, c.nombre, e.fecha from entrada as e, usuario as u, cliente as c where e.idusuario = u.idusuario and e.idcliente = c.idcliente $Condicion";
			$Rst = $ClsCn->EjecutaConsulta($query);
			return $Rst;
		}	
		
		function DatosLlantas($prmIdllanta, $prmFolioEntradam, $prmCliente){
		 	$Condicion = "";
		 	if($prmIdllanta <>"")
		 	$Condicion = "And l.idllante = $prmIdllanta ";
		 	if($prmFolio<> "")
				$Condicion = "And e.folioentrada = $prmFolio ";
			if ($prmCliente <>"")
				$Condicion = "And c.nombre = '$prmCliente' ";
			$query = "select l.idllanta, l.folioentrada, l.descripcion, l.idmarca, m.marca, l.idmodelo, mo.modelo, l.idcliente, c.nombre, l.idtrabajo, t.desctrabajo, l.status from datosllantas as l, marcas as m, modelo as mo, trabajo as t, cliente as c where l.idmarca =m.idmarca and l.idmodelo= mo.idmodelo and l.idcliente = c.idcliente and l.idtrabajo = t.idtrabajo $Condicion ";
			$Rst = $ClsCn->EjecutaConsulta($query);
			return $Rst;
		}



	}


?>