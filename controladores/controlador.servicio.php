<?php

	require 'modelos/modelo.servicio.php';
	$obj = new modelo_servicio();

	$operacion = !empty($_GET['operacion']) ? $_GET['operacion'] : 'todos';

	$obj->id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
	$obj->nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : NULL;

	switch($operacion){
		case 'todos':
			$data = $obj->buscar_todos();
		break;

		case 'insertar':
			$data = (object) $obj->registrar();
			echo "<script>location.href='?vista=vistas/servicios/servicios&mensaje=".$data->mensaje."';</script>";
		break;

		case 'actualizar':
			$data = (object) $obj->actualizar();
			echo "<script>location.href='?vista=vistas/servicios/servicios&mensaje=".$data->mensaje."';</script>";
		break;

		case 'buscarxid':
			$data = (object) $obj->buscarxid()['servicio'];
		break;

		case 'eliminar':
			$data = (object) $obj->eliminar();
			echo "<script>location.href='?vista=vistas/servicios/servicios&mensaje=".$data->mensaje."';</script>";
		break;
	}