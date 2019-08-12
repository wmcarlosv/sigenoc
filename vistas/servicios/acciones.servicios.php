<?php
	include 'controladores/controlador.servicio.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('servicios');

	if($_GET['accion'] == 'crear'){
		$title = "Nuevo Servicio";
		$action = "?vista=vistas/servicios/servicios&operacion=insertar";
	}else{
		$title = "Editar Servicio";
		$action = "?vista=vistas/servicios/servicios&operacion=actualizar&id=".$obj->id;
	}	
?>

<div class="panel">
	<h2><?=$title?></h2>
	<div class="cuerpo-panel">
			<form method="POST" action="<?=$action?>" autocomplete="off">
			<table class="table">
				<tbody>
					<tr>
						<td>Nombre: </td>
						<td><input type="text" name="nombre" value="<?=@$data->nombre?>" id="nombre" /></td>
					</tr>
					<tr>
						<td><button>Guardar</button></td>
						<td><a href="?vista=vistas/servicios/servicios">Cancelar</a></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>