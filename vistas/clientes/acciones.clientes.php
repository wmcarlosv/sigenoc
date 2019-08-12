<?php
	include 'controladores/controlador.cliente.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('clientes');

	if($_GET['accion'] == 'crear'){
		$title = "Nuevo Cliente";
		$action = "?vista=vistas/clientes/clientes&operacion=insertar";
	}else{
		$title = "Editar Cliente";
		$action = "?vista=vistas/clientes/clientes&operacion=actualizar&id=".$obj->id;
	}
?>

<div class="panel">
	<h2><?=$title?></h2>
	<div class="cuerpo-panel">
			<form method="POST" action="<?=$action?>" autocomplete="off">
			<table class="table">
				<tbody>
					<tr>
						<td>Rif: </td>
						<td><input type="text" name="rif" value="<?=@$data->rif?>" id="rif" /></td>
					</tr>
					<tr>
						<td>Razon Social: </td>
						<td><input type="text" name="razon_social" value="<?=@$data->razon_social?>" id="razon_social" /></td>
					</tr>
					<tr>
						<td>Direccion: </td>
						<td><input type="text" name="direccion" value="<?=@$data->direccion?>" id="direccion" /></td>
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
						<td>Persona Contacto: </td>
						<td><input type="text" name="persona_contacto" value="<?=@$data->persona_contacto?>" id="persona_contacto" /></td>
					</tr>
					<tr>
						<td>Telefono Persona Contacto: </td>
						<td><input type="text" name="telefono_persona_contacto" value="<?=@$data->telefono_persona_contacto?>" id="telefono_persona_contacto" /></td>
					</tr>
					<tr>
						<td><button>Guardar</button></td>
						<td><a href="?vista=vistas/clientes/clientes">Cancelar</a></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>