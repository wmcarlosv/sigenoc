<?php

	require 'modelos/modelo.cliente.php';
	$obj = new modelo_cliente();

	$operacion = !empty($_GET['operacion']) ? $_GET['operacion'] : 'todos';

	$obj->id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
	$obj->rif = !empty($_POST['rif']) ? $_POST['rif'] : NULL;
	$obj->razon_social = !empty($_POST['razon_social']) ? $_POST['razon_social'] : NULL;
	$obj->direccion = !empty($_POST['direccion']) ? $_POST['direccion'] : NULL;
	$obj->correo = !empty($_POST['correo']) ? $_POST['correo'] : NULL;
	$obj->telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : NULL;
	$obj->persona_contacto = !empty($_POST['persona_contacto']) ? $_POST['persona_contacto'] : NULL;
	$obj->telefono_persona_contacto = !empty($_POST['telefono_persona_contacto']) ? $_POST['telefono_persona_contacto'] : NULL;

	switch($operacion){
		case 'todos':
			$data = $obj->buscar_todos();
		break;

		case 'insertar':
			$data = (object) $obj->registrar();
			echo "<script>location.href='?vista=vistas/clientes/clientes&mensaje=".$data->mensaje."';</script>";
		break;

		case 'actualizar':
			$data = (object) $obj->actualizar();
			echo "<script>location.href='?vista=vistas/clientes/clientes&mensaje=".$data->mensaje."';</script>";
		break;

		case 'buscarxid':
			$data = (object) $obj->buscarxid()['cliente'];
		break;

		case 'eliminar':
			$data = (object) $obj->eliminar();
			echo "<script>location.href='?vista=vistas/clientes/clientes&mensaje=".$data->mensaje."';</script>";
		break;
	}