<?php
	include 'controladores/controlador.usuario.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('usuarios');

	if($_GET['accion'] == 'crear'){
		$title = "Nuevo Usuario";
		$action = "?vista=vistas/usuarios/usuarios&operacion=insertar";
	}else{
		$title = "Editar Usuario";
		$action = "?vista=vistas/usuarios/usuarios&operacion=actualizar&id=".$obj->id;
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
						<td>Correo: </td>
						<td><input type="text" name="correo" value="<?=@$data->correo?>" id="correo" /></td>
					</tr>
					<tr>
						<td>Telefono: </td>
						<td><input type="text" name="telefono" value="<?=@$data->telefono?>" id="telefono" /></td>
					</tr>
					<tr>
						<td><button>Guardar</button></td>
						<td><a href="?vista=vistas/usuarios/usuarios">Cancelar</a></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>