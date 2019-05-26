<?php
	include_once("conecta.php");
	class Consultas{

		function __construct (){

		}

		function DatosEntrada($prmFolioEntrada,$prmUsuario,$prmStatus,$prmCliente){
			$Condicion = " ";
			if($prmFolioEntrada<> "")
				$Condicion = "And e.folioentrada = $prmFolioEntrada ";
			if ($prmUsuario<>"")
				$Condicion .= "And usuario = '$prmUsuario' ";
			if ($prmStatus <>"")
				$Condicion .= "And e.status = '$prmStatus' ";
			if ($prmCliente <>"")
				$Condicion .= "And c.nombre = '$prmCliente' ";
			$query = "select e.folioentrada, e.idusuario, u.nombre, e.comentario, e.status, e.idcliente, c.nombre, e.fecha, e.status from entrada as e, usuario as u, cliente as c where e.idusuario = u.idusuario and e.idcliente = c.idcliente $Condicion";
			return $query;
		}	
		
		function DatosLlantas($prmIdllanta, $prmFolioEntrada, $prmCliente){
		 	$Condicion = "";
		 	if($prmIdllanta <>"")
		 	$Condicion .= "And l.idllanta = $prmIdllanta ";
		 	if($prmFolioEntrada<> "")
				$Condicion .= "And l.folioentrada = $prmFolioEntrada ";
			if ($prmCliente <>"")
				$Condicion .= "And c.nombre = '$prmCliente' ";
			$query = "select l.idllanta, l.folioentrada, l.descripcion, l.idmarca, m.marca, l.idmodelo, mo.modelo, l.idcliente, c.nombre, l.idtrabajo, t.desctrabajo, l.status from datosllantas as l, marcas as m, modelo as mo, trabajo as t, cliente as c where l.idmarca =m.idmarca and l.idmodelo= mo.idmodelo and l.idcliente = c.idcliente and l.idtrabajo = t.idtrabajo $Condicion ";
			return $query;
		}

		function DatosClientes($prmIDCliente, $prmRFC, $prmNombre, $prmApellidoPat, $prmApellidoMat, $prmCP, $prmLocalidad, $prmStatus){
			$Condicion = "";
			if($prmIDCliente <>"")
		 		$Condicion .= "And C.idcliente = '$prmIDCliente' ";
		 	if($prmRFC <>"")
		 		$Condicion .= "And C.rfc = '$prmRFC' ";
		 	if($prmNombre<> "")
				$Condicion .= "And C.Nombre = '$prmNombre' ";
			if ($prmApellidoPat <>"")
				$Condicion .= "And C.apellidopaterno = '$prmApellidoPat' ";
			if ($prmApellidoMat <>"")
				$Condicion .= "And C.apellidomaterno = '$prmApellidoMat' ";
			if ($prmCP <>"")
				$Condicion .= "And C.cp = '$prmCP' ";
			if ($prmLocalidad <> "")
				$Condicion .="And C.localidad = '$prmLocalidad'";
			if ($prmStatus <> "")
				$Condicion .="And C.Status = '$prmStatus'";
			$query = "select c.idcliente, c.nombre, c.apellidopaterno, c.apellidomaterno, c.rfc, c.correo, c.telefono, c.calle, c.numext, c.numint, c.colonia, c.cp, c.localidad, c.status FROM cliente c where c.idcliente = c.idcliente $Condicion ";
			return $query;
		}
		function DatosConcentrado($prmFolio,$prmUsuario,$prmStatus){
			$Condicion = " ";
			if($prmFolio<> "")
				$Condicion = "And c.idconcentrado = $prmFolio ";
			if ($prmUsuario<>"")
				$Condicion .= "And u.usuario = '$prmUsuario' ";
			if ($prmStatus <>"")
				$Condicion .= "And c.status = '$prmStatus' ";
			$query = "select c.idconcentrado, c.idusuario, u.nombre, c.comentario, c.fecha, c.status from concentradorenovado c, usuario u where c.idusuario = u.idusuario $Condicion";
			return $query;
		}	
		function DatosConcentradodetalle($prmFolio,$prmidllanta,$condicionextra){
			$Condicion = " ";
			if($prmFolio<> "")
				$Condicion = "And cd.idconcentrado = $prmFolio ";
			if($prmidllanta <>"")
				$Condicion .="And cd.idllanta = $prmidllanta";
			$query = "select cd.idconcentrado, cd.iddetalle, cd.idllanta,dl.descripcion, ma.marca, mo.modelo, cd.idtrabajo, t.desctrabajo, cd.comentario from concetradorenovadodetalle cd, datosllantas dl, marcas ma, modelo mo, trabajo t where cd.idllanta = dl.idllanta and dl.idmarca = ma.idmarca and dl.idmodelo = mo.idmodelo and cd.idtrabajo = t.idtrabajo $Condicion $condicionextra order by cd.idconcentrado, cd.iddetalle, cd.idllanta";
			return $query;
		}	
	}


?>