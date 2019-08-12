<?php
	include 'controladores/controlador.escritorio.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('escritorio');
?>

<div class="panel">
	<h2>Resumen</h2>
	<div class="cuerpo-panel">
		<table class="table">
			<thead>
				<tr>
					<td>Servicios</td>
					<td>Clientes</td>
					<td>Mensajes</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?=$servicios?></td>
					<td><?=$clientes?></td>
					<td><?=$mensajes?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel">
	<h2>10 Ultimos Mensajes Enviados</h2>
	<div class="cuerpo-panel">
		<table class="table">
			<thead>
				<tr>
					<td>ID</td>
					<td>Titulo</td>
					<td>Contenido</td>
					<td>Fecha</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($lista_mensajes as $m): ?>
					<tr>
						<td><?=$m['id']?></td>
						<td><?=$m['titulo']?></td>
						<td><?=substr($m['contenido'],0,30)?>...</td>
						<td><?=$m['fecha']?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>