<?php
	require 'modelos/modelo.mensaje.php';
	require 'modelos/modelo.cliente.php';
	require 'modelos/modelo.servicio.php';

	$obj = new modelo_mensaje();
	$cli = new modelo_cliente();

	$ser = new modelo_servicio();

	$operacion = !empty($_GET['operacion']) ? $_GET['operacion'] : 'todos';

	$obj->id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
	$obj->titulo = !empty($_POST['titulo']) ? $_POST['titulo'] : NULL;
	$obj->contenido = !empty($_POST['contenido']) ? $_POST['contenido'] : NULL;
	$clientes = !empty($_POST['input_clientes']) ? $_POST['input_clientes'] : NULL;
	$servicios = !empty($_POST['input_servicios']) ? $_POST['input_servicios'] : NULL;

	$cont_errors = 0;
	$correos = [];
	$nombres_servicios = [];

	switch($operacion){
		case 'todos':
			$data = $obj->buscar_todos();
		break;

		case 'insertar':
			$obj->conexion->begin_transaction();

			$data = (object) $obj->registrar();

			if(!empty($clientes)){
				for($c = 0;$c < count($clientes); $c++){
					$d = (object)$obj->insertar_detalle('mensaje_clientes','cliente_id', $clientes[$c]);
					if($d->error > 0){
						$cont_errors++;
					}else{
						$cli->id = $clientes[$c];
						$cd = (object) $cli->buscarxid();
						array_push($correos, $cd->cliente['correo']);
					}

				}
			}

			if(!empty($servicios)){
				for($s=0;$s<count($servicios);$s++){
					$d = (object)$obj->insertar_detalle('mensaje_servicios','servicio_id', $servicios[$s]);
					if($d->error > 0){
						$cont_errors++;
					}else{
						$ser->id = $servicios[$s];
						$sd = (object) $ser->buscarxid();
						array_push($nombres_servicios, $sd->servicio['nombre']);
					}
				}
			}

			if($cont_errors > 0){
				$obj->conexion->rollback();
				echo "<script>location.href='?vista=vistas/mensajes/mensajes&mensaje=Ocurrio un error al tratar registrar el mensaje, por favor revise los datos';</script>";
			}else{
				if($obj->send_email($correos,$obj->titulo,$obj->contenido, $nombres_servicios)){
					$obj->conexion->commit();
					echo "<script>location.href='?vista=vistas/mensajes/mensajes&mensaje=".$data->mensaje."';</script>";
				}else{
					$obj->conexion->rollback();
					echo "<script>location.href='?vista=vistas/mensajes/mensajes&mensaje=Ocurrio un error al tratar enviar el mensaje, por favor revise los datos';</script>";
				}
			}
			
		break;

		case 'buscarxid':
			$data = (object) $obj->buscarxid()['mensaje'];
			$clientes = $obj->traer_clientes();
			$servicios = $obj->traer_servicios();
		break;

		case 'eliminar':
			$data = (object) $obj->eliminar();
			echo "<script>location.href='?vista=vistas/mensajes/mensajes&mensaje=".$data->mensaje."';</script>";
		break;
	}