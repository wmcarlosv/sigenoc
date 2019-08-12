<?php
	include 'controladores/controlador.servicio.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('servicios');
?>

<div class="panel">
	<h2>Servicios</h2>
	<div class="cuerpo-panel">
		<a class="boton" href="?vista=vistas/servicios/acciones.servicios&accion=crear">Nuevo</a>
		<table class="table">
			<thead>
				<tr>
					<td>ID</td>
					<td>Nombre</td>
					<td>-</td>
				</tr>
			</thead>
			<tbody>
				<?php 
					if (!empty($data['servicios'])):
						foreach($data['servicios'] as $servicio): ?>
							<tr>
								<td><?=$servicio['id']?></td>
								<td><?=$servicio['nombre']?></td>
								<td>
									<a href="?vista=vistas/servicios/acciones.servicios&accion=editar&operacion=buscarxid&id=<?=$servicio['id']?>">Editar</a>
									<a onclick="eliminar(event);" href="?vista=vistas/servicios/servicios&operacion=eliminar&id=<?=$servicio['id']?>">Eliminar</a>
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