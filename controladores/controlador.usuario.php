<?php

	require 'modelos/modelo.usuario.php';
	$obj = new modelo_usuario();

	$operacion = !empty($_GET['operacion']) ? $_GET['operacion'] : 'todos';

	$obj->id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
	$obj->nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : NULL;
	$obj->correo = !empty($_POST['correo']) ? $_POST['correo'] : NULL;
	$obj->telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : NULL;
	$obj->clave = !empty($_POST['clave']) ? $_POST['clave'] : NULL;

	switch($operacion){
		case 'todos':
			$data = $obj->buscar_todos();
		break;

		case 'iniciar_sesion':
			$data = (object) $obj->iniciar_sesion();
			if($data->error === 0){
				$_SESSION['usuario'] = $data->usuario;
				$_SESSION['en_sesion'] = 'si';
				echo "<script>location.href='?vista=vistas/escritorio/escritorio';</script>"; 
			}
		break;

		case 'cerrar_sesion':
			unset($_SESSION['en_sesion']);
			unset($_SESSION['usuario']);
			echo "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>"; 
		break;

		case 'insertar':
			$data = (object) $obj->registrar();
			echo "<script>location.href='?vista=vistas/usuarios/usuarios&mensaje=".$data->mensaje."';</script>";
		break;

		case 'actualizar':
			$data = (object) $obj->actualizar();
			echo "<script>location.href='?vista=vistas/usuarios/usuarios&mensaje=".$data->mensaje."';</script>";
		break;

		case 'buscarxid':
			$data = (object) $obj->buscarxid()['usuario'];
		break;

		case 'eliminar':
			$data = (object) $obj->eliminar();
			echo "<script>location.href='?vista=vistas/usuarios/usuarios&mensaje=".$data->mensaje."';</script>";
		break;

		case 'resetear_clave':
			$data = (object)$obj->recuperar_clave();
			echo "<script>location.href='?vista=vistas/sesion/iniciar.sesion&mensaje=".$data->mensaje."';</script>";
		break;
	}