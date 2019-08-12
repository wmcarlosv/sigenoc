<?php
	include 'controladores/controlador.usuario.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('usuarios');
?>

<div class="panel">
	<h2>Usuarios</h2>
	<div class="cuerpo-panel">
		<a class="boton" href="?vista=vistas/usuarios/acciones.usuarios&accion=crear">Nuevo</a>
		<table class="table">
			<thead>
				<tr>
					<td>ID</td>
					<td>Nombre</td>
					<td>Correo</td>
					<td>Telefono</td>
					<td>-</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($data['usuarios'] as $usuario): ?>
					<tr>
						<td><?=$usuario['id']?></td>
						<td><?=$usuario['nombre']?></td>
						<td><?=$usuario['correo']?></td>
						<td><?=$usuario['telefono']?></td>
						<td>
							<a href="?vista=vistas/usuarios/acciones.usuarios&accion=editar&operacion=buscarxid&id=<?=$usuario['id']?>">Editar</a>
							<a onclick="eliminar(event);" href="?vista=vistas/usuarios/usuarios&operacion=eliminar&id=<?=$usuario['id']?>">Eliminar</a>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>