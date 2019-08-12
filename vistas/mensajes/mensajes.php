<?php
	include 'controladores/controlador.mensaje.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('mensajes');
?>

<div class="panel">
	<h2>Mensajes</h2>
	<div class="cuerpo-panel">
		<a class="boton" href="?vista=vistas/mensajes/acciones.mensajes&accion=crear">Nuevo</a>
		<table class="table">
			<thead>
				<tr>
					<td>ID</td>
					<td>Titulo</td>
					<td>Contenido</td>
					<td>-</td>
				</tr>
			</thead>
			<tbody>
				<?php 
					if (!empty($data['mensajes'])):
						foreach($data['mensajes'] as $mensaje): ?>
							<tr>
								<td><?=$mensaje['id']?></td>
								<td><?=$mensaje['titulo']?></td>
								<td><?=substr($mensaje['contenido'],0,30)?>...</td>
								<td>
									<a href="?vista=vistas/mensajes/acciones.mensajes&accion=editar&operacion=buscarxid&id=<?=$mensaje['id']?>">Reenviar</a>
									<a onclick="eliminar(event);" href="?vista=vistas/mensajes/mensajes&operacion=eliminar&id=<?=$mensaje['id']?>">Eliminar</a>
								</td>
							</tr>
				<?php 
						endforeach;
					endif;
				?>
			</tbody>
		</table>
	</div>
</div>